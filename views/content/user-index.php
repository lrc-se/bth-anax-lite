        <h1>Hantera innehåll</h1>
<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
        <p><a class="button" href="<?= $app->href('user/content/create') ?>">Skapa nytt innehåll</a></p>
<?php include 'list.php'; ?>
