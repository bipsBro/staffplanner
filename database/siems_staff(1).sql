-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3312
-- Generation Time: Jul 18, 2018 at 06:37 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siems_staff`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1528099832),
('admin', '2', 1528099832),
('developer', '1', 1528099832);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'master admin', NULL, NULL, 1528099832, 1528099832),
('developer', 1, 'Developer admin', NULL, NULL, 1528099832, 1528099832);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `slug`, `description`, `category_id`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 'Instapaper buys itself back from Pinterest', 'instapaper-buys-itself-back-from-pinterest', '<p><img src=\"https://o.aolcdn.com/images/dims?quality=100&amp;image_uri=http%3A%2F%2Fo.aolcdn.com%2Fhss%2Fstorage%2Fmidas%2F4f243d641ac282cd5cb4f2233f41b0f0%2F206531019%2F4995944368_9c49a897a6_o.jpg&amp;client=cbc79c14efcebee57402&amp;signature=860fadfd2dd621003d63c190e1ae1aea84ee0d0b\" style=\"height:auto; margin:0px; width:640px\" /></p>\r\n\r\n<p>Johan Larsson/Flickr</p>\r\n\r\n<p>Back in 2013, developer Marco Arment&nbsp;<a href=\"https://techcrunch.com/2013/04/25/betaworks-instapaper/\">sold</a>&nbsp;his popular read-it-later app Instapaper to Betaworks, the company that had previously acquired Digg. Two years ago, Pinterest&nbsp;<a href=\"https://www.engadget.com/2016/08/23/pinterest-buys-instapaper/\">bought</a>&nbsp;the little company to &quot;accelerate discovering and saving articles on Pinterest.&quot; Now, the very same team that&#39;s been working on it for the past five years is&nbsp;<a href=\"http://blog.instapaper.com/post/175953870856\">taking Instapaper back</a>.</p>\r\n\r\n<p>Newly formed Instant Paper, Inc. will receive ownership from Pinterest after a 21-day waiting period so it can give Instapaper users fair notice about the change. Not much will change for users of the service, which the new owners say they&#39;ll continue offering &quot;for the foreseeable future.&quot; The developers also thanked Pinterest for being a good partner over the last two years, which allowed them to rebuild search within the app, add an extension for Firefox users and&nbsp;<a href=\"https://www.engadget.com/2014/12/04/instapaper-for-ios-adds-device-handoff-support-and-unread-count/\">optimize</a>&nbsp;the product for mobile operating systems.</p>\r\n', '[\"1\",\"2\"]', '2018-07-17 09:19:56', 2, '2018-07-17 11:19:56', 2),
(2, 'Microsoft Edge iOS beta offers handy visual search tool', 'microsoft-edge-ios-beta-offers-handy-visual-search-tool', '<p><img src=\"https://o.aolcdn.com/images/dims?quality=100&amp;image_uri=http%3A%2F%2Fo.aolcdn.com%2Fhss%2Fstorage%2Fmidas%2F6fd5b1321b9aeeedcd2df91237a4ecd2%2F206531708%2Fcombo.jpg&amp;client=cbc79c14efcebee57402&amp;signature=6241f9af07288d96ccfbc0f1472a390a6e7c477c\" style=\"height:auto; margin:0px; width:640px\" /></p>\r\n\r\n<p>Microsoft</p>\r\n\r\n<p>Today, beta testers of the Microsoft Edge browser on iOS can now&nbsp;<a href=\"https://www.imore.com/microsoft-edge-starts-testing-visual-search-ios-beta-users\">try</a>&nbsp;out Visual Search, which parses images taken by your device&#39;s camera and delivers links to related information. The Bing-based feature&nbsp;<a href=\"https://www.engadget.com/2018/06/21/bing-visual-search/\">came</a>&nbsp;to early users on Android last month, and it works with just-taken photos or from those in your camera roll.</p>\r\n\r\n<p>Microsoft Edge beta testers on iOS also get a couple other new features. One, paste-and-search, saves you a step by letting you look for whatever&#39;s on your clipboard instead of having to paste it in a search field first. Those with a work or school account can access intranet sites from their home as well as the ability to see mobile browser activity on the Windows 10 timeline feature.</p>\r\n\r\n<p>Unlike the Android beta users, those who get an early look at Microsoft Edge on iOS must be enrolled through Apple TestFlight.&nbsp;</p>\r\n', '[\"1\",\"2\",\"3\"]', '2018-07-17 09:39:13', 2, '2018-07-17 11:39:13', 2),
(3, 'Amazon warehouse workers in Europe stage protest on Prime Day', 'amazon-warehouse-workers-in-europe-stage-protest-on-prime-day', '<p><img src=\"https://o.aolcdn.com/images/dims?quality=100&amp;image_uri=https%3A%2F%2Fo.aolcdn.com%2Fimages%2Fdims%3Fcrop%3D3500%252C2184%252C0%252C148%26quality%3D85%26format%3Djpg%26resize%3D1600%252C999%26image_uri%3Dhttp%253A%252F%252Fo.aolcdn.com%252Fhss%252Fstorage%252Fmidas%252Fca8a5f5dc13a079f46216bc38bc47f5e%252F206531972%252Fsecurity-measures-are-taken-in-front-of-the-amazon-building-as-amazon-picture-id935597876%26client%3Da1acac3e1b3290917d92%26signature%3D8c9b1c829dee25c5972ff0939cda100a957d769a&amp;client=cbc79c14efcebee57402&amp;signature=c44fc30a3f42ad90956830d34b32d47c6493b07b\" style=\"height:auto; margin:0px; width:640px\" /></p>\r\n\r\n<p>Burak Akbulut/Anadolu Agency/Getty Images</p>\r\n\r\n<p>Amazon warehouse workers in Germany, Spain and Poland are hoping to call the e-commerce giant&#39;s attention to their plea for better working conditions by&nbsp;<a href=\"https://www.reuters.com/article/us-amazon-com-germany-strike/amazon-workers-strike-in-germany-joining-action-in-spain-and-poland-idUSKBN1K61OY\">going on strike</a>&nbsp;on Prime Day. The workers for the company&#39;s fulfillment centers are protesting the increase in working hours even though they don&#39;t receive bonuses, as well as the lack of protection against illnesses. Stefanie Nutzenberger from German labor union Verdi, which called for the strike, said &quot;The message is clear -- while the online giant gets rich, it is saving money on the health of its workers.&quot;</p>\r\n\r\n<p>According to&nbsp;<a href=\"https://www.washingtonpost.com/business/2018/07/16/amazon-prime-day-now-an-opportunity-worker-strikes-consumer-protests-around-world/?utm_term=.31f084a05a55\"><em>The Washington Post</em></a>, 1,800 workers in Spain went on strike today, July 16th, and the protest in the country is expected to last until July 18th. Thousands of workers across six fulfillment centers in Germany plan to walk out tomorrow, July 17th, while those in Poland intend to do the bare minimum to stay employed.</p>\r\n\r\n<p>It&#39;s far from the first time Amazon&#39;s warehouse workers staged a protest: distribution center employees in Germany and Italy also&nbsp;<a href=\"https://www.engadget.com/2017/11/24/amazon-warehouse-workers-strike-in-germany-and-italy/\">walked out</a>&nbsp;on Black Friday last year over pay issues and workplace health hazards. Over the years,&nbsp;<a href=\"http://gawker.com/true-stories-of-life-as-an-amazon-worker-1002568208\">reports</a>&nbsp;about harsh working conditions in the company&#39;s distribution centers regularly popped up, including stories from people claiming they were&nbsp;<a href=\"http://nypost.com/2017/11/28/amazon-workers-reveal-brutal-conditions-in-pre-christmas-rush/\">injured</a>&nbsp;on the job and collapsed due to exhaustion. Just earlier this year, the National Council for Occupational Safety and Health&nbsp;<a href=\"https://www.engadget.com/2018/04/25/amazon-and-tesla-in-most-dangerous-workplace-report/\">named</a>&nbsp;Amazon as one of the most dangerous places to work for in the US, citing seven workhouse workers&#39; deaths since 2013.</p>\r\n\r\n<p>The company insists, however, that its fulfillment center jobs offer competitive pay and benefits, with workers earning 12.22 euros ($14.31) an hour or more after two years. &quot;We believe Amazon&#39;s Fulfillment Center jobs are excellent jobs providing a great place to learn skills to start and further develop a career,&quot; a spokesperson told&nbsp;<em>Reuters</em>. Amazon also believes only a fraction of its 12,000 workers in Germany will walk out tomorrow and that the protest will not affect its Prime Day sales.&nbsp;<em>The Post</em>&nbsp;says the event is expected to bring in a whopping $3.4 billion this year, so it&#39;s no wonder the company doesn&#39;t seem concerned. Unfortunately for the protesters, a few thousand people walking out might truly not be a big deal for the e-retail titan.</p>\r\n\r\n<p><strong>Update:</strong>&nbsp;An Amazon spokesperson has reached out and told Engadget that the company &quot;is a fair and responsible employer&quot; committed to dialogue:</p>\r\n\r\n<p>&quot;Amazon is proud to have created over 130,000 new jobs in the last year alone. These are good jobs with highly competitive pay and full benefits. One of the reasons we&#39;ve been able to attract so many people to join us is that our number one priority is to ensure a positive and safe working environment. We use our Connections program to ask associates a question every day about how we can make things even better, we develop new processes and technology to make the roles in our facilities more ergonomic and comfortable for our associates, and we investigate any allegation we are made aware of and fix things that are wrong. We believe it&#39;s this commitment to our associates and operational excellence that makes Amazon the most attractive place to work in the U.S., according to the annual LinkedIn Top Companies List. We encourage anyone to come see for themselves what it&#39;s like to work at an Amazon fulfillment center by taking a tour -- sign up and learn more at http://amazonfctours.com.&quot;</p>\r\n', '[\"1\",\"2\",\"3\"]', '2018-07-17 09:40:03', 2, '2018-07-17 11:40:03', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `slug`, `name`, `details`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, NULL, 'technology', 'Technology', '<p>Technology</p>\r\n', 2, '2018-07-17 07:11:19', 2, '2018-07-17 09:11:19'),
(2, NULL, 'information-technology', 'Information technology', '<p>IT</p>\r\n', 2, '2018-07-17 07:21:11', 2, '2018-07-17 09:21:11'),
(3, 2, 'computers', 'Computers', '<p>Information technology</p>\r\n', 2, '2018-07-17 07:28:26', 2, '2018-07-17 10:38:42');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `can_update_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `name`, `value`, `can_update_value`) VALUES
(1, 'site_name', 'SIEMS-STAFF', 1),
(2, 'site_email', 'info@siems-staff.com', 1),
(3, 'site_phone_number', '+11 111 111 111', 1),
(4, 'site_address', 'Malmo, sweden', 1),
(5, 'site_fax_num', '+11 111 111 111', 1),
(6, 'site_currency', 'KR', 1),
(7, 'default_skin', 'skin-black-light', 1);

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `show_in_menu` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `slug`, `title`, `description`, `show_in_menu`, `status`, `position`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 'About us', '<p>About us About usAbout us</p>\r\n', 3, 1, 1, 1, 2, '2018-06-04 12:10:38', '2018-07-16 12:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1528096342),
('m140209_132017_init', 1528096351),
('m140403_174025_create_account_table', 1528096354),
('m140504_113157_update_tables', 1528096363),
('m140504_130429_create_token_table', 1528096368),
('m140506_102106_rbac_init', 1528096999),
('m140830_171933_fix_ip_field', 1528096375),
('m140830_172703_change_account_table_name', 1528096378),
('m141222_110026_update_ip_field', 1528096381),
('m141222_135246_alter_username_length', 1528096386),
('m150614_103145_update_social_account_table', 1528096407),
('m150623_212711_fix_username_notnull', 1528096408),
('m151218_234654_add_timezone_to_profile', 1528096411),
('m160929_103127_add_last_login_at_to_user_table', 1528096412),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1528096999);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1, 'Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(1, 'PUfeClkKbmXVrnWmpKCUqJHV36f78YiJ', 1528099832, 0),
(2, 'E11wmyPyPx2mQx_qBDkLTb4vyVg0hngs', 1528099872, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`, `last_login_at`) VALUES
(1, 'developer', 'hussainmanjar444@gmail.com', '$2y$10$lX95k7.tYukmNYW05Mq.QuGtwgDFoj/efH8gFgRvMltMR2R3cS31.', 'vIYhFO_YgeUpQCUBbmA65ga88PIK6Khg', 1528099832, NULL, NULL, '::1', 1528099832, 1528099832, 0, 1531809956),
(2, 'admin', 'hussainmanjar44@hotmail.com', '$2y$10$IC.xKf5fdwa35dGx6dJghOnEE21EqF3WBroDXVbr0olDJhsoy/35K', 'vSDn4Zpkyoafh6oBeKDz8Iw4EsX5F_aA', 1528099832, NULL, NULL, '::1', 1528099871, 1528099871, 0, 1531887557);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_unique` (`provider`,`client_id`),
  ADD UNIQUE KEY `account_unique_code` (`code`),
  ADD KEY `fk_user_account` (`user_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
