        <h1>Lagerför leverans</h1>
        <p>
            Lagerför en leverans av produkten <strong><?= $app->esc($product->name) ?></strong> i webbshoppen genom att fylla i hur många enheter som levererats. 
            Ange ett negativt tal för att minska lagersaldot om produkten istället har skickats iväg.
        </p>
        <br>
<?php $app->msg('err') ?>
<?php $app->msg('msg') ?>
        <form class="object-form" action="<?= $app->href('user/webshop-admin/product/restock/' . $product->id) ?>" method="post">
            <div class="form-input">
                <label class="label">Nuvarande lagersaldo:</label>
                <span class="field field-static"><?= ($product->stock ? $product->stock . ' st' : 'Slutsåld') ?></span>
            </div>
            <div class="form-input">
                <label class="label" for="amount">Levererat antal:</label>
                <div class="field">
                    <input id="amount" type="number" name="amount" value="<?= $app->esc($amount) ?>" required autofocus>
                </div>
            </div>
            <div class="form-input">
                <span class="label"></span>
                <div class="field">
                    <input type="submit" value="Spara">
                    <a class="button" href="<?= $app->href('user/webshop-admin') ?>">Avbryt</a>
                </div>
            </div>
        </form>
