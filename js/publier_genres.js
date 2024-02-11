
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
    selectedGenreInput.name = 'genre[]';
    selectedGenreInput.value = genre;

    // Ajouter l'input au li
    selectedGenreLi.appendChild(selectedGenreInput);

    // Créer un nouvel élément span pour afficher le genre
    const selectedGenreSpan = document.createElement('span');
    selectedGenreSpan.classList.add('genres-selectionnes');
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


