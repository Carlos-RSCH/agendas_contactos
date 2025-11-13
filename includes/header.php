<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Agenda de contactos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body> 
<header class="site-header"> 
    <div class="container">
        <h1 class="logo"><a href="index.php">Agenda de contactos</a></h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="create.php">Nuevo contacto</a>
        </nav>
    </div>
</header>

<main class="container">
    <?php foreach (get_flashes() as $flash): ?>
        <div class="alert <?= e($flash['type']) ?>">
            <?= e($flash['message']) ?>
        </div>
    <?php endforeach; ?>

