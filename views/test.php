        <h1>TEST</h1>
<?php if (!empty($texts)) : ?>
        <h3>Textformaterare</h3>
<?php   foreach ($texts as $title => $text) : ?>
        <h5><?= $title ?></h5>
        <pre class="wrap"><?= $app->esc($text) ?></pre>
        <p><?= $this->app->format->apply($text, $title) ?></p>
<?php   endforeach; ?>
<?php endif; ?>
