<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?> | Kalles sida</title>
    <link href="<?= $app->url->asset('css/style.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Averia+Sans+Libre:300,400i,900,900i%7CNova+Oval" rel="stylesheet"> 
    <link href="<?= $app->url->asset('favicon.ico') ?>" rel="shortcut icon">
</head>
<body>
<header>
<?php include 'navbar.php'; ?>
</header>
<?php
if (!empty($flash)) {
    include 'flash.php';
}
?>
<main>
    <article class="container">
