
// ==============================

// CHARGEMENT DE LA PAGE DE PUBLICATION

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


