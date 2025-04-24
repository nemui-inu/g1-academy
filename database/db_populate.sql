-- Use the database
USE `g1_academy`;

-- USERS
INSERT INTO `users` (name, email, password, role, status)
VALUES 
('Super Admin', 'superadmin@g1.com', 'hashed_password_1', 'super-admin', 'active'),
('Admin One', 'admin1@g1.com', 'hashed_password_2', 'admin', 'active'),
('Instructor A', 'instructorA@g1.com', 'hashed_password_3', 'instructor', 'active'),
('Instructor B', 'instructorB@g1.com', 'hashed_password_4', 'instructor', 'active');

select * from users;

-- COURSES
INSERT INTO `courses` (code, name)
VALUES 
('BSIT', 'Bachelor of Science in Information Technology'),
('BSCS', 'Bachelor of Science in Computer Science');

select * from courses;

-- STUDENTS
INSERT INTO `students` (student_id, name, gender, birthdate, course_id, year_level, status)
VALUES
('STUD1001', 'John Doe', 'male', '2002-03-15', 1, 2, 'active'),
('STUD1002', 'Jane Smith', 'female', '2003-07-22', 1, 1, 'active'),
('STUD1003', 'Carlos Rivera', 'male', '2001-12-05', 2, 3, 'active');

select * from students;

-- SUBJECTS
INSERT INTO `subjects` (code, catalog_no, name, day, time, room, course_id, semester, year_level, instructor_id)
VALUES
('IT101', 'CAT001', 'Introduction to IT', 'Monday', '08:00-10:00', 'Comlab 101', 1, 1, 1, 3),
('CS201', 'CAT002', 'Data Structures', 'Tuesday', '10:00-12:00', 'Comlab 102', 2, 1, 3, 4),
('IT202', 'CAT003', 'Web Development', 'Wednesday', '13:00-15:00', 'Comlab 103', 1, 2, 2, 3);

select * from subjects;

-- ENROLLMENTS
INSERT INTO `subject_enrollments` (student_id, subject_id, status)
VALUES
(1, 1, 'enrolled'),
(1, 3, 'enrolled'),
(2, 1, 'enrolled'),
(3, 2, 'enrolled');

select * from subject_enrollments;

-- GRADES
INSERT INTO `grades` (student_id, subject_id, instructor_id, grade, remarks)
VALUES
(1, 1, 3, 1.75, 'Passed'),
(1, 3, 3, 2.00, 'Passed'),
(2, 1, 3, 2.25, 'Passed'),
(3, 2, 4, 1.50, 'Passed');

select * from grades;
