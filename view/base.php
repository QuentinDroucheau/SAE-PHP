<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/base.css">
</head>
<body>
    <?php echo isset($header) ? $header : "";?>
    <div class="contenu">
        <div class="page">
            <?php echo isset($content) ? $content : ""; ?>
        </div>
        <?php echo isset($menu) ? $menu : "";?>
    </div>
</body>
</html>
