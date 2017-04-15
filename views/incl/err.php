<?php $err = $this->app->session->getOnce('err'); ?>
<?php if (!empty($err)) : ?>
        <div class="msg err"><div><?= $err ?></div></div>
<?php endif; ?>
