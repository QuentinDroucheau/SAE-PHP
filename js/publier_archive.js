src="https://code.jquery.com/jquery-3.6.4.min.js"

$(document).ready(function() {
    $('.btn-supprimer').on('click', function() {
        var idAlbum = $(this).data('id');

        // Envoyer une requête AJAX pour supprimer l'album
        $.ajax({
            url: 'classes/controller/ControllerPublier.php',
            method: 'POST',
            data: { idAlbum: idAlbum, action: 'supprimerAlbum' },
            success: function(response) {
                // Afficher la réponse de la suppression (peut être utilisé pour des retours visuels)
                alert(response);
                // Actualiser la page ou effectuer d'autres actions après la suppression
                location.reload();
            },
            error: function(error) {
                // Gérer les erreurs d'AJAX
                console.error("Erreur AJAX: " + error.responseText);
            }
        });
    });
});