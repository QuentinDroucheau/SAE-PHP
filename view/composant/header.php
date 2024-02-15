<script src ="js/search_bar.js" defer></script>
<link rel="stylesheet" href="styles/header.css">
<header class="header">
    <div class="left">
        <div class="container">
            <a href="/"><img class="logo" src="img/logo.png" alt=""></a>
            <div class="search-bar">
                <div class="icon_search">
                    <img src="img/search.png" alt="">
                </div>
                <input id="search-input" type="text" placeholder="Cherchez des albums/artistes...">
                <div id="search-results" class="search-results">
                    <!-- Les résultats de la recherche seront insérés ici -->
                </div>
            </div>
        </div>
        <div class="publier">
            <img class="icon_publier" src="img/icon_publier.png" alt="">
            <a href="/publier">PUBLIER</a>
        </div>
    </div>
    <div class="right">
        <div class="notif">
            <img class="notif-icon" src="img/notif.png" alt="">
            <div class="nb-notif">
                <p>3</p>
            </div>
        </div>
        <div class="profil-container">
            <?php

            use utils\Utils;

            if (is_null(Utils::getConnexion())) {
                echo '<div class="profil" onclick="openConnexion();">';
            } else {
                echo '<div class="profil" onclick="openUpdate();">';
            }
            ?>
            <a><?php echo $utilisateur; ?></a>
            <img class="profil-icon" src="img/profil.png" alt="">
        </div>
        <div class="connexion">
            <div class="close">
                <img src="img/close.svg" alt="" onclick="closeConnexion();">
            </div>
            <div class="profil">
                <a><?php echo $utilisateur; ?></a>
                <img class="profil-icon" src="img/profil.png" alt="">
            </div>
        </div>
        <div class="password">
            <div class="close">
                <img src="img/close.svg" alt="" onclick="closePassword();">
            </div>
            <div class="profil">
                <a><?php echo $utilisateur; ?></a>
                <img class="profil-icon" src="img/profil.png" alt="">
            </div>
        </div>
        <div class="profil-update">
            <div class="close">
                <img src="img/close.svg" alt="" onclick="closeUpdate();">
            </div>
            <div class="profil">
                <a><?php echo $utilisateur; ?></a>
                <img class="profil-icon" src="img/profil.png" alt="">
            </div>
            <div class="action">
                <ul>
                    <li>
                        <a onclick="openPassword();">Modifier mon mot de passe</a>
                    </li>
                    <li>
                        <a href="/login?action=logout">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/header.js"></script>