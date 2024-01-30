<link rel="stylesheet" href="styles/artiste.css">
<div>
    <section class="infos-artistes">
        <div class="img-artiste">
            <img src="fixtures/images/220px-DarkChords.jpg" alt="photo de profil">
        </div>
        <div>
            <h1>
                Luther
            </h1>
            <p>
                10 354 écoute ce mois-ci
            </p>
            <p>
                34039 abonnées
            </p>
            <div>
                <?php
                foreach ($albums as $album){
                    foreach ($musique as $key => $value){
                        echo "<p>$key : $value</p>";
                    }
                }
                ?>
            </div>
            <div>
                <button>
                    SUIVRE
                </button>
            </div>
        </div>
    </section>

    <nav class="nav-artiste">
        <ul>
            <li>
                <a href="">MUSIQUES</a>
            </li>
            <li>
                <a href="">ARTISTE SIMILAIRE</a>
            </li>
            <li>
                <a href="">PLAYLISTS</a>
            </li>
            <li>
                <a href="">CRITIQUES</a>
            </li>
        </ul>
    </nav>


    <section>

    </section>
</div>