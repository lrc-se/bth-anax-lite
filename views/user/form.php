<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
        <form class="user-form" action="<?= $app->href($action) ?>" method="post">
<?php if ($user->id) : ?>
            <input type="hidden" name="id" value="<?= $user->id ?>">
<?php endif; ?>
            <div class="form-input">
                <label>
                    <span class="label">Användarnamn:</span>
                    <input class="field" type="text" name="username" value="<?= $app->esc($user->username) ?>" maxlength="20" required>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Lösenord:</span>
                    <div class="field">
                        <input type="password" name="password" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
                        <span class="desc">(minst 8 tecken)</span>
                    </div>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Upprepa lösenord:</span>
                    <input class="field" type="password" name="password2" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Födelsedatum:</span>
                    <div class="field">
                        <input type="text" name="birthdate" value="<?= $app->esc($user->birthdate) ?>" maxlength="10" required>
                        <span class="desc">(åååå-mm-dd)</span>
                    </div>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">E-postadress:</span>
                    <input class="field" type="email" name="email" value="<?= $app->esc($user->email) ?>" maxlength="100" required>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Bild-URL:</span>
                    <div class="field">
                        <input type="text" name="image" value="<?= $app->esc($user->image) ?>" maxlength="500">
<?php if (!empty($user->image)) : ?>
                        <img class="user-img-small" src="<?= $app->href($user->image, true) ?>" alt="">
<?php endif; ?>
                    </div>
                </label>
            </div>
<?php if ($admin) : ?>
            <div class="form-input">
                <label>
                    <span class="label">Nivå:</span>
<?php if ($user->id == $admin->id) : ?>
                    <span class="field field-static"><?= $admin->getLevel() ?></span>
<?php else : ?>
                    <select class="field" name="level">
                        <option value="0"<?= ($user->level == 0 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[0] ?></option>
                        <option value="1"<?= ($user->level == 1 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[1] ?></option>
<?php   if ($admin->isAdmin(true)) : ?>
                        <option value="2"<?= ($user->level == 2 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[2] ?></option>
<?php   endif; ?>
                    </select>
<?php endif; ?>
                </label>
            </div>
            <div class="form-input">
                <label>
                    <span class="label">Aktiv:</span>
                    <input class="field" type="checkbox" name="active" value="1"<?= ($user->active ? ' checked' : '') ?>>
                </label>
            </div>
<?php endif; ?>
            <div class="form-input">
                <span class="label"></span>
                <div class="field">
                    <input type="submit" value="<?= ($user->id ? 'Uppdatera' : 'Skapa') ?>">
<?php if (strpos($action, 'edit') !== false) : ?>
                    <a class="button" href="<?= $app->href(($admin ? 'user/admin' : 'user/profile')) ?>">Avbryt</a>
<?php endif; ?>
                </div>
            </div>
        </form>
