<link rel="stylesheet" href="styles/admin.css">
<script src="js/admin.js"></script>
<section>
    <h1>
        ADMINISTRATION
    </h1>
    <nav class="admin-artiste">
        <ul>
            <li>
                <a href="#" onclick="showSection('albums'); return false;">ALBUMS</a>
            </li>
            <li>
                <a href="#" onclick="showSection('musiques'); return false;">MUSIQUES</a>
            </li>
            <li>
                <a href="#" onclick="showSection('artistes'); return false;">ARTISTES</a>
            </li>
            <li>
                <a href="#" onclick="showSection('genres'); return false;">GENRES</a>
            </li>
            <li>
                <a href="#" onclick="showSection('utilisateurs'); return false;">UTILISATEURS</a>
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
    <section id="musiques-section" class="section-mouvante">
        <table>
            <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach($musiques as $musique) {
                echo "<form class='musiques-form' action='/administrateur' method='post'>";
                echo "<tr>";
                echo "<td>";
                echo $musique->getNom();
                echo "</td>";
                echo "<td>";
                echo $musique->getArtisteMusique($musique->getId());
                echo "</td>";
                echo "<td>";
                echo "<input type='hidden' name='action' value='supprimer'>";
                echo "<input type='hidden' name='id' value=" . $musique->getId() .">";
                echo "<input type='hidden' name='type' value='musique'>";
                echo "<button type='submit'>Supprimer la musique</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
            ?>
        </table>
    </section>
    <section id="artistes-section" class="section-mouvante">
        <table>
            <tr>
                <th>Nom</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach($artistes as $artiste) {
                echo "<form class='artistes-form' action='/administrateur' method='post'>";
                echo "<tr>";
                echo "<td>";
                echo $artiste->getNom();
                echo "</td>";
                echo "<td>";
                echo "<input type='hidden' name='action' value='supprimer'>";
                echo "<input type='hidden' name='id' value=" . $artiste->getId() .">";
                echo "<input type='hidden' name='type' value='artiste'>";
                echo "<button type='submit'>Supprimer l'artiste</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
            ?>
        </table>
    </section>
    <section id="genres-section" class="section-mouvante">
        <table>
            <tr>
                <th>Nom</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach($genres as $genre) {
                echo "<form class='genres-form' action='/administrateur' method='post'>";
                echo "<tr>";
                echo "<td>";
                echo $genre->getNom();
                echo "</td>";
                echo "<td>";
                echo "<input type='hidden' name='action' value='supprimer'>";
                echo "<input type='hidden' name='id' value=" . $genre->getId() .">";
                echo "<input type='hidden' name='type' value='genre'>";
                echo "<button type='submit'>Supprimer le genre</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
            ?>
        </table>
    </section>
    <section id="utilisateurs-section" class="section-mouvante">
        <table>
            <tr>
                <th>Pseudo</th>
                <th>Mot de passe</th>
                <th>Role</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach($utilisateurs as $utilisateur) {
                echo "<form class='utilisateurs-form' action='/administrateur' method='post'>";
                echo "<tr>";
                echo "<td>";
                echo $utilisateur->getPseudoU();
                echo "</td>";
                echo "<td>";
                echo $utilisateur->getMdpU();
                echo "</td>";
                echo "<td>";
                echo $utilisateur->getRoleU();
                echo "</td>";
                echo "<td>";
                echo "<input type='hidden' name='action' value='supprimer'>";
                echo "<input type='hidden' name='id' value=" . $utilisateur->getId() .">";
                echo "<input type='hidden' name='type' value='utilisateur'>";
                echo "<button type='submit'>Supprimer l'utilisateur</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
            ?>
        </table>
    </section>
</section>