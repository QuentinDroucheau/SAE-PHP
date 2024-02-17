$(document).ready(function () {
  $("#search-input").keyup(function () {
    let query = $(this).val();
    if (query.length > 0) {
      $.ajax({
        url: "/search",
        type: "POST",
        data: {
          search: query,
        },
        success: function (response) {
          let data = JSON.parse(response);
          let html = "";
          if (data.artistes.length > 0) {
            html += "<h2>Artistes</h2><ul>";
            data.artistes.forEach(function (artist) {
              console.log(artist);
              html +=
                "<li><a href='/artistes?id=" +
                artist.idA +
                "'>" +
                artist.nomA +
                "</a></li>";
            });
            html += "</ul>";
          }
          if (data.albums.length > 0) {
            html += "<h2>Albums</h2><ul>";
            data.albums.forEach(function (album) {
              console.log(album);
              html +=
                "<li><a href='/album?id=" +
                album.idAlbum +
                "'>" +
                album.anneeAlbum +
                " - " +
                album.titreAlbum +
                "</a></li>";
            });
            html += "</ul>";
          }

          if (data.musiques.length > 0) {
            html += "<h2>Musiques</h2><ul>";
            data.musiques.forEach(function (musique) {
              html += "<li>" + musique.nomM + "</li>";
            });
            html += "</ul>";
          }
          $("#search-results").html(html);
          $("#search-results").show();
        },
      });
    } else {
      $("#search-results").html("");
      $("#search-results").hide();
    }
  });
});
