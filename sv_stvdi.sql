-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 27, 2015 at 12:28 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sv_stvdi`
--

-- --------------------------------------------------------

--
-- Table structure for table `sv_access_level`
--

CREATE TABLE IF NOT EXISTS `sv_access_level` (
  `access_id` int(11) NOT NULL,
  `access_name` varchar(30) NOT NULL,
  `access_desc` varchar(30) NOT NULL,
  `access_level_id` int(11) NOT NULL,
  `access_status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sv_access_level`
--

INSERT INTO `sv_access_level` (`access_id`, `access_name`, `access_desc`, `access_level_id`, `access_status`) VALUES
(1, 'super_admin', 'Super Administrator', 1, '1'),
(2, 'admin', 'Stvdi Administrator', 2, '1'),
(3, 'school_admin', 'School Administrator', 11, '1'),
(4, 'branch_admin', 'Branch Administrator', 12, '1'),
(5, 'principal', 'Principal', 13, '1'),
(6, 'account_head', 'Head Accountant', 15, '1'),
(7, 'accountant', 'Accountant Assistant', 16, '1'),
(8, 'vice_principal', 'Vice Principal', 14, '1'),
(9, 'teacher', 'Teacher', 17, '1'),
(10, 'form_master', 'Class Teacher/Form Master', 18, '1'),
(11, 'resident_head', 'Head Boarding', 19, '1'),
(12, 'resident_manager', 'Resident Manager', 20, '1'),
(13, 'student', 'Student', 21, '1'),
(14, 'parent', 'Parent', 22, '1'),
(15, 'dept_head', 'Department Head', 23, '1'),
(16, 'guidance_counselor', 'Guidance and Counselor', 24, '1');

-- --------------------------------------------------------

--
-- Table structure for table `sv_branch_contact`
--

CREATE TABLE IF NOT EXISTS `sv_branch_contact` (
  `contact_id` bigint(20) NOT NULL,
  `contact_branch_id` bigint(20) NOT NULL,
  `contact_type` varchar(5) NOT NULL,
  `contact_detail` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sv_branch_options`
--

