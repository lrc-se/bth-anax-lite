    <nav class="<?= $app->navbar->getData('class') ?> container clear">
        <button id="menu-toggle">Meny</button>
        <a class="logo" href="<?= $app->href('') ?>">Kalles sida</a>
<?= $app->navbar->renderItems() ?>
    </nav>
