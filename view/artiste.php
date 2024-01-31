<link rel="stylesheet" href="styles/artiste.css">
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
                foreach ($genres as $genre) {
                    $genreName = $genre->getNom();
                    if (!isset($uniqueGenres[$genreName])) {
                        echo "<li>" . $genreName . "</li>";
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
                <div>
                    <div class="element">
                        <div>
                            <img class="pochette" src="img/pochette.png" alt="">
                        </div>
                        <div class="text">
                            <div class="title">
                                <p>Titre</p>
                                <div class="title-info">
                                    <img class="icon" src="img/horloge.jpg" alt="">
                                    <p>43:20</p>
                                </div>
                            </div>
                            <p>Mis a jour le 27/01/2023</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="top-titres">
                <h2>
                    Top Titres 
                </h2>
                <ul id="list-titles">
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                    <li>
                        <p>
                            j
                        </p>
                    </li>
                </ul>
            </div>

        </section>

        <section id="artistesimilaire-section" class="section-mouvante">
            <div class="derniere-sortie">
                <h2>
                    Dernières sorties
                </h2>
            </div>

            <div class="top-titres">
                <h2>
                    artiste similaire
                </h2>
            </div>

        </section>

        <section id="playlist-section" class="section-mouvante">
            <div class="derniere-sortie">
                <h2>
                    Dernières sorties
                </h2>
            </div>

            <div class="top-titres">
                <h2>
                    playlist
                </h2>
            </div>

        </section>

        <section id="critique-section" class="section-mouvante">
            <div class="derniere-sortie">
                <h2>
                    Dernières sorties
                </h2>
            </div>

            <div class="top-titres">
                <h2>
                    critique 
                </h2>
            </div>

        </section>

    </section>
</div>

<script>
    // Fonction pour afficher une section
    function showSection(sectionId) {
        // Masquer toutes les sections
        document.querySelectorAll('.section-mouvante').forEach(function(section) {
            section.style.display = 'none';
        });

        // Afficher la section spécifique
        document.getElementById(sectionId + '-section').style.display = 'flex';
    }

    // Affiche la section "Musiques" au départ
    window.onload = function () {
        showSection('musiques');
    };
</script>
