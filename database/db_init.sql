-- MySql Databse Initialization

create database if not exists `g1_academy`;

use `g1_academy`;

create table if not exists 'users' (
  user_id int(11) primary key auto_increment not null, -- Unique user id
  name varchar(100) not null, -- Full name
  email varchar(100) unique not null, -- Unique email for login
  password varchar(255) not null, -- Password hash
  role varchar(20) not null, -- User role (super-admin, admin, instructor)
  status varchar(20) not null, -- User status (active, inactive)
  created_at timestamp default current_timestamp, -- Account creation date
  updated_at timestamp default current_timestamp on update current_timestamp -- Last update date 
);

desc users;