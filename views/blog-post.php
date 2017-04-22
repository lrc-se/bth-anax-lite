<?php if (!empty($msg)) : ?>
        <div class="msg warning"><div><?= $msg ?></div></div>
<?php endif; ?>
<?php if ($link) : ?>
        <h3><a href="<?= $app->href('content/blog/' . $content->id) ?>"><?= $app->esc($content->title) ?></a></h3>
<?php else : ?>
        <h1><?= $app->esc($content->title) ?></h1>
<?php endif; ?>
        <div class="blog-header">
            <div>
                <div class="blog-author">Av <?= ($user ? '<a href="mailto:' . $app->esc($user->email) . '">' . $app->esc($user->username) . '</a>' : '(okänd)') ?></div>
                <div class="blog-time">
<?php if ($content->published) : ?>
                    <span class="blog-published"><strong>Publicerat:</strong> <time datetime="<?= $content->published ?>"><?= $content->published ?></time></span>
<?php endif; ?>
<?php if ($content->updated) : ?>
                    <span class="blog-updated"><strong>Uppdaterat:</strong> <time datetime="<?= $content->updated ?>"><?= $content->updated ?></time></span>
<?php endif; ?>
                </div>
            </div>
        </div>
<?php

$output = $app->renderContent($content, false);
echo ($excerpt ? $app->getExcerpt($output) : $output);
