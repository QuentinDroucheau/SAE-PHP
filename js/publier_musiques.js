let musiqueID = 0;

// ==============================

// GESTION DES MUSIQUES

// ==============================


// Fonction pour permettre le glisser-déposer des fichiers audio
function allowDropAudio(event) {
    event.preventDefault();
}

// Fonction pour ouvrir le gestionnaire de fichiers en cliquant sur la section
function openAudioFileInput() {
    document.getElementById('audio-input').click();
}

// Fonction pour le glisser-déposer des fichiers audio
function dropAudioFile(event) {
    event.preventDefault();

    const files = event.dataTransfer.files;

    // Vérifiez si des fichiers ont été déposés
    if (files.length > 0) {
        // Vérifiez si le fichier déposé est un fichier audio
        if (isAudioFile(files[0])) {
            console.log('Fichier audio déposé :', files[0]);
            handleAudioFiles(files);
        } else {
            alert("Veuillez déposer un fichier audio valide.");
        }
    }
}

// Fonction pour vérifier si un fichier est un fichier audio
function isAudioFile(file) {
    return file.type.startsWith('audio/');
}


// Fonction pour traiter les fichiers audio et afficher dans la liste
function handleAudioFiles(files) {
    const musiquesListe = document.getElementById('musiques-liste');

    // Incrémente l'identifiant pour la nouvelle musique
    musiqueID++;

    // Créer un nouvel élément li pour chaque fichier audio
    const nouvelleMusique = document.createElement('li');
    nouvelleMusique.draggable = true; // Rendre l'élément déplaçable
    nouvelleMusique.dataset.musicId = musiqueID;

    // Afficher l'ID avant l'image
    const idParagraphe = document.createElement('p');
    idParagraphe.textContent = musiqueID + '.';
    nouvelleMusique.appendChild(idParagraphe);

    // Ajouter une image de l'album à chaque nouvel élément li
    const imageAlbum = document.createElement('img');
    imageAlbum.src = document.getElementById('upload-image').src;
    imageAlbum.alt = 'Image de l\'album';
    imageAlbum.classList.add('album-image');
    nouvelleMusique.appendChild(imageAlbum);

    // Afficher le nom du fichier audio
    const nomFichierParagraphe = document.createElement('p');
    nomFichierParagraphe.textContent = 'Fichier : ' + files[0].name;
    nomFichierParagraphe.classList.add('fichier-audio');
    nouvelleMusique.appendChild(nomFichierParagraphe);

    // Créer une div pour regrouper le paragraphe titre et l'input
    const divTitreMusique = document.createElement('div');
    divTitreMusique.classList.add('titre-musique');

    // Créer un paragraphe pour le titre de la musique
    const titreMusiqueParagraphe = document.createElement('p');
    titreMusiqueParagraphe.textContent = 'Titre de la musique :';

    // Créer un champ d'entrée pour le nom de la musique
    const nomMusiqueInput = document.createElement('input');
    nomMusiqueInput.type = 'text';
    nomMusiqueInput.name = 'nomM';
    nomMusiqueInput.placeholder = 'Nom de la musique';
    nomMusiqueInput.classList.add('nom-musique');

    // Ajouter le paragraphe et l'input à la div
    divTitreMusique.appendChild(titreMusiqueParagraphe);
    divTitreMusique.appendChild(nomMusiqueInput);

    // Ajouter la div au nouvel élément li
    nouvelleMusique.appendChild(divTitreMusique);

    // Créer un bouton "Supprimer" pour chaque fichier audio
    const boutonSupprimer = document.createElement('button');
    boutonSupprimer.textContent = 'Supprimer';
    boutonSupprimer.addEventListener('click', function () {
        musiquesListe.removeChild(nouvelleMusique);
    });
    nouvelleMusique.appendChild(boutonSupprimer);

    musiquesListe.appendChild(nouvelleMusique);
}

