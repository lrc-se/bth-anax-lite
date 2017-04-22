        <h1>Blocktest</h1>
        <p>Då testar vi att blockinnehåll fungerar. Här nedanför skall det dyka upp någon form av signatur, som definieras av innehållet med etiketten <code>signature</code>:</p>
<?php $app->renderBlock('signature'); ?>
        <p>Nu kör vi igen, fast med meddelandestil:</p>
        <div class="msg"><div><?php $app->renderBlock('signature'); ?></div></div>
        <p>Och så samma sak ytterligare en gång, fast nu med en felaktig etikett (<code>foo</code>), vilket innebär att blocket skall bli tomt utan att ramverket kastar undantag:</p>
        <div class="msg"><div><?php $app->renderBlock('foo'); ?></div></div>
