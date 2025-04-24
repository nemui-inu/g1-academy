-- MySql Databse Initialization

create database if not exists `g1_academy`;

use `g1_academy`;

-- Table creation script

create table if not exists `users` (
  user_id int(11) primary key auto_increment not null,
  name varchar(100) not null, -- Full name
  email varchar(100) unique not null, -- Unique email for login
  password varchar(255) not null, -- Password hash
  role varchar(20) not null, -- User role (super-admin, admin, instructor)
  status varchar(20) not null, -- User status (active, inactive)
  created_at timestamp default current_timestamp, 
  updated_at timestamp default current_timestamp on update current_timestamp 
);

desc users;

create table if not exists `courses` (
  course_id int(11) primary key auto_increment not null,
  code varchar(20) unique not null, -- Unique course code
  name varchar(100) not null, -- Course name
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp
);

desc courses;

create table if not exists `students` (
  id int(11) primary key auto_increment not null,
  student_id varchar(20) unique not null, -- Unique student ID
  name varchar(100) not null, -- Full name
  gender varchar(20) not null, -- male/female
  birthdate date not null, -- DOB
  course_id int(11) not null, -- Foreign key to courses table
  year_level tinyint(2) not null, -- Year level (1-4)
  status varchar(20) not null, -- Student status (active, inactive)
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp,
  foreign key (course_id) references courses(course_id) on delete cascade
);

desc students;

create table if not exists `subjects` (
  id int(11) primary key auto_increment not null,
  code varchar(20) unique not null, -- Unique subject code
  catalog_no varchar(20) not null, -- Catalog number
  name varchar(100) not null, -- Subject name
  day varchar(20) not null, -- Day of the week (Monday-Sunday)
  time varchar(20) not null, -- Time (HH:MM-HH:MM)
  room varchar(20) not null, -- Room number e.g. `Comlab 111
  course_id int(11) not null, -- Foreign key to courses table
  semester tinyint(2) not null, -- Semester (1-2)
  year_level tinyint(2) not null, -- Year level (1-4)
  instructor_id int(11) not null, -- Foreign key to users table (instructor)
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp,
  foreign key (course_id) references courses(course_id) on delete cascade,
  foreign key (instructor_id) references users(user_id) on delete cascade
);

desc subjects;

create table if not exists `subject_enrollments` (
  subEnrollment_id int (11) primary key auto_increment not null,
  student_id int(11) not null, -- Foreign key to students table
  subject_id int(11) not null, -- Foreign key to subjects table
  status varchar(20) not null, -- Enrollment status (enrolled, dropped, completed)
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp,
  foreign key (student_id) references students(id) on delete cascade,
  foreign key (subject_id) references subjects(id) on delete cascade
);

desc subject_enrollments;

create table if not exists `grades` (
  grade_id int(11) primary key auto_increment not null,
  student_id int(11) not null, -- Foreign key to students table
  subject_id int(11) not null, -- Foreign key to subjects table
  instructor_id int(11) not null, -- Foreign key to users table (instructor)
  grade decimal(3,2), -- Grade (5.00-1.00)
  remarks varchar(50), -- Remarks (e.g. Passed, Failed, Pending)
  created_at timestamp default current_timestamp,
  updated_at timestamp default current_timestamp on update current_timestamp,
  foreign key (student_id) references students(id) on delete cascade,
  foreign key (subject_id) references subjects(id) on delete cascade,
  foreign key (instructor_id) references users(user_id) on delete cascade
);

desc grades;
