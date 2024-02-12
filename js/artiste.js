
 function updateActiveLink(sectionId) {
    document.querySelectorAll('.nav-artiste a').forEach(function(link) {
        link.classList.remove('active');
    });
    document.querySelector('.nav-artiste a[href="#"][onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
}

function showSection(sectionId) {
    document.querySelectorAll('.section-mouvante').forEach(function(section) {
        section.style.display = 'none';
    });
    document.getElementById(sectionId + '-section').style.display = 'flex';
    updateActiveLink(sectionId);
}

window.onload = function () {
    showSection('musiques');
};