SET NAMES utf8;

-- CREATE DATABASE kabc16;
USE kabc16;

-- create user table
DROP TABLE IF EXISTS oophp_user;
CREATE TABLE oophp_user (
	id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) UNIQUE NOT NULL,			-- unique index
	password VARCHAR(255) NOT NULL,
	birthdate DATE NOT NULL,
	email VARCHAR(100) NOT NULL,
	image VARCHAR(500),
	level TINYINT NOT NULL DEFAULT 0,
	active TINYINT NOT NULL DEFAULT 1
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- populate table
INSERT INTO oophp_user (username, password, birthdate, email, image, level)
	VALUES ('lrc', '$2y$10$RmWcMBGCO1G7K22lbAVHLOZZvUpSOX0k3nOsbmm2X4ky9iOY8xNDu', '1983-02-19', 'kabc16@student.bth.se', 'http://www.lillsjon.net/~v108e/confed.jpg', 2);

INSERT INTO oophp_user (username, password, birthdate, email, image, level)
	VALUES ('admin', '$2y$10$tpp.kluE4FjBbAsczWh/Xul40YLIF4IBPai6ADoqlwpBq4njr0AOy', '2015-09-01', 'kabc16@student.bth.se', NULL, 1);

INSERT INTO oophp_user (username, password, birthdate, email, image)
	VALUES ('John Doe', '$2y$10$YhiIKvjfI8hLDzrWeR.qFuEWi/t06iClL1Pb4LlrHg4capZiVNnda', '1991-11-19', 'e@mail.com', NULL);

INSERT INTO oophp_user (username, password, birthdate, email, image)
	VALUES ('Jane Doe', '$2y$10$YhiIKvjfI8hLDzrWeR.qFuEWi/t06iClL1Pb4LlrHg4capZiVNnda', '1985-07-23', 'e@mail.com', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/500px-Anonymous_emblem.svg.png');


SELECT * FROM oophp_user;
