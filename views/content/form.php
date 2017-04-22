<?php $this->renderView('incl/err') ?>
<?php $this->renderView('incl/msg') ?>
        <form class="object-form" action="<?= $app->href($action) ?>" method="post">
<?php if ($content->id) : ?>
            <input type="hidden" name="id" value="<?= $content->id ?>">
<?php endif; ?>
            <div class="form-input">
                <label class="label" for="title">Titel:</label>
                <div class="field">
                    <input id="title" type="text" name="title" value="<?= $app->esc($content->title) ?>" maxlength="100" required>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="type">Typ:</label>
                <div class="field">
                    <select id="type" name="type">
<?php foreach (\LRC\Content\Content::TYPES as $type => $title) : ?>
                        <option value="<?= $type ?>"<?= ($content->type == $type ? ' selected' : '') ?>><?= $title ?></option>
<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="label">Etikett:</label>
                <div class="field">
                    <input id="label" type="text" name="label" value="<?= $app->esc($content->label) ?>" maxlength="50">
                    <span class="desc">(bokstäver A-Z, siffror, bindestreck)</span>
                </div>
            </div>
<?php if ($admin) : ?>
            <div class="form-input">
                <label class="label" for="userId">Skapare:</label>
<?php   if ($admin->isAdmin(true)) : ?>
                <div class="field">
                    <select id="userId" name="userId">
                        <option value=""<?= (is_null($content->userId) ? ' selected' : '') ?>>(okänd)</option>
<?php       foreach ($users as $user) : ?>
                        <option value="<?= $user->id ?>"<?= ($content->userId == $user->id ? ' selected' : '') ?>><?= $app->esc($user->username) ?></option>
<?php       endforeach; ?>
                    </select>
                </div>
<?php   else: ?>
                <span class="field field-static"><?= $app->esc(($user ? $user->username : '(okänd)')) ?></span>
<?php   endif; ?>
            </div>
<?php endif; ?>
            <div class="form-input">
                <label class="label" for="formatters">Formaterare:</label>
                <div class="field">
                    <select id="formatters" name="formatters">
                        <option value="nl2br"<?= ($content->formatters == 'nl2br' ? ' selected' : '') ?>>Endast radbrytningar</option>
                        <option value="nl2br,link"<?= ($content->formatters == 'nl2br,link' ? ' selected' : '') ?>>Klickbara länkar</option>
                        <option value="nl2br,bbcode"<?= ($content->formatters == 'nl2br,bbcode' ? ' selected' : '') ?>>BBCode</option>
                        <option value="markdown"<?= ($content->formatters == 'markdown' || empty($content->formatters) ? ' selected' : '') ?>>Markdown</option>
                    </select>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="published">Publiceringstid:</label>
                <div class="field">
                    <div>
                        <input id="publish-now" type="radio" name="publish" value="now"<?= ($publish == 'now' || empty($publish) ? ' checked' : '') ?>><label for="publish-now">&nbsp;Nu</label><br>
<?php if ($content->id) : ?>
<?php   if ($published) : ?>
                        <input id="publish-same" type="radio" name="publish" value="same"<?= ($publish == 'same' ? ' checked' : '') ?>><label for="publish-same">&nbsp;Ingen ändring</label><br>
<?php   endif; ?>
                        <input id="publish-un" type="radio" name="publish" value="un"<?= ($publish == 'un' ? ' checked' : '') ?>><label for="publish-un">&nbsp;Avpublicerad</label><br>
<?php endif; ?>
                        <input id="publish-other" type="radio" name="publish" value="other"<?= ($publish == 'other' ? ' checked' : '') ?>><label for="publish-other">&nbsp;Annan tid:</label>
                    </div>
                    <input id="published" type="text" name="published" value="<?= ($content->published !== 'now' ? $content->published : '') ?>" maxlength="19">
                    <span class="desc">(åååå-mm-dd hh:mm:ss)</span>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="content">Innehåll:</label>
                <div class="field">
                    <textarea id="content" name="content" rows="25"><?= $app->esc($content->content) ?></textarea>
                </div>
            </div>
            <div class="form-input">
                <span class="label"></span>
                <div class="field">
                    <input type="submit" value="<?= ($content->id ? 'Uppdatera' : 'Skapa') ?>">
                    <a class="button" href="<?= $app->href('user/content' . ($admin ? '-admin' : '')) ?>">Tillbaka</a>
                </div>
            </div>
        </form>
