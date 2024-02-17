function redirectAlbum(id) {
  window.location.href = "/album?id=" + id;
}


let buttons = document.querySelectorAll(".add-to-playlist-button");

buttons.forEach(function (button) {
  button.addEventListener("click", function (event) {
    event.preventDefault();
    event.stopPropagation();
    console.log("click");
    let submenu = button.nextElementSibling;
    submenu.style.display = submenu.style.display === "none" ? "block" : "none";
  });
});

$(".img-album-container").on("click", function (event) {
  let id = $(this).data("albumId");
  redirectAlbum(id);
});

let infoCards = document.querySelectorAll(".infos-card");
infoCards.forEach(function (card) {
  card.addEventListener("click", function (event) {
    let id = card.dataset.albumId;
    redirect(id);
  });
});

let playlistItems = document.querySelectorAll(".playlist-item");
$(".submenu").on("click", ".playlist-item", function (event) {
  event.preventDefault(); 
  event.stopPropagation();
  let idPlaylist = $(this).data("id");
  let albumId = $(this).closest(".img-album-container").data("albumId");
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
  let submenu = $(this).closest(".submenu")[0];
  console.log("submenu:", submenu);
  submenu.innerHTML = "";

  songs.forEach(function (song) {
    let songElement = document.createElement("div");
    songElement.classList.add("song-item");
  
    let checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.name = "song";
    checkbox.value = JSON.stringify(song);
    checkbox.addEventListener("click", function (event) {
      event.stopPropagation();
    });
    let label = document.createElement("label");
    label.appendChild(document.createTextNode(song.nom));
  
    songElement.appendChild(checkbox);
    songElement.appendChild(label);
  
    submenu.appendChild(songElement);
  });
  let submitButton = document.createElement("button");
  submitButton.textContent = "Valider";
  submitButton.addEventListener("click", function (event) {
    event.stopPropagation();
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
    formData.append("songIds", JSON.stringify(songIds));
    formData.append("playlistId", idPlaylist);
    console.log("formData:", formData);

    $.ajax({
      type: "POST",
      url: "/publiersSonsPlaylist",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        var jsonResponse = JSON.parse(response);
        var playlistId = jsonResponse.id;
        var element = $(".element[data-id='" + playlistId + "']");
        var nbMusiquesElement = element.find(".title .nbMusiques");
        var oldNbMusiques = parseInt(nbMusiquesElement.text().split(" ")[0]);
        var newNbMusiques = oldNbMusiques + jsonResponse.nbMusiques;
        nbMusiquesElement.text(newNbMusiques + " Titre(s)");
        submenu.style.display = "none";
      },
    });
  });
  
  submenu.appendChild(submitButton); 
  if (songs.length === 1) {
  let checkbox = submenu.querySelector(".song-item input[type='checkbox']");
  checkbox.checked = true;
  submitButton.click();
}
  });