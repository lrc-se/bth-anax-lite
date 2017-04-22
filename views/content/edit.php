        <h1>Redigera innehåll</h1>
<?php if ($content->isPage()) : ?>
        <p><a class="button" href="<?= $app->href('content/page/' . $content->label) ?>">Visa innehåll</a></p>
<?php elseif ($content->isPost()) : ?>
        <p><a class="button" href="<?= $app->href('content/blog/' . $content->id) ?>">Visa innehåll</a></p>
<?php endif; ?>
