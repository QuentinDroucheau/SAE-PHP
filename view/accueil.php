<script src="js/swiper-bundle.min.js" defer></script>
<script src="js/slideAccueil.js" defer></script>

<link rel="stylesheet" href="styles/accueil.css">
<link rel="stylesheet" href="styles/swiper.css">


<?php foreach ($albumsByCategory as $category => $lesAlbums) : ?>
    <section class="section-categorie-album">
        <h2><?= $category ?></h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($lesAlbums as $album) : ?>
                    <div class="swiper-slide">
                        <?= $album->render() ?>
                    </div> <!-- ferme le swiper-slide -->
                <?php endforeach ?>
            </div> <!-- ferme le wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
<?php endforeach ?>