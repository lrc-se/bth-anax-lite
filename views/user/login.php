        <h1>Logga in</h1>
<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
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
            <div class="form-input">
                <label>
                    <span class="label">Användarnamn:</span>
                    <input class="field" type="text" name="username" maxlength="20" required>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Lösenord:</span>
                    <input class="field" type="password" name="password" maxlength="50" required>
                </label>
            </div>
            <div class="form-input">
                <span class="label"></span>
                <input class="field" type="submit" value="Logga in">
            </div>
        </form>
<?php endif; ?>
