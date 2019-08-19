-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 10:45 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-website`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `cl_id` smallint(3) UNSIGNED NOT NULL,
  `cl_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cl_desc` text COLLATE utf8_unicode_ci,
  `cl_duration` smallint(3) UNSIGNED DEFAULT NULL,
  `cl_max_people` smallint(3) UNSIGNED NOT NULL DEFAULT '10',
  `cl_img_id` smallint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`cl_id`, `cl_name`, `cl_desc`, `cl_duration`, `cl_max_people`, `cl_img_id`) VALUES
(1, 'boxing', 'Hath creeping subdue he fish green face whose spirit that seasons today multiply female midst upon.', 120, 15, 101),
(2, 'crossfit', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam eligendi id labore repellat rerum.', 60, 20, 102),
(3, 'yoga', 'Ad adipisci aspernatur autem consequatur dolor dolores esse iste, laborum nam, nihil, nobis quo.', 60, 25, 103),
(4, 'metcon', 'Consectetur adipisicing elit. Aperiam delectus doloremque pariatur suscipit ullam. Laboriosam.', 45, 20, 104),
(5, 'high intensity', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi dignissimos est hic incidunt.', 30, 20, 105),
(6, 'kickboxing', 'Praesentium recusandae repellat, tenetur velit? A, dolore doloremque iure necessitatibus non odio.', 90, 12, 106),
(7, 'pilates', 'Ipsum dolor sit amet, consectetur adipisicing elit. Error id impedit quo, ratione similique soluta dolor sit amet.', 60, 35, 107),
(8, 'rope training', 'Consectetur adipisicing elit est. Alias et necessitatibus praesentium quia reiciendis odio odit.', 60, 30, 108);

-- --------------------------------------------------------

--
-- Table structure for table `class_image`
--

CREATE TABLE `class_image` (
  `cl_img_id` smallint(3) UNSIGNED NOT NULL,
  `cl_img_url` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_img_alt` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class_image`
--

INSERT INTO `class_image` (`cl_img_id`, `cl_img_url`, `cl_img_alt`) VALUES
(101, 'img/classes/class-1.jpg', 'boxing training'),
(102, 'img/classes/class-2.jpg', 'crossfit olympic bar'),
(103, 'img/classes/class-3.jpg', 'yoga class'),
(104, 'img/classes/class-4.jpg', 'metcon training'),
(105, 'img/classes/class-5.jpg', 'high-intensity'),
(106, 'img/classes/class-6.jpg', 'kickboxing'),
(107, 'img/classes/class-7.jpg', 'pilates class'),
(108, 'img/classes/class-8.jpg', 'rope training');

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `co_id` smallint(3) UNSIGNED NOT NULL,
  `co_first_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_last_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_focus` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_img` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_facebook` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_twitter` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `co_linkedin` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`co_id`, `co_first_name`, `co_last_name`, `co_email`, `co_focus`, `co_img`, `co_facebook`, `co_twitter`, `co_linkedin`) VALUES
(1, 'jamie', 'hart', 'j.hart@mail.com', 'personal trainer', 'img/coaches/coach-1.jpg', 'facebookuk/', 'twitter', 'uas/login'),
(2, 'jack', 'fraser', 'j.fraser@mail.com', 'boxing', 'img/coaches/coach-2.jpg', 'facebookuk/', 'twitter', 'uas/login'),
(3, 'elsa', 'watson', 'e.watson@mail.com', 'weight loss', 'img/coaches/coach-3.jpg', 'facebookuk/', 'twitter', 'uas/login'),
(4, 'arthur', 'wood', 'a.wood@mail.com', 'gym fitness', 'img/coaches/coach-4.jpg', 'facebookuk/', 'twitter', 'uas/login'),
(5, 'laura', 'mason', 'l.mason@mail.com', 'yoga', 'img/coaches/coach-5.jpg', 'facebookuk/', 'twitter', 'uas/login'),
(6, 'mark', 'hughes', 'm.hughes@gmail.com', 'personal trainer', 'img/coaches/coach-6.jpg', 'facebookuk/', 'twitter', 'uas/login');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `me_id` smallint(3) UNSIGNED NOT NULL,
  `u_id` smallint(3) UNSIGNED NOT NULL,
  `me_expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`me_id`, `u_id`, `me_expiry_date`) VALUES
(1, 1, '2023-05-20'),
(2, 2, '2022-08-12'),
(3, 3, '2023-09-12'),
(4, 4, '2032-08-12'),
(5, 5, '2023-08-12'),
(6, 6, '2023-07-12'),
(7, 7, '2037-07-12'),
(8, 8, '2032-08-12'),
(9, 9, '2029-08-12'),
(10, 11, '2019-08-18'),
(11, 12, '2019-08-18'),
(12, 14, '2019-08-18'),
(13, 15, '2019-08-18'),
(14, 16, '2019-08-18'),
(15, 17, '2019-08-18'),
(16, 31, '2035-08-12'),
(17, 19, '2026-08-12'),
(18, 21, '2037-09-24'),
(19, 27, '2027-08-13'),
(20, 24, '2040-08-13');

-- --------------------------------------------------------

--
-- Table structure for table `opinion`
--

CREATE TABLE `opinion` (
  `op_id` smallint(3) UNSIGNED NOT NULL,
  `op_client_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_photo_url` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_desc` text COLLATE utf8_unicode_ci,
  `cl_id` smallint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `opinion`
--

