        <h1>Logga in</h1>
<?php if (!empty($err)) : ?>
        <p class="msg err"><span><?= $err ?></span></p>
<?php endif; ?>
<?php if (!empty($msg)) : ?>
        <p class="msg"><span><?= $msg ?></span></p>
<?php endif; ?>
<?php if ($user) : ?>
        <p>
            Du är inloggad som <strong><?= $app->esc($user->username) ?></strong>.
<?php if ($user->isAdmin()) : ?>
            Ditt konto har <?= ($user->isAdmin(true) ? 'super&shy;' : '') ?>administratörs&shy;rättigheter.
<?php endif; ?>
        </p>
        <a class="button" href="<?= $app->href('user/profile') ?>">Visa profil</a> &nbsp;
        <a class="button" href="<?= $app->href('user/logout') ?>">Logga ut</a>
<?php else : ?>
        <form action="<?= $app->href('user/login') ?>" method="post">
            <label>
                Användarnamn:
                <input type="text" name="username" maxlength="20" required>
            </label>
            <label>
                Lösenord:
                <input type="password" name="password" maxlength="50" required>
            </label>
            <input type="submit" value="Logga in">
        </form>
<?php endif; ?>
