<link rel="stylesheet" href="styles/musicCard.css">
<div class="main-album">
    <img class="img-album" src="<?= $album->getImageAlbum() ?>" alt="">
    <section class="infos-card">
        <div class="top-infos-card">
            <h3><?= $album->getTitreAlbum() ?></h3>
            <p><?= count($album->musiques) ?>Titres</p>
        </div>
        <div class="bottom-infos-card">
            <div class="bottom-infos-card-artist">
                <img src="../img/icone_artist.svg" alt="icone de l'artiste"/>
                <p><?= $album->artiste->getNom() ?></p>
            </div>
            <p><?= $album->getAnneeAlbum() ?></p>
        </div>
    </section>
</div>