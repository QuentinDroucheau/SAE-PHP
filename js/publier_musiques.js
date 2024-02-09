
// ==============================

// GESTION DES MUSIQUES

// ==============================

// Variables
let musiqueID = 0;

// Fonction pour permettre le glisser-déposer des fichiers audio
function allowDropAudio(event) {
    event.preventDefault();
}

// Fonction pour ouvrir le gestionnaire de fichiers en cliquant sur la section
function openAudioFileInput() {
    const audioInput = document.getElementById('audio-input');
    audioInput.setAttribute('accept', 'audio/mp3, audio/wav, audio/flac, audio/ogg');
    audioInput.click();
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
    const extensionsAutoriseesAudio = ['mp3', 'wav', 'flac', 'ogg'];
    const extensionAudio = file.name.split('.').pop().toLowerCase();
    return extensionsAutoriseesAudio.includes(extensionAudio) && file.type.startsWith('audio/');
}


function handleAudioFiles(files) {
    const musiquesListe = document.getElementById('musiques-liste');

    // Incrémente l'identifiant pour la nouvelle musique
    musiqueID++;

    // Créer un nouvel élément li pour chaque fichier audio
    const nouvelleMusique = document.createElement('li');
    nouvelleMusique.draggable = true; // Rendre l'élément déplaçable
    nouvelleMusique.dataset.musicId = musiqueID;


    // ID DE LA MUSIQUE


    // Afficher l'ID avant l'image
    const idParagraphe = document.createElement('p');
    idParagraphe.textContent = musiqueID + '.';
    nouvelleMusique.appendChild(idParagraphe);


    // IMAGE DE L'ALBUM


    // Ajouter une image de l'album à chaque nouvel élément li
    const imageAlbum = document.createElement('img');
    imageAlbum.src = document.getElementById('upload-image').src;
    imageAlbum.alt = 'Image de l\'album';
    imageAlbum.classList.add('album-image');
    nouvelleMusique.appendChild(imageAlbum);


    // FICHIER AUDIO


    // Afficher le nom du fichier audio
    const nomFichierParagraphe = document.createElement('p');
    nomFichierParagraphe.textContent = 'Fichier : ' + files[0].name;
    nomFichierParagraphe.classList.add('fichier-audio');
    nouvelleMusique.appendChild(nomFichierParagraphe);


    // GENRE DE LA MUSIQUE


    // Créer une div pour regrouper le paragraphe "Genre :" et le sélecteur
    const divGenreMusique = document.createElement('div');
    divGenreMusique.classList.add('musique-genre');

    // Créer un paragraphe "Genre :"
    const paragrapheGenre = document.createElement('p');
    paragrapheGenre.textContent = 'Genre :';

    // Ajouter le paragraphe à la div
    divGenreMusique.appendChild(paragrapheGenre);

    // Créer un sélecteur (select) pour les genres
    const selectGenreAudio = document.createElement('select');
    selectGenreAudio.name = 'genreAudio';
    selectGenreAudio.classList.add('select-genre-audio');

    // Récupérer la liste des genres sélectionnés
    const selectedGenresList = document.getElementById('selectedGenresList');
    const selectedGenres = selectedGenresList.querySelectorAll('.selected-genre');

    // Ajouter les options de genre au sélecteur
    selectedGenres.forEach((selectedGenre) => {
        const option = document.createElement('option');
        option.value = selectedGenre.querySelector('span.genres-selectionnes').textContent;
        option.textContent = selectedGenre.querySelector('span.genres-selectionnes').textContent;
        selectGenreAudio.appendChild(option);
    });

    // Ajouter le sélecteur de genre à la div
    divGenreMusique.appendChild(selectGenreAudio);

    // Ajouter la div à la nouvelle musique
    nouvelleMusique.appendChild(divGenreMusique);


    // TITRE DE LA MUSIQUE

    // Créer une div pour regrouper le paragraphe titre, l'input et le bouton
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

    // Ajouter le paragraphe, l'input, le bouton à la div
    divTitreMusique.appendChild(titreMusiqueParagraphe);
    divTitreMusique.appendChild(nomMusiqueInput);

    // Ajouter la div au nouvel élément li
    nouvelleMusique.appendChild(divTitreMusique);



    // SUPPRIMER LA MUSIQUE

    
    // Créer un bouton "Supprimer" pour chaque fichier audio
    const boutonSupprimer = document.createElement('button');
    boutonSupprimer.textContent = 'Supprimer';
    boutonSupprimer.addEventListener('click', function () {
        musiquesListe.removeChild(nouvelleMusique);
    });
    nouvelleMusique.appendChild(boutonSupprimer);

    musiquesListe.appendChild(nouvelleMusique);


    // partieA


    // Créer un tableau pour stocker les informations sur la musique
    const musiqueInfo = {
        nomMusique: nomMusiqueInput.value,
        audioPath: files[0].name,
    };


    // Vérifier si le champ 'musiquesListe' existe déjà dans le formulaire
    const musiquesListeInput = document.getElementById('musiques-liste-input');
    let musiquesList = [];

    // Si le champ existe, récupérer et parser sa valeur
    if (musiquesListeInput && musiquesListeInput.value.trim() !== "") {
        try {
            musiquesList = JSON.parse(musiquesListeInput.value);
        } catch (error) {
            console.error('Erreur lors de l\'analyse JSON :', error);
        }
    }

    // Ajouter les informations de la musique à la liste
    musiquesList.push(musiqueInfo);

    // Mettre à jour le champ caché avec la liste des musiques en tant que chaîne JSON
    if (musiquesListeInput) {
        musiquesListeInput.value = JSON.stringify(musiquesList);
    }

    // Ajouter des déclarations console.log pour le débogage
    console.log('Nouvelle musique ajoutée :', musiqueInfo);
    console.log('Liste actuelle des musiques :', musiquesList);
}


