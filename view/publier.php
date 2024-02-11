<link rel="stylesheet" href="styles/publier.css">
<script src="js/publier.js"></script>
<script src="js/publier_genres.js"></script>
<script src="js/publier_musiques.js"></script>
<script src="js/publier_page.js"></script>
<script src="js/publier_image.js"></script>
<section class="retour">
    <a href="/"><img src="img/retour.png" alt="retour à l'accueil"><p>Retour</p></a>
</section>
<div>
    <h1 id="publier-titre">
        PUBLIER DU CONTENU
    </h1>
    <h1 id="archives-titre">
        ARCHIVES
    </h1>
    <nav class="nav-artiste">
        <ul>
            <li>
                <a href="#" onclick="showSection('publier'); showTitre('publier'); return false;">PUBLIER</a>
            </li>
            <li>
                <a href="#" onclick="showSection('archives'); showTitre('archives'); return false;">ARCHIVES</a>
            </li>
        </ul>
    </nav>
    <section id="publier-section" class="section-mouvante">
            <form action="/publier?action=publierContenue" method="post" enctype="multipart/form-data">
                <section class="infos-publication">    
                    <section>
                        <label for="titreAlbum">Nom de l'album</label>
                        <input id="name-album" type="text" name="titre" id="titre" placeholder="Nom de l'album" required>
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="Description de l'album" required></textarea>
                        <label for="genres">Genres</label>

                        <ul id="selectedGenresList" class="selected-genres-list">
                        </ul>

                        <ul id="genreList" class="list-genre" onclick="handleGenreSelection(event)">
                            <li class="li-search-genre">
                                <div class="search-genre">
                                    <div class="img-search">
                                        <img src="img/search.png" alt="">
                                    </div>
                                    <input type="text" class="search-genre" placeholder="Cherchez un genre ..." oninput="filterGenres(event)">
                                    
                                </div>
                            </li>

                            <?php
                            $cpt = 0;
                            foreach($genres as $genre) {
                                if ($cpt < 5) {
                                    echo "<li>";
                                    echo $genre->getNom();
                                    echo "</li>";
                                    $cpt++;
                                }
                                else {
                                    echo "<li style='display: none;'>";
                                    echo $genre->getNom();
                                    echo "</li>";
                                }
                            }
                            ?>
                            <li class="new-genre">
                                <div class="img-plus" onclick="addNewGenre()">
                                    <img src="img/plus.png" alt="Ajouter un nouveau genre">
                                </div>
                            </li>
                        </ul>
                    </section>
                    <div class="drop-zone" ondrop="drop(event)" ondragover="over(event)">
                        <img id="upload-image" src="img/img_upload.png" alt="Image pour glisser-déposer" onclick="openFileInput()">
                        <input type="file" id="file-input" style="display: none;" onchange="handleFiles(this.files)" name="image">
                    </div>
                </section>
                <section class="musiques">
                    <div class="drop-musique" ondrop="dropAudioFile(event)" ondragover="allowDropAudio(event)" onclick="openAudioFileInput()">
                        <h2>
                            Glisser/Déposer vos fichiers ici
                        </h2>
                        <input type="file" accept="audio/*" id="audio-input" style="display: none;" onchange="handleAudioFiles(this.files)">
                        <p>
                            (Formats acceptés: .mp3, .wav, .flac, .ogg)
                        </p>
                    </div>
                </section>

                <section class="liste-musiques" id="liste-musiques">
                    <h2>Musiques déposées :</h2>
                    <ul id="musiques-liste"></ul>
                    <input type="hidden" id="musiques-liste-input" name="musiquesListe">
                </section>
                <div class="publier-album">
                    <input type="submit" class="bouton-publier" value="PUBLIER">
                </div>
                
            </form>
    </section>
    <section id="archives-section" class="section-mouvante">
        <h2>
            ARCHIVES
        </h2>
    </section>
</div>