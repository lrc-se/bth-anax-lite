        <h1>Sessionstest</h1>
        <p>Testa ramverkets sessionsfunktion genom att klicka på nedanstående knappar.</p>
        <br>
<?php if (!empty($msg)) : ?>
        <p class="msg"><span><?= $msg ?></span></p>
<?php endif; ?>
        <p><strong>Nuvarande värde: <code><?= $app->session->get('number', 0) ?></code></strong></p>
        <p>
            <a class="button" href="<?= $app->url->create('session/increment') ?>">Öka värdet</a>
            <a class="button" href="<?= $app->url->create('session/decrement') ?>">Minska värdet</a>
            <a class="button" href="<?= $app->url->create('session/status') ?>">Visa status</a>
            <a class="button" href="<?= $app->url->create('session/dump') ?>">Visa sessionsinnehåll</a>
            <a class="button" href="<?= $app->url->create('session/destroy') ?>">Rensa sessionen</a>
        </p>
