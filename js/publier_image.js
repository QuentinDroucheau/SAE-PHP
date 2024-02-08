
// Fonction pour le drag and drop des fichiers
function drop(event) {
    event.preventDefault();

    const files = event.dataTransfer.files;

    // Vérifiez si des fichiers ont été déposés
    if (files.length > 0) {
        // Vérifiez si le fichier déposé est une image
        if (isImageFile(files[0])) {
            handleFiles(files);
        } else {
            alert("Veuillez déposer une image.");
        }
    }
}

// Fonction pour le drag and drop des fichiers
function over(event) {
    event.preventDefault();
}

// Fonction pour vérifier si un fichier est une image avec des extensions spécifiques
function isImageFile(file) {
    // Liste des extensions d'images autorisées
    const extensionsAutorisees = ['jpg', 'jpeg', 'png'];

    // Obtenir l'extension du fichier
    const extension = file.name.split('.').pop().toLowerCase();

    // Vérifier si l'extension est autorisée
    return extensionsAutorisees.includes(extension) && file.type.startsWith('image/');
}

// Fonction pour traiter les fichiers et afficher l'image dans la div
function handleFiles(files) {
    const imageElement = document.getElementById('upload-image');

    // Vérifiez si le fichier est une image avec des extensions autorisées
    if (isImageFile(files[0])) {
        // Mettez à jour la source de l'image avec l'URL de l'image déposée
        imageElement.src = URL.createObjectURL(files[0]);
    } else {
        alert("Veuillez déposer une image avec une extension autorisée (jpg, jpeg, png).");
    }
}


// Fonction pour ouvrir le gestionnaire de fichiers en cliquant sur l'image
function openFileInput() {
    const fileInput = document.getElementById('file-input');
    fileInput.setAttribute('accept', 'image/jpeg, image/jpg, image/png');
    fileInput.click();
}

