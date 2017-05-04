SET NAMES utf8;

USE kabc16;


-- USER --

-- check existing indices
SHOW INDEXES FROM oophp_user;
-- DROP INDEX idx_username ON oophp_user;
DESCRIBE oophp_user;

EXPLAIN SELECT * FROM oophp_user WHERE username = 'lrc';	-- wihtout index: full table scan
CREATE UNIQUE INDEX idx_username ON oophp_user(username);	-- create unique index for username
EXPLAIN SELECT * FROM oophp_user WHERE username = 'lrc';	-- with index: index lookup (1 row)

-- check updated indices
SHOW INDEXES FROM oophp_user;
DESCRIBE oophp_user;


-- CONTENT --

-- check existing indices
SHOW INDEXES FROM oophp_content;
-- DROP INDEX idx_type ON oophp_content;
-- DROP INDEX idx_published ON oophp_content;
DESCRIBE oophp_content;

EXPLAIN SELECT * FROM oophp_content WHERE type = 'post';	-- without index: full table scan
CREATE INDEX idx_type ON oophp_content(type);				-- create index for content type
EXPLAIN SELECT * FROM oophp_content WHERE type = 'post';	-- with index: index lookup (3 rows at time of test)

-- complex query indirectly optimized by index
EXPLAIN SELECT * FROM oophp_content WHERE type = 'page' AND deleted IS NULL AND published IS NOT NULL AND published <= NOW() ORDER BY published;
CREATE INDEX idx_published ON oophp_content(published);		-- create index for publish date
EXPLAIN SELECT * FROM oophp_content WHERE type = 'page' AND deleted IS NULL AND published IS NOT NULL AND published <= NOW() ORDER BY published;

-- check updated indices
SHOW INDEXES FROM oophp_content;
DESCRIBE oophp_content;
