$(document).ready(function() {
  $('#search-input').keyup(function() {
    let query = $(this).val();
    if (query.length > 0) {
      $.ajax({
        url: '/search',
        type: 'POST',
        data: { search: query },
        success: function(reponse) {
          let html = '';
          console.log(query);
          console.log(reponse);
          let data = JSON.parse(reponse);
          if (data.artistes.length > 0) {
            html += '<h2>Artistes</h2>';
            data.artistes.forEach(function(artist) {
              html += '<p>' + artistes.name + '</p>';
            });
          }
          if (data.albums.length > 0) {
            html += '<h2>Albums</h2>';
            data.albums.forEach(function(album) {
              html += '<p>' + albums.title + '</p>';
            });
          }
          $('#search-results').html(html);
        }
      });
    } else {
      $('#search-results').html('');
    }
  });
});