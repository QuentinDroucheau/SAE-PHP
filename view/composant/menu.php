<link rel="stylesheet" href="styles/menu.css">
<link rel="stylesheet" href="styles/composantPlaylist.css">
<script src="js/sidebar.js" defer></script>
<div class="menu-close">
    <a class="button-open">Ouvrir</a>
</div>
<div class="menu">
    <div class="menu-header">
        <ul>
            <li>
                <img class="icon" src="img/icon_accueil.png" alt="">
                <a href="">Accueil</a>
            </li>
            <li>
                <img class="icon" src="img/icon_bibliotheque.png" alt="">
                <a href="">Ma bibliothèque</a>
            </li>
            <li>
                <a class="button-close">Fermer</a>
            </li>
        </ul>
    </div>
    <div class="scroll-1">
        <ul>
            <li>
                <a class="playlist-button" href="">
                    <img src="img/icon_musique2.png" alt="">
                    <img class="icon_musique" src="img/icon_musique.png" alt="">
                    Mes playlists</a>
            </li>
            <li>
                <a href="">
                    <img class="plus-button" src="img/plus.png" alt="">
                </a>
            </li>
        </ul>
        <div class="elements">
            <?php foreach ($playlists as $playlist) : ?>
                <?= $playlist->render(); ?>
            <?php endforeach; ?>
    </div>
</div>
<div class="scroll-2">
    <ul>
        <li><a href="">Mon historique</a></li>
    </ul>
    <div class="elements">
        <div class="element">
            <div>
                <img class="icon" src="img/pochette.png" alt="">
            </div>
            <div class="info">
                <p>titre</p>
                <p>auteur</p>
                <p>Ecouté il y a ..;</p>
            </div>
        </div>
    </div>
</div>
</div>