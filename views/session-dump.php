        <h1>Sessions&shy;innehåll</h1>
<?php if (!empty($msg)) : ?>
        <p class="msg"><span><?= $msg ?></span></p>
<?php endif; ?>
        <p>Sessionen innehåller följande värden:</p>
        <pre><code><?= $app->session->dump() ?></code></pre>
        <br>
        <p><a class="button" href="<?= $app->url->create('session') ?>">« Tillbaka</a></p>

