let musiqueID = 0;

// ==============================

// NAV BAR PUBLIER ET ARCHIVES

// ==============================


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


// ==============================

// CHARGEMENT DE LA PAGE ET GESTION DES ÉVÉNEMENTS

// ==============================


// Fonction appelée lors du chargement de la page
window.onload = function () {
    showSection('publier');
    showTitre('publier');

    // Ajout d'un gestionnaire d'événements à la liste des genres sélectionnés
    const selectedGenresList = document.getElementById('selectedGenresList');
    selectedGenresList.addEventListener('click', handleSelectedGenreClick);
};

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

    genresList.insertBefore(newGenreLi, genresList.lastElementChild);
    setTimeout(() => newGenreLi.classList.add('show'), 0);
}


// ==============================

// GESTION DES GENRES

// ==============================


// Fonction pour sauvegarder le nouveau genre
function saveNewGenre(inputElement) {
    const newGenre = inputElement.value.trim();
    if (newGenre !== '' && !isGenreAlreadySelected(newGenre)) {
        console.log('Nouveau genre ajouté :', newGenre);
        const newGenreLi = inputElement.closest('li.new-genre');
        newGenreLi.remove();
        addSelectedGenre(newGenre);
    } 
    else if (isGenreAlreadySelected(newGenre)) {
        alert('Ce genre est déjà sélectionné.');
    }
    const newGenreLi = inputElement.closest('li.new-genre');
    newGenreLi.remove();
    
}

// Fonction appelée lors du clic sur un genre
function handleGenreSelection(event) {
    // Récupérer l'élément cliqué
    const clickedElement = event.target;

    // Exclure les éléments de recherche et le bouton "Voir plus"
    if (
        clickedElement.tagName === 'LI' &&
        !clickedElement.classList.contains('li-search-genre') &&
        !clickedElement.classList.contains('new-genre') &&
        !clickedElement.classList.contains('img-plus')
    ) {
        // Vérifier si l'élément cliqué n'est pas la div search-genre, img-search ou img-plus
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

function addSelectedGenre(genre) {
    // Créer un nouvel élément li avec la classe 'selected-genre'
    const selectedGenreLi = document.createElement('li');
    
    // Créer un nouvel élément input avec le type 'hidden'
    const selectedGenreInput = document.createElement('input');
    selectedGenreInput.type = 'hidden';
    selectedGenreInput.name = 'genre[]'; // Utiliser des crochets pour envoyer un tableau PHP
    selectedGenreInput.value = genre;

    // Ajouter l'input au li
    selectedGenreLi.appendChild(selectedGenreInput);

    // Créer un nouvel élément span pour afficher le genre
    const selectedGenreSpan = document.createElement('span');
    selectedGenreSpan.textContent = genre;

    // Ajouter le span au li
    selectedGenreLi.appendChild(selectedGenreSpan);

    selectedGenreLi.classList.add('selected-genre');

    // Ajouter le bouton de suppression spécifique à ce genre
    const removeButton = createRemoveButton();
    selectedGenreLi.appendChild(removeButton);

    // Ajouter le nouvel élément à la liste des genres sélectionnés
    const selectedGenresList = document.getElementById('selectedGenresList');
    selectedGenresList.appendChild(selectedGenreLi);

    // Afficher le bouton "Effacer tous les genres" s'il y a au moins 1 genre sélectionné
    const clearGenresButton = document.querySelector('button.clear-all');
    if (selectedGenresList.children.length > 0) {
        clearGenresButton.style.display = 'block';
    }
    updateSelectedGenresInput();
}


function updateSelectedGenresInput() {
    const selectedGenresInput = document.getElementById('genre');
    const selectedGenresList = document.getElementById('selectedGenresList');
    
    // Récupérer tous les genres sélectionnés
    const selectedGenres = Array.from(selectedGenresList.children)
        .filter(element => element.classList.contains('selected-genre'))
        .map(element => element.textContent.trim());

    // Mettre à jour la valeur de l'input caché avec les genres sélectionnés sous forme de chaîne JSON
    selectedGenresInput.value = JSON.stringify(selectedGenres);
}


function createRemoveButton() {
    const removeButton = document.createElement('button');
    removeButton.classList.add('remove-genre');

    // Ajouter une balise img avec la source de l'image de la croix
    const imgElement = document.createElement('img');
    imgElement.src = 'img/croix.png';
    imgElement.alt = 'Supprimer';
    
    // Ajouter un gestionnaire d'événements pour supprimer le genre associé
    removeButton.addEventListener('click', function () {
        removeSelectedGenre(this.closest('li.selected-genre'));
    });

    // Ajouter l'élément img au bouton
    removeButton.appendChild(imgElement);

    return removeButton;
}

// Ajout d'un gestionnaire d'événements à la liste des genres sélectionnés
const selectedGenresList = document.getElementById('selectedGenresList');
selectedGenresList.addEventListener('click', handleSelectedGenreClick);

function handleSelectedGenreClick(event) {
    const clickedElement = event.target;

    // Vérifier si l'élément cliqué est un bouton de suppression
    if (clickedElement.classList.contains('remove-genre')) {
        // Récupérer l'élément li parent
        const selectedGenreLi = clickedElement.closest('li.selected-genre');

        // Appeler la fonction pour supprimer le genre sélectionné
        removeSelectedGenre(selectedGenreLi);
    }
}

function removeSelectedGenre(selectedGenreLi) {
    // Supprimer l'élément li correspondant au genre sélectionné
    if (selectedGenreLi) {
        selectedGenreLi.remove();

        // Si la liste des genres sélectionnés est vide, masquer le bouton "Effacer tous les genres"
        const selectedGenresList = document.getElementById('selectedGenresList');
        const clearGenresButton = document.querySelector('#selectedGenresList button.clear-all');

        if (clearGenresButton && selectedGenresList.children.length === 0) {
            clearGenresButton.style.display = 'none';
        }

        // Appeler la fonction pour mettre à jour l'input caché
        updateSelectedGenresInput();
    }
}


// Ajoutez cette ligne au début de votre fichier js/publier.js
document.addEventListener('DOMContentLoaded', function () {
    // Ajoutez un gestionnaire d'événements à l'élément de saisie de recherche
    const searchInput = document.querySelector('.li-search-genre input');
    searchInput.addEventListener('input', filterGenres);
});

function filterGenres(event) {
    // Récupérer la valeur saisie dans l'élément de saisie de recherche
    const searchValue = event.target.value.toLowerCase();
    
    // Récupérer la liste des genres
    const genresList = document.querySelector('.list-genre');
    const genres = genresList.querySelectorAll('li');

    // Parcourir la liste des genres
    for (const genre of genres) {
        // Exclure l'élément de recherche et le bouton "Voir plus" de la filtration
        if (!genre.classList.contains('li-search-genre') && !genre.classList.contains('new-genre')) {
            const genreName = genre.textContent.toLowerCase();
            if (searchValue === "") {
                // Si la recherche est vide, afficher les 5 premiers genres a l'aide d'un compteur
                let count = 0;
                for (const genre of genres) {
                    if (!genre.classList.contains('li-search-genre') && !genre.classList.contains('new-genre')) {
                        if (count < 5) {
                            genre.style.display = 'block';
                            count++;
                        } else {
                            genre.style.display = 'none';
                        }
                    }
                }
            } else {
                // Sinon, appliquer le filtre en fonction de la recherche
                if (genreName.includes(searchValue)) {
                    genre.style.display = 'block';
                } else {
                    genre.style.display = 'none';
                }
            }
        }
    }
}





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

