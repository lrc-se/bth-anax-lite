        <h1>Innehålls&shy;administration</h1>
<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
        <p><a class="button" href="<?= $app->href('user/content-admin/create') ?>">Skapa nytt innehåll</a></p>
<?php include 'list.php'; ?>
