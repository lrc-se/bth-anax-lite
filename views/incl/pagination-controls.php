        <div class="pagination-controls flex">
            <div class="prev">
<?php   if ($page > 1) : ?>
                <a class="button page-first" href="?<?= $app->mergeQS(['page' => 1]) ?>">«&nbsp;Första</a>
                <a class="button page-prev" href="?<?= $app->mergeQS(['page' => $page - 1]) ?>">‹&nbsp;Förra</a>
<?php   else : ?>
                <span class="button page-first disabled">«&nbsp;Första</span>
                <span class="button page-prev disabled">‹&nbsp;Förra</span>
<?php   endif; ?>
            </div>
            <span class="page-current">Sida <?= $page ?>&nbsp;av&nbsp;<?= $max ?></span>
            <div class="next">
<?php   if ($page < $max) : ?>
                <a class="button page-next" href="?<?= $app->mergeQS(['page' => $page + 1]) ?>">Nästa&nbsp;›</a>
                <a class="button page-last" href="?<?= $app->mergeQS(['page' => $max]) ?>">Sista&nbsp;»</a>
<?php   else : ?>
                <span class="button page-next disabled">Nästa&nbsp;›</span>
                <span class="button page-last disabled">Sista&nbsp;»</span>
<?php   endif; ?>
            </div>
        </div>
