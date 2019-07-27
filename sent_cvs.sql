use mysql;

CREATE TABLE IF NOT EXISTS sent_cvs(
    username varchar(20) NOT NULL,
	job_id int NOT NULL,
	selected varchar(10)
);