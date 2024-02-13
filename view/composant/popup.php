<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/publier_image.js" defer></script>
<script src="js/publier_playlist.js" defer></script>
<div id="popup" style="display: none;">
    <div id="top-pop-up">
        <h1>Création de la playlist</h1>
        <button id="close-popup"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                <path d="M13 2L2 13M2 2L13 13" stroke="#323232" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg></button>
    </div>
    <form class="form-publie-playlist" action="/publierPlaylist" method="post" enctype="multipart/form-data">
        <div id="infos-images-left" class="drop-zone" ondrop="drop(event)" ondragover="over(event)">
            <img id="upload-image" src="img/img_upload.png" alt="Image pour glisser-déposer" onclick="openFileInput()">
            <input type="file" id="file-input" style="display: none;" onchange="handleFiles(this.files)" name="image">
        </div>
        <div id="infos-playlist-right">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre">
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <input type="submit" value="Publier">
        </div>
    </form>
</div>