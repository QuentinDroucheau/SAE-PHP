

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

