        <h1>Sessions&shy;innehåll</h1>
<?php $app->msg() ?>
        <p>Sessionen innehåller följande värden:</p>
        <pre><code><?= $app->session->dump() ?></code></pre>
        <br>
        <p><a class="button" href="<?= $app->href('session') ?>">« Tillbaka</a></p>

