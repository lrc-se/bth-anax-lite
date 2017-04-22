        <form action="" method="get">
            <div class="pagination-form flex">
<?php if (!empty($entries)) : ?>
                <div class="total">Visar <strong><?= $total ?></strong> post<?= ($total != 1 ? 'er' : '') ?></div>
<?php else : ?>
                <div class="total"><em>Inga poster att visa</em></div>
<?php endif; ?>
                <div class="num">
                    <label for="num"><strong>Antal per sida: </strong></label> &nbsp;
                    <select id="num" name="num" onchange="this.form.submit()"<?= (empty($entries) ? ' disabled' : '') ?>>
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
<?php if (!empty($entries)) : ?>
        <div class="xscroll" style="clear: both">
            <table class="user-table">
                <tr>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'id', 'desc' => (int)(!$params['desc'])]) ?>">ID</a><?= ($params['sort'] == 'id' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'title', 'desc' => (int)(!$params['desc'])]) ?>">Titel</a><?= ($params['sort'] == 'title' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'type', 'desc' => (int)(!$params['desc'])]) ?>">Typ</a><?= ($params['sort'] == 'type' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'label', 'desc' => (int)(!$params['desc'])]) ?>">Etikett</a><?= ($params['sort'] == 'label' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
<?php   if ($admin) : ?>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'username', 'desc' => (int)(!$params['desc'])]) ?>">Skapare</a><?= ($params['sort'] == 'username' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
<?php   endif; ?>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'created', 'desc' => (int)(!$params['desc'])]) ?>">Skapat</a><?= ($params['sort'] == 'created' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'updated', 'desc' => (int)(!$params['desc'])]) ?>">Uppdaterat</a><?= ($params['sort'] == 'updated' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'published', 'desc' => (int)(!$params['desc'])]) ?>">Publicerat</a><?= ($params['sort'] == 'published' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
<?php   if ($admin) : ?>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'deleted', 'desc' => (int)(!$params['desc'])]) ?>">Borttaget</a><?= ($params['sort'] == 'deleted' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
<?php   endif; ?>
                    <th>Åtgärd</th>
                </tr>
<?php   foreach ($entries as $content) : ?>
                <tr<?= (!$content->deleted ? ' class="deleted"' : '') ?>>
                    <td><?= $content->id ?></td>
                    <td>
<?php       if ($content->type == 'page') : ?>
                        <a href="<?= $app->href('content/page/' . $content->label) ?>"><?= $app->esc($content->title) ?></a>
<?php       elseif ($content->type == 'post') : ?>
                        <a href="<?= $app->href('content/blog/' . $content->id) ?>"><?= $app->esc($content->title) ?></a>
<?php       else : ?>
                        <?= $app->esc($content->title) ?>
<?php       endif; ?>
                    </td>
                    <td><?= $content->getType() ?></td>
                    <td><?= $content->label ?></td>
<?php       if ($admin) : ?>
<?php           $user = $cf->getUser($content); ?>
                    <td><?= ($user ? $user->username : '(okänd)') ?></td>
<?php       endif; ?>
                    <td><?= $content->created ?></td>
                    <td><?= $content->updated ?></td>
                    <td><?= $content->published ?></td>
<?php       if ($admin) : ?>
                    <td><?= $content->deleted ?></td>
<?php       endif; ?>
                    <td>
<?php       if ($admin) : ?>
<?php           if (!$user || $admin->level >= $user->level) : ?>
                    <a href="<?= $app->href('user/content/admin/edit/' . $content->id) ?>">Redigera</a><br>
<?php               if (is_null($content->deleted)) :?>
                    <a href="<?= $app->href('user/content/admin/delete/' . $content->id) ?>">Radera</a>
<?php               else : ?>
                    <a href="<?= $app->href('user/content/admin/restore/' . $content->id) ?>">Återställ</a>
<?php               endif; ?>
<?php           endif; ?>
<?php       else : ?>
                    <a href="<?= $app->href('user/content/edit/' . $content->id) ?>">Redigera</a><br>
                    <a href="<?= $app->href('user/content/delete/' . $content->id) ?>">Radera</a>
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
