<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
        <form class="user-form" action="<?= $app->href($action) ?>" method="post">
<?php if ($user->id) : ?>
            <input type="hidden" name="id" value="<?= $user->id ?>">
<?php endif; ?>
            <div class="form-input">
                <label class="label" for="username">Användarnamn:</label>
                <input id="username" class="field" type="text" name="username" value="<?= $app->esc($user->username) ?>" maxlength="20" required>
            </div>
            <div class="form-input">
                <label class="label" for="password">Lösenord:</label>
                <div class="field">
                    <input id="password" type="password" name="password" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
                    <span class="desc">(minst 8 tecken)</span>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="password2">Upprepa lösenord:</label>
                <input id="password2" class="field" type="password" name="password2" maxlength="50"<?= (!$user->id ? ' required' : '') ?>>
            </div>
            <div class="form-input">
                <label class="label" for="birthdate">Födelsedatum:</label>
                <div class="field">
                    <input id="birthdate" type="text" name="birthdate" value="<?= $app->esc($user->birthdate) ?>" maxlength="10" required>
                    <span class="desc">(åååå-mm-dd)</span>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="email">E-postadress:</label>
                <input id="email" class="field" type="email" name="email" value="<?= $app->esc($user->email) ?>" maxlength="100" required>
            </div>
            <div class="form-input">
                <label class="label" for="image">Bild-URL:</label>
                <div class="field">
                    <input id="image" type="text" name="image" value="<?= $app->esc($user->image) ?>" maxlength="500">
<?php if (!empty($user->image)) : ?>
                    <img class="user-img-small" src="<?= $app->href($user->image, true) ?>" alt="">
<?php endif; ?>
                </div>
            </div>
<?php if ($admin) : ?>
            <div class="form-input">
                <label class="label" for="level">Nivå:</label>
<?php if ($user->id == $admin->id) : ?>
                <span class="field field-static"><?= $admin->getLevel() ?></span>
<?php else : ?>
                <select id="level" class="field" name="level">
                    <option value="0"<?= ($user->level == 0 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[0] ?></option>
                    <option value="1"<?= ($user->level == 1 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[1] ?></option>
<?php   if ($admin->isAdmin(true)) : ?>
                    <option value="2"<?= ($user->level == 2 ? ' selected' : '') ?>><?= \LRC\User\User::LEVELS[2] ?></option>
<?php   endif; ?>
                </select>
<?php endif; ?>
            </div>
            <div class="form-input">
                <label class="label" for="active">Aktiv:</label>
                <div class="field"><input id="active" type="checkbox" name="active" value="1"<?= ($user->active ? ' checked' : '') ?>></div>
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
