<script src="js/swiper-bundle.min.js" defer></script>
<script src="js/slideAccueil.js" defer></script>
<script src="js/sub_menu_ajout_playlist.js" defer></script>

<script>
    var albums = <?php echo $albumsDetailsJson; ?>;
</script>
<link rel="stylesheet" href="styles/accueil.css">
<link rel="stylesheet" href="styles/swiper.css">
<link rel="stylesheet" href="styles/musicCard.css">
<link rel="stylesheet" href="styles/composantArtiste.css">
<?php foreach ($albumsDetails as $category => $albumDetails) : ?>
    <section class="section-categorie-album">
        <h2><?= $category ?></h2>
        <div class="container-for-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($albumDetails as $albumDetail) : ?>
                        <div class="swiper-slide">
                            <?= $albumDetail['album']->render() ?>
                        </div> <!-- ferme le swiper-slide -->
                    <?php endforeach; ?>
                </div> <!-- ferme le wrapper -->
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    
    
    <?php endforeach ?>
    <section class="section-categorie-artiste">
        <h2>Des artistes...</h2>
        <div class="container-for-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($artistes as $artiste) : ?>
                        <div class="swiper-slide">
                            <?= $artiste->render() ?>
                        </div> <!-- ferme le swiper-slide -->
                    <?php endforeach; ?>
                </div> <!-- ferme le wrapper -->
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>