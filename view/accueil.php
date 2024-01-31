<link rel="stylesheet" href = "styles/accueil.css">
<?php foreach ($albumsByCategory as $category => $lesAlbums) : ?>
    <section class="section-categorie-album">
        <h2><?= ucfirst($category) ?></h2>
        <div class="albums">
            <?php foreach ($lesAlbums as $album) : ?>
                <?= $renderMusicCard($album) ?>
            <?php endforeach ?>
        </div>
    </section>
<?php endforeach ?>