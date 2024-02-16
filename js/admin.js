// Fonction pour mettre à jour le lien actif dans la navigation
function updateActiveLink(sectionId) {
    document.querySelectorAll('.admin-artiste a').forEach(function (link) {
        link.classList.remove('active');
    });
    document.querySelector('.admin-artiste a[href="#"][onclick="showSection(\'' + sectionId + '\'); showTitre(\'' + sectionId + '\'); return false;"]').classList.add('active');
}

// Fonction pour afficher une section spécifique
function showSection(sectionId) {
    document.querySelectorAll('.section-mouvante').forEach(function (section) {
        section.style.display = 'none';
    });
    document.getElementById(sectionId + '-section').style.display = 'flex';
    updateActiveLink(sectionId);
}

// Fonction appelée lors du chargement de la page
window.onload = function () {
    showSection('albums');
};