CREATE TABLE IF NOT EXISTS `sv_branch_options` (
  `option_id` bigint(20) NOT NULL,
  `option_branch_id` bigint(20) NOT NULL,
  `option_key` varchar(50) NOT NULL,
  `option_value` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sv_email_notification`
--

CREATE TABLE IF NOT EXISTS `sv_email_notification` (
  `notice_id` int(11) NOT NULL,
  `notice_key` varchar(100) NOT NULL,
  `notice_from` varchar(50) NOT NULL,
  `notice_email` varchar(200) NOT NULL,
  `notice_subject` tinytext NOT NULL,
  `notice_content` text NOT NULL,
  `notice_created` int(20) NOT NULL,
  `notice_modified` int(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sv_email_notification`
--

INSERT INTO `sv_email_notification` (`notice_id`, `notice_key`, `notice_from`, `notice_email`, `notice_subject`, `notice_content`, `notice_created`, `notice_modified`) VALUES
(1, 'password_reset_link', 'Stvdi', 'noreply@stvdi.com', '[MyGiftKard] Password reset request', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>{subject}</title>\r\n</head>\r\n\r\n<body>\r\n<p>Hello <span style="text-transform: capitalize">{name}</span>,</p>\r\n<p>We received a request to reset the password associated with this e-mail address. If you made this request, please click on the link below to reset your password.</p>\r\n<p><a href="http://{website}/{merchant-uname}/reset:{auth-code}">http://{website}/{merchant-uname}/reset:{auth-code}</a></p>\r\n<p>If clicking the link does not seem to work, you can copy and paste the link into your browser''s address bar, or retype it there. Once you have returned to <a href="http://{website}/{merchant-uname}">{website}/{merchant-uname}</a>, we will give instructions for resetting your password.</p>\r\n<p>If you did not request to have your password reset you can safely ignore this email, no changes will be made to your account.</p>\r\n<p><span style="text-transform: capitalize">{website}/{merchant-uname}</span> will never e-mail you and ask you to disclose or verify your  password or username. If you receive a suspicious e-mail with a link to update your account information, do not click on the link -- instead, report the e-mail to {website}/{merchant-uname} for investigation.</p>\r\n<p>Thank you,<br />\r\n  <strong style="text-transform: capitalize">{merchant-uname} Team</strong><br />\r\nPowered by &copy; <span style="text-transform: capitalize">{site-name}</span></p>\r\n</body>\r\n</html>', 129948585, 0),
(2, 'temp_password_link', 'Stvdi', 'noreply@stvdi.com', '[MyGiftKard] Password reset request ', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n<html lang="en">\n<head>\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\n<title>{subject}</title>\n</head>\n\n<body>\n<p>Hello <span style="text-transform: capitalize">{name}</span>,</p>\n<p>We received a request to reset the password associated with this e-mail address. If you made this request, we can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like. </p>\n<p>Click on the link below to reset your password:<a href="http://{website}/{merchant-uname}/password:{auth-code}"><br />\nhttp://{website}/{merchant-uname}/password:{auth-code}</a></p>\n<p>After you click the link your temporary password to login will be:<br />\nPassword: <strong>{password}</strong></p>\n<p>If clicking the link does not seem to work, you can copy and paste the link into your browser''s address bar, or retype it there. Once you have returned to <a href="http://{website}/{merchant-uname}">{website}/{merchant-uname}</a>, we will give instructions for resetting your password.</p>\n<p>If you did not request to have your password reset you can safely ignore this email, no changes will be made to your account.</p>\n<p><span style="text-transform: capitalize">{website}/{merchant-uname}</span> will never e-mail you and ask you to disclose or verify your  password or username. If you receive a suspicious e-mail with a link to update your account information, do not click on the link -- instead, report the e-mail to {website}/{merchant-uname} for investigation.</p>\n<p>Thank you,<br />\n  <strong style="text-transform: capitalize">{merchant-uname} Team</strong><br />\nPowered by &copy; <span style="text-transform: capitalize">{site-name}</span></p>\n</body>\n</html>', 1340589485, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sv_schools`
--

CREATE TABLE IF NOT EXISTS `sv_schools` (
  `school_id` bigint(20) NOT NULL,
  `school_name` varchar(200) NOT NULL,
  `school_uniqname` varchar(15) NOT NULL,
  `school_logo` varchar(100) NOT NULL,
  `school_desc` text NOT NULL,
  `school_email` varchar(100) NOT NULL,
  `school_website` varchar(100) NOT NULL,
  `school_registered` varchar(20) NOT NULL,
  `school_is_active` enum('0','1') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='School details table';

--
-- Dumping data for table `sv_schools`
--

INSERT INTO `sv_schools` (`school_id`, `school_name`, `school_uniqname`, `school_logo`, `school_desc`, `school_email`, `school_website`, `school_registered`, `school_is_active`) VALUES
(1, 'Stvdi Academy', 'stvdiacademy', '', 'Test school for the stvdi application', 'j.ilukhor@gmail.com', 'www.stvdi.com', '148827849', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sv_school_branch`
--

CREATE TABLE IF NOT EXISTS `sv_school_branch` (
  `branch_id` bigint(20) NOT NULL,
  `branch_school_id` bigint(20) NOT NULL,
  `branch_school_type` varchar(4) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_logo` varchar(100) NOT NULL,
  `branch_add_a` varchar(255) NOT NULL,
  `branch_add_b` varchar(255) NOT NULL,
  `branch_city` varchar(50) NOT NULL,
  `branch_state` varchar(50) NOT NULL,
  `branch_post_code` varchar(10) NOT NULL,
  `branch_country` varchar(5) NOT NULL,
  `branch_currency` varchar(5) NOT NULL,
  `branch_website` varchar(100) NOT NULL,
  `branch_is_active` enum('0','1') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='School branches details';

-- --------------------------------------------------------

--
-- Table structure for table `sv_school_options`
--

CREATE TABLE IF NOT EXISTS `sv_school_options` (
  `option_id` bigint(20) NOT NULL,
  `option_school_id` int(11) NOT NULL,
  `option_key` varchar(50) NOT NULL,
  `option_value` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='School settings';

-- --------------------------------------------------------

--
-- Table structure for table `sv_students`
--

CREATE TABLE IF NOT EXISTS `sv_students` (
  `student_id` varchar(20) NOT NULL,
  `student_branch_id` int(11) NOT NULL,
  `student_fname` varchar(30) NOT NULL,
  `student_mname` varchar(30) NOT NULL,
  `student_lname` varchar(30) NOT NULL,
  `student_img` varchar(100) NOT NULL,
  `student_gender` enum('f','m') NOT NULL,
  `student_dob` varchar(20) NOT NULL,
  `student_local_gov` varchar(50) NOT NULL,
  `student_state_origin` varchar(50) NOT NULL,
  `student_country` varchar(50) NOT NULL,
  `student_religion` varchar(20) NOT NULL,
  `student_add_a` varchar(100) NOT NULL,
  `student_add_b` varchar(100) NOT NULL,
  `student_mailing_add` tinytext NOT NULL,
  `student_add_city` varchar(5) NOT NULL,
  `student_add_state` varchar(5) NOT NULL,
  `student_add_country` varchar(5) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `student_phone` varchar(15) NOT NULL,
  `student_has_scholarship` enum('0','1') NOT NULL,
  `student_status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Student details table';

--
-- Dumping data for table `sv_students`
--

INSERT INTO `sv_students` (`student_id`, `student_branch_id`, `student_fname`, `student_mname`, `student_lname`, `student_img`, `student_gender`, `student_dob`, `student_local_gov`, `student_state_origin`, `student_country`, `student_religion`, `student_add_a`, `student_add_b`, `student_mailing_add`, `student_add_city`, `student_add_state`, `student_add_country`, `student_email`, `student_phone`, `student_has_scholarship`, `student_status`) VALUES
('90454', 1, 'Susan', '', 'Benson', '', 'f', '926287200', '', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('423736', 1, 'Susan', '', 'Benson', '', 'f', '926287200', '', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('601562', 1, 'Susan', '', 'Benson', '', 'f', '926287200', '', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('53024291', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('38098144', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('34121704', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('23239135', 1, 'Ama', 'Daniel', 'Eze', '', 'm', '810684000', 'Oredo', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('9802246', 1, 'Ama', 'Daniel', 'Eze', '', 'm', '810684000', 'Oredo', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('66921997', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('30609130', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('306091301', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('65905761', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('27651977', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('6427001', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('72592163', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('70532226', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('13186645', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('85955810', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('72482299', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('64807128', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('70401000', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('78570556', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('98739624', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('33105468', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('96170043', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0),
('43646240', 1, 'Mary', '', 'Bensons', '', 'f', '926287200', 'Bwari', '', '', '', '', '', '', '', '', '', '', '', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sv_users`
--

CREATE TABLE IF NOT EXISTS `sv_users` (
  `user_id` varchar(15) NOT NULL,
  `user_branch_id` int(11) NOT NULL,
  `user_session` varchar(200) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `user_old_pass` varchar(200) NOT NULL,
  `user_display_name` varchar(100) NOT NULL,
  `user_photo` varchar(50) NOT NULL,
  `user_access_level` int(11) NOT NULL,
  `user_auth_code` varchar(200) NOT NULL,
  `user_temp_pass` varchar(200) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_ip_addrs` varchar(15) NOT NULL,
  `user_base_url` varchar(25) NOT NULL,
  `user_lang` varchar(6) NOT NULL,
  `user_page_list` int(11) NOT NULL,
  `user_last_login` varchar(15) NOT NULL,
  `user_created` varchar(15) NOT NULL,
  `user_is_online` enum('0','1') NOT NULL DEFAULT '0',
  `user_is_active` enum('0','1','2') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sv_users`
--

INSERT INTO `sv_users` (`user_id`, `user_branch_id`, `user_session`, `user_name`, `user_pass`, `user_old_pass`, `user_display_name`, `user_photo`, `user_access_level`, `user_auth_code`, `user_temp_pass`, `user_email`, `user_ip_addrs`, `user_base_url`, `user_lang`, `user_page_list`, `user_last_login`, `user_created`, `user_is_online`, `user_is_active`) VALUES
('ENG000454565', 1, '', 'administrator', '70873e8580c9900986939611618d7b1e', '70873e8580c9900986939611618d7b1e', 'Administrator', '', 11, '', '', 'j.ilukhor@gmail.com', '', '', 'en-us', 10, '', '13094885', '0', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sv_access_level`
--
ALTER TABLE `sv_access_level`
  ADD PRIMARY KEY (`access_id`);

--
-- Indexes for table `sv_branch_contact`
--
ALTER TABLE `sv_branch_contact`
  ADD PRIMARY KEY (`contact_id`), ADD KEY `branch_id` (`contact_branch_id`);

--
-- Indexes for table `sv_branch_options`
--
ALTER TABLE `sv_branch_options`
  ADD PRIMARY KEY (`option_id`), ADD KEY `branch_id` (`option_branch_id`);

--
-- Indexes for table `sv_email_notification`
--
ALTER TABLE `sv_email_notification`
  ADD PRIMARY KEY (`notice_id`), ADD KEY `key` (`notice_key`);

--
-- Indexes for table `sv_schools`
--
ALTER TABLE `sv_schools`
  ADD PRIMARY KEY (`school_id`), ADD KEY `unique_name` (`school_uniqname`);

--
-- Indexes for table `sv_school_branch`
--
ALTER TABLE `sv_school_branch`
  ADD PRIMARY KEY (`branch_id`), ADD KEY `school_id` (`branch_school_id`), ADD KEY `branch_school_type` (`branch_school_type`);

--
-- Indexes for table `sv_school_options`
--
ALTER TABLE `sv_school_options`
  ADD PRIMARY KEY (`option_id`), ADD KEY `school_id` (`option_school_id`);

--
-- Indexes for table `sv_students`
--
ALTER TABLE `sv_students`
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `sv_users`
--
ALTER TABLE `sv_users`
  ADD UNIQUE KEY `user_id` (`user_id`), ADD UNIQUE KEY `user_name` (`user_name`), ADD UNIQUE KEY `user_email` (`user_email`), ADD KEY `branch_id` (`user_branch_id`), ADD KEY `user_session` (`user_session`), ADD KEY `user_is_active` (`user_is_active`), ADD KEY `user_pass` (`user_pass`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sv_access_level`
--
ALTER TABLE `sv_access_level`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `sv_branch_contact`
--
ALTER TABLE `sv_branch_contact`
  MODIFY `contact_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sv_branch_options`
--
ALTER TABLE `sv_branch_options`
  MODIFY `option_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sv_email_notification`
--
ALTER TABLE `sv_email_notification`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sv_schools`
--
ALTER TABLE `sv_schools`
  MODIFY `school_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sv_school_branch`
--
ALTER TABLE `sv_school_branch`
  MODIFY `branch_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sv_school_options`
--
ALTER TABLE `sv_school_options`
  MODIFY `option_id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
