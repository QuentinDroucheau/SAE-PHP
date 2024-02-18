function redirect(id) {

}

$(document).ready(function() {
$('.form-publie-playlist').on('submit', function(e) {
  e.preventDefault();

  var formData = new FormData(this);
  console.log('formData:', formData);

  $.ajax({
    type: 'POST',
    url: '/publierPlaylist',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
      if (response.success) {
        console.log(response);
        $('#popup').hide();
        $('#overlay').hide();
        alert('Playlist publiée avec succès');
        var playlistItem = '<div class="element">' +
                              '<div>' +
                              '<img class="pochette" src="public/images/' + response.image + '" alt=""' +
                              '</div>' +
                              '<div class="text">' +
                                '<div class="title">' +
                                  '<p>' + response.titre + '</p>' +
                                  '<div class="title-info">' +
                                    '<img class="icon" src="img/horloge.svg" alt="">' +
                                    '<p>' + response.nbMusiques + ' Titre(s)</p>' +
                                  '</div>' +
                                '</div>' +
                                '<p>Mis a jour le ' + response.dateMaj + '</p>' +
                              '</div>' +
                            '</div>';
                            
        $('.menu .scroll-1 .elements').append(playlistItem);
      } else {
        alert('Erreur lors de la publication de la playlist');
      }
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
});
});