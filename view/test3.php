<?php foreach($lesAlbums as $album): ?>
    <div class="album">
        <img src="<?= $album->getImageAlbum() ?>" alt="">
        <h3><?= $album->getTitreAlbum() ?></h3>
        <p><?= $album->getAnneeAlbum() ?></p>
        <p>Artiste: <?= $album->artiste->getNom() ?></p>
        <p>Nombre de musiques: <?= count($album->musiques) ?></p>
    </div>
<?php endforeach ?>