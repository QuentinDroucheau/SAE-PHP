// Fonction pour mettre à jour le lien actif dans la navigation
function updateActiveLink(sectionId) {
    document.querySelectorAll('.nav-artiste a').forEach(function (link) {
        link.classList.remove('active');
    });
    document.querySelector('.nav-artiste a[href="#"][onclick="showSection(\'' + sectionId + '\'); showTitre(\'' + sectionId + '\'); return false;"]').classList.add('active');
}

// Fonction pour afficher une section spécifique
function showSection(sectionId) {
    document.querySelectorAll('.section-mouvante').forEach(function (section) {
        section.style.display = 'none';
    });
    document.getElementById(sectionId + '-section').style.display = 'flex';
    updateActiveLink(sectionId);
}

// Fonction pour afficher un titre spécifique
function showTitre(h1id) {
    document.querySelectorAll('h1').forEach(function (titre) {
        titre.style.display = 'none';
    });
    document.getElementById(h1id + '-titre').style.display = 'block';
}

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

// Fonction pour vérifier si un fichier est une image
function isImageFile(file) {
    return file.type.startsWith('image/');
}

// Fonction pour traiter les fichiers et afficher l'image dans la div
function handleFiles(files) {
    const imageElement = document.getElementById('upload-image');

    // Mettez à jour la source de l'image avec l'URL de l'image déposée
    imageElement.src = URL.createObjectURL(files[0]);
}

// Fonction pour ouvrir le gestionnaire de fichiers en cliquant sur l'image
function openFileInput() {
    document.getElementById('file-input').click();
}

// Fonction appelée lors du chargement de la page
window.onload = function () {
    showSection('publier');
    showTitre('publier');

    const genresList = document.getElementById('genresList');
    const voirPlusLink = genresList.querySelector('.img-plus');

    voirPlusLink.addEventListener('click', handleVoirPlusClick);

    // Ajout d'un gestionnaire d'événements à la liste des genres sélectionnés
    const selectedGenresList = document.getElementById('selectedGenresList');
    selectedGenresList.addEventListener('click', handleSelectedGenreClick);
};

// Fonction appelée lors du clic sur le bouton "Voir plus" des genres
function handleVoirPlusClick() {
    addNewGenre();
}

// Fonction pour ajouter un nouveau genre
function addNewGenre() {
    const genresList = document.querySelector('.list-genre');
    const newGenreLi = document.createElement('li');
    newGenreLi.classList.add('new-genre');
    newGenreLi.innerHTML = `
        <div class="new-genre-container">
            <input type="text" placeholder="Nouveau genre ..." onblur="saveNewGenre(this)">
            <button onclick="saveNewGenre(this.previousElementSibling.value)">Sauvegarder</button>
        </div>
    `;

    // Ajout d'un identifiant unique à chaque nouvel élément de genre
    const uniqueId = 'new-genre-' + Date.now();
    newGenreLi.setAttribute('id', uniqueId);

    genresList.insertBefore(newGenreLi, genresList.lastElementChild);
    setTimeout(() => newGenreLi.classList.add('show'), 0);
}

// Fonction pour sauvegarder le nouveau genre
function saveNewGenre(inputElement) {
    const newGenre = inputElement.value.trim();
    if (newGenre !== '' && !isGenreAlreadySelected(newGenre)) {
        console.log('Nouveau genre ajouté :', newGenre);
        // Ajout du genre à la liste des genres sélectionnés
        addSelectedGenre(newGenre);
        // Masquer l'élément de la liste des genres ajoutés
        const newGenreLi = inputElement.parentElement;
        if (newGenreLi) {
            newGenreLi.classList.add('hide');
            setTimeout(() => newGenreLi.remove(), 500); // Supprimer l'élément après l'animation
        }
    } else if (isGenreAlreadySelected(newGenre)) {
        alert('Ce genre est déjà sélectionné.');
        // Masquer l'élément de la liste des genres ajoutés
        const newGenreLi = inputElement.parentElement;
        if (newGenreLi) {
            newGenreLi.classList.add('hide');
            setTimeout(() => newGenreLi.remove(), 500); // Supprimer l'élément après l'animation
        }
    }
}

