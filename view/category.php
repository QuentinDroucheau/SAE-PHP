<script src="js/sub_menu_ajout_playlist.js" defer></script>
<script src="js/filtre_on_select.js" defer></script>
<link rel="stylesheet" href="styles/musicCard.css">
<link rel="stylesheet" href="styles/composantArtiste.css">
<link rel="stylesheet" href="styles/categorie.css">
<section class="retour">
  <a href="/"><img src="img/retour.png" alt="retour à l'accueil">
    <p>Retour</p>
  </a>
</section>
<section class="categorie-album">
  <div id="header-title">
  <h1><?= $category ?></h1>
  <form method="get" action="filtreView">
    <input type="hidden" name="category" value="<?= $category ?>">
    <label for="year">Année</label>
    <select name="year">
      <option value="">Tout</option>
      <?php
      $yearStart = 1970;
      $yearEnd = date("Y");

      for ($year = $yearStart; $year <= $yearEnd; $year++) {
        $selected = ($year == $selectedYear) ? 'selected' : '';
        echo "<option value='$year' $selected>$year</option>";
      }
      ?>
    </select>
    <label for="genre">Genre</label>
    <select name="genre">
      <option value="">Tout</option>
      <?php
      foreach ($genres as $genre) {
        $selected = ($genre->getId() == $selectedGenre) ? 'selected' : '';
        echo "<option value='{$genre->getId()}' $selected>{$genre->getNom()}</option>";
      }
      ?>
    </select>
    <label for="artistId">Artiste</label>
    <select name="artistId">
      <option value="">Tout</option>
      <?php
      foreach ($artistes as $artiste) {
        $selected = ($artiste->getId() == $selectedArtist) ? 'selected' : '';
        echo "<option value='{$artiste->getId()}' $selected>{$artiste->getNom()}</option>";
      }
      ?>
    </select>
  </form>
  </div>
  <div class="album-row">
    <?php foreach ($items as $item) : ?>
      <div class="list-item">
        <?= $item->render() ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>