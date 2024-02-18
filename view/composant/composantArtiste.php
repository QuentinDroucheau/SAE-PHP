<script>
function redirectArtist(id) {
  window.location.href = "/artiste?id=" + id;
}
</script>

<div class="artiste" data-id="<?php echo $id; ?>" onclick="redirectArtist(<?php echo $id; ?>)">
    <div class="circle" style="background-image: url('<?php echo $image; ?>');"></div>
    <div class="name"><?php echo $nom?></div>
</div>