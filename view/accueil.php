<link rel="stylesheet" href = "styles/accueil.css">
<?php foreach ($albumsByCategory as $category => $lesAlbums) : ?>
    <section class="section-categorie-album">
        <h2><?= ucfirst($category) ?></h2>
        <button class="btn-voir-plus">plus</button>
        <div class="albums">
            <?php foreach ($lesAlbums as $album) : ?>
                <?= $album->render() ?>
            <?php endforeach ?>
        </div>
    </section>
<?php endforeach ?>