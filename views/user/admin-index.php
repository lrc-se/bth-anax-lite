        <h1 class="mobile-hide">Användar&shy;administration</h1>
        <h1 class="mobile-only">Admini&shy;stration</h1>
<?php $this->renderView('incl/err', $data) ?>
<?php $this->renderView('incl/msg', $data) ?>
        <p><a class="button" href="<?= $app->href('user/admin/create') ?>">Skapa ny användare</a></p>
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
        <div class="xscroll">
            <table class="user-table">
                <tr>
                    <th>
                        <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'username', 'desc' => (int)(!$params['desc'])]) ?>"><span class="mobile-hide">Användarnamn</span><span class="mobile-only">Namn</span></a><?= ($params['sort'] == 'username' ? "&nbsp;$arrow" : '') ?>
                    </th>
                    <th>
                        <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'birthdate', 'desc' => (int)(!$params['desc'])]) ?>"><span class="mobile-hide">Födelsedatum</span><span class="mobile-only">Född</span></a><?= ($params['sort'] == 'birthdate' ? "&nbsp;$arrow" : '') ?>
                    </th>
                    <th>
                        <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'email', 'desc' => (int)(!$params['desc'])]) ?>">E-post<span class="mobile-hide">adress</span></a><?= ($params['sort'] == 'email' ? "&nbsp;$arrow" : '') ?>
                    </th>
                    <th>
                        <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'level', 'desc' => (int)(!$params['desc'])]) ?>">Nivå</a><?= ($params['sort'] == 'level' ? "&nbsp;$arrow" : '') ?>
                    </th>
                    <th>
                        <a href="<?= $app->href('user/admin?') . $app->mergeQS(['sort' => 'active', 'desc' => (int)(!$params['desc'])]) ?>">Aktiv</a><?= ($params['sort'] == 'active' ? "&nbsp;$arrow" : '') ?>
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
<?php       if ($admin->level >= $user->level) : ?>
                        <a href="<?= $app->href('user/admin/edit/' . $user->id) ?>">Redigera</a><br>
<?php           if ($admin->id != $user->id) : ?>
                        <a href="<?= $app->href('user/admin/delete/' . $user->id) ?>">Radera</a>
<?php           endif; ?>
<?php       endif; ?>
                    </td>
                </tr>
<?php   endforeach; ?>
            </table>
        </div>
<?php else: ?>
        <p><em>Inga användare att visa</em></p>
<?php endif; ?>
