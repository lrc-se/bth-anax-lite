<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
        <form class="user-form" action="<?= $app->href($action) ?>" method="post">
<?php if ($user->id) : ?>
            <input type="hidden" name="id" value="<?= $user->id ?>">
<?php endif; ?>
            <label class="form-input">
                <span class="label">Användarnamn:</span>
                <input type="text" name="username" value="<?= $app->esc($user->username) ?>" maxlength="20" required>
            </label>
            <label class="form-input">
                <span class="label">Lösenord:</span>
                <input type="password" name="password" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
                <span class="desc">(minst 8 tecken)</span>
            </label>
            <label class="form-input">
                <span class="label">Upprepa lösenord:</span>
                <input type="password" name="password2" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
            </label>
            <label class="form-input">
                <span class="label">Födelsedatum:</span>
                <input type="text" name="birthdate" value="<?= $app->esc($user->birthdate) ?>" maxlength="10" required>
                <span class="desc">(åååå-mm-dd)</span>
            </label>
            <label class="form-input">
                <span class="label">E-postadress:</span>
                <input type="email" name="email" value="<?= $app->esc($user->email) ?>" maxlength="100" required>
            </label>
            <label class="form-input">
                <span class="label">Bild-URL:</span>
                <input type="text" name="image" value="<?= $app->esc($user->image) ?>" maxlength="500">
<?php if (!empty($user->image)) : ?>
                <img class="user-img-small" src="<?= $app->href($user->image, true) ?>" alt="">
<?php endif; ?>
            </label>
<?php if ($admin) : ?>
            <label class="form-input">
                <span class="label">Nivå:</span>
<?php if ($user->id == $admin->id || $user->level > $admin->level) : ?>
                <span class="field"><?= ($admin->isAdmin(true) ? 'Superadministratör' : 'Administratör') ?></span>
<?php else : ?>
                <select name="level">
                    <option value="0"<?= ($user->level == 0 ? ' selected' : '') ?>>Användare</option>
                    <option value="1"<?= ($user->level == 1 ? ' selected' : '') ?>>Administratör</option>
<?php   if ($admin->isAdmin(true)) : ?>
                    <option value="2"<?= ($user->level == 2 ? ' selected' : '') ?>>Superadministratör</option>
<?php   endif; ?>
                </select>
<?php endif; ?>
            </label>
            <label class="form-input">
                <span class="label">Aktiv:</span>
                <input type="checkbox" name="active" value="1"<?= ($user->active ? ' checked' : '') ?>>
            </label>
<?php endif; ?>
            <div class="form-input">
                <span class="label"></span>
                <input type="submit" value="<?= ($user->id ? 'Uppdatera' : 'Skapa') ?>">
<?php if (strpos($action, 'edit') !== false) : ?>
                <a class="button" href="<?= $app->href(($admin ? 'user/admin' : 'user/profile')) ?>">Avbryt</a>
<?php endif; ?>
            </div>
        </form>
