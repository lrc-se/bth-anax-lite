        <h1>Ta bort innehåll</h1>
        <h5>Är du helt säker på att du vill ta bort detta innehåll?</h5>
        <br>
        <dl>
<?php if ($admin) : ?>
            <dt>ID:</dt>
            <dd><?= $content->id ?></dd>
<?php endif; ?>
            <dt>Titel:</dt>
            <dd><?= $app->esc($content->title) ?></dd>
            <dt>Typ:</dt>
            <dd><?= $content->getType() ?></dd>
<?php if ($content->label) : ?>
            <dt>Etikett:</dt>
            <dd><?= $content->label ?></dd>
<?php endif; ?>
<?php if ($admin) : ?>
            <dt>Skapare:</dt>
            <dd><?= $app->esc($user->username) ?></dd>
<?php endif; ?>
            <dt>Skapat:</dt>
            <dd><?= $app->esc($content->created) ?></dd>
<?php if ($content->updated) : ?>
            <dt>Uppdaterat:</dt>
            <dd><?= $content->updated ?></dd>
<?php endif; ?>
            <dt>Publicerat:</dt>
            <dd><?= ($content->published ?: 'Nej') ?></dd>
        </dl>
        <br>
        <form action="<?= $app->href('user/content' . ($admin ? '/admin' : '') . '/delete/' . $content->id) ?>" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="submit" value="Ta bort">
            <a class="button" href="<?= $app->href('user/content' . ($admin ? '/admin' : '')) ?>">Avbryt</a>
        </form>
