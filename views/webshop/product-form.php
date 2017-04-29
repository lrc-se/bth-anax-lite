<?php $app->msg('err') ?>
<?php $app->msg('msg') ?>
        <form class="object-form" action="<?= $app->href($action) ?>" method="post">
<?php if ($product->id) : ?>
            <input type="hidden" name="id" value="<?= $product->id ?>">
<?php endif; ?>
            <div class="form-input">
                <label class="label" for="name">Namn:</label>
                <div class="field">
                    <input id="name" type="text" name="name" value="<?= $app->esc($product->name) ?>" maxlength="50" required autofocus>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="price">Pris:</label>
                <div class="field">
                    <input id="price" type="number" name="price" value="<?= $app->esc($product->price) ?>" min="0">
                    <span class="desc">SEK</span>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="image">Bild-URL:</label>
                <div class="field">
                    <input id="image" type="text" name="image" value="<?= $app->esc($product->image) ?>" maxlength="200">
<?php if (!empty($product->image)) : ?>
                    <img class="user-img-small" src="<?= $app->href($product->getImage(), true) ?>" alt="">
<?php endif; ?>
                </div>
            </div>
            <div class="form-input">
                <label class="label">Kategori:</label>
                <div class="field">
<?php foreach ($categories as $n => $category) : ?>
                    <input id="category-<?= $n ?>" type="checkbox" name="category[]" value="<?= $category->id ?>"<?= ($product->hasCategory($category->id) ? ' checked' : '') ?>><label for="category-<?= $n ?>">&nbsp;<?= $category->name ?></label><br>
<?php endforeach; ?>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="available">Till salu:</label>
                <div class="field">
                    <input id="available" type="checkbox" name="available" value="1"<?= ($product->available ? ' checked' : '') ?>>
                </div>
            </div>
            <div class="form-input">
                <label class="label" for="description">Beskrivning:</label>
                <div class="field">
                    <textarea id="description" name="description" rows="15" required><?= $app->esc($product->description) ?></textarea>
                </div>
            </div>
            <div class="form-input">
                <span class="label"></span>
                <div class="field">
                    <input type="submit" value="<?= ($product->id ? 'Uppdatera' : 'Skapa') ?>">
                    <a class="button" href="<?= $app->href('user/webshop-admin') ?>">Avbryt</a>
                </div>
            </div>
        </form>
