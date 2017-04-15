<?php $msg = $this->app->session->getOnce('msg'); ?>
<?php if (!empty($msg)) : ?>
        <div class="msg"><div><?= $msg ?></div></div>
<?php endif; ?>
