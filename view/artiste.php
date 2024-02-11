<link rel="stylesheet" href="styles/artiste.css">
<script src="js/artiste.js"></script>
<div>
    <section class="infos-artistes">
        <div class="img-artiste">
            <img src="fixtures/images/220px-DarkChords.jpg" alt="photo de profil">
        </div>
        <div class="desc-artiste">
            <h1>
                <?php
                    echo $artiste->getNom();
                ?>
            </h1>
            <p>
                10 354 écoute ce mois-ci
            </p>
            <p>
                34039 abonnées
            </p>
            <ul class="artiste-genre">
                

                <?php
                $uniqueGenres = [];
                $genreCount = count($genres);

                foreach ($genres as $index => $genre) {
                    $genreName = $genre->getNom();
                    if (!isset($uniqueGenres[$genreName])) {
                        echo "<li>" . $genreName;
                        if ($index < $genreCount - 1) {
                            echo ", ";
                        }
                        echo "</li>";
                        $uniqueGenres[$genreName] = true;
                    }
                }
                ?>
        
            </ul>
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
                <a href="#" onclick="showSection('musiques')">MUSIQUES</a>
            </li>
            <li>
                <a href="#" onclick="showSection('artistesimilaire')">ARTISTE SIMILAIRE</a>
            </li>
            <li>
                <a href="#" onclick="showSection('playlist')">PLAYLISTS</a>
            </li>
            <li>
                <a href="#" onclick="showSection('critique')">CRITIQUES</a>
            </li>
        </ul>
    </nav>

    <section>
        <section id="musiques-section" class="section-mouvante">
            <div class="derniere-sortie">
                <h2>
                    Dernières sorties
                </h2>
                <div class="album">
                    <?php
                    $albumCpt = 0;
                    foreach ($albums as $album) {
                        if ($albumCpt < 2) {
                            echo "<img src='".$album->getImageAlbum()."' alt='cover de l'album >";
                            echo "<p>" . $album->getTitreAlbum() . "</p>";
                            echo "<span>" . $album->getAnneeAlbum() . "</span>";

                            $albumCpt++;
                        } else {
                            break;
                        }
                    }
                    ?>

                    <!-- rajouter le css/html de l'album -->

                </div>
            </div>

            <div class="top-titres">
                <h2>
                    Top Titres 
                </h2>
                <?php
                if (count($musiquesArtiste) > 3) {
                    echo "<div class='scroll'>";
                }
                else {
                    echo "<div>";
                }
                ?>
                    <ul class="list-titres">
                        <?php
                        $i = 0;
                        foreach ($musiquesArtiste as $musique) {
                            if ($i < 5) {
                                $i ++;
                                echo "<li>";
                                echo "<div class='musique-titre'>";
                                echo "<p>". $i . ".  </p>";
                                echo "<p>" . $musique->getNom() . "</p>";
                                echo "<p>" . $artiste->getNom() . "</p>";
                                echo "</div>";
                                echo "</li>";
                            }
                            else {
                                break;
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </section>

        <section id="artistesimilaire-section" class="section-mouvante">
            <h2>
                artiste similaire
            </h2>
        </section>

        <section id="playlist-section" class="section-mouvante">
            <h2>
                playlist
            </h2>
        </section>

        <section id="critique-section" class="section-mouvante">
            <h2>
                critiques
            </h2>
        </section>

    </section>
</div>

