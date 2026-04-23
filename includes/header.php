<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Mini Forum' ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- JS -->
    <script src="js/app.js" defer></script>
</head>
<body>
<?php require __DIR__ . '/nav.php'; ?>
