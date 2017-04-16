<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $app->esc($title) ?> | Kalles sida</title>
    <link href="<?= $app->href('css/style.css', true) ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Averia+Sans+Libre:300,400i,900,900i%7CNova+Oval" rel="stylesheet"> 
    <link href="<?= $app->href('favicon.ico', true) ?>" rel="shortcut icon">
</head>
<body>
<header>
<?php include 'navbar2.php'; ?>
</header>
<?php
if (!empty($flash)) {
    include 'flash.php';
}
?>
<main>
    <article class="container">
