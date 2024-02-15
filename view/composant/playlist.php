<div class="element">
  <div>
    <img class="pochette" src=<?php echo $image; ?> alt="" onclick="redirect(<?php echo $id; ?>)";>
  </div>
  <div class="text">
    <div class="title">
      <p><?php echo $titre?></p>
      <div class="title-info">
      </div>
      <?php echo $nbMusiques . " Titre(s)" ?>
    </div>
    <p>Mis a jour le <?php echo $dateMaj  ?></p>
  </div>
</div>