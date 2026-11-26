-- InternTrack demo seed data
-- 8 fictional UiTM female student profiles across different campuses,
-- faculties, CGPA bands and states (Addendum V2-D). For demo/learning
-- use only — not real students. Safe to re-run: clears rows 1-8 first.
-- Usage: mysql -u root interntrack < database/seed_demo.sql

USE `interntrack`;

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM `student_preferences` WHERE `student_id` BETWEEN 1 AND 8;
DELETE FROM `student_skills` WHERE `student_id` BETWEEN 1 AND 8;
DELETE FROM `student_academic_projects` WHERE `student_id` BETWEEN 1 AND 8;
DELETE FROM `student_subjects` WHERE `student_id` BETWEEN 1 AND 8;
DELETE FROM `students` WHERE `id` BETWEEN 1 AND 8;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- STUDENTS
-- =====================================================================

INSERT INTO `students`
(`id`, `display_name`, `institution_name`, `qualification_level`, `faculty`, `course_name`, `course_code`,
 `study_year`, `current_semester`, `expected_graduation_date`, `internship_start_date`, `internship_end_date`,
 `internship_duration_weeks`, `current_cgpa`, `cgpa_scale`, `latest_semester_gpa`, `portfolio_url`, `github_url`,
 `linkedin_url`, `preferred_work_mode`, `minimum_allowance`, `willing_to_relocate`, `transport_availability`,
 `preferred_company_size`, `photo_path`)
VALUES
(1, 'Nur Aisyah Balqis', 'UiTM Shah Alam', 'Bachelor Degree', 'Faculty of Computer and Mathematical Sciences',
 'Bachelor of Computer Science (Software Engineering)', 'CS241', 3, 6, '2027-07-31', '2027-02-15', '2027-07-15',
 22, 3.75, 4.00, 3.80, NULL, NULL, NULL, 'hybrid', 900.00, 1, 'Own transport (car)', 'MNC', NULL),

(2, 'Siti Nur Damia', 'UiTM Pahang (Jengka)', 'Diploma', 'Faculty of Business and Management',
 'Diploma in Business Studies', 'BA119', 2, 4, '2027-05-31', '2027-02-01', '2027-06-30',
 20, 3.40, 4.00, 3.35, NULL, NULL, NULL, 'onsite', 600.00, 0, 'Public transport only', 'SME', NULL),

(3, 'Nur Izzati Hanim', 'UiTM Perlis (Arau)', 'Bachelor Degree', 'Faculty of Electrical Engineering',
 'Bachelor of Electrical Engineering (Hons)', 'EE220', 4, 7, '2027-01-31', '2026-12-01', '2027-05-31',
 26, 3.55, 4.00, 3.50, NULL, NULL, NULL, 'onsite', 1000.00, 1, 'Own transport (car)', 'Government-linked', NULL),

(4, 'Nurul Syafiqah', 'UiTM Melaka (Alor Gajah)', 'Diploma', 'Faculty of Art and Design',
 'Diploma in Graphic Design', 'AD117', 3, 5, '2027-06-30', '2027-01-15', '2027-05-15',
 16, 3.20, 4.00, 3.10, NULL, NULL, NULL, 'remote', 500.00, 0, 'Motorcycle', 'Startup', NULL),

(5, 'Farah Nabilah', 'UiTM Terengganu (Dungun)', 'Bachelor Degree', 'Faculty of Computer and Mathematical Sciences',
 'Bachelor of Information Technology (Hons)', 'CS243', 4, 8, '2027-01-31', '2026-12-15', '2027-06-15',
 24, 3.85, 4.00, 3.90, NULL, NULL, NULL, 'hybrid', 1100.00, 1, 'Own transport (car)', 'MNC', NULL),

(6, 'Aina Sofea', 'UiTM Kelantan (Machang)', 'Bachelor Degree', 'Faculty of Accountancy',
 'Bachelor of Accountancy (Hons)', 'AC220', 3, 6, '2027-07-31', '2027-03-01', '2027-07-31',
 20, 3.60, 4.00, 3.65, NULL, NULL, NULL, 'onsite', 800.00, 1, 'Public transport only', 'MNC', NULL),

