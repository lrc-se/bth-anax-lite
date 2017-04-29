SET NAMES utf8;

USE kabc16;


-- RESET --

DROP TABLE IF EXISTS oophp_prodcat;
DROP TABLE IF EXISTS oophp_orderline;
DROP TABLE IF EXISTS oophp_basketitem;
DROP TABLE IF EXISTS oophp_stockalert;
DROP TABLE IF EXISTS oophp_product;
DROP TABLE IF EXISTS oophp_category;
DROP TABLE IF EXISTS oophp_order;
DROP TABLE IF EXISTS oophp_basket;
DROP TABLE IF EXISTS oophp_customer;


-- TABLES AND DATA --

-- Product
CREATE TABLE oophp_product (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	description TEXT,
	image VARCHAR(200),
	price DECIMAL NOT NULL,
	stock INT UNSIGNED NOT NULL DEFAULT 0,
	available BOOLEAN DEFAULT TRUE
);

INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Rottefella R8', 'Klassisk kabelbindning för 75 mm-normen.', 'webshop/r8.png', 1600, 25);
INSERT INTO oophp_product (name, description, image, price, stock, available)
	VALUES ('Rottefella R4', 'Klassisk kabelbindning för 75 mm-normen. Mjuka fjädrar.', 'webshop/r4.png', 1300, 15, FALSE);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Black Diamond O1 MidStiff', 'Aktiv bindning med fjädrarna under foten för 75 mm-normen. Gåläge för toppturer.', 'webshop/o1.png', 2000, 20);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('22 Designs Axl', 'Mycket stabil och kraftfull bidning med fjädrarna under foten för 75 mm-normen. Gåläge för toppturer.', 'webshop/axl.png', 3200, 30);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Rottefella NTN Freeride', 'Stor och stabil NTN-bindning. Gåläge för toppturer (begränsad steglängd).', 'webshop/freeride.png', 2900, 30);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Rottefella NTN Freedom', 'Avskalad NTN-bindning med bättre gåläge för toppturer.', 'webshop/freedom.png', 3300, 20);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Scarpa T1', 'Hög och styv pjäxa för 75 mm-normen. 4 spännen, 2 skaftvinklar och gåläge.', 'webshop/t1.png', 4100, 10);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Scarpa TX Pro', 'Hög och styv pjäxa för NTN. 4 spännen, 2 skaftvinklar, gåläge och Tec-inserts.', 'webshop/tx.png', 4300, 12);
INSERT INTO oophp_product (name, description, image, price, stock)
	VALUES ('Crispi Shiver', 'Halvhög styv pjäxa för NTN. 3 spännen, 2 skaftvinklar, gåläge och Tec-inserts.', 'webshop/shiver.png', 3200, 4);


-- Category
CREATE TABLE oophp_category (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL
);

INSERT INTO oophp_category (name) VALUES ('Bindningar');
INSERT INTO oophp_category (name) VALUES ('Pjäxor');
INSERT INTO oophp_category (name) VALUES ('75 mm');
INSERT INTO oophp_category (name) VALUES ('NTN');


-- (Connection Product/Category)
CREATE TABLE oophp_prodcat (
	prodId INT UNSIGNED NOT NULL,
	catId INT UNSIGNED NOT NULL,
	PRIMARY KEY (prodId, catId)
);

INSERT INTO oophp_prodcat VALUES (1, 1);
INSERT INTO oophp_prodcat VALUES (1, 3);
INSERT INTO oophp_prodcat VALUES (2, 1);
INSERT INTO oophp_prodcat VALUES (2, 3);
INSERT INTO oophp_prodcat VALUES (3, 1);
INSERT INTO oophp_prodcat VALUES (3, 3);
INSERT INTO oophp_prodcat VALUES (4, 1);
INSERT INTO oophp_prodcat VALUES (4, 3);
INSERT INTO oophp_prodcat VALUES (5, 1);
INSERT INTO oophp_prodcat VALUES (5, 4);
INSERT INTO oophp_prodcat VALUES (6, 1);
INSERT INTO oophp_prodcat VALUES (6, 4);
INSERT INTO oophp_prodcat VALUES (7, 2);
INSERT INTO oophp_prodcat VALUES (7, 3);
INSERT INTO oophp_prodcat VALUES (8, 2);
INSERT INTO oophp_prodcat VALUES (8, 4);
INSERT INTO oophp_prodcat VALUES (9, 2);
INSERT INTO oophp_prodcat VALUES (9, 4);


