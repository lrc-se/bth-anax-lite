        <h1 class="mobile-hide">Användar&shy;administration</h1>
        <h1 class="mobile-only">Admini&shy;stration</h1>
<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
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
            <table class="user-table">
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
                        <a href="?<?= $app->mergeQS(['sort' => 'email', 'desc' => (int)(!$params['desc'])]) ?>">E-post<span class="mobile-hide">adress</span></a><?= ($params['sort'] == 'email' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
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
        <div class="pagination-controls flex">
            <div class="prev">
<?php   if ($params['page'] > 1) : ?>
                <a class="button page-first" href="?<?= $app->mergeQS(['page' => 1]) ?>">«&nbsp;Första</a>
                <a class="button page-prev" href="?<?= $app->mergeQS(['page' => $params['page'] - 1]) ?>">‹&nbsp;Förra</a>
<?php   else : ?>
                <span class="button page-first disabled">«&nbsp;Första</span>
                <span class="button page-prev disabled">‹&nbsp;Förra</span>
<?php   endif; ?>
            </div>
            <span class="page-current">Sida <?= $params['page'] ?>&nbsp;av&nbsp;<?= $max ?></span>
            <div class="next">
<?php   if ($params['page'] < $max) : ?>
                <a class="button page-next" href="?<?= $app->mergeQS(['page' => $params['page'] + 1]) ?>">Nästa&nbsp;›</a>
                <a class="button page-last" href="?<?= $app->mergeQS(['page' => $max]) ?>">Sista&nbsp;»</a>
<?php   else : ?>
                <span class="button page-next disabled">Nästa&nbsp;›</span>
                <span class="button page-last disabled">Sista&nbsp;»</span>
<?php   endif; ?>
            </div>
        </div>
<?php endif; ?>
