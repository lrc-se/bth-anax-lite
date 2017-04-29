Webshop Database API
====================

Use the following commands to perform operations against the webshop database.


Shopping basket operations
--------------------------

### Create shopping basket

`CALL createBasket(customerId, basketId);`

Creates a new shopping basket for the specified customer and returns the primary key (id) of the created basket in the out parameter `basketId`. 
If `customerId` is `NULL`, the basket is not tied to an existing customer.


### Add product(s) to shopping basket

`CALL addBasketItem(basketId, productId, amount);`

Adds the specified amount of the specified product to the specified basket. If the basket already contains a nonzero amount of the requested product, 
the total amount is updated, otherwise a new item is inserted. If the product does not exist, is unavailable for sale or does not remain in sufficient quantity to satisfy the requested amount, 
an exception is raised and the operation is rolled back.


### Remove product(s) from shopping basket

`CALL removeBasketItem(basketId, productId, amount);`

Removes the specified amount of the specified product from the specified basket. If the basket does not contain the requested product or the requested amount is higher than the amount in the basket, 
an exception is raised and the operation is rolled back. Pass `0` as the `amount` parameter to remove all copies of the product from the basket.


### Create order from shopping basket

`CALL createOrder(basketId, customerId, orderId);`

Creates a new order for the specified customer, creating order lines for all items in the specified basket in turn, 
and returns the primary key (id) of the created order in the out parameter `orderId`. If `customerId` is `NULL`, the customer tied to the basket is used when creating the order. 
If successful, the stock level of the constituent products is decreased correspondingly and the basket is deleted along with its constituent items (NOTE: not the actual products). 
If no customer is found or if an error occurs when inserting the order lines, an exception is raised and the entire operation is rolled back.


### View basket contents

`SELECT * FROM oophp_viewbasket WHERE id = :basketId;`

Shows a summary of the contents of the basket having the primary key `:basketId`.


### Delete basket

`DELETE FROM oophp_basket WHERE id = :basketId;`

Permanently removes the basket having the primary key `:basketId`. The constituent items, if any, are removed as well (NOTE: not the actual products).



Orders
------

### Create order

`INSERT INTO oophp_order (custId, created) VALUES (:customerId, :creationDatetime);`

Creates a new order for the specified customer. Normally the value of `:creationDatetime` should simply be `NOW()`.


### Order product(s)

`CALL orderProduct(orderId, productId, amount);`

Adds the specified amount of the specified product to the specified order. If successful, the stock level of the requested product is decreased correspondingly. 
If the product does not exist, is unavailable for sale or does not remain in sufficient quantity to satisfy the requested amount, an exception is raised and the operation is rolled back.


### View order info

`SELECT * FROM oophp_vieworder WHERE id = :orderId;`

Shows details about the order with the primary key `:orderId` and the customer who placed it.


### View order contents

`SELECT * FROM oophp_viewordercontents WHERE id = :orderId;`

Shows details about the contents of the order with the primary key `:orderId`.


### Delete order

`DELETE FROM oophp_order WHERE id = :orderId;`

Permanently removes the order having the primary key `:orderId`. The constituent order lines, if any, are removed as well (NOTE: not the actual products).



Products
--------

### Add stock

`CALL addStock(productId, amount);`

Adds the specified amount to the specified product's stock level.


### Check availability

`SELECT canOrder(productId, amount);`

Returns `TRUE` (`1`) if the specified product is available for sale and remains in sufficient quantity to satisfy the requested amount, otherwise `FALSE` (`0`).


### View stock alerts

`SELECT * FROM oophp_viewalert;`

Shows a summary of unhandled product stock level alerts. An alert is automatically issued whenever a product's stock level falls below 5, 
but is not reissued for any subsequent changes that remain below that limit – only changes that cross the limit from above are recorded.
