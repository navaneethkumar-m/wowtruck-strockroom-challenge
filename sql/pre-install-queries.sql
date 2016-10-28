
-- Create a user account for teacher - Usha

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'usha', 'Nh7gO3lNYtXql9aPTr5HCKVel0ykZKEu', '$2y$13$xIF1LpIIJ9XyStU/wU8AGO0xwoidwLOz7qyxDCjG2wXtgFMedjulG', NULL, 'usha@theschool.com', 10, 1477467599, 1477467599);

-- Inserting teacher 'Usha' into 'Teacher' table

INSERT INTO `teacher` (`id`, `salutation`, `first_name`, `middle_name`, `last_name`, `emp_id`, `joined_on`, `date_of_birth`, `status`) VALUES
(1, 'Ms', 'Usha', NULL, 'Usha', 'E101', '2013-05-01 00:00:00', '1987-05-20', 1);

-- Mapping 'user' with 'teacher' record

INSERT INTO `teacher_user` (`id`, `teacher_id`, `user_id`) VALUES (NULL, '1', '1');

-- Creating subjects into 'subject' table

INSERT INTO `subject` (`id`, `name`, `code`, `status`) VALUES (1, 'English', '3eng', 1), (2, 'Maths', '3maths', 1), (3, 'Science', '3sci', 1);

-- Creating grades into 'grades' table

INSERT INTO `grade` (`id`, `standard`, `section`, `code`, `status`) VALUES (1, 'Third', 'A', '3A', 1);

-- Mapping 'teacher' with 'grade' record

INSERT INTO `teacher_grade` (`id`, `teacher_id`, `grade_id`) VALUES (NULL, '1', '1');

-- Mapping 'teacher' with 'grade' record and 'subject' record

INSERT INTO `teacher_grade_subject` (`id`, `teacher_id`, `grade_id`, `subject_id`) VALUES (NULL, '1', '1','1'), (NULL, '1', '1','2'), (NULL, '1', '1','3');

-- Inserting a student into 'Teacher' table

INSERT INTO `student` (`id`, `first_name`, `middle_name`, `last_name`, `registration_no`, `registered_on`, `date_of_birth`, `status`) VALUES
(1, 'Student', '', 'One', 1000, '2010-05-01 10:00:00', '2007-12-27', 1);

-- Mapping 'student' with 'grade' record

INSERT INTO `student_grade` (`id`, `student_id`, `grade_id`) VALUES (NULL, '1', '1');