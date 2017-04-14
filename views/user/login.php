        <h1>Logga in</h1>
<?php if (!empty($err)) : ?>
        <div class="msg err"><div><?= $err ?></div></div>
<?php endif; ?>
<?php if (!empty($msg)) : ?>
        <div class="msg"><div><?= $msg ?></div></div>
<?php endif; ?>
<?php if ($user) : ?>
        <p>
            Du är inloggad som <strong><?= $app->esc($user->username) ?></strong>.
<?php if ($user->isAdmin()) : ?>
            Ditt konto har <?= ($user->isAdmin(true) ? 'super&shy;' : '') ?>administratörs&shy;rättigheter.
<?php endif; ?>
        </p>
        <br>
        <a class="button" href="<?= $app->href('user/profile') ?>">Visa profil</a>
        <a class="button" href="<?= $app->href('user/logout') ?>">Logga ut</a>
<?php else : ?>
        <form action="<?= $app->href('user/login') ?>" method="post">
            <label class="form-input">
                <span class="label">Användarnamn:</span>
                <input type="text" name="username" maxlength="20" required>
            </label>
            <label class="form-input">
                <span class="label">Lösenord:</span>
                <input type="password" name="password" maxlength="50" required>
            </label>
            <div class="form-input">
                <span class="label"></span>
                <input type="submit" value="Logga in">
            </label>
        </form>
<?php endif; ?>
