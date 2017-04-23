        <h1>Användar&shy;admin<span class="mobile-hide">istration</span></h1>
<?php $app->msg('err') ?>
<?php $app->msg('msg') ?>
        <p><a class="button" href="<?= $app->href('user/admin/create') ?>">Skapa ny användare</a></p>
        <h3>Registrerade användare</h3>
        <form action="" method="get">
            <div class="flex flex-inline">
                <label for="search">Filter:</label>
                <input type="text" name="search" value="<?= $app->esc($params['search']) ?>">
                <div>
                    <input type="submit" value="Sök">
                    <a class="button" href="<?= $app->href('user/admin?') . $app->mergeQS(array_merge($params, ['search' => null])) ?>">Rensa</a>
                </div>
            </div>
            <div class="pagination-form flex">
<?php if (!empty($users)) : ?>
                <div class="total">Visar <strong><?= $matches ?></strong> av <strong><?= $total ?></strong> användare</div>
<?php else : ?>
                <div class="total"><em>Inga användare att visa</em></div>
<?php endif; ?>
                <div class="num">
                    <label for="num"><strong>Antal per sida: </strong></label> &nbsp;
                    <select id="num" name="num" onchange="this.form.submit()"<?= (empty($users) ? ' disabled' : '') ?>>
<?php foreach ($nums as $num) : ?>
                        <option value="<?= $num ?>"<?= ($params['num'] == $num ? ' selected' : '') ?>><?= ($num ?: 'Alla') ?></option>
<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <input type="hidden" name="sort" value="<?= $app->esc($params['sort']) ?>">
            <input type="hidden" name="desc" value="<?= $app->esc($params['desc']) ?>">
            <input type="hidden" name="page" value="<?= $app->esc($params['page']) ?>">
        </form>
<?php if (!empty($users)) : ?>
        <div class="xscroll" style="clear: both">
            <table class="object-table user-table">
                <tr>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'id', 'desc' => (int)(!$params['desc'])]) ?>">ID</a><?= ($params['sort'] == 'id' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'username', 'desc' => (int)(!$params['desc'])]) ?>"><span class="mobile-hide">Användarnamn</span><span class="mobile-only">Namn</span></a><?= ($params['sort'] == 'username' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'birthdate', 'desc' => (int)(!$params['desc'])]) ?>"><span class="mobile-hide">Födelsedatum</span><span class="mobile-only">Född</span></a><?= ($params['sort'] == 'birthdate' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'email', 'desc' => (int)(!$params['desc'])]) ?>">E&#8209;post<span class="mobile-hide">adress</span></a><?= ($params['sort'] == 'email' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'level', 'desc' => (int)(!$params['desc'])]) ?>">Nivå</a><?= ($params['sort'] == 'level' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'active', 'desc' => (int)(!$params['desc'])]) ?>">Aktiv</a><?= ($params['sort'] == 'active' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>Åtgärd</th>
                </tr>
<?php   foreach ($users as $user) : ?>
                <tr<?= (!$user->active ? ' class="inactive"' : '') ?>>
                    <td><?= $user->id ?></td>
                    <td><?= $app->esc($user->username) ?></td>
                    <td><?= $user->birthdate ?></td>
                    <td><a href="mailto:<?= $app->esc($user->email) ?>"><?= str_replace('@', '@<wbr>', $app->esc($user->email)) ?></a></td>
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
<?php   $this->renderView('incl/pagination-controls', ['page' => $params['page'], 'max' => $max]); ?>
<?php endif; ?>
