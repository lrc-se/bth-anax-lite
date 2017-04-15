        <h1>Logga in</h1>
<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
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
                <label class="label" for="username">Användarnamn:</label>
                <div class="field">
                    <input id="username" type="text" name="username" maxlength="20" required autofocus>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="password">Lösenord:</label>
                <div class="field">
                    <input id="password" type="password" name="password" maxlength="50" required>
                </div>
            </div>
            <div class="form-input">
                <span class="label"></span>
                <div class="field">
                    <input type="submit" value="Logga in">
                </div>
            </div>
<?php if (isset($redirect)) : ?>
            <input type="hidden" name="redirect" value="<?= $redirect ?>">
<?php endif; ?>
        </form>
<?php endif; ?>