INSERT INTO `opinion` (`op_id`, `op_client_name`, `op_photo_url`, `op_desc`, `cl_id`) VALUES
(1, 'john doe', 'img/opinions/client1.png', 'Atque aut dignissimos dolor labore molestiae placeat quas quo tenetur ullam veniam.', 1),
(2, 'mark may', 'img/opinions/client2.png', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti facere illum.', NULL),
(3, 'john brown', 'img/opinions/client3.png', 'Accusantium assumenda dolorem doloremque, eligendi esse est hic est lorem laborum nulla.', 5),
(4, 'jenny wills', 'img/opinions/client4.png', 'Rperiam aspernatur atque aut autem consectetur consequatur cumque cupiditate deleniti ducimus.', 7),
(5, 'james king', 'img/opinions/client5.png', 'Etque aut dignissimos dolor labore molestiae placeat quas quo tenetur ullam veniam! Accusantium.', 4),
(6, 'anna gordon', 'img/opinions/client6.png', 'Adipisci alias aliquam aperiam at, corporis cum cupiditate deleniti deserunt dolorem doloremque.', NULL),
(7, 'jay clarke', 'img/opinions/client7.png', 'Ab accusamus aut blanditiis consequuntur dolor earum enim excepturi explicabo illo impedit labor.', 6),
(8, 'sophie phillips', 'img/opinions/client8.png', 'Aut autem consequatur eaque labore laborum laudantium magni, maiores mollitia, necessitatibus.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `pg_ID` smallint(3) UNSIGNED NOT NULL,
  `pg_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_order` int(3) UNSIGNED DEFAULT NULL,
  `pg_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_desc` text COLLATE utf8_unicode_ci,
  `pg_keys` text COLLATE utf8_unicode_ci,
  `pg_footer` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_banner` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`pg_ID`, `pg_name`, `pg_order`, `pg_url`, `pg_title`, `pg_desc`, `pg_keys`, `pg_footer`, `pg_banner`) VALUES
(1, 'home', 0, 'home', 'home', 'fitzone home page', 'home fitzone fitness club gym', 'light', NULL),
(2, 'blog', 1, 'blog', 'blog', 'latest news', 'blog latest news gym', 'light', 'light'),
(3, 'about', 2, 'about', 'about us', 'what we do', 'about us team couches gym', 'dark', 'dark'),
(4, 'schedule', 3, 'schedule', 'schedule', 'upcoming classes', 'upcoming classes gym', 'dark', 'light'),
(5, 'contact', 4, 'contact', 'contact us', 'where to find us', 'contact page email map address', 'light', 'dark'),
(6, 'login', 100, 'login', 'login', NULL, NULL, 'dark', 'light'),
(7, 'register', 101, 'register', 'register', NULL, NULL, 'dark', 'dark'),
(8, 'dashboard', 102, 'dashboard', 'your account', NULL, NULL, 'dark', 'light'),
(9, 'admin', 103, 'admin', 'admin panel', NULL, NULL, 'light', 'dark');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `p_id` smallint(3) UNSIGNED NOT NULL,
  `p_title` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_text` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `p_date` date DEFAULT NULL,
  `p_time` time DEFAULT NULL,
  `p_author` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_comments` smallint(3) DEFAULT NULL,
  `p_img_id` smallint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`p_id`, `p_title`, `p_text`, `p_category`, `p_date`, `p_time`, `p_author`, `p_comments`, `p_img_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 'Suspendisse sed nisi lacus sed viverra tellus. Mattis vulputate enim nulla aliquet porttitor lacus luctus. Mauris pharetra et ultrices neque ornare aenean euismod elementum nisi. Consectetur adipiscing elit ut aliquam purus sit. Augue ut lectus arcu bibendum at varius vel. Turpis egestas sed tempus urna et pharetra pharetra massa. \r\nFeugiat nisl pretium fusce id velit ut. Est ullamcorper eget nulla facilisi etiam dignissim. Quam nulla porttitor massa id neque aliquam. Metus aliquam eleifend mi in nulla posuere sollicitudin aliquam. Amet nulla facilisi morbi tempus iaculis urna id. \r\nQuam quisque id diam vel quam elementum pulvinar. Augue mauris augue neque gravida in fermentum et sollicitudin ac. Eget dolor morbi non arcu risus. Faucibus turpis in eu mi bibendum. At ultrices mi tempus imperdiet nulla malesuada. Odio aenean sed adipiscing diam donec adipiscing. Mattis ullamcorper velit sed ullamcorper. Euismod quis viverra nibh cras. Nunc consequat interdum varius sit amet mattis.', 'gym', '2018-11-01', '14:00:00', 'Jamie Hart', 3, 4),
(2, 'Commodi, doloremque eveniet exercitationem explicabo', 'Elit duis tristique sollicitudin nibh sit amet commodo nulla facilisi. Vitae proin sagittis nisl rhoncus mattis rhoncus urna. Tellus orci ac auctor augue mauris augue neque gravida. \r\nMi bibendum neque egestas congue quisque egestas diam in arcu. Suspendisse in est ante in nibh mauris cursus mattis. Nec feugiat nisl pretium fusce id velit. Eget gravida cum sociis natoque penatibus et magnis dis parturient.  Nibh ipsum consequat nisl vel pretium lectus quam id leo. Et tortor at risus viverra adipiscing at in tellus. \r\nArcu non odio euismod lacinia at quis risus sed vulputate. Massa sed elementum tempus egestas. Elit sed vulputate mi sit amet mauris commodo quis imperdiet. Fringilla ut morbi tincidunt augue interdum velit euismod in. Sed faucibus turpis in eu mi bibendum neque egestas.', 'trainer', '2018-11-02', '13:30:00', 'Jamie Hart', 1, 3),
(3, 'Aliquam asperiores culpa dicta dolore', 'Mollis aliquam ut porttitor leo. Suspendisse ultrices gravida dictum fusce. Non tellus orci ac auctor augue mauris. In arcu cursus euismod quis viverra nibh cras pulvinar. Blandit cursus risus at ultrices mi tempus imperdiet nulla. Purus sit amet luctus venenatis lectus magna fringilla. Nisl condimentum id venenatis a.\r\nUltrices gravida dictum fusce ut placerat. Pulvinar sapien et ligula ullamcorper. Cras adipiscing enim eu turpis egestas pretium. Amet volutpat consequat mauris nunc. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Non consectetur a erat nam at lectus urna. Ultrices tincidunt arcu non sodales. Neque gravida in fermentum et.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At urna condimentum mattis pellentesque id nibh tortor. \r\nArcu cursus vitae congue mauris rhoncus aenean. Sed faucibus turpis in eu mi bibendum neque egestas congue. ', 'crossfit', '2017-05-02', '12:30:11', 'Jack Fraser', 4, 3),
(4, 'Quisque egestas diam in arcu cursus', ' Libero id faucibus nisl tincidunt eget nullam non nisi. Lorem ipsum dolor sit amet consectetur adipiscing elit pellentesque. Viverra mauris in aliquam sem. Risus commodo viverra maecenas accumsan lacus vel. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor.\r\nMetus aliquam eleifend mi in nulla.  At quis risus sed vulputate odio ut enim blandit. Auctor eu augue ut lectus arcu bibendum at varius vel. Tincidunt eget nullam non nisi est sit. Et molestie ac feugiat sed lectus vestibulum mattis. Et ligula ullamcorper malesuada proin libero nunc consequat. Tempus urna et pharetra pharetra massa.\r\nNec feugiat nisl pretium fusce id velit ut tortor pretium.Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'class', '2017-08-02', '14:30:12', 'Jack Fraser', 3, 5),
(5, 'Accusantium ex fuga ipsa nulla quae velit voluptatibus', ' Blandit volutpat maecenas volutpat blandit aliquam etiam erat. Sit amet porttitor eget dolor morbi. Eu turpis egestas pretium aenean pharetra magna. Enim ut tellus elementum sagittis vitae et. Scelerisque in dictum non consectetur a. Pellentesque pulvinar pellentesque habitant morbi tristique senectus.\r\nAmet consectetur adipiscing elit pellentesque habitant morbi tristique senectus et. Amet porttitor eget dolor morbi non arcu.\r\nEget mauris pharetra et ultrices neque ornare. Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor. Donec ultrices tincidunt arcu non sodales.\r\nEt odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'class', '2017-10-05', '11:31:12', 'Jack Fraser', 1, 1),
(6, 'Aliquam, deleniti enim natus quia quos sit suscipit', ' Volutpat commodo sed egestas egestas fringilla phasellus faucibus. Aliquam sem et tortor consequat id porta nibh. Nunc mi ipsum faucibus vitae aliquet nec. Mauris rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque. Tempus quam pellentesque nec nam aliquam sem.\r\nFeugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum. Viverra justo nec ultrices dui sapien eget. Risus sed vulputate odio ut enim blandit volutpat maecenas. Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. Libero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices. In aliquam sem fringilla ut morbi tincidunt augue interdum velit.', 'pilates', '2018-10-05', '15:31:12', 'Jamie Hart', 1, 2),
(7, 'Cum cumque deleniti dolore ipsum itaque labore nisi officia', ' Fringilla urna porttitor rhoncus dolor purus non enim praesent. Enim neque volutpat ac tincidunt vitae semper quis lectus. Et sollicitudin ac orci phasellus egestas. Viverra aliquet eget sit amet tellus cras adipiscing enim eu. Quis enim lobortis scelerisque fermentum dui faucibus in ornare quam. Id donec ultrices tincidunt arcu non sodales.  Eget lorem dolor sed viverra ipsum nunc aliquet bibendum.\r\nOrnare arcu odio ut sem nulla pharetra diam sit. Justo eget magna fermentum iaculis eu non diam phasellus vestibulum. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Integer quis auctor elit sed vulputate mi sit amet mauris. Ut porttitor leo a diam. Consequat mauris nunc congue nisi vitae. Cursus metus aliquam eleifend mi in.Sed sed risus pretium quam vulputate dignissim. Est ante in nibh mauris. Quis commodo odio aenean sed adipiscing diam. Turpis cursus in hac habitasse platea dictumst quisque. Lacus luctus accumsan tortor posuere ac ut consequat semper. Gravida rutrum quisque non tellus orci ac.', 'class', '2018-08-02', '11:30:12', 'Elsa Watson', 0, 5),
(8, 'Accusantium ex fuga ipsa nulla quae velit voluptatibus', ' Sed cras ornare arcu dui vivamus arcu felis bibendum ut. At consectetur lorem donec massa sapien. Quam adipiscing vitae proin sagittis nisl rhoncus. Pulvinar etiam non quam lacus suspendisse faucibus. Ullamcorper malesuada proin libero nunc consequat interdum varius.  Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor. Donec ultrices tincidunt arcu non sodales.\r\nEt odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'kickboxing', '2015-12-05', '14:31:12', 'Jack Fraser', 5, 6),
(9, 'Aliquam, deleniti enim natus quia quos sit suscipit', ' Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit. Fringilla phasellus faucibus scelerisque eleifend. Mattis molestie a iaculis at erat pellentesque adipiscing commodo. Sit amet justo donec enim diam. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant.  Tempus quam pellentesque nec nam aliquam sem.\r\nFeugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum. Viverra justo nec ultrices dui sapien eget. Risus sed vulputate odio ut enim blandit volutpat maecenas. Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. Libero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices. In aliquam sem fringilla ut morbi tincidunt augue interdum velit.', 'pilates', '2018-06-12', '18:31:12', 'Elsa Watson', 3, 2),
(10, 'Adipisci aliquam amet asperiores aspernatur', ' Fringilla urna porttitor rhoncus dolor purus non enim praesent. Enim neque volutpat ac tincidunt vitae semper quis lectus. Et sollicitudin ac orci phasellus egestas. Viverra aliquet eget sit amet tellus cras adipiscing enim eu. Quis enim lobortis scelerisque fermentum dui faucibus in ornare quam. Id donec ultrices tincidunt arcu non sodales.  Eget lorem dolor sed viverra ipsum nunc aliquet bibendum. Ornare arcu odio ut sem nulla pharetra diam sit.\r\nJusto eget magna fermentum iaculis eu non diam phasellus vestibulum. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Integer quis auctor elit sed vulputate mi sit amet mauris. Ut porttitor leo a diam. Consequat mauris nunc congue nisi vitae. Cursus metus aliquam eleifend mi in.Sed sed risus pretium quam vulputate dignissim. Est ante in nibh mauris. Quis commodo odio aenean sed adipiscing diam. Turpis cursus in hac habitasse platea dictumst quisque. Lacus luctus accumsan tortor posuere ac ut consequat semper. Gravida rutrum quisque non tellus orci ac.', 'gym', '2018-08-02', '12:18:00', 'Elsa Watson', 0, 4),
(11, 'Non blandit massa enim nec dui nunc mattis enim', ' Sed cras ornare arcu dui vivamus arcu felis bibendum ut. At consectetur lorem donec massa sapien. Quam adipiscing vitae proin sagittis nisl rhoncus. Pulvinar etiam non quam lacus suspendisse faucibus. Ullamcorper malesuada proin libero nunc consequat interdum varius.  Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor. Donec ultrices tincidunt arcu non sodales. Et odio pellentesque diam volutpat commodo.\r\nAt in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'kickboxing', '2018-01-05', '11:31:12', 'Jack Fraser', 1, 6),
(12, 'Cum dolore dolores ducimus et in nostrum', ' Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit. Fringilla phasellus faucibus scelerisque eleifend. Mattis molestie a iaculis at erat pellentesque adipiscing commodo. Sit amet justo donec enim diam. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant.\r\nTempus quam pellentesque nec nam aliquam sem. Feugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum. Viverra justo nec ultrices dui sapien eget. Risus sed vulputate odio ut enim blandit volutpat maecenas. Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. Libero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices. In aliquam sem fringilla ut morbi tincidunt augue interdum velit.', 'class', '2018-07-21', '10:11:12', 'Elsa Watson', 0, 7),
(13, 'Et egestas quis ipsum suspendisse ultrices gravida', 'Fringilla urna porttitor rhoncus dolor purus non enim praesent. Enim neque volutpat ac tincidunt vitae semper quis lectus. Et sollicitudin ac orci phasellus egestas. Viverra aliquet eget sit amet tellus cras adipiscing enim eu. Quis enim lobortis scelerisque fermentum dui faucibus in ornare quam. Id donec ultrices tincidunt arcu non sodales.  Eget lorem dolor sed viverra ipsum nunc aliquet bibendum. Ornare arcu odio ut sem nulla pharetra diam sit.\r\nJusto eget magna fermentum iaculis eu non diam phasellus vestibulum. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Integer quis auctor elit sed vulputate mi sit amet mauris. Ut porttitor leo a diam. Consequat mauris nunc congue nisi vitae. Cursus metus aliquam eleifend mi in.Sed sed risus pretium quam vulputate dignissim. Est ante in nibh mauris. Quis commodo odio aenean sed adipiscing diam.\r\nTurpis cursus in hac habitasse platea dictumst quisque. Lacus luctus accumsan tortor posuere ac ut consequat semper. Gravida rutrum quisque non tellus orci ac.', 'gym', '2018-05-02', '17:30:12', 'Elsa Watson', 0, 4),
(14, 'Nisl nisi scelerisque eu ultrices vitae', ' Sed cras ornare arcu dui vivamus arcu felis bibendum ut. At consectetur lorem donec massa sapien. Quam adipiscing vitae proin sagittis nisl rhoncus. Pulvinar etiam non quam lacus suspendisse faucibus. Ullamcorper malesuada proin libero nunc consequat interdum varius.  Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor.\r\nDonec ultrices tincidunt arcu non sodales. Et odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'kickboxing', '2018-04-05', '17:31:12', 'Jack Fraser', 0, 6),
(15, 'Sit amet nulla facilisi morbi tempus iaculism', ' Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit. Fringilla phasellus faucibus scelerisque eleifend. Mattis molestie a iaculis at erat pellentesque adipiscing commodo. Sit amet justo donec enim diam. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant.\r\nTempus quam pellentesque nec nam aliquam sem. Feugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum. Viverra justo nec ultrices dui sapien eget. Risus sed vulputate odio ut enim blandit volutpat maecenas. Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. Libero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices. In aliquam sem fringilla ut morbi tincidunt augue interdum velit.', 'class', '2018-07-21', '11:41:12', 'Elsa Watson', 0, 7),
(16, 'Et egestas quis ipsum suspendisse ultrices Sit', 'Fringilla urna porttitor rhoncus dolor purus non enim praesent. Enim neque volutpat ac tincidunt vitae semper quis lectus. Et sollicitudin ac orci phasellus egestas. Viverra aliquet eget sit amet tellus cras adipiscing enim eu. Quis enim lobortis scelerisque fermentum dui faucibus in ornare quam. Id donec ultrices tincidunt arcu non sodales.  Eget lorem dolor sed viverra ipsum nunc aliquet bibendum. Ornare arcu odio ut sem nulla pharetra diam sit.\r\n\r\nJusto eget magna fermentum iaculis eu non diam phasellus vestibulum. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Integer quis auctor elit sed vulputate mi sit amet mauris. Ut porttitor leo a diam. Consequat mauris nunc congue nisi vitae. \r\n\r\nCursus metus aliquam eleifend mi in.Sed sed risus pretium quam vulputate dignissim. Est ante in nibh mauris. Quis commodo odio aenean sed adipiscing diam. Turpis cursus in hac habitasse platea dictumst quisque. Lacus luctus accumsan tortor posuere ac ut consequat semper. Gravida rutrum quisque non tellus orci ac.', 'trainer', '2019-01-11', '17:45:00', 'Jamie Hart', 5, 4),
(17, 'Nisl nisi scelerisque eu ultrices vitae', 'Sed cras ornare arcu dui vivamus arcu felis bibendum ut. Quam adipiscing vitae proin sagittis nisl rhoncus. \r\nAt consectetur lorem donec massa sapien. Quam adipiscing vitae proin sagittis nisl rhoncus. Pulvinar etiam non quam lacus suspendisse faucibus. Ullamcorper malesuada proin libero nunc consequat interdum varius.  Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor. Donec ultrices tincidunt arcu non sodales. Et odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit.\r\nUrna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna. ', 'rope training', '2018-08-12', '12:22:12', 'Jamie Hart', 2, 1),
(18, 'Sit amet nulla facilisi morbi tempus iaculism', 'Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit. Fringilla phasellus faucibus scelerisque eleifend. Mattis molestie a iaculis at erat pellentesque adipiscing commodo.\r\n\r\nSit amet justo donec enim diam. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant. Tempus quam pellentesque nec nam aliquam sem. Feugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum. Viverra justo nec ultrices dui sapien eget. Risus sed vulputate odio ut enim blandit volutpat maecenas. Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada.\r\n\r\nLibero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices. In aliquam sem fringilla ut morbi tincidunt augue interdum velit.', 'gym', '2019-01-21', '12:41:12', 'Jamie Hart', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `pc_id` smallint(3) UNSIGNED NOT NULL,
  `p_id` smallint(3) UNSIGNED NOT NULL,
  `pc_date` date DEFAULT NULL,
  `pc_time` time DEFAULT NULL,
  `pc_text` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`pc_id`, `p_id`, `pc_date`, `pc_time`, `pc_text`, `pc_author`, `pc_approved`) VALUES
(1, 1, '2019-04-02', '19:00:00', 'Est ullamcorper eget nulla facilisi etiam dignissim. Quam nulla porttitor massa id neque aliquam. Metus aliquam eleifend mi in nulla posuere sollicitudin aliquam.', 'Mark Brown', 1),
(2, 1, '2019-04-02', '19:02:20', 'Diam sit amet nisl suscipit adipiscing bibendum est. Lobortis elementum nibh tellus molestie nunc. Diam maecenas sed enim ut sem viverra. Facilisi cras fermentum odio eu feugiat pretium nibh ipsum consequat. Ante in nibh mauris cursus mattis molestie a. Amet consectetur adipiscing elit pellentesque. Molestie a iaculis at erat pellentesque adipiscing. Sit amet consectetur adipiscing elit ut aliquam. Id semper risus in hendrerit gravida.', 'Jenny Watson', 1),
(3, 1, '2018-12-02', '18:02:20', 'Scelerisque viverra mauris in aliquam sem. Etiam non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Blandit massa enim nec dui. Adipiscing elit pellentesque habitant morbi tristique. Tortor at risus viverra adipiscing. Enim lobortis scelerisque fermentum dui faucibus in ornare quam. Cras semper auctor neque vitae tempus quam pellentesque nec. Tincidunt dui ut ornare lectus sit amet est. Nibh cras pulvinar mattis nunc sed.', 'Maria Stubbs', 1),
(4, 3, '2017-05-28', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'Ann Sept', 1),
(5, 3, '2017-06-05', '14:00:00', 'Morbi tincidunt ornare massa eget egestas purus viverra accumsan in. Sed augue lacus viverra vitae congue eu. Aliquam nulla facilisi cras fermentum odio eu feugiat. Eget nullam non nisi est sit. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Maecenas accumsan lacus vel facilisis volutpat est. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum.', 'James Hart', 1),
(6, 3, '2017-05-28', '17:32:11', 'In cursus turpis massa tincidunt dui ut ornare lectus sit. Consectetur libero id faucibus nisl. Aliquam purus sit amet luctus venenatis lectus. Scelerisque fermentum dui faucibus in ornare quam viverra. At augue eget arcu dictum varius duis at consectetur. Mauris a diam maecenas sed enim ut. Nisl vel pretium lectus quam id. Viverra aliquet eget sit amet tellus cras adipiscing enim. Vestibulum lorem sed risus ultricies tristique nulla. ', 'Jenny Watson', 1),
(7, 3, '2017-07-11', '11:12:30', 'Scelerisque viverra mauris in aliquam sem. Etiam non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Blandit massa enim nec dui. Adipiscing elit pellentesque habitant morbi tristique. Tortor at risus viverra adipiscing. Enim lobortis scelerisque fermentum dui faucibus in ornare quam. Cras semper auctor neque vitae tempus quam pellentesque nec. Tincidunt dui ut ornare lectus sit amet est. Nibh cras pulvinar mattis nunc sed.', 'Jack James', 1),
(8, 4, '2017-11-28', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'Ann Sept', 1),
(9, 4, '2017-11-05', '14:00:00', 'Morbi tincidunt ornare massa eget egestas purus viverra accumsan in. Sed augue lacus viverra vitae congue eu. Aliquam nulla facilisi cras fermentum odio eu feugiat. Eget nullam non nisi est sit. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Maecenas accumsan lacus vel facilisis volutpat est. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum.', 'James Hart', 1),
(10, 5, '2017-11-28', '17:32:11', 'In cursus turpis massa tincidunt dui ut ornare lectus sit. Consectetur libero id faucibus nisl. Aliquam purus sit amet luctus venenatis lectus. Scelerisque fermentum dui faucibus in ornare quam viverra. At augue eget arcu dictum varius duis at consectetur. Mauris a diam maecenas sed enim ut. Nisl vel pretium lectus quam id. Viverra aliquet eget sit amet tellus cras adipiscing enim. Vestibulum lorem sed risus ultricies tristique nulla. ', 'Jenny Watson', 1),
(11, 8, '2015-12-28', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'John Doe', 1),
(12, 8, '2015-12-28', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'Neil Wildfire', 1),
(13, 8, '2015-12-06', '14:00:00', 'Morbi tincidunt ornare massa eget egestas purus viverra accumsan in. Sed augue lacus viverra vitae congue eu. Aliquam nulla facilisi cras fermentum odio eu feugiat. Eget nullam non nisi est sit. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Maecenas accumsan lacus vel facilisis volutpat est. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum.', 'James Hart', 1),
(14, 8, '2015-12-14', '17:32:11', 'In cursus turpis massa tincidunt dui ut ornare lectus sit. Consectetur libero id faucibus nisl. Aliquam purus sit amet luctus venenatis lectus. Scelerisque fermentum dui faucibus in ornare quam viverra. At augue eget arcu dictum varius duis at consectetur. Mauris a diam maecenas sed enim ut. Nisl vel pretium lectus quam id. Viverra aliquet eget sit amet tellus cras adipiscing enim. Vestibulum lorem sed risus ultricies tristique nulla. ', 'Mark Brown', 1),
(15, 11, '2018-06-18', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'John Doe', 1),
(16, 16, '2019-06-28', '11:11:00', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod.\r\n\r\nLorem Ipsum', 'John Doe', 1),
(17, 16, '2019-04-28', '18:02:20', 'Non pulvinar neque laoreet suspendisse interdum consectetur libero. Tempor orci eu lobortis elementum nibh tellus molestie nunc non. Tristique magna sit amet purus. Commodo odio aenean sed adipiscing diam donec. Egestas diam in arcu cursus euismod. ', 'Neil Wildfire', 1),
(18, 16, '2019-03-06', '14:00:00', 'Morbi tincidunt ornare massa eget egestas purus viverra accumsan in. Sed augue lacus viverra vitae congue eu. Aliquam nulla facilisi cras fermentum odio eu feugiat. Eget nullam non nisi est sit. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Maecenas accumsan lacus vel facilisis volutpat est. Facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum.', 'James Hart', 1),
(19, 16, '2019-02-14', '17:32:11', 'In cursus turpis massa tincidunt dui ut ornare lectus sit. Consectetur libero id faucibus nisl. Aliquam purus sit amet luctus venenatis lectus. Scelerisque fermentum dui faucibus in ornare quam viverra. At augue eget arcu dictum varius duis at consectetur. Mauris a diam maecenas sed enim ut. Nisl vel pretium lectus quam id. Viverra aliquet eget sit amet tellus cras adipiscing enim. Vestibulum lorem sed risus ultricies tristique nulla. ', 'Mark Brown', 1),
(20, 16, '2019-02-14', '16:22:11', 'Massa tincidunt dui ut ornare. Id neque aliquam vestibulum morbi blandit cursus risus at ultrices. Habitant morbi tristique senectus et netus et malesuada. Molestie a iaculis at erat pellentesque adipiscing commodo. Egestas pretium aenean pharetra magna ac placerat vestibulum lectus mauris. Ullamcorper dignissim cras tincidunt lobortis.', 'Mark Brown', 1),
(21, 9, '2019-07-24', '21:00:00', 'Sit amet justo donec enim diam. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant. Tempus quam pellentesque nec nam aliquam sem. Feugiat in ante metus dictum at tempor. Convallis convallis tellus id interdum.', 'Mark Brown', 1),
(22, 4, '2019-07-09', '21:00:00', 'Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit.', 'Katie Turner', 1),
(23, 9, '2019-10-17', '19:07:00', 'Libero id faucibus nisl tincidunt eget nullam non nisi. Amet risus nullam eget felis eget nunc lobortis. Vel eros donec ac odio tempor orci dapibus ultrices.', 'John May', 1),
(24, 2, '2019-07-17', '21:00:00', 'Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit.', 'John Doe', 1),
(25, 6, '2019-07-09', '16:00:00', 'Sed cras ornare arcu dui vivamus arcu felis bibendum ut. Quam adipiscing vitae proin sagittis nisl rhoncus. \r\nAt consectetur lorem donec massa sapien. Quam adipiscing vitae proin sagittis nisl rhoncus. Pulvinar etiam non quam lacus suspendisse faucibus.', 'Mark Smith', 1),
(26, 8, '2019-07-09', '16:00:00', 'Et odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit.', 'Neil Smith', 1),
(27, 17, '2019-07-01', '16:22:00', 'Urna id volutpat lacus laoreet non curabitur. Diam volutpat commodo sed egestas egestas. Suspendisse sed nisi lacus sed viverra. Mattis vulputate enim nulla aliquet porttitor. Fermentum iaculis eu non diam phasellus vestibulum lorem. Eget duis at tellus at urna.', 'John Doe', 1),
(28, 9, '2019-07-23', '16:00:00', 'Non blandit massa enim nec dui nunc mattis enim. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Vitae congue mauris rhoncus aenean vel elit.', 'John Doe', 1),
(29, 17, '2019-07-27', '19:57:00', 'Ullamcorper malesuada proin libero nunc consequat interdum varius. Nunc sed velit dignissim sodales ut. Lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor. Donec ultrices tincidunt arcu non sodales. Et odio pellentesque diam volutpat commodo. At in tellus integer feugiat. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit.', 'Emma Stone', 1),
(30, 7, '2019-08-01', '13:00:00', 'Pretium vulputate sapien nec sagittis aliquam malesuada bibendum. Pellentesque elit ullamcorper dignissim cras. Mauris commodo quis imperdiet massa tincidunt. Nisl vel pretium lectus quam id leo. Ornare arcu odio ut sem nulla pharetra. Nibh cras pulvinar mattis nunc sed blandit libero volutpat sed. Nulla posuere sollicitudin aliquam ultrices sagittis orci a scelerisque purus. Eleifend quam adipiscing vitae proin sagittis. Aenean vel elit scelerisque mauris.', 'John Doe', 0),
(31, 7, '2019-07-01', '15:00:00', 'Nibh cras pulvinar mattis nunc sed blandit libero volutpat sed. Nulla posuere sollicitudin aliquam ultrices sagittis orci a scelerisque purus. Eleifend quam adipiscing vitae proin sagittis. Aenean vel elit scelerisque mauris.', 'Jenny Watson', 0),
(32, 7, '2019-07-01', '14:00:00', 'Blandit massa enim nec dui nunc mattis enim ut tellus. Eget lorem dolor sed viverra ipsum nunc. Purus sit amet volutpat consequat mauris nunc congue nisi vitae. Ac turpis egestas maecenas pharetra convallis.', 'Mark Doe', 0),
(33, 11, '2019-07-01', '15:00:00', 'Nibh cras pulvinar mattis nunc sed blandit libero volutpat sed. Nulla posuere sollicitudin aliquam ultrices sagittis orci a scelerisque purus. Eleifend quam adipiscing vitae proin sagittis. Aenean vel elit scelerisque mauris.', 'Jenny Watson', 0),
(34, 11, '2019-08-04', '14:00:00', 'Blandit massa enim nec dui nunc mattis enim ut tellus. Eget lorem dolor sed viverra ipsum nunc. Purus sit amet volutpat consequat mauris nunc congue nisi vitae. Ac turpis egestas maecenas pharetra convallis.', 'Mark Doe', 0),
(35, 12, '2019-07-04', '16:00:00', 'Mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien et.', 'Jenny Watson', 0),
(36, 12, '2019-06-06', '17:00:00', 'Enim facilisis gravida neque convallis a. Sagittis nisl rhoncus mattis rhoncus urna. Risus sed vulputate odio ut enim. Eu turpis egestas pretium aenean.', 'Rebecca Doe', 0),
(37, 13, '2019-07-04', '16:00:00', 'Mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien et.', 'John Doe', 0),
(38, 13, '2019-06-06', '17:00:00', 'Enim facilisis gravida neque convallis a. Sagittis nisl rhoncus mattis rhoncus urna. Risus sed vulputate odio ut enim. Eu turpis egestas pretium aenean.', 'Rebecca Doe', 0),
(39, 18, '2019-07-04', '16:00:00', 'Mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien et.', 'Jenny Watson', 0),
(40, 18, '2019-06-06', '17:00:00', 'Enim facilisis gravida neque convallis a. Sagittis nisl rhoncus mattis rhoncus urna. Risus sed vulputate odio ut enim. Eu turpis egestas pretium aenean.', 'Rebecca Doe', 0),
(41, 18, '2019-07-04', '16:00:00', 'Mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien et.', 'John Doe', 0),
(42, 18, '2019-06-06', '17:00:00', 'Enim facilisis gravida neque convallis a. Sagittis nisl rhoncus mattis rhoncus urna. Risus sed vulputate odio ut enim. Eu turpis egestas pretium aenean.', 'Rebecca Doe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_image`
--

CREATE TABLE `post_image` (
  `p_img_id` smallint(3) UNSIGNED NOT NULL,
  `p_img_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_thumb_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_img_alt` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_img_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_image`
--

INSERT INTO `post_image` (`p_img_id`, `p_img_url`, `p_thumb_url`, `p_img_alt`, `p_img_default`) VALUES
(1, 'img/blog/post-img/post-img-0.jpg', 'img/blog/post-thumbnail/thumb-post-img-0.jpg', 'bar with weights', 1),
(2, 'img/blog/post-img/post-img-1.jpg', 'img/blog/post-thumbnail/thumb-post-img-1.jpg', 'pilates class', 0),
(3, 'img/blog/post-img/post-img-2.jpg', 'img/blog/post-thumbnail/thumb-post-img-2.jpg', 'personal trainer', 0),
(4, 'img/blog/post-img/post-img-3.jpg', 'img/blog/post-thumbnail/thumb-post-img-3.jpg', 'gym', 0),
(5, 'img/blog/post-img/post-img-4.jpg', 'img/blog/post-thumbnail/thumb-post-img-4.jpg', 'woman on the beach', 0),
(6, 'img/blog/post-img/post-img-5.jpg', 'img/blog/post-thumbnail/thumb-post-img-5.jpg', 'kickboxing', 0),
(7, 'img/blog/post-img/post-img-6.jpg', 'img/blog/post-thumbnail/thumb-post-img-6.jpg', 'man on treadmill', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `pt_id` smallint(3) UNSIGNED NOT NULL,
  `p_id` smallint(3) UNSIGNED NOT NULL,
  `pt_text` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`pt_id`, `p_id`, `pt_text`) VALUES
(1, 1, 'gym'),
(2, 1, 'class'),
(3, 1, 'miscellaneous'),
(5, 2, 'trainer'),
(6, 2, 'people'),
(7, 2, 'news'),
(8, 3, 'crossfit'),
(9, 3, 'class'),
(10, 4, 'news'),
(11, 4, 'time change'),
(12, 4, 'class'),
(13, 5, 'yoga'),
(14, 5, 'time change'),
(15, 5, 'pilates'),
(16, 6, 'class'),
(17, 6, 'trainer'),
(18, 6, 'pilates'),
(19, 7, 'class'),
(20, 7, 'trainer'),
(21, 7, 'rope trainer'),
(22, 8, 'trainer'),
(23, 8, 'kickboxing'),
(24, 9, 'pilates'),
(25, 9, 'class'),
(26, 9, 'time change'),
(27, 10, 'miscellaneous'),
(28, 10, 'news'),
(29, 10, 'trainer'),
(30, 11, 'class'),
(31, 11, 'news'),
(32, 11, 'kickboxing'),
(36, 12, 'class'),
(37, 12, 'news'),
(38, 13, 'miscellaneous'),
(39, 13, 'news'),
(40, 14, 'kickboxing'),
(41, 14, 'class'),
(42, 14, 'important'),
(43, 15, 'class'),
(44, 15, 'important'),
(48, 17, 'rope training'),
(49, 17, 'trainer'),
(50, 17, 'important'),
(51, 18, 'gym'),
(52, 18, 'class'),
(53, 18, 'important'),
(54, 18, 'miscellaneous'),
(57, 16, 'trainer'),
(58, 16, 'gym'),
(59, 16, 'class');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sc_id` smallint(3) UNSIGNED NOT NULL,
  `cl_id` smallint(3) UNSIGNED DEFAULT NULL,
  `co_id` smallint(3) UNSIGNED DEFAULT NULL,
  `sc_no_people` smallint(3) UNSIGNED DEFAULT NULL,
  `sc_class_date` date DEFAULT NULL,
  `sc_class_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sc_id`, `cl_id`, `co_id`, `sc_no_people`, `sc_class_date`, `sc_class_time`) VALUES
(1, 6, 1, 12, '2019-08-13', '09:30:00'),
(2, 7, 3, 10, '2019-08-13', '11:15:00'),
(3, 5, 5, 15, '2019-08-13', '14:15:00'),
(4, 4, 4, 12, '2019-08-14', '11:15:00'),
(5, 4, 6, 8, '2019-08-15', '11:50:00'),
(6, 6, 5, 9, '2019-08-15', '15:15:00'),
(7, 2, 6, 10, '2019-08-16', '20:00:00'),
(8, 1, 6, 9, '2019-08-15', '17:30:00'),
(9, 8, 3, 4, '2021-08-13', '20:00:00'),
(10, 7, 2, 9, '2021-08-11', '13:00:00'),
(11, 7, 4, 9, '2019-08-16', '09:00:00'),
(12, 3, 5, 8, '2019-08-16', '15:00:00'),
(13, 2, 3, 9, '2021-08-10', '11:10:00'),
(14, 5, 2, 0, '2021-10-26', '11:00:00'),
(15, 3, 3, 9, '2020-10-13', '11:00:00'),
(16, 1, 4, 0, '2021-12-23', '09:00:00'),
(17, 5, 5, 9, '2019-08-16', '23:00:00'),
(18, 4, 4, 0, '2021-12-13', '18:00:00'),
(19, 8, 5, 9, '2020-09-13', '21:00:00'),
(20, 4, 1, 0, '2021-08-13', '11:15:00'),
(21, 8, 1, 8, '2020-10-13', '21:00:00'),
(22, 5, 3, 8, '2021-08-09', '11:00:00'),
(23, 5, 2, 0, '2019-08-11', '09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` smallint(3) UNSIGNED NOT NULL,
  `u_first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_address_1` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_address_2` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_postcode` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_city` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_salt` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_group_id` smallint(3) UNSIGNED DEFAULT NULL,
  `u_joined` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `u_first_name`, `u_last_name`, `u_address_1`, `u_address_2`, `u_postcode`, `u_city`, `u_username`, `u_email`, `u_password`, `u_salt`, `u_group_id`, `u_joined`) VALUES
(1, 'Radoslaw', 'Soltan', 'Some Street 1', 'Some Flat 1', 'SO11 111', 'Southampton', 'radzio123', 'rado@mail.com', '65652119d531be833942c39ef8efbf82d2e43361f87b14939e24ad6df2c76612', '8fa791f897fa4a212dd8b837613f7a36b7cca2c7fa47c2270adcc837f47c1dd3', 2, '2019-04-14 13:37:39'),
(2, 'John', 'Doe', 'Some Street 1', '', 'E1 123', 'London', 'johndoe123', 'jd@mail.com', 'af8d0be9f826ed54f691c422c21545eb3f319818dfe897eec1d7ab6d13e95367', '7946e89252bd159c73ec174b6928fe3f4a93ed01071477c9946d5dd273e34c4c', 1, '2019-08-11 21:01:34'),
(3, 'Mark', 'Doe', 'Some Street 11', 'Flat 22', 'E1 123', 'London', 'markdoe123', 'md@mail.com', 'd4077ab78b2dadf8e630bb5c1ffea2c551b23f26255f655fd109f5bd04ceb6d5', '6acd23ec36fd19e76240f2437a8115294ff4dfe11277987f3a284e363edbb588', 1, '2019-08-11 21:11:30'),
(4, 'Jenny', 'Watson', 'Some Street 99', 'Flat 1', 'E1 321', 'London', 'jenny123', 'jenny-w@mail.com', '7c153c5846f395fc9f8798bf361d47952f72f906cbde18d8f10c99974ba7c21e', 'e0debf3bde400f49efda2c8a2e0caa136e1228a9dc6905d647619cb17eb97911', 1, '2019-08-11 21:14:07'),
(5, 'Mark', 'Smith', 'Some Street 2', 'Flat 1', 'SO 123', 'Southampton', 'marksmith321', 'm-smith@gmail.com', 'bc1cdf9d9b1a6f128c57ad287d45f0a94476c1175c7d5911ea49e111fb6dcec5', '39c67c11a6f6243d15812a118f10d5208a2c6fe0690af316502c5639ecc2c7b0', 1, '2019-08-11 21:17:12'),
(6, 'Emily', 'Smith', 'Some Street 54', '', 'E1 321', 'London', 'emilys123', 'emilysmith@gmail.com', '79bcf7974ab59d903cb33bf78104db5fa5deea5ce3b50d8883b646effad260fc', '85da1b54e70f1a1e867e57ed139bdbc8905886fd3e8976a64797939df2dc3407', 1, '2019-08-11 21:21:57'),
(7, 'Ralf', 'Doe', 'Some Street 12', 'Flat 1', 'LP 132', 'Liverpool', 'ralf123doe', 'doe-ralf-123@gmail.com', 'ac596009a966c2f2b1d21c461094f0f114f79ab36d1b0121a954e5a875592996', 'd1e2b0d22b4e23d7c925eff6da4ae1e3801e882521fe07e041793a42734354ef', 1, '2019-08-11 21:24:13'),
(8, 'John', 'Peterson', 'Some Street 22', '', 'EN1 345', 'London', 'Petejohn123', 'peterson123@hotmail.com', '5e067a7822d557c18b30923db69d1e1f63fe475a007bc4d9b3fee9f5819dd731', '39abfcca99b84f55bb2e3c8035c8097636323804b19fbc6e2e0e9057140de343', 1, '2019-08-11 21:25:11'),
(9, 'Pete', 'Smith', 'Some Street 12', 'Floor 2', 'EN 872', 'London', 'smithp123', 'smith@gmail.com', '8d24dd0697aaabd31a07bbb85a3fa7ed6be86a2f2324717550f47007aefdf17a', '425e6330e7a00efb2b16e06fabca96cbf942daa3c2b3825f6d21ce0a68e515de', 1, '2019-08-11 21:26:51'),
(10, 'Kate', 'Norman', 'Some Street 1', 'Floor 1', 'E1 478', 'London', 'knorman123', 'knorman@mail.com', '066eea06108fe6c17d2586eb15601de6f53d5cc49970bb87ac9ca5d058cc291d', 'ea16cfeaab924f55d301a333485451310f57b8091c9f62c92a7a44ac7198dd27', 1, '2019-08-11 21:31:40'),
(11, 'Lucy', 'Smith', 'Some Street 33', 'Flat 1', 'EX 123', 'London', 'smithl22', 'smith-l@gmail.com', '627d1a407deceb6b5b4c61beb159306eb86211cc70cc795025dcc28c6e259a81', '7e9875cd9c2bb20635eecfb9970c5606bb5d5d48fef447dfa5af788be81b7924', 1, '2019-08-11 21:33:05'),
(12, 'Ben', 'Hughes', 'Some Street 33', 'Floor 2', 'E1 232', 'London', 'b-hughes123', 'b-hughes@mail.com', '69f76133e578162ae4e9df2bf3b3cd166efc59bca351812634c0126ece20cfe6', 'd8e05f4b20bb6add98f90d2d58533f507fbbb14cf989db6bc964fa0f2223ddf2', 1, '2019-08-11 21:46:13'),
(13, 'Neil', 'Smith', 'Some Street 22', '', 'SO12 222', 'Southampton', 'smithn222', 'smith.n@mail.com', '77f3409bd7f1542e41741e74b9d9e99c951759ade7e5fe362eff65dab113c824', 'c9fc0b99e3499c93bb9a4359ae914195c0844631e27a199b5bc3a439847ac97c', 1, '2019-08-11 22:19:01'),
(14, 'Paul', 'Stone', 'Some Street 11', 'Flat 99', 'LP1 123', 'Liverpool', 'stone_123', 'stone.paul@hotmail.com', '29c58bf3e4370ec50a2b3eb1cd15c77365feb3ada79efbb5bcdef2d721138a68', '476fd7943cfb52a1db334a75f607ad91852874d6ff4795928bec5f46015d045d', 1, '2019-08-11 22:34:30'),
(15, 'Nick', 'Kowalski', 'Some Street 11', 'Suite 11', 'LP22 123', 'Liverpool', 'kowalski1244', 'kowalski@wp.pl', '3d9a0a6c5789d0c07a6f222ec68c70b599dae379fdcf10199dcb187fbc0348cb', '69dacec403193aa15cb384c248d733a59db99e9fb47610a875e2dde5498a20b7', 1, '2019-08-11 22:35:15'),
(16, 'Karl', 'Stone', 'Some Street 11', '', 'LP11 233', 'Liverpool', 'stonek11', 'stone11@gmail.com', 'd5292b9593da9705aadfebbe95cbba977e244400814b40a5bed9e4e7570c7475', 'd9ed1eb9e715c806176c972752606a961e302ac75574f5322607aebb15fab366', 1, '2019-08-11 22:36:58'),
(17, 'Brett', 'Ash', 'Some Street 2', '', 'LP1 446', 'Liverpool', 'brash123', 'ash.brett@mail.com', 'c1deea7ab0af632a9d729025902d79850f7f3fe63f1cfcab062a6af6a16ea975', '3f2dad034e5c96642668f3e7054a1b938e12d9486e8fde79bcb24385ff64bed8', 1, '2019-08-11 22:39:46'),
(18, 'Ashley', 'Jane', 'Some Street 1', '', 'SO11 222', 'Southampton', 'janesh123', 'ashley@gmail.com', '977a30e64be5de0d1d9f367dfaaa34f8a7d764727dfb514d3682a0fe410e15b1', 'b771e70948d71e8b800004915ba80917ccb237230a26da38e61d425691c52b98', 1, '2019-08-11 22:40:57'),
(19, 'Rebecca', 'Doe', 'Some Street 22', 'Floor 2', 'E1 322', 'London', 'becca123', 'bex-d@mail.com', '3df2680fc1f00d03c8f6181a5737cc01e2b9244f47890d5f3cedfbdfcc7cbb55', 'dbb2a8395a285ac5d66c6fb2da0e13526cfc7dfad9c9c341223f863f664dd07b', 1, '2019-08-11 23:36:32'),
(20, 'Claire', 'Smith', 'Some Street 34', 'Flat 3', 'LP 321', 'Liverpool', 'csmith223', 'claire@gmail.com', '9427f3e84b328ace8247251d4002520276be1403b219e212b8c800cb31fe00b0', '82f2cbb64cd07a4ed843ddbd6f90cddc171f2fe410b885e00e8d62fd1630a0ef', 1, '2019-08-11 23:37:20'),
(21, 'Claire', 'Doe', 'Some Street 344', '', 'EN 122', 'London', 'doeclaire22', 'doeclaire@mail.com', '10b37b42172b24e3dfc0756647b6e28eea6ec3f3790dec210a475908890f8ef8', 'ed70833d1f6dc92228bd23954eee8e6d5788de7ac4e8c525bf6c07e360619148', 1, '2019-08-11 23:39:23'),
(22, 'Sophie', 'Webb', 'Some Street 2', 'Floor 3', 'SO11 212', 'Southampton', 'websoph123', 'sophw@mail.com', 'cd7972548b4610c523c73d021aa0b87feedd3a329a98469ec77af8b9e26d7f9c', 'e0a3a7e0d213ea80a79a0efad4516b8c606da33741fd6901aa698a515d213d40', 1, '2019-08-11 23:40:34'),
(23, 'Katie', 'Turner', 'Some Street 11', '', 'E1 333', 'London', 'turner22', 'turner@mail.com', '7cc7c77cac454222c7aadf67370efbe815e173fde2ccfeacf22b05ba60e431ba', '2db0786552f20e6a8664b6d59439c68134b29fe305219e6d84be9e1407bad959', 1, '2019-08-12 22:15:51'),
(24, 'John', 'Doe', 'Some Street 32', 'Flat 1', 'SO11 233', 'Southampton', 'doe.j332', 'doe-j@mail.com', 'bb9328ab45e4601608aff728ff9f1da90ac9e33de1288d74723273d6271c7ceb', 'd7f27d5c67c9e6fd470a14490447576052743b5a5c5ee3bad4be4a4a9b1feac4', 1, '2019-08-12 22:19:13'),
(25, 'John', 'Doe', 'Some Street 3', 'Flat 2', 'LP 322', 'Liverpool', 'doejohnny223', 'doej22@mail.com', '13257b19eacd8ce5e150549641fef5f4f74c424e3a000d6381521e807f713331', 'f9556cad81fe21768461257aaa5144fea304714d329ad66b03cf77fd80981fae', 1, '2019-08-12 22:20:03'),
(26, 'Steve', 'Murray', 'Some Street 3', '', 'EN 232', 'London', 'murrayst23', 'murray@mail.com', '01aa2c8bb026b667f2a7bf867b0f13bc5b8540fca731bcba995a1112bbf04b1f', 'd5f1b67e7d29877c8956a4c8601a517cd9d73866ea871890cf6a5cc4f6bafad0', 1, '2019-08-12 22:21:01'),
(27, 'Mark', 'Brown', 'Some Street 33', '', 'E2 323', 'London', 'brown23mark', 'mark-brown@mail.com', '2f8f7d1bb22f99967d3bb03cf6de1f70c25e5c2d7ee21d28525b6a88c4db9ee9', '0e93237e46b7d41122b53c220a43c7cda2365626720baa54a3c16c15c745e383', 1, '2019-08-12 22:27:19'),
(28, 'Jenny', 'James', 'Some Street 33', '', 'E2 322', 'London', 'jjames232', 'james_jenny@gmail.com', 'e45436be879b9335d93d559d8a626f514db0c2c3eb3a343fcbebb3ddceffb567', '0a3771d9119713c483ca8332d04ee34868a634d08ef8b325dcf2ab5f7381a465', 1, '2019-08-12 22:38:20'),
(29, 'Nigel', 'Smith', 'Some Street 2', 'Flat 2', 'E3 232', 'London', 'nigelsmith232', 'smith.nigel@mail.com', '15d4769680c038c209040285d015509b8dd2a5ff92553770dc66d8b907c84c20', '465249e962d8537eb422b99056e33d8d60926f98abc0c7442415b01fdd0fa656', 1, '2019-08-12 22:44:52'),
(30, 'John', 'Doe', 'Some Street 2', '', 'E2 232', 'London', 'doejohn232', 'doe_john_232@gmail.com', '4f4b419ae23eb4cbc0d55fd71486410894520b4a7ce17532bb2ea332708b32b3', 'ac006fe459bd85d0a06f7f67ad280f041987d40c5a4e8984c99c975a64d57ad2', 1, '2019-08-12 22:49:10'),
(31, 'John', 'May', 'Some Street 23', 'Flat 23', 'SO12 322', 'Southampton', 'mayjohn2', 'may@mail.com', '452b45e1d4c8ead08e4021843004f9b6247b3d4459de643b43611def1cc1f2b3', 'd7046a4dc1c6ce63064cb7e7a3fa0f6975a046996f07b55fe9c7e005dbfd2ad4', 1, '2019-08-12 22:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_class`
--

CREATE TABLE `user_class` (
  `uc_id` smallint(3) UNSIGNED NOT NULL,
  `u_id` smallint(3) UNSIGNED DEFAULT NULL,
  `sc_id` smallint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_class`
--

INSERT INTO `user_class` (`uc_id`, `u_id`, `sc_id`) VALUES
(1, 1, 1),
(2, 1, 8),
(3, 2, 1),
(4, 3, 3),
(5, 4, 3),
(6, 5, 3),
(7, 8, 3),
(8, 11, 3),
(9, 12, 3),
(10, 15, 3),
(11, 1, 3),
(12, 6, 3),
(13, 16, 3),
(14, 21, 3),
(15, 4, 1),
(16, 3, 1),
(18, 7, 1),
(19, 8, 1),
(20, 9, 1),
(21, 11, 1),
(22, 14, 1),
(23, 19, 1),
(29, 1, 2),
(30, 2, 2),
(31, 3, 2),
(32, 4, 2),
(33, 5, 2),
(34, 11, 2),
(35, 12, 2),
(36, 14, 2),
(37, 15, 2),
(38, 16, 1),
(39, 17, 2),
(40, 7, 3),
(41, 14, 3),
(42, 31, 3),
(43, 19, 3),
(44, 31, 1),
(45, 1, 4),
(46, 3, 4),
(47, 2, 4),
(48, 31, 4),
(49, 21, 4),
(50, 19, 4),
(51, 16, 4),
(52, 12, 4),
(53, 9, 4),
(54, 5, 4),
(55, 4, 4),
(56, 17, 4),
(57, 5, 5),
(58, 7, 5),
(59, 8, 5),
(60, 9, 5),
(61, 21, 5),
(62, 31, 5),
(63, 19, 5),
(64, 17, 5),
(65, 1, 6),
(66, 2, 6),
(67, 3, 6),
(68, 6, 6),
(69, 12, 6),
(70, 15, 6),
(71, 19, 6),
(72, 31, 6),
(73, 21, 6),
(74, 4, 8),
(75, 3, 8),
(76, 11, 8),
(77, 12, 8),
(78, 14, 8),
(79, 16, 8),
(80, 17, 8),
(81, 19, 8),
(82, 1, 7),
(83, 5, 7),
(84, 31, 7),
(85, 19, 7),
(86, 21, 7),
(87, 17, 7),
(88, 14, 7),
(89, 12, 7),
(90, 16, 7),
(91, 4, 7),
(92, 3, 17),
(93, 4, 17),
(94, 31, 17),
(95, 19, 17),
(96, 17, 17),
(97, 16, 17),
(98, 15, 17),
(99, 14, 17),
(100, 5, 17),
(101, 1, 12),
(102, 4, 12),
(103, 6, 12),
(104, 31, 12),
(105, 16, 12),
(106, 15, 12),
(107, 14, 12),
(108, 11, 12),
(109, 3, 11),
(110, 16, 11),
(111, 31, 11),
(112, 21, 11),
(113, 19, 11),
(114, 17, 11),
(115, 12, 11),
(116, 11, 11),
(117, 4, 11),
(118, 1, 21),
(119, 2, 21),
(120, 4, 21),
(121, 31, 21),
(122, 21, 21),
(123, 9, 21),
(124, 6, 21),
(125, 5, 21),
(126, 1, 19),
(127, 2, 19),
(128, 3, 19),
(129, 4, 19),
(130, 5, 19),
(131, 7, 19),
(132, 8, 19),
(133, 31, 19),
(134, 19, 19),
(135, 1, 15),
(136, 2, 15),
(137, 3, 15),
(138, 4, 15),
(139, 19, 15),
(140, 31, 15),
(141, 21, 15),
(142, 6, 15),
(143, 7, 15),
(144, 1, 22),
(145, 4, 22),
(146, 5, 22),
(147, 7, 22),
(148, 21, 22),
(149, 31, 22),
(150, 19, 22),
(151, 6, 22),
(152, 1, 13),
(153, 3, 13),
(154, 2, 13),
(155, 24, 13),
(156, 27, 13),
(157, 31, 13),
(158, 19, 13),
(159, 6, 13),
(160, 7, 13),
(161, 1, 10),
(162, 24, 10),
(163, 27, 10),
(164, 31, 10),
(165, 8, 10),
(166, 9, 10),
(167, 4, 10),
(168, 3, 10),
(169, 19, 10),
(170, 1, 9),
(171, 31, 9),
(172, 27, 9),
(173, 6, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `u_group_id` smallint(3) UNSIGNED NOT NULL,
  `u_group_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_permissions` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`u_group_id`, `u_group_name`, `u_permissions`) VALUES
(1, 'standard user', NULL),
(2, 'admin', '{\"admin\": 1}');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `us_id` smallint(3) UNSIGNED NOT NULL,
  `user_id` smallint(3) UNSIGNED DEFAULT NULL,
  `us_hash` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`cl_id`),
  ADD KEY `cl_img_id` (`cl_img_id`);

--
-- Indexes for table `class_image`
--
ALTER TABLE `class_image`
  ADD PRIMARY KEY (`cl_img_id`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`co_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`me_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `opinion`
--
ALTER TABLE `opinion`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `cl_id` (`cl_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`pg_ID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_img_id` (`p_img_id`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`pc_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `post_image`
--
ALTER TABLE `post_image`
  ADD PRIMARY KEY (`p_img_id`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`pt_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sc_id`),
  ADD KEY `cl_id` (`cl_id`),
  ADD KEY `co_id` (`co_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `u_group_id` (`u_group_id`);

--
-- Indexes for table `user_class`
--
ALTER TABLE `user_class`
  ADD PRIMARY KEY (`uc_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `sc_id` (`sc_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`u_group_id`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`us_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `cl_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_image`
--
ALTER TABLE `class_image`
  MODIFY `cl_img_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `co_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `me_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `opinion`
--
ALTER TABLE `opinion`
  MODIFY `op_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `pg_ID` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `p_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `pc_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `post_image`
--
ALTER TABLE `post_image`
  MODIFY `p_img_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `pt_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sc_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_class`
--
ALTER TABLE `user_class`
  MODIFY `uc_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `u_group_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `us_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`cl_img_id`) REFERENCES `class_image` (`cl_img_id`) ON UPDATE CASCADE;

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON UPDATE CASCADE;

--
-- Constraints for table `opinion`
--
ALTER TABLE `opinion`
  ADD CONSTRAINT `opinion_ibfk_1` FOREIGN KEY (`cl_id`) REFERENCES `class` (`cl_id`) ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`p_img_id`) REFERENCES `post_image` (`p_img_id`) ON UPDATE CASCADE;

--
-- Constraints for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `post_comment_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`) ON UPDATE CASCADE;

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`) ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`cl_id`) REFERENCES `class` (`cl_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`co_id`) REFERENCES `coach` (`co_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`u_group_id`) REFERENCES `user_group` (`u_group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_class`
--
ALTER TABLE `user_class`
  ADD CONSTRAINT `user_class_ibfk_1` FOREIGN KEY (`sc_id`) REFERENCES `schedule` (`sc_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_class_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
