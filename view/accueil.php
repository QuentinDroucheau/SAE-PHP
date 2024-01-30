<?php foreach($albumsByCategory as $category => $lesAlbums): ?>
    <h2><?= ucfirst($category) ?></h2>
    <?php foreach($lesAlbums as $album): ?>
        <div class="album">
            <img src="<?= $album->getImageAlbum() ?>" alt="">
            <h3><?= $album->getTitreAlbum() ?></h3>
            <p><?= $album->getAnneeAlbum() ?></p>
            <p><?= $album->artiste->getNom() ?></p>
            <p><?= count($album->musiques) ?>Titres</p>
        </div>
    <?php endforeach ?>
<?php endforeach ?>