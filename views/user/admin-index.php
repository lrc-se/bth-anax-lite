        <h1>Användar&shy;administration</h1>
<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
        <h3>Registrerade användare</h3>
        <form action="" method="get">
            <p>
                <label><strong>Filter: </strong>&nbsp; <input type="text" name="search" value="<?= $app->esc($params['search']) ?>"></label> &nbsp;
                <input type="submit" value="Sök">
                <a class="button" href="<?= $app->href('user/admin?') . $app->mergeQS(['search' => null]) ?>">Rensa</a>
            </p>
<?php foreach ($params as $key => $val) : ?>
<?php   if ($key !== 'search') : ?>
            <input type="hidden" name="<?= $app->esc($key) ?>" value="<?= $app->esc($val) ?>">
<?php   endif; ?>
<?php endforeach; ?>
        </form>
<?php if (!empty($users)) : ?>
        <table class="user-table">
            <tr>
                <th>
                    <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'username', 'desc' => (int)(!$params['desc'])]) ?>">Användarnamn</a>
<?php   if ($params['sort'] == 'username') : ?>
                    <?= $arrow ?>
<?php   endif; ?>
                </th>
                <th>
                    <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'birthdate', 'desc' => (int)(!$params['desc'])]) ?>">Födelsedatum</a>
<?php   if ($params['sort'] == 'birthdate') : ?>
                    <?= $arrow ?>
<?php   endif; ?>
                </th>
                <th>
                    <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'email', 'desc' => (int)(!$params['desc'])]) ?>">E-postadress</a>
<?php   if ($params['sort'] == 'email') : ?>
                    <?= $arrow ?>
<?php   endif; ?>
                </th>
                <th>
                    <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'level', 'desc' => (int)(!$params['desc'])]) ?>">Nivå</a>
<?php   if ($params['sort'] == 'level') : ?>
                    <?= $arrow ?>
<?php   endif; ?>
                </th>
                <th>
                    <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'active', 'desc' => (int)(!$params['desc'])]) ?>">Aktiv</a>
<?php   if ($params['sort'] == 'active') : ?>
                    <?= $arrow ?>
<?php   endif; ?>
                </th>
                <th>Åtgärd</th>
            </tr>
<?php   foreach ($users as $user) : ?>
            <tr<?= (!$user->active ? ' class="inactive"' : '') ?>>
                <td><?= $app->esc($user->username) ?></td>
                <td><?= $user->birthdate ?></td>
                <td><a href="mailto:<?= $app->esc($user->email) ?>"><?= $app->esc($user->email) ?></a></td>
                <td><?= $user->getLevel() ?></td>
                <td><?= ($user->active ? 'Ja' : 'Nej') ?></td>
                <td>
                    <a href="<?= $app->href('user/admin/edit/' . $user->id) ?>">Redigera</a>
                    <a href="<?= $app->href('user/admin/delete/' . $user->id) ?>">Radera</a>
                </td>
            </tr>
<?php   endforeach; ?>
        </table>
<?php else: ?>
        <p><em>Inga användare att visa</em></p>
<?php endif; ?>