(7, 'Nur Athirah', 'UiTM Johor (Segamat)', 'Diploma', 'Faculty of Mechanical Engineering',
 'Diploma in Mechanical Engineering', 'EM117', 2, 4, '2027-05-31', '2027-02-01', '2027-05-31',
 16, 3.10, 4.00, 3.05, NULL, NULL, NULL, 'onsite', 550.00, 0, 'Motorcycle', 'SME', NULL),

(8, 'Maisarah Irdina', 'UiTM Sarawak (Samarahan)', 'Bachelor Degree', 'Faculty of Communication and Media Studies',
 'Bachelor of Mass Communication (Hons) Broadcasting', 'MC234', 3, 6, '2027-07-31', '2027-02-15', '2027-06-15',
 18, 3.45, 4.00, 3.40, NULL, NULL, NULL, 'flexible', 700.00, 1, 'Public transport only', 'Startup', NULL);

-- =====================================================================
-- RELEVANT SUBJECTS
-- =====================================================================

INSERT INTO `student_subjects` (`student_id`, `subject_name`) VALUES
(1, 'Data Structures & Algorithms'), (1, 'Software Engineering Principles'), (1, 'Database Systems'), (1, 'Web Application Development'),
(2, 'Principles of Marketing'), (2, 'Business Communication'), (2, 'Financial Management'),
(3, 'Electrical Circuit Analysis'), (3, 'Power System Analysis'), (3, 'Control Systems'),
(4, 'Typography'), (4, 'Digital Illustration'), (4, 'Branding & Identity Design'),
(5, 'Mobile Application Development'), (5, 'Cloud Computing Fundamentals'), (5, 'Artificial Intelligence'), (5, 'Network Security'),
(6, 'Financial Accounting'), (6, 'Taxation'), (6, 'Auditing Principles'),
(7, 'Engineering Mechanics'), (7, 'Manufacturing Technology'), (7, 'CAD/CAM'),
(8, 'Broadcast Journalism'), (8, 'Media Writing'), (8, 'Digital Content Production');

-- =====================================================================
-- ACADEMIC PROJECTS
-- =====================================================================

INSERT INTO `student_academic_projects` (`student_id`, `title`, `description`) VALUES
(1, 'Campus Lost & Found Web App', 'Built a full-stack PHP/MySQL web app for students to report and claim lost items on campus.'),
(2, 'Local SME Marketing Plan', 'Group project developing a 6-month digital marketing plan for a local Pahang bakery.'),
(3, 'Solar-Powered Streetlight Controller', 'Designed and simulated a microcontroller-based control circuit for solar streetlights.'),
(4, 'UiTM Open Day Branding Kit', 'Created a full visual identity and poster series for the faculty open day.'),
(5, 'AI Chatbot for Student FAQ', 'Developed a rule-based + NLP chatbot prototype to answer common student enquiries.'),
(6, 'Audit Simulation for a Retail Co-operative', 'Conducted a mock audit engagement on a student-run retail co-operative.'),
(7, '3D Printed Jig for Assembly Line', 'Designed and prototyped a 3D-printed assembly jig to reduce production time.'),
(8, 'Campus News Mini-Documentary', 'Produced and edited a 10-minute documentary on student life during exam week.');

-- =====================================================================
-- SKILLS (technical_skill, software_tool, soft_skill, language)
-- =====================================================================

INSERT INTO `student_skills` (`student_id`, `skill_type`, `skill_name`) VALUES
(1, 'technical_skill', 'PHP'), (1, 'technical_skill', 'JavaScript'), (1, 'technical_skill', 'SQL'),
(1, 'software_tool', 'Git'), (1, 'software_tool', 'XAMPP'), (1, 'soft_skill', 'Problem Solving'), (1, 'language', 'Malay'), (1, 'language', 'English'),

