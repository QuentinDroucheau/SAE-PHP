<section class="main-album">
    <img class="img-album" src=<?php echo $image; ?> alt="" onclick="redirect(<?php echo $id; ?>);">
    <section class="infos-card">
        <div class="top-infos-card">
            <h3><?php echo $titre; ?></h3>
            <p>
                <?php echo (count($musiques) == 1 ? 'Single' : count($musiques)) . " Titres"; ?>
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
<script>
    function redirect(id) {
        window.location.href = "album?id=" + id;
    }
</script>