use mysql;

CREATE TABLE company (
	user_id int AUTO_INCREMENT PRIMARY KEY,
	
	username varchar(20) NOT NULL,
	password varchar(80) NOT NULL,
	
	company varchar(20) NOT NULL,
	company_id varchar(20) NOT NULL,
	address varchar(100) NOT NULL,

	email varchar(20) NOT NULL,
	phone varchar(20) NOT NULL,

	logo varchar(20) NOT NULL
	
);
