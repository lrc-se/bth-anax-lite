SET NAMES utf8;

USE kabc16;

DROP TABLE IF EXISTS oophp_content;
CREATE TABLE oophp_content (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	userId INT,
	type VARCHAR(10) NOT NULL,
	label VARCHAR(50) UNIQUE,
	title VARCHAR(100) NOT NULL,
	content TEXT,
	formatters VARCHAR(50),
	created DATETIME NOT NULL,
	updated DATETIME,
	published DATETIME,
	deleted DATETIME,
	FOREIGN KEY (userId) REFERENCES oophp_user(id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO oophp_content (userId, type, label, title, content, formatters, created, published)
	VALUES (1, 'page', 'simple', 'En enkel sida', 'Detta är en [b]mycket[/b] enkel sida som bara innehåller [i]lite[/i] formatering.', 'nl2br,bbcode', '2017-04-21 17:31:33', '2017-04-21 17:31:33');

INSERT INTO oophp_content (userId, type, label, title, content, formatters, created, published)
	VALUES (1, 'page', 'rottefella', 'Råttfälla', 'Har __du__ fångat någon råtta i din Rottefella-bindning idag?\r\n\r\n![Råttfälla](http://telemark.se/wordpress/wp-content/uploads/gb05-568x426.jpg)', 'markdown', '2017-04-22 13:09:05', '2017-04-22 13:09:05');

INSERT INTO oophp_content (userId, type, label, title, content, formatters, created)
	VALUES (2, 'page', 'test', 'Testsida', 'Detta är (eller var) en opublicerad sida!', 'nl2br,link', '2017-04-22 13:10:28');

INSERT INTO oophp_content (userId, type, title, content, formatters, created, published)
	VALUES (1, 'post', 'Första inlägget', 'Då testar vi ett *jättelitet* blogginlägg också!', 'markdown', '2017-04-22 20:51:57', '2017-04-22 21:00:00');

INSERT INTO oophp_content (userId, type, title, content, formatters, created, published)
	VALUES (3, 'post', 'Inlägg #2 med en längre rubrik', 'Jaha, då var vi igång igen då. **Skönt**!\r\n\r\n* Listpunkt 1\r\n* Listpunkt 2\r\n* Listpunkt 3\r\n\r\nVi testar en bild också:\r\n![bild](http://www.lillsjon.net/~v108e/confed.jpg)\r\n\r\n### Rubrik\r\n\r\n1. Listpunkt 4\r\n2. Listpunkt 5\r\n3. Listpunkt 6.', 'markdown', '2017-04-23 13:15:57', '2017-04-23 14:00:00');

INSERT INTO oophp_content (userId, type, title, content, formatters, created, published)
	VALUES (NULL, 'post', 'Test', 'Inte mycket att se här!', 'nl2br', '2017-04-23 13:30:31', '2017-04-23 14:01:08');

INSERT INTO oophp_content (userId, type, label, title, content, formatters, created, published)
	VALUES (1, 'block', 'signature', 'Signatur', '*/ Kalle* ([skicka e-post](mailto:kabc16@student.bth.se))', 'markdown', '2017-04-23 13:37:26', '2017-04-23 13:37:26');


SELECT * FROM oophp_content;
