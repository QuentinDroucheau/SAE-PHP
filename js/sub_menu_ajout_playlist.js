// ERREUR BUG PARSE JSON

// $('.add-to-playlist-button').each(function() {
//   let $button = $(this);
//   $button.click(function() {
//     console.log('click');
//     $.ajax({
//       url: '/getPlaylistSub',
//       type: 'GET',
//       dataType: 'json',
//       success: function(data) {
//         try {
//           console.log(data);
//           let $submenu = $button.next('.submenu');
//           $submenu.empty();
//           $.each(data, function(i, playlist) {
//             let $playlistItem = $('<div>').addClass('playlist-item');
//             $playlistItem.html('<img src="fixtures/images/' + playlist.image + '" alt="">' +
//                                '<p>' + playlist.titre + '</p>');
//             $submenu.append($playlistItem);
//           });
//           $submenu.show();
//         } catch (error) {
//           console.error('Error processing data: ', error);
//         }
//       },
//       error: function(jqXHR, textStatus, errorThrown) {
//         console.error('Error: ' + textStatus + ', ' + errorThrown);
//         console.log('Response text: ' + jqXHR.responseText);
//       }
//     });
//   });
// });
let buttons = document.querySelectorAll(".add-to-playlist-button");

buttons.forEach(function (button) {
  button.addEventListener("click", function () {
    console.log("click");
    let submenu = button.nextElementSibling;
    submenu.style.display = submenu.style.display === "none" ? "block" : "none";
  });
});

let playlistItems = document.querySelectorAll(".playlist-item");

playlistItems.forEach(function (playlistItem) {
  playlistItem.addEventListener("click", function () {
    let idPlaylist = playlistItem.dataset.id;
    let albumId = playlistItem.closest(".img-album-container").dataset.albumId;
    let album;

    for (let category in albums) {
      for (let i = 0; i < albums[category].length; i++) {
        if (albums[category][i].album.id === parseInt(albumId)) {
          album = albums[category][i];
          break;
        }
      }
      if (album) {
        break;
      }
    }

    let songs = album ? album.musiques : [];
    let submenu = playlistItem.closest(".submenu");
    submenu.innerHTML = "";

    songs.forEach(function (song) {
      let songElement = document.createElement("div");
      songElement.classList.add("song-item");

      let checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.name = "song";
      checkbox.value = JSON.stringify(song);

      let label = document.createElement("label");
      label.appendChild(document.createTextNode(song.nom));

      songElement.appendChild(checkbox);
      songElement.appendChild(label);

      submenu.appendChild(songElement);
    });

    let submitButton = document.createElement("button");
    submitButton.textContent = "Valider";
    submitButton.addEventListener("click", function () {
      let songItems = submenu.querySelectorAll(".song-item");
      let songIds = [];
      songItems.forEach(function (songItem) {
        let checkbox = songItem.querySelector("input[type='checkbox']");
        if (checkbox.checked) {
          let song = JSON.parse(checkbox.value);
          songIds.push(song.id);
        }
      });

      let formData = new FormData();
      formData.append('songIds', JSON.stringify(songIds));
      formData.append('playlistId', idPlaylist);
      console.log('formData:', formData);

      $.ajax({
        type: 'POST',
        url: "/publiersSonsPlaylist",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            alert('Songs successfully added to the playlist');
          } else {
            alert('Error adding songs to the playlist: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
    submenu.appendChild(submitButton);
  });
});

// $(document).on('click', '.playlist-item', function() {
//   let idPlaylist = $(this).data('id');
//   let albumId = $(this).closest('.img-album-container').data('album-id');
//   console.log('idPlaylist:', idPlaylist);
//   console.log('idAlbum:', albumId);
//   $.ajax({
//       url: '/getMusiquesAlbumSelec',
//       type: 'GET',
//       data: { albumId: albumId },
//       success: function(response) {
//         console.log('Response:', response);
//         try {
//           let musiques = JSON.parse(response);
//           console.log('Parsed musiques:', musiques);
//           let sousMenu = $('.submenu');
//           sousMenu.empty();
//           musiques.forEach(function(musique) {
//               sousMenu.append('<div class="musique"><input type="checkbox">' + musique.nomM + '</div>');
//           });
//         } catch (error) {
//           console.error('Error parsing JSON:', error);
//         }
//       },
//       error: function(jqXHR, textStatus, errorThrown) {
//         console.error('AJAX error:', textStatus, errorThrown);
//       }
//   });
// });