// Fonction appelée lors de la sélection d'un genre
function handleGenreSelection(event) {
    // Récupérer l'élément cliqué
    const clickedElement = event.target;

    // Exclure les éléments de recherche et le bouton "Voir plus"
    if (
        clickedElement.tagName === 'LI' &&
        !clickedElement.classList.contains('search-genre') &&
        !clickedElement.classList.contains('img-search') &&
        !clickedElement.classList.contains('img-plus')
    ) {
        const selectedGenre = clickedElement.textContent;

        // Vérifier si le genre sélectionné n'est pas déjà dans la liste
        if (!isGenreAlreadySelected(selectedGenre)) {
            // Ajouter le genre sélectionné à une nouvelle liste au-dessus de #genreList
            addSelectedGenre(selectedGenre);
        } else {
            alert('Ce genre est déjà sélectionné.');
        }
    }
}

// Fonction appelée lors du clic sur un genre sélectionné
function handleSelectedGenreClick(event) {
    const clickedElement = event.target;

    // Vérifier si l'élément cliqué est un genre sélectionné
    if (clickedElement.classList.contains('selected-genre')) {
        const selectedGenre = clickedElement.textContent;
        removeSelectedGenre(selectedGenre);
    }
}

// Fonction pour vérifier si le genre est déjà sélectionné
function isGenreAlreadySelected(genre) {
    // Vérifier si le genre est déjà présent dans la liste des genres sélectionnés
    const selectedGenres = document.querySelectorAll('.selected-genre');
    for (const selectedGenre of selectedGenres) {
        if (selectedGenre.textContent === genre) {
            return true;
        }
    }
    return false;
}

// Fonction pour ajouter un genre à la liste des genres sélectionnés
function addSelectedGenre(genre) {
    // Créer un nouvel élément li avec la classe 'selected-genre'
    const selectedGenreLi = document.createElement('li');
    selectedGenreLi.textContent = genre;
    selectedGenreLi.classList.add('selected-genre');

    // Ajouter le nouvel élément à la liste des genres sélectionnés
    const selectedGenresList = document.getElementById('selectedGenresList');
    selectedGenresList.appendChild(selectedGenreLi);

    // Afficher le bouton "Effacer tous les genres" s'il y a au moins 1 genre sélectionné
    const clearGenresButton = document.querySelector('#selectedGenresList button.clear-all');
    if (selectedGenresList.children.length > 0) {
        clearGenresButton.style.display = 'block';
    }
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
            handleAudioFiles(files);
        } else {
            alert("Veuillez déposer un fichier audio valide.");
        }
    }
}
// Ajoutez cette ligne au début de votre fichier js/publier.js
let lastMusicId = 0;

// Modifiez la fonction handleAudioFiles comme suit
function handleAudioFiles(files) {
    const musiquesListe = document.getElementById('musiques-liste');

    // Incrémente l'identifiant pour la nouvelle musique
    lastMusicId++;

    // Créer un nouvel élément li pour chaque fichier audio
    const nouvelleMusique = document.createElement('li');
    nouvelleMusique.draggable = true; // Rendre l'élément déplaçable

    // Ajouter un identifiant à l'élément li
    nouvelleMusique.setAttribute('data-music-id', lastMusicId);

    // Afficher l'ID avant l'image
    const idParagraphe = document.createElement('p');
    idParagraphe.textContent = lastMusicId + '.';
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

    // Ajouter le nom du fichier audio au nouvel élément li
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
    boutonSupprimer.onclick = function () {
        musiquesListe.removeChild(nouvelleMusique);
    };
    nouvelleMusique.appendChild(boutonSupprimer);

    musiquesListe.appendChild(nouvelleMusique);
}
