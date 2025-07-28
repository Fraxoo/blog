// Import des modules nécessaires de Three.js
import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";

// Récupérer le modèle à afficher depuis la variable globale PHP -> JS
let objToRender = window.objToRender || "default_model";

// Déclarer les variables globales
let scene, camera, renderer, controls, object;

// Initialisation
init();
animate();

function init() {
    // Créer la scène
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xeeeeee);

    // Ajouter une lumière directionnelle
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(2, 20, 10);
    scene.add(light);

    // Créer la caméra
    camera = new THREE.PerspectiveCamera(
        45,
        window.innerWidth / window.innerHeight,
        0.1,
        1000
    );
    camera.position.set(0, 1.5, 3);

    // Renderer
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById("container3D").appendChild(renderer.domElement);

    // OrbitControls pour naviguer
    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.screenSpacePanning = false;

    // Charger le modèle glTF
    loadModel();
    
    // Ajuster la scène si la fenêtre change de taille
    window.addEventListener("resize", onWindowResize, false);
}

function loadModel() {
    const loader = new GLTFLoader();
    loader.load(
        `./uploads/${objToRender}/scene.gltf`,
        function (gltf) {
            object = gltf.scene;
            scene.add(object);

            // Centrer et adapter l'objet à la vue
            centerAndScaleObject(object);
        },
        undefined,
        function (error) {
            console.error("Erreur lors du chargement du modèle :", error);
        }
    );
}

// Ajuster la scène lors du resize
function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

// Animation
function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

// Fonction pour centrer et adapter l'objet à la caméra
function centerAndScaleObject(obj) {
    const box = new THREE.Box3().setFromObject(obj);
    const size = new THREE.Vector3();
    box.getSize(size);

    // Calcul du facteur d'échelle
    const maxDim = Math.max(size.x, size.y, size.z);
    const scale = 1.5 / maxDim; // Ajuste la taille à la scène
    obj.scale.set(scale, scale, scale);

    // Centrer
    box.setFromObject(obj);
    const center = new THREE.Vector3();
    box.getCenter(center);
    obj.position.sub(center); // Déplacer l'objet au centre
}
