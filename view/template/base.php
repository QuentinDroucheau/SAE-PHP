<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/base.css">
    <script src="js/base.js" defer></script>
</head>
<body>
    <div id="overlay"></div>
    <?php echo isset($header) ? $header : "";?>
    <div class="contenu">
        <div class="page">
            <?php echo isset($content) ? $content : ""; ?>
        </div>
        <?php echo isset($menu) ? $menu : "";?>
        <?php echo isset($popup) ? $popup : "";?>
    </div>
</body>
</html>
