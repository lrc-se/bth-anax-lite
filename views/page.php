<?php if (!empty($msg)) : ?>
        <div class="msg warning"><div><?= $msg ?></div></div>
<?php endif; ?>
        <h1><?= $app->esc($content->title) ?></h1>
<? $app->renderContent($content) ?>
