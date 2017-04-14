<?php if (!empty($err)) : ?>
        <p class="msg err"><span><?= $err ?></span></p>
<?php endif; ?>
<?php if (!empty($msg)) : ?>
        <p class="msg"><span><?= $msg ?></span></p>
<?php endif; ?>
        <form action="<?= $app->href($action) ?>" method="post">
<?php if ($user->id) : ?>
            <input type="hidden" name="id" value="<?= $user->id ?>">
<?php endif; ?>
            <label>
                Användarnamn:
                <input type="text" name="username" value="<?= $app->esc($user->username) ?>" maxlength="20" required>
            </label>
            <label>
                Lösenord (minst 8 tecken):
                <input type="password" name="password" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
            </label>
            <label>
                Upprepa lösenord:
                <input type="password" name="password2" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
            </label>
            <label>
                Födelsedatum (åååå-mm-dd):
                <input type="text" name="birthdate" value="<?= $app->esc($user->birthdate) ?>" maxlength="10" required>
            </label>
            <label>
                E-postadress:
                <input type="email" name="email" value="<?= $app->esc($user->email) ?>" maxlength="100" required>
            </label>
            <label>
                Bild (URL):
                <input type="text" name="image" value="<?= $app->esc($user->image) ?>" maxlength="500">
            </label>
<?php if ($admin) : ?>
            <label>
                Nivå:
<?php if ($user->id == $admin->id || $user->level > $admin->level) : ?>
                <span><?= ($admin->isAdmin(true) ? 'Superadministratör' : 'Administratör') ?></span>
<?php else : ?>
                <select name="level">
                    <option value="0"<?= ($user->level == 0 ? ' selected' : '') ?>>Användare</option>
                    <option value="1"<?= ($user->level == 1 ? ' selected' : '') ?>>Administratör</option>
<?php   if ($admin->isAdmin(true)) : ?>
                    <option value="2"<?= ($user->level == 2 ? ' selected' : '') ?>>Superadministratör</option>
<?php   endif; ?>
                </select>
            </label>
<?php endif; ?>
            <label>
                Aktiv:
                <input type="checkbox" name="active" value="1"<?= ($user->active ? ' checked' : '') ?>>
            </label>
<?php endif; ?>
            <input type="submit" value="<?= ($user->id ? 'Uppdatera' : 'Skapa') ?>">
        </form>
