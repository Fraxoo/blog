<?php
// Connexion à la base de données
function connect()
{
    // Remplacez les valeurs ci-dessous par celles de votre base de données
    $host = '127.0.0.1';
    $dbname = 'fablog';
    $user = 'root';
    $password = 'root';
    return new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
}





//                                      REGISTER :

//create user


function adduser($pseudo, $email, $password)
{
    $db = connect();
    $sql = "INSERT INTO user (pseudo,email,password) VALUES (:pseudo,:email,:password)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'pseudo' => $pseudo,
        'email' => $email,
        'password' => $password
    ]);
}

//read user
function getAll()
{
    $db = connect();
    $sql = "SELECT * FROM user";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function doubleemail($email)
{
    $db = connect();
    $stmt = $db->prepare('SELECT email FROM user WHERE email = :email');
    $stmt->execute([
        'email' => $email
    ]);
    $result = $stmt->fetchColumn();
    return $result !== false; // returns true if email exists
}

function doublepseudo($pseudo)
{
    $db = connect();
    $stmt = $db->prepare('SELECT pseudo FROM user WHERE pseudo = :pseudo');
    $stmt->execute([
        'pseudo' => $pseudo
    ]);
    $result = $stmt->fetchColumn();
    return $result !== false; // returns true if email exists
}


//                                          FIN REGISTER







//                                              LOGIN

function login()
{
    $bdd = connect();
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($email, $password)) {
        $verifcompte = $bdd->prepare('SELECT * FROM user WHERE email = :email');
        $verifcompte->execute([
            'email' => $email
        ]);

        $usercompte = $verifcompte->fetch(pdo::FETCH_ASSOC);

        if ($usercompte && password_verify($password, $usercompte['password'])) {
            $_SESSION['id'] = $usercompte['id'];
            $_SESSION['pseudo'] = $usercompte['pseudo'];
            header("Location: index.php");
            exit();
        } else {
            return "Email ou mot de passe incorrect";
        }
    }
}


//                                            FIN LOGIN






                                            //ADDPOST:

function addpost() {
    function createDirectoryIfNotExists($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    // Extensions autorisées pour la preview
    $allowedPreviewExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    // Extensions autorisées pour les fichiers principaux
    $allowedFileExtensions = ['zip', 'obj', 'fbx', 'glb', 'gltf', 'bin', 'jpg', 'png', 'txt', 'pdf'];

    if (!empty($_POST['nom']) && !empty($_POST['description']) && isset($_FILES['files'])) {
        $db = connect();
        $userid = $_SESSION['id'] ?? 0;

        // Nom du modèle (sécurisé)
        $modelName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['nom']);
        $baseUploadDir = __DIR__ . '/uploads/' . $modelName . '_' . $userid . '/';

        // Vérifier si le dossier existe déjà
        if (file_exists($baseUploadDir)) {
            echo "<p style='color:red;'>Erreur : un modèle nommé <strong>$modelName</strong> existe déjà pour cet utilisateur.</p>";
            echo "<a href='index.php'>Retour</a>";
            return;
        }

        // Créer le dossier principal et textures
        createDirectoryIfNotExists($baseUploadDir);
        createDirectoryIfNotExists($baseUploadDir . 'textures/');

        // ====== 1. Upload des fichiers ======
        $uploadedFiles = [];
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                // Nom du fichier
                $fileName = basename($_FILES['files']['name'][$key]);
                $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

                // Vérification de l'extension
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedFileExtensions)) {
                    echo "<p style='color:red;'>Extension de fichier non autorisée : $fileName</p>";
                    continue;
                }

                // Si c'est une image (sauf preview), la placer dans /textures
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $targetPath = $isImage ? $baseUploadDir . 'textures/' . $fileName : $baseUploadDir . $fileName;

                // Déplacement
                if (move_uploaded_file($tmp_name, $targetPath)) {
                    $uploadedFiles[] = $isImage ? 'textures/' . $fileName : $fileName;
                } else {
                    echo "<p style='color:red;'>Erreur lors de l'upload de $fileName.</p>";
                }
            }
        }

        // ====== 2. Upload de la preview ======
        $preview = null;
        if (isset($_FILES['preview']) && $_FILES['preview']['error'] === UPLOAD_ERR_OK) {
            $extPreview = strtolower(pathinfo($_FILES['preview']['name'], PATHINFO_EXTENSION));

            if (in_array($extPreview, $allowedPreviewExtensions)) {
                // Nom forcé : preview.extension
                $previewName = 'preview.' . $extPreview;
                $previewPath = $baseUploadDir . $previewName;

                if (move_uploaded_file($_FILES['preview']['tmp_name'], $previewPath)) {
                    $preview = $previewName;
                } else {
                    echo "<p style='color:red;'>Erreur lors de l'upload de l'image de preview.</p>";
                }
            } else {
                echo "<p style='color:red;'>Extension de la preview non autorisée.</p>";
            }
        }

        // ====== 3. Sauvegarde en BDD ======
        try {
            $filesJson = json_encode($uploadedFiles);
            $sql = "INSERT INTO post (nom, description, files, preview, userid)
                    VALUES (:nom, :description, :files, :preview, :userid)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'nom' => $_POST['nom'],
                'description' => $_POST['description'],
                'files' => $filesJson,
                'preview' => $preview,
                'userid' => $userid
            ]);

            echo "<p style='color:green;'>Upload terminé avec succès !</p>";
            echo "<a href='index.php'>Retour</a>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erreur lors de l'enregistrement en base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
        }

    } else {
        $debut = "<p style='color:red;'>Formulaire incomplet ou aucun fichier envoyé.</p>";
    }
}



                                            //FIN ADD POST






//CREATE GROUPE :

function addgroup($nom, $userid)
{
    $db = connect();
    $sql = "INSERT INTO group (nom,userid) VALUES (:nom,:userid)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'nom' => $_POST['nom'],
        'userid' => $_SESSION['id']
    ]);
};


//FIN CREATE GROUPE




//read
function getById()
{
    $id = $_GET["id"];
    $db = connect();
    $sql = "SELECT * FROM post WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    $product = $stmt->fetch();
}



//delete
function deleteById()
{
    $id = $_GET["id"];
    $db = connect();
    $sql = "DELETE FROM post WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
}
//update
function update($id, $nom, $type, $calories)
{
    $db = connect();
    $sql = "UPDATE aliments SET nom = :nom, type = :type, calories = :calories WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'nom' => $nom,
        'type' => $type,
        'calories' => $calories
    ]);
}








