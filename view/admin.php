<link rel="stylesheet" href="styles/admin.css">
<script src="js/admin.js"></script>
<section>
    <h1>
        ADMINISTRATION
    </h1>
    <nav class="admin-artiste">
        <ul>
            <li>
                <a href="#" onclick="showSection('albums'); showTitre('albums'); return false;">ALBUMS</a>
            </li>
            <li>
                <a href="#" onclick="showSection('playlists'); showTitre('archives'); return false;">ARCHIVES</a>
            </li>
        </ul>
    </nav>
    <section id="albums-section" class="section-mouvante">
        <table>
            <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Année</th>
                <th>Image</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach($albums as $album) {
                echo "<form class='albums-form' action='/administrateur' method='post'>";
                echo "<tr>";
                echo "<td>";
                echo $album->getTitre();
                echo "</td>";
                echo "<td>";
                echo $album->getAuteur()->getNom();
                echo "</td>";
                echo "<td>";
                echo $album->getAnneeAlbum()->format("d/m/Y");
                echo "</td>";
                echo "<td>";
                echo "<img src=" . $album->getImage() . " alt='image album'>";
                echo "</td>";
                echo "<td>";
                // echo "<a href='/admin?action=supprimer&idAlbum=" . $album->getId() . "'>Supprimer</a>";
                echo "<input type='hidden' name='action' value='supprimer'>";
                echo "<input type='hidden' name='id' value=" . $album->getId() .">";
                echo "<input type='hidden' name='type' value='album'>";
                echo "<button type='submit'>Supprimer l'album</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
            ?>
        </table>
    </section>
    <section id="playlists-section" class="section-mouvante">
        <table>
            <!-- <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Année</th>
                <th>Image</th>
                <th>Supprimer</th> -->
            <!-- </tr> -->
            <!-- <?php
            // foreach($playlists as $playlist) {
            //     echo "<tr>";
            //     echo "<td>";
            //     echo $playlist->getTitrePlaylist();
            //     echo "</td>";
            //     echo "<td>";
            //     echo $playlist->getArtiste()->getNomArtiste();
            //     echo "</td>";
            //     echo "<td>";
            //     echo $playlist->getAnneePlaylist();
            //     echo "</td>";
                // echo "<td>";
                // echo "<img src='fixtures/images/" . $playlist->getImgPlaylist() . "' alt='image playlist'>";
                // echo "</td>";
                // echo "<td>";
                // echo "<a href='/admin?action=supprimerPlaylist&idPlaylist=" . $playlist->getIdPlaylist() . "'>Supprimer</a>";
                // echo "</td>";
                // echo "</tr>";
            // }
            ?> -->
        </table>

</section>