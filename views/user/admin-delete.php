        <h1>Ta bort användare</h1>
        <h4>Är du helt säker på att du vill ta bort denna användare?</h4>
        <p><strong>Detta kan inte ångras!</strong></p>
        <dl>
            <dt>ID</dt>
            <dd><?= $user->id ?></dd>
            <dt>Användarnamn</dt>
            <dd><?= $app->esc($user->username) ?></dd>
            <dt>Födelsedatum</dt>
            <dd><?= $user->birthdate ?></dd>
            <dt>E-postadress</dt>
            <dd><?= $app->esc($user->email) ?></dd>
            <dt>Nivå</dt>
            <dd><?= $user->getLevel() ?></dd>
            <dt>Aktiv</dt>
            <dd><?= ($user->active ? 'Ja' : 'Nej') ?></dd>
        </dl>
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="submit" value="Ta bort">
            <a class="button" href="<?= $app->href('user/admin') ?>">Avbryt</a>
        </form>
