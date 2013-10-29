CREATE TABLE tbl_person (
    id INT AUTO_INCREMENT,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    author VARCHAR(64),
    title VARCHAR(64),
    content TEXT,
    version INT DEFAULT 0,
    PRIMARY KEY (id)
);
