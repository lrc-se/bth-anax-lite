SET NAMES utf8;

USE kabc16;


-- User

SHOW INDEXES FROM oophp_user;
-- DROP INDEX idx_username ON oophp_user;
DESCRIBE oophp_user;

EXPLAIN SELECT * FROM oophp_user WHERE username = 'lrc';	-- full table scan
CREATE UNIQUE INDEX idx_username ON oophp_user(username);
EXPLAIN SELECT * FROM oophp_user WHERE username = 'lrc';	-- index lookup (1 row)

SHOW INDEXES FROM oophp_user;


-- Content

SHOW INDEXES FROM oophp_content;
-- DROP INDEX idx_type ON oophp_content;
-- DROP INDEX idx_published ON oophp_content;
DESCRIBE oophp_content;

EXPLAIN SELECT * FROM oophp_content WHERE type = 'post';	-- full table scan
CREATE INDEX idx_type ON oophp_content(type);
EXPLAIN SELECT * FROM oophp_content WHERE type = 'post';	-- index lookup (3 rows)

EXPLAIN SELECT * FROM oophp_content WHERE type = 'page' AND deleted IS NULL AND published IS NOT NULL AND published <= NOW() ORDER BY published;
CREATE INDEX idx_published ON oophp_content(published);
EXPLAIN SELECT * FROM oophp_content WHERE type = 'page' AND deleted IS NULL AND published IS NOT NULL AND published <= NOW() ORDER BY published;

SHOW INDEXES FROM oophp_content;
