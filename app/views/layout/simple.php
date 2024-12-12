<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= BASE_URL.'/public/css/tailwind.css' ?>">
    <?php
        // Import CSS files here
        foreach ($assetList as $asset) {
            if ($asset['type'] == 'css') {
                echo " <link rel=\"stylesheet\" href=\"".$asset['path']."\">";
            }
        }
    ?>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-full mx-auto p-4">
        <?php echo $content; ?>
    </div>
    <?php
        // Import JS files here
        foreach ($assetList as $asset) {
            if ($asset['type'] == 'js') {
                echo "<script src=\"". $asset['path']."\"></script>";
            }
        }
    ?>
</body>
</html>
