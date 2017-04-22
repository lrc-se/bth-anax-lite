        <h1>Inlägg</h1>
        <p>blubb</p>
<?php if ($total > 0) : ?>
<?php   foreach ($entries as $n => $content) : ?>
        <section class="blog-post">
<?php   $this->renderView('blog-post', ['content' => $content, 'user' => $cf->getUser($content), 'link' => $link, 'shorten' => $shorten]); ?>
        </section>
<?php   endforeach; ?>
<?php   $this->renderView('incl/pagination-controls', ['page' => $page, 'max' => $max]); ?>
<?php else : ?>
        <p><em>Inga inlägg att visa</em></p>
<?php endif; ?>
