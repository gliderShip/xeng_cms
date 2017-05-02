-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2017 at 12:33 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xeng_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `x_profile`
--

CREATE TABLE `x_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `x_profile`
--

INSERT INTO `x_profile` (`id`, `user_id`, `first_name`, `last_name`, `image_id`) VALUES
(1, 3, 'TestName1', 'TestSurname1', NULL),
(2, 2, 'Admin', 'Admin', NULL),
(3, 4, 'test2', 'test2', NULL),
(4, 1, 'super1', 'super1', NULL),
(6, 5, 'Test 3', 't3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `x_profile_image`
--

CREATE TABLE `x_profile_image` (
  `id` int(11) NOT NULL,
  `profile` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `x_role`
--

CREATE TABLE `x_role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `x_role`
--

INSERT INTO `x_role` (`id`, `name`, `enabled`, `description`) VALUES
(1, 'Site Admin', 0, 'Site Administrator, with full privileges on site level'),
(2, 'Super Admin', 1, 'This is God');

-- --------------------------------------------------------

--
-- Table structure for table `x_role_permission`
--

CREATE TABLE `x_role_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `x_role_permission`
--

INSERT INTO `x_role_permission` (`id`, `role_id`, `permission`, `module`) VALUES
(3, 1, 'user.list', 'x_core'),
(4, 1, 'user.detail', 'x_core'),
(6, 1, 'admin', 'x_admin'),
(7, 1, 'role.list', 'x_core'),
(8, 1, 'role.create', 'x_core'),
(9, 2, 'user.list', 'x_core'),
(10, 2, 'user.detail', 'x_core'),
(11, 2, 'user.create', 'x_core'),
(12, 2, 'user.update', 'x_core'),
(13, 2, 'user.delete', 'x_core'),
(14, 2, 'user.profile', 'x_core'),
(15, 2, 'role.list', 'x_core'),
(16, 2, 'role.detail', 'x_core'),
(17, 2, 'role.create', 'x_core'),
(18, 2, 'role.update', 'x_core'),
(19, 2, 'role.delete', 'x_core'),
(20, 2, 'role.permissions_list', 'x_core'),
(21, 2, 'role.permissions_update', 'x_core'),
(22, 2, 'admin', 'x_admin');

-- --------------------------------------------------------

--
-- Table structure for table `x_user`
--

CREATE TABLE `x_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `x_user`
--

INSERT INTO `x_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `profile_id`) VALUES
(1, 'superadmin', 'superadmin', 'ermal.mino@gmail.com', 'ermal.mino@gmail.com', 1, 'rggyb7drp80s8ksks0ccs8c4k8wo8k8', '$2y$13$rggyb7drp80s8ksks0ccsu.6LJAiZL9sEaTg9S1Qx3JJVfqrrlrga', '2017-05-01 18:23:25', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 4),
(2, 'admin', 'admin', 'ermal@xeng.org', 'ermal@xeng.org', 1, 'd5h75xjq5fcwos8goc8go8ko0os84cc', '$2y$13$d5h75xjq5fcwos8goc8gouk68UDgWwQriqYnih0OTgiT/pGBk/OR.', '2017-04-25 12:42:09', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 2),
(3, 'test1', 'test1', 'test@xeng.org', 'test@xeng.org', 1, 'mq7v72ksscg0ocwo488kkckwoskggsw', '$2y$13$mq7v72ksscg0ocwo488kkOS4F0j0NYD9sTzOovb9U2j44EkQQrXd.', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 1),
(4, 'test2', 'test2', 'test2@xeng.org', 'test2@xeng.org', 1, 'jhlw9ouz1xwsk4gw8s8soc00wwk8ko8', '$2y$13$jhlw9ouz1xwsk4gw8s8soONuXz2UEKrcGR7qVPmV53Hg3JtKJchu6', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 3),
(5, 'test3', 'test3', 'test3@xeng.org', 'test3@xeng.org', 1, 'scwgxelst40ko88080cskskcwc40cks', '$2y$13$scwgxelst40ko88080cskeW4hQMLOxLSyyJJ/8rqTk4HqDbIGTigS', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `x_user_role`
--

CREATE TABLE `x_user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `x_user_role`
--

INSERT INTO `x_user_role` (`id`, `user_id`, `role_id`) VALUES
(2, 2, 1),
(3, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `x_profile`
--
ALTER TABLE `x_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3D4FE178A76ED395` (`user_id`),
  ADD UNIQUE KEY `UNIQ_3D4FE1783DA5256D` (`image_id`);

--
-- Indexes for table `x_profile_image`
--
ALTER TABLE `x_profile_image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5204B7A88157AA0F` (`profile`);

--
-- Indexes for table `x_role`
--
ALTER TABLE `x_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x_role_permission`
--
ALTER TABLE `x_role_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permission_unique` (`role_id`,`permission`),
  ADD KEY `IDX_B556246FD60322AC` (`role_id`);

--
-- Indexes for table `x_user`
--
ALTER TABLE `x_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_40277F4092FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_40277F40A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_40277F40CCFA12B8` (`profile_id`);

--
-- Indexes for table `x_user_role`
--
ALTER TABLE `x_user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role_unique` (`user_id`,`role_id`),
  ADD KEY `IDX_AC980D92A76ED395` (`user_id`),
  ADD KEY `IDX_AC980D92D60322AC` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `x_profile`
--
ALTER TABLE `x_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `x_profile_image`
--
ALTER TABLE `x_profile_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `x_role`
--
ALTER TABLE `x_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `x_role_permission`
--
ALTER TABLE `x_role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `x_user`
--
ALTER TABLE `x_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `x_user_role`
--
ALTER TABLE `x_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `x_profile`
--
ALTER TABLE `x_profile`
  ADD CONSTRAINT `FK_3D4FE1783DA5256D` FOREIGN KEY (`image_id`) REFERENCES `x_profile_image` (`id`),
  ADD CONSTRAINT `FK_3D4FE178A76ED395` FOREIGN KEY (`user_id`) REFERENCES `x_user` (`id`);

--
-- Constraints for table `x_profile_image`
--
ALTER TABLE `x_profile_image`
  ADD CONSTRAINT `FK_5204B7A88157AA0F` FOREIGN KEY (`profile`) REFERENCES `x_profile` (`id`);

--
-- Constraints for table `x_role_permission`
--
ALTER TABLE `x_role_permission`
  ADD CONSTRAINT `FK_B556246FD60322AC` FOREIGN KEY (`role_id`) REFERENCES `x_role` (`id`);

--
-- Constraints for table `x_user`
--
ALTER TABLE `x_user`
  ADD CONSTRAINT `FK_40277F40CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `x_profile` (`id`);

--
-- Constraints for table `x_user_role`
--
ALTER TABLE `x_user_role`
  ADD CONSTRAINT `FK_AC980D92A76ED395` FOREIGN KEY (`user_id`) REFERENCES `x_user` (`id`),
  ADD CONSTRAINT `FK_AC980D92D60322AC` FOREIGN KEY (`role_id`) REFERENCES `x_role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
