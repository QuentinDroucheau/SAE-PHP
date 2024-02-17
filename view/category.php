<script src="js/sub_menu_ajout_playlist.js" defer></script>

<link rel="stylesheet" href="styles/musicCard.css">
<link rel="stylesheet" href="styles/composantArtiste.css">
<link rel="stylesheet" href="styles/categorie.css">
<section class="retour">
  <a href="/"><img src="img/retour.png" alt="retour à l'accueil">
    <p>Retour</p>
  </a>
</section>
<section class="categorie-album">
  <h1><?= $category ?></h1>
  <form method="get" action="filtreView">
    <input type="hidden" name="category" value="<?= $category ?>">
    <select name="year">
      <option value="">Tout</option>
      <?php
      $yearStart = 2000;
      $yearEnd = date("Y");

      for ($year = $yearStart; $year <= $yearEnd; $year++) {
        echo "<option value='$year'>$year</option>";
      }
      ?>
    </select>
    <select name="genre">
      <option value="">Tout</option>
      <?php
      foreach ($genres as $genre) {
        echo "<option value='{$genre->getId()}'>{$genre->getNom()}</option>";
        echo "<!-- Debug: Genre nom: {$genre->getNom()} -->";
      }
      ?>
    </select>

    <input type="submit" value="Filtrer">
  </form>

  <div class="album-row">
    <?php foreach ($items as $item) : ?>
      <div class="list-item">
        <?= $item->render() ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>