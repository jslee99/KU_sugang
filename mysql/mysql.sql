create database ku_sugang;

use ku_sugang;

create table 2022_1st(
	haksu_id varchar(20),
    category char(2),-- 이수구분
    id int,
    title char(40),
    credit tinyint,
    hours tinyint,
    how varchar(50),
    _language varchar(10),
    note varchar(500),
    category_of_elective varchar(50),
    grade tinyint,
    department varchar(20),
    professor varchar(150),
    summary varchar(200),
    
    primary key(id)
);

create table 2022_2nd(
	haksu_id varchar(20),
    category char(2),-- 이수구분
    id int,
    title char(40),
    credit tinyint,
    hours tinyint,
    how varchar(50),
    _language varchar(10),
    note varchar(500),
    category_of_elective varchar(50),
    grade tinyint,
    department varchar(20),
    professor varchar(150),
    summary varchar(200),
    
    primary key(id)
);

create table 2021_2nd(
	haksu_id varchar(20),
    category char(2),-- 이수구분
    id int,
    title char(40),
    credit tinyint,
    hours tinyint,
    how varchar(50),
    _language varchar(10),
    note varchar(500),
    category_of_elective varchar(50),
    grade tinyint,
    department varchar(20),
    professor varchar(150),
    summary varchar(200),
    
    primary key(id)
);

create table 2021_winter(
	haksu_id varchar(20),
    category char(2),-- 이수구분
    id int,
    title char(40),
    credit tinyint,
    hours tinyint,
    how varchar(50),
    _language varchar(10),
    note varchar(500),
    category_of_elective varchar(50),
    grade tinyint,
    department varchar(20),
    professor varchar(150),
    summary varchar(200),
    
    primary key(id)
);


-- alter table ku_sugang_2022_1 modify how varchar(50);
-- alter table ku_sugang_2022_1 modify note varchar(500);
-- alter table ku_sugang_2022_1 modify professor varchar(150);

select * from 2022_1st where id = 0567;
select * from 2022_1st where professor like '%이승제%';
show tables;
select distinct(department) from 2022_1;
select * from 2022_1st where department = '전체대학';
select * from ku_sugang_2022_1 where title = 'CSP진로탐색';
select * from ku_sugang_2022_1 where id = 2001;
select count(*) from ku_sugang_2022_1;