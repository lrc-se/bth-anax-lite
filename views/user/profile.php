        <h1><?= $app->esc($user->username) ?></h1>
        <img class="user-img" src="<?= $app->href($user->getImage(), true) ?>" alt="<?= $user->username ?>">
        <p>
            <?= $user->getAge() ?> år
            <br>
            <a href="mailto:<?= $app->esc($user->email) ?>"><?= $app->esc($user->email) ?></a>
<?php if ($user->isAdmin()) : ?>
            <br>
            <em><?= ($user->isAdmin(true) ? 'Superadministratör' : 'Administratör') ?></em>
<?php endif; ?>
        </p>
        <br>
        <p>
            <a class="button" href="<?= $app->href('user/profile/edit') ?>">Redigera profil</a>
<?php if ($user->isAdmin()) : ?>
            <a class="button" href="<?= $app->href('user/admin') ?>">Administrera användare</a>
<?php endif; ?>
            <a class="button" href="<?= $app->href('user/logout') ?>">Logga ut</a>
        </p>