(2, 'technical_skill', 'Market Research'), (2, 'software_tool', 'Microsoft Excel'), (2, 'software_tool', 'Canva'),
(2, 'soft_skill', 'Communication'), (2, 'soft_skill', 'Teamwork'), (2, 'language', 'Malay'), (2, 'language', 'English'),

(3, 'technical_skill', 'Circuit Design'), (3, 'technical_skill', 'PLC Programming'), (3, 'software_tool', 'MATLAB'),
(3, 'software_tool', 'AutoCAD Electrical'), (3, 'soft_skill', 'Analytical Thinking'), (3, 'language', 'Malay'), (3, 'language', 'English'),

(4, 'technical_skill', 'Visual Design'), (4, 'software_tool', 'Adobe Photoshop'), (4, 'software_tool', 'Adobe Illustrator'),
(4, 'software_tool', 'Figma'), (4, 'soft_skill', 'Creativity'), (4, 'language', 'Malay'), (4, 'language', 'English'),

(5, 'technical_skill', 'Python'), (5, 'technical_skill', 'Flutter'), (5, 'technical_skill', 'REST API'),
(5, 'software_tool', 'Git'), (5, 'software_tool', 'Firebase'), (5, 'soft_skill', 'Adaptability'),
(5, 'language', 'Malay'), (5, 'language', 'English'), (5, 'language', 'Mandarin'),

(6, 'technical_skill', 'Financial Reporting'), (6, 'software_tool', 'Microsoft Excel'), (6, 'software_tool', 'AutoCount'),
(6, 'soft_skill', 'Attention to Detail'), (6, 'soft_skill', 'Time Management'), (6, 'language', 'Malay'), (6, 'language', 'English'),

(7, 'technical_skill', 'CAD Drafting'), (7, 'software_tool', 'SolidWorks'), (7, 'software_tool', 'AutoCAD'),
(7, 'soft_skill', 'Hands-on Troubleshooting'), (7, 'language', 'Malay'), (7, 'language', 'English'),

(8, 'technical_skill', 'Video Editing'), (8, 'software_tool', 'Adobe Premiere Pro'), (8, 'software_tool', 'CapCut'),
(8, 'soft_skill', 'Storytelling'), (8, 'soft_skill', 'Public Speaking'), (8, 'language', 'Malay'), (8, 'language', 'English');

-- =====================================================================
-- PREFERENCES (industry, job_role, state)
-- =====================================================================

INSERT INTO `student_preferences` (`student_id`, `preference_type`, `preference_value`) VALUES
(1, 'industry', 'Information Technology'), (1, 'job_role', 'Software Engineer Intern'), (1, 'state', 'Selangor'), (1, 'state', 'Kuala Lumpur'),
(2, 'industry', 'Retail & FMCG'), (2, 'job_role', 'Marketing Intern'), (2, 'state', 'Pahang'),
(3, 'industry', 'Energy & Utilities'), (3, 'job_role', 'Electrical Engineer Intern'), (3, 'state', 'Perlis'), (3, 'state', 'Kedah'),
(4, 'industry', 'Media & Creative'), (4, 'job_role', 'Graphic Design Intern'), (4, 'state', 'Melaka'), (4, 'state', 'Selangor'),
(5, 'industry', 'Information Technology'), (5, 'job_role', 'Mobile App Developer Intern'), (5, 'state', 'Terengganu'), (5, 'state', 'Kuala Lumpur'),
(6, 'industry', 'Finance & Accounting'), (6, 'job_role', 'Audit Intern'), (6, 'state', 'Kelantan'), (6, 'state', 'Kuala Lumpur'),
(7, 'industry', 'Manufacturing'), (7, 'job_role', 'Mechanical Engineer Intern'), (7, 'state', 'Johor'),
(8, 'industry', 'Media & Broadcasting'), (8, 'job_role', 'Content Production Intern'), (8, 'state', 'Sarawak'), (8, 'state', 'Kuala Lumpur');
