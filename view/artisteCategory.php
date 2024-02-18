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
  </div>
  <div class="album-row">
    <?php foreach ($items as $item) : ?>
      <div class="list-item">
        <?= $item->render() ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>