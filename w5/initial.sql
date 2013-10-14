CREATE TABLE tasks (
        `id`   INT         NOT NULL AUTO_INCREMENT,
        `what` VARCHAR(64) NOT NULL,
        `when` DATE        NOT NULL,
	PRIMARY KEY (`id`)
);
