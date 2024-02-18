<link rel="stylesheet" href="styles/playlist.css">
<script src="js/modif_playlist.js" defer></script>
<div class="header-playlist" data-id="<?= $playlist->getId() ?>">
    <div class="img-playlist">
        <img src=<?= $playlist->getImage() ?> alt="">
    </div>
    <div class="info">
        <p>Playlist</p>
        <h1 onmouseover="showEditButton('editNameButton')" onmouseout="hideEditButton('editNameButton')">
            <?= $playlist->getTitre() ?>
            <button id="editNameButton" class="edit-button" style="display: none;" onclick="openEditModal('name')">Modifier</button>
        </h1>
        <div class="container-description" onmouseover="showEditButton('editDescriptionButton')" onmouseout="hideEditButton('editDescriptionButton')">
            <p>
                <?= $playlist->getDescription() ?>
                <button id="editDescriptionButton" class="edit-button" style="display: none;" onclick="openEditModal('description')">Modifier</button>
            </p>
        </div>
        <div class="buttons">
            <div class="button-play"></div>
            <div class="button-add"></div>
        </div>
    </div>

    <ul class="navbar-playlist">
        <li><a onclick="openMusique();">Musiques</a></li>
    </ul>
</div>
<div class="container-musique">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>TITRES</th>
                <th>ALBUM</th>
                <th>DATE AJOUT</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($musiques as $musique) : ?>
                <tr class="musique-<?= $musique->getId() ?>">
                    <td><?= $musique->getId() ?></td>

                    <td class="musique-title">
                        <div class="left">
                            <img src=<?= $musique->getLien() ?> alt="" style="height: 70px; width:70px;">
                        </div>
                        <div class="right">
                            <p class="title"><?= $musique->getNom() ?></p>
                        </div>
                    </td>
                    <td><?= $musique->getAlbumName() ?></td>
                    <td><?= $playlist->getDateAjoutMusique($musique->getId()) ?></td>
                    <td>
                        <div class="remove" onclick="removeMusique(<?= $idPlaylist ?>, <?= $musique->getId() ?>);">
                            <div></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function removeMusique(idPlaylist, idMusique) {
        $.ajax({
            url: "/playlist/musique",
            method: "POST",
            data: {
                playlist: idPlaylist,
                musique: idMusique,
                action: "ajaxRemoveMusiqueInPlaylist"
            },
            success: function(result) {
                let r = JSON.parse(result);
                if (r.success) {
                    musique = document.querySelector(".musique-" + idMusique);
                    if (musique) {
                        musique.remove();
                    }
                }
            }
        });
    }
</script>