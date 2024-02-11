<script src="js/swiper-bundle.min.js" defer></script>
<script src="js/slideAccueil.js" defer></script>

<link rel="stylesheet" href="styles/accueil.css">
<link rel="stylesheet" href="styles/swiper.css">
<link rel="stylesheet" href="styles/musicCard.css">

<?php foreach ($albumsDetails as $category => $albumDetails) : ?>
    <section class="section-categorie-album">
        <h2><?= $category ?></h2>
        <div class="container-for-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($albumDetails as $albumDetail) : ?>
                        <div class="swiper-slide">
                            <?= $albumDetail['album']->render() ?>
                            <div class="add-to-playlist-button">+</div>
                            <div class="submenu" style="display: none;">
                                <?php foreach ($playlists as $playlist) : ?>
                                    <a href="#"><?= $playlist ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div> <!-- ferme le swiper-slide -->
                    <?php endforeach; ?>
                </div> <!-- ferme le wrapper -->
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
<?php endforeach ?>