-- Customer
CREATE TABLE oophp_customer (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	firstName VARCHAR(50) NOT NULL,
	lastName VARCHAR(50) NOT NULL,
	address VARCHAR(100) NOT NULL,
	postcode VARCHAR(10) NOT NULL,
	city VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	deleted DATETIME DEFAULT NULL
);

INSERT INTO oophp_customer (firstName, lastName, address, postcode, city, email)
	VALUES ('Nisse', 'Hult', 'Stora Torget 1', '11122', 'Lilleby', 'nisse@hult.se');
INSERT INTO oophp_customer (firstName, lastName, address, postcode, city, email)
	VALUES ('John', 'Doe', 'Anonymgränd 0', '55555', 'Ingensta', 'no1@anonymous.org');


-- Order
CREATE TABLE oophp_order (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	custId INT UNSIGNED NOT NULL,
	ordered DATETIME NOT NULL,
	updated DATETIME DEFAULT NULL,
	delivered DATETIME DEFAULT NULL,
	FOREIGN KEY (custId) REFERENCES oophp_customer(id)
);

INSERT INTO oophp_order (custId, ordered, delivered)
	VALUES (1, '2017-04-26', '2017-04-27');
INSERT INTO oophp_order (custId, ordered)
	VALUES (2, '2017-04-27');


-- Order line
CREATE TABLE oophp_orderline (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	orderId INT UNSIGNED NOT NULL,
	prodId INT UNSIGNED NOT NULL,
	amount INT UNSIGNED NOT NULL,
	unitPrice DECIMAL NOT NULL,
	FOREIGN KEY (orderId) REFERENCES oophp_order(id) ON DELETE CASCADE,
	FOREIGN KEY (prodId) REFERENCES oophp_product(id)
);

INSERT INTO oophp_orderline (orderId, prodId, amount, unitPrice)
	VALUES (1, 4, 1, 2800);
INSERT INTO oophp_orderline (orderId, prodId, amount, unitPrice)
	VALUES (1, 7, 1, 3200);
INSERT INTO oophp_orderline (orderId, prodId, amount, unitPrice)
	VALUES (2, 6, 2, 2750);
INSERT INTO oophp_orderline (orderId, prodId, amount, unitPrice)
	VALUES (2, 9, 1, 3400);


-- Shopping basket
CREATE TABLE oophp_basket (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	custId INT UNSIGNED,
	created DATETIME NOT NULL,
	FOREIGN KEY (custId) REFERENCES oophp_customer(id)
);


-- Shopping basket content
CREATE TABLE oophp_basketitem (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	basketId INT UNSIGNED NOT NULL,
	prodId INT UNSIGNED NOT NULL,
	amount INT UNSIGNED NOT NULL,
	FOREIGN KEY (basketId) REFERENCES oophp_basket(id) ON DELETE CASCADE,
	FOREIGN KEY (prodId) REFERENCES oophp_product(id)
);


-- Stock level alert
CREATE TABLE oophp_stockalert (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	prodId INT UNSIGNED NOT NULL,
	level INT UNSIGNED NOT NULL,
	created DATETIME NOT NULL,
	handled DATETIME DEFAULT NULL
);



-- VIEWS --

-- View order
DROP VIEW IF EXISTS oophp_vieworder;
CREATE VIEW oophp_vieworder AS (
    SELECT
        o.id AS id,
        CONCAT(c.firstName, ' ', c.lastName) AS Customer,
        CONCAT(c.address, ', ', c.postcode, ' ', c.city) AS Address,
        c.email AS 'E-mail',
        o.ordered AS Ordered,
        o.updated AS Updated,
        o.delivered AS Delivered
    FROM oophp_order o
        JOIN oophp_customer c ON o.custId = c.id
);


-- View order contents
DROP VIEW IF EXISTS oophp_viewordercontents;
CREATE VIEW oophp_viewordercontents AS (
	SELECT
		ol.orderId AS id,
		p.id AS 'Product ID',
		p.name AS Product,
		ol.amount AS Amount,
		ol.unitPrice AS 'Unit price'
	FROM oophp_orderline ol
		JOIN oophp_product p ON ol.prodId = p.id
);


-- View basket
DROP VIEW IF EXISTS oophp_viewbasket;
CREATE VIEW oophp_viewbasket AS (
    SELECT
		b.id AS id,
		b.created AS Created,
		p.id AS 'Product ID',
		p.name AS Product,
		p.price AS Price,
		bi.amount AS Amount
	FROM oophp_basket b
		JOIN oophp_basketitem bi ON b.id = bi.basketId
		JOIN oophp_product p ON bi.prodId = p.id
);


-- View stock alert
DROP VIEW IF EXISTS oophp_viewalert;
CREATE VIEW oophp_viewalert AS (
	SELECT
		a.id,
		a.prodId AS 'Product ID',
		p.name AS 'Product',
		a.level AS 'Stock level',
		a.created AS 'Alert logged'
	FROM oophp_stockalert a
		JOIN oophp_product p ON a.prodId = p.id
	WHERE a.handled IS NULL
);



-- PROCEDURES --

DELIMITER $$

-- Add product stock
DROP PROCEDURE IF EXISTS addStock$$
CREATE PROCEDURE addStock (
	_prodId INT UNSIGNED,
	_amount INT UNSIGNED
)
BEGIN
	UPDATE oophp_product SET stock = stock + _amount WHERE id = _prodId;
END$$


-- Order product
DROP PROCEDURE IF EXISTS orderProduct$$
CREATE PROCEDURE orderProduct (
    _orderId INT UNSIGNED,
    _prodId INT UNSIGNED,
    _amount INT UNSIGNED
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
		RESIGNAL;
	END;
    START TRANSACTION;
    IF canOrder(_prodId, _amount) = TRUE THEN
		-- product available in sufficient quantity, so create order line
		INSERT INTO oophp_orderline (orderId, prodId, amount, unitPrice)
			VALUES (_orderId, _prodId, _amount, (SELECT price FROM oophp_product WHERE id = _prodId));
		
		-- decrease stock level
        UPDATE oophp_product SET stock = stock - _amount WHERE id = _prodId;
        COMMIT;
    ELSE
		-- product not available in sufficient quantity (or at all)
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Unable to order the requested product(s)';
    END IF;
END$$


-- Create shopping basket
DROP PROCEDURE IF EXISTS createBasket$$
CREATE PROCEDURE createBasket (
	IN _custId INT UNSIGNED,
	OUT _basketId INT UNSIGNED
)
BEGIN
	INSERT INTO oophp_basket (custId, created) VALUES (_custId, NOW());
	SET _basketId = LAST_INSERT_ID();
END$$


-- Add item to shopping basket
DROP PROCEDURE IF EXISTS addBasketItem$$
CREATE PROCEDURE addBasketItem (
	_basketId INT UNSIGNED,
	_prodId INT UNSIGNED,
	_amount INT UNSIGNED
)
BEGIN
	DECLARE _curAmount INT UNSIGNED;
	DECLARE _total INT UNSIGNED;

	START TRANSACTION;
	SELECT amount INTO _curAmount FROM oophp_basketitem WHERE basketId = _basketId AND prodId = _prodId;
	IF _curAmount IS NOT NULL THEN
		-- product exists in basket, so calculate total amount
		SET _total = _curAmount + _amount;
	ELSE
		-- product does not exist in basket, so use specified amount
		SET _total = _amount;
	END IF;

	-- check availability
	IF canOrder(_prodId, _total) = TRUE THEN
		-- product available in sufficient quantity
		IF _curAmount IS NOT NULL THEN
			-- product exists in basket, so add to current amount
			UPDATE oophp_basketitem SET amount = amount + _amount WHERE basketId = _basketId AND prodId = _prodId;
		ELSE
			-- product does not exist in basket, so create new item
			INSERT INTO oophp_basketitem (basketId, prodId, amount) VALUES (_basketId, _prodId, _amount);
		END IF;
		COMMIT;
	ELSE
		-- product not available in sufficient quantity (or at all)
		ROLLBACK;
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Unable to order the requested product(s)';
	END IF;
END$$


-- Remove item from shopping basket
DROP PROCEDURE IF EXISTS removeBasketItem$$
CREATE PROCEDURE removeBasketItem (
	_basketId INT UNSIGNED,
	_prodId INT UNSIGNED,
	_amount INT UNSIGNED
)
BEGIN
	DECLARE _curAmount INT UNSIGNED;
	START TRANSACTION;
	SELECT amount INTO _curAmount FROM oophp_basketitem WHERE basketId = _basketId AND prodId = _prodId;
	IF _curAmount IS NULL THEN
		-- product does not exist in basket
		ROLLBACK;
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'The basket does not contain that product';
	ELSEIF _amount > _curAmount THEN
		-- product does not exist in basket in sufficient quantity
		ROLLBACK;
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'The basket does not contain that many items of that product';
	ELSE
		-- product exists in basket in sufficient quantity
	    IF _amount = 0 OR _amount = _curAmount THEN
			-- remove entire basket item
	        DELETE FROM oophp_basketitem WHERE basketId = _basketId AND prodId = _prodId;
	    ELSE
			-- decrease basket item amount
		    UPDATE oophp_basketitem SET amount = amount - _amount WHERE basketId = _basketId AND prodId = _prodId;
		END IF;
		COMMIT;
	END IF;
END$$


-- Create order from basket
DROP PROCEDURE IF EXISTS createOrder$$
CREATE PROCEDURE createOrder (
	IN _basketId INT UNSIGNED,
	IN _custId INT UNSIGNED,
	OUT _orderId INT UNSIGNED
)
BEGIN
	DECLARE _customer INT UNSIGNED;
	DECLARE _order INT UNSIGNED;
	DECLARE _product INT UNSIGNED;
	DECLARE _amount INT UNSIGNED;

	DECLARE _finished BOOLEAN DEFAULT FALSE;
	DECLARE _cursor CURSOR FOR SELECT prodId, amount FROM oophp_basketitem WHERE basketId = _basketId;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET _finished = TRUE;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;

	START TRANSACTION;
	IF _custId IS NULL THEN
		-- no customer specified in call, so attempt to use customer stored in basket
		SELECT custId INTO _customer FROM oophp_basket WHERE id = _basketId;
		IF _customer IS NULL THEN
		    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No customer specified';
	    END IF;
	ELSE
		-- use customer specified in call
		SET _customer = _custId;
	END IF;

	-- create new order	
	INSERT INTO oophp_order (custId, ordered) VALUES (_customer, NOW());
	SET _order = LAST_INSERT_ID();

	-- create order lines from basket items
	OPEN _cursor;
	looop: LOOP
	    FETCH _cursor INTO _product, _amount;
	    IF _finished = TRUE THEN
	        LEAVE looop;
	    END IF;
	    CALL orderProduct(_order, _product, _amount);
    END LOOP looop;
    CLOSE _cursor;

	-- remove basket
	DELETE FROM oophp_basket WHERE id = _basketId;
	SET _orderId = _order;
	COMMIT;
END$$

DELIMITER ;



-- FUNCTIONS --

DELIMITER $$

-- Check product availability
DROP FUNCTION IF EXISTS canOrder$$
CREATE FUNCTION canOrder (
    _prodId INT UNSIGNED,
    _amount INT UNSIGNED
)
RETURNS BOOLEAN
BEGIN
    DECLARE _curAmount INT UNSIGNED;
    SELECT stock INTO _curAmount FROM oophp_product WHERE id = _prodId AND available = TRUE;
    IF _amount <= _curAmount THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

DELIMITER ;



-- TRIGGERS --

DELIMITER $$

-- Stock level alert
DROP TRIGGER IF EXISTS stockAlert$$
CREATE TRIGGER stockAlert AFTER UPDATE ON oophp_product FOR EACH ROW
BEGIN
	IF OLD.stock >= 5 AND NEW.stock < 5 THEN
		INSERT INTO oophp_stockalert (prodId, level, created) VALUES (NEW.id, NEW.stock, NOW());
	END IF;
END$$

DELIMITER ;
