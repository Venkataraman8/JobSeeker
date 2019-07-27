use mysql;

CREATE TABLE IF NOT EXISTS jobs(
job_id int AUTO_INCREMENT PRIMARY KEY,
employer varchar(20) NOT NULL,
  company varchar(20) NOT NULL,
  title varchar(20) NOT NULL,
  description varchar(100) NOT NULL,
  fields varchar(20) NOT NULL,
  experience varchar(10) NOT NULL,
  salary varchar(10) NOT NULL,
  vacancies varchar(10) NOT NULL,
  qualification varchar(100) NOT NULL,
  location varchar(50) NOT NULL,
  interview varchar(50) NOT NULL
);