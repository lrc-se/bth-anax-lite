        <h1>Webbshops&shy;admin<span class="mobile-hide">istration</span></h1>
<?php $app->msg('err') ?>
<?php $app->msg('msg') ?>
        <p>
            <a class="button" href="<?= $app->href('user/webshop-admin/product/create') ?>">Skapa ny produkt</a>
            <a class="button" href="<?= $app->href('user/webshop-admin/product/alert') ?>">Lagersaldovarningar (JSON)</a>
        </p>
        <h3>Produkter</h3>
        <form action="" method="get">
            <div class="flex flex-inline">
                <label for="search">Filter:</label>
                <input type="text" name="search" value="<?= $app->esc($params['search']) ?>">
                <div>
                    <input type="submit" value="Sök">
                    <a class="button" href="?<?= $app->mergeQS(array_merge($params, ['search' => null])) ?>">Rensa</a>
                </div>
            </div>
            <div class="pagination-form flex">
<?php if (!empty($products)) : ?>
                <div class="total">Visar <strong><?= $matches ?></strong> av <strong><?= $total ?></strong> produkter</div>
<?php else : ?>
                <div class="total"><em>Inga produkter att visa</em></div>
<?php endif; ?>
                <div class="num">
                    <label for="num"><strong>Antal per sida: </strong></label> &nbsp;
                    <select id="num" name="num" onchange="this.form.submit()"<?= (empty($products) ? ' disabled' : '') ?>>
<?php foreach ($nums as $num) : ?>
                        <option value="<?= $num ?>"<?= ($params['num'] == $num ? ' selected' : '') ?>><?= ($num ?: 'Alla') ?></option>
<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <input type="hidden" name="sort" value="<?= $app->esc($params['sort']) ?>">
            <input type="hidden" name="desc" value="<?= $app->esc($params['desc']) ?>">
            <input type="hidden" name="page" value="<?= $app->esc($params['page']) ?>">
        </form>
<?php if (!empty($products)) : ?>
        <div class="xscroll" style="clear: both">
            <table class="object-table">
                <tr>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'id', 'desc' => (int)(!$params['desc'])]) ?>">ID</a><?= ($params['sort'] == 'id' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'name', 'desc' => (int)(!$params['desc'])]) ?>">Namn</a><?= ($params['sort'] == 'name' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'price', 'desc' => (int)(!$params['desc'])]) ?>">Pris</a><?= ($params['sort'] == 'price' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'stock', 'desc' => (int)(!$params['desc'])]) ?>">Lager<span class="mobile-hide">saldo</span></a><?= ($params['sort'] == 'stock' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>
                        <a href="?<?= $app->mergeQS(['sort' => 'available', 'desc' => (int)(!$params['desc'])]) ?>">Till salu</a><?= ($params['sort'] == 'available' ? '&nbsp;<span class="arrow">' . "$arrow</span>" : '') ?>
                    </th>
                    <th>Kategorier</th>
                    <th>Åtgärd</th>
                </tr>
<?php   foreach ($products as $product) : ?>
                <tr<?= (!$product->available ? ' class="inactive"' : ($product->stock < 5 ? ' class="alert"' : '')) ?>>
                    <td><?= $product->id ?></td>
                    <td><?= $app->esc($product->name) ?></td>
                    <td><?= $product->price ?> kr</td>
                    <td><?= ($product->stock ? $product->stock . ' st' : 'Slutsåld') ?></td>
                    <td><?= ($product->available ? 'Ja' : 'Nej') ?></td>
                    <td>
<?php       foreach ($product->categoryIds as $n => $id) : ?>
<?php           $cat = $cf->getById($id); ?>
<?php           if ($cat) : ?>
<?php               echo ($n > 0 ? '<br>' : '') . $app->esc($cat->name); ?>
<?php           endif; ?>
<?php       endforeach; ?>
                    </td>
                    <td>
                        <a href="<?= $app->href('user/webshop-admin/product/edit/' . $product->id) ?>">Redigera</a><br>
                        <a href="<?= $app->href('user/webshop-admin/product/restock/' . $product->id) ?>">Lagerför</a>
                    </td>
                </tr>
<?php   endforeach; ?>
            </table>
        </div>
<?php   $this->renderView('incl/pagination-controls', ['page' => $params['page'], 'max' => $max]); ?>
<?php endif; ?>
