use mysql;

CREATE TABLE IF NOT EXISTS cv_details (
	user_id int AUTO_INCREMENT PRIMARY KEY,
	
	username varchar(20) NOT NULL,
	password varchar(80) NOT NULL,
	
	firstname varchar(20) NOT NULL,
	lastname varchar(20) NOT NULL,
	age varchar(20) NOT NULL,
	gender varchar(20) NOT NULL,

	email varchar(20) NOT NULL,
	phone varchar(20) NOT NULL,
	location varchar(100) NOT NULL,
	aadhar varchar(20) NOT NULL,
	
	cv varchar(100) NOT NULL
	
);