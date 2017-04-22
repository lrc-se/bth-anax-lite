        <h1><?= $app->esc($user->username) ?></h1>
<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
        <div class="user">
            <img class="user-img" src="<?= $app->href($user->getImage(), true) ?>" alt="<?= $app->esc($user->username) ?>">
            <p>
                <?= $user->getAge() ?> år
                <br>
                <a href="mailto:<?= $app->esc($user->email) ?>"><?= str_replace('@', '@<wbr>', $app->esc($user->email)) ?></a>
<?php if ($user->isAdmin()) : ?>
                <br>
                <em><?= $user->getLevel() ?></em>
<?php endif; ?>
            </p>
        </div>
        <p><strong>Senaste inloggning: </strong><?= ($lastLogin ? date('Y-m-d H:i:s', $lastLogin) : '<em>Okänt</em>') ?></p>
        <br>
        <p>
            <a class="button" href="<?= $app->href('user/profile/edit') ?>">Redigera profil</a>
<?php if ($user->isAdmin()) : ?>
            <a class="button" href="<?= $app->href('user/admin') ?>">Administrera användare</a>
            <a class="button" href="<?= $app->href('user/content-admin') ?>">Administrera innehåll</a>
<?php endif; ?>
            <a class="button" href="<?= $app->href('user/logout') ?>">Logga ut</a>
        </p>
