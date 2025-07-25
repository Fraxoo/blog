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

function addpost(){
    
    function createDirectoryIfNotExists($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

if (!empty($_POST['nom']) && !empty($_POST['description']) && isset($_FILES['files'])) {
    $db = connect();
    $userid = $_SESSION['id'] ?? 0;

    // Nom du dossier principal
    $modelName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['nom']); 
    $baseUploadDir = __DIR__ . '/uploads/' . $modelName . '_' . $userid . '/';

    // **Vérifier si le dossier existe déjà**
    if (file_exists($baseUploadDir)) {
        $erreur = "<p style='color:red;'>Erreur : un modèle nommé <strong>$modelName</strong> existe déjà pour cet utilisateur.</p>";
        $retour =  "<a href='index.php'>Retour</a>";
        exit;
    }

    // Créer le dossier principal
    createDirectoryIfNotExists($baseUploadDir);

    $uploadedFiles = [];
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
            $relativePath = $_FILES['files']['name'][$key];
            $targetPath = $baseUploadDir . $relativePath;

            // Créer sous-dossiers si nécessaires
            $directory = dirname($targetPath);
            createDirectoryIfNotExists($directory);

            if (move_uploaded_file($tmp_name, $targetPath)) {
                $uploadedFiles[] = $relativePath;
            } else {
                echo "Erreur lors de l'upload de $relativePath.<br>";
            }
        }
    }

    // Sauvegarde en BDD
    $filesJson = json_encode($uploadedFiles);
    $sql = "INSERT INTO post (nom, description, files, userid)
            VALUES (:nom, :description, :files, :userid)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'files' => $filesJson,
        'userid' => $userid
    ]);

    $sent =  "<p>Upload terminé</p>";
    $acceuil = "<a href='index.php'>Retour</a>";
    exit;
} else {
    $incomplet = "Formulaire incomplet ou aucun fichier envoyé.";
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
function getById($id)
{
    $db = connect();
    $sql = "SELECT * FROM  WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



//delete
function deleteById($id)
{
    $db = connect();
    $sql = "DELETE FROM  WHERE id = :id";
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
