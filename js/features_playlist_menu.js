function redirectPlaylist(id) {
  window.location.href = "/playlist?id=" + id;
}

$(document).ready(function () {
  $(".form-publie-playlist").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log("formData:", formData);

    $.ajax({
      type: "POST",
      url: "/publierPlaylist",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
          console.log(response);
          $("#popup").hide();
          $("#overlay").hide();
          alert("Playlist publiée avec succès");
          var playlistItem =
            '<div class="element">' +
            "<div>" +
            '<div id="image-container-playlist">' +
            '<img class="pochette" src="../img/default_playlist.png' +
            '" alt="" onclick="redirect(' +
            response.id +
            ')">' +
            '<svg class="options-button" data-id="' +
            response.id +
            '" xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4" fill="none">' +
            '<path d="M1 2C1 2.26522 1.10536 2.51957 1.29289 2.70711C1.48043 2.89464 1.73478 3 2 3C2.26522 3 2.51957 2.89464 2.70711 2.70711C2.89464 2.51957 3 2.26522 3 2C3 1.73478 2.89464 1.48043 2.70711 1.29289C2.51957 1.10536 2.26522 1 2 1C1.73478 1 1.48043 1.10536 1.29289 1.29289C1.10536 1.48043 1 1.73478 1 2ZM8 2C8 2.26522 8.10536 2.51957 8.29289 2.70711C8.48043 2.89464 8.73478 3 9 3C9.26522 3 9.51957 2.89464 9.70711 2.70711C9.89464 2.51957 10 2.26522 10 2C10 1.73478 9.89464 1.48043 9.70711 1.29289C9.51957 1.10536 9.26522 1 9 1C8.73478 1 8.48043 1.10536 8.29289 1.29289C8.10536 1.48043 8 1.73478 8 2ZM15 2C15 2.26522 15.1054 2.51957 15.2929 2.70711C15.4804 2.89464 15.7348 3 16 3C16.2652 3 16.5196 2.89464 16.7071 2.70711C16.8946 2.51957 17 2.26522 17 2C17 1.73478 16.8946 1.48043 16.7071 1.29289C16.5196 1.10536 16.2652 1 16 1C15.7348 1 15.4804 1.10536 15.2929 1.29289C15.1054 1.48043 15 1.73478 15 2Z" stroke="#FDFCFE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />' +
            "</svg>" +
            '<div class="dropdown-content">' +
            '<a href="#" class="delete-button" data-id="' +
            response.id +
            '">Supprimer</a>' +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="text">' +
            '<div class="title">' +
            "<p>" +
            response.titre +
            "</p>" +
            '<div class="title-info">' +
            "<p>" +
            response.nbMusiques +
            " Titre(s)</p>" +
            "</div>" +
            "</div>" +
            "<p>Mis a jour le " +
            response.dateMaj +
            "</p>" +
            "</div>" +
            "</div>";

          $(".menu .scroll-1 .elements").append(playlistItem);
          var newPlaylistItem = '<div class="playlist-item" data-id="' + response.playlistId + '">' +
                                '<p>' + response.titre + '</p>' +
                            '</div>';
      $(".submenu").each(function() {
        $(this).append(newPlaylistItem);
      });
    } else {
      alert("Erreur lors de la publication de la playlist");
    }
  },
  error: function (xhr, status, error) {
    console.error(error);
  },
});
  });
});

$(document).ready(function () {
  $(".options-button").on("click", function (e) {
    e.stopPropagation();
    $(this).next(".dropdown-content").toggle();
  });

  $(".dropdown-content .delete-button").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation(); 
    var playlistId = $(this).data("id");
    var button = $(this);
    $.ajax({
      type: "POST",
      url: "/effacerPlaylist",
      data: { playlistId: playlistId },
      success: function (response) {
        if (response.success) {
          button.closest(".element").remove();
        } else {
          alert("Erreur lors de l'effacement de la playlist");
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".options-button").length) {
      $(".dropdown-content").hide();
    }
  });
});