<section class="main-album">
<div class="img-album-container" data-album-id="<?php echo $id; ?>">
        <img class="img-album" src=<?php echo $image; ?> alt="">
        <div class="add-to-playlist-button">+</div>
        <div class="submenu" style="display: none;">
            <?php foreach ($lesPlaylists as $playlist) : ?>
                <div class="playlist-item" data-id="<?php echo $playlist->getId(); ?>">
                    <p><?php echo $playlist->getTitre(); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <section class="infos-card" onclick="redirect(<?php echo $id; ?>);">
        <div class="top-infos-card">
        <h3 title="<?php echo $titre; ?>"><?php echo mb_strimwidth($titre, 0, 25, "..."); ?></h3>
            <p>
                <?php echo $nbMusiques == 1 ? 'Single' : $nbMusiques . " Titres"; ?>
            </p>
        </div>
        <div class="bottom-infos-card">
            <div class="bottom-infos-card-artist">
                <img src="../img/icone_artist.svg" alt="icone de l\'artiste" />
                <p>
                    <?php echo $auteurNom; ?>
                </p>
            </div>
            <p>
                <?php echo $anneeAlbum ?>
            </p>
        </div>
    </section>
</section>
