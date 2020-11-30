-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.4.11-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица yii-chat-bd.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-messages-author_id` (`author_id`),
  CONSTRAINT `fk-messages-author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii-chat-bd.messages: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
REPLACE INTO `messages` (`id`, `message`, `author_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(80, 'Привет', 1, NULL, 1606726739, 1606726739),
	(81, 'Как дела, есть кто то?', 1, NULL, 1606727221, 1606727221),
	(82, 'Все дурики!', 1, NULL, 1606727239, 1606748305),
	(83, 'Привет я тоже тут!', 3, NULL, 1606728994, 1606728994),
	(84, 'Ты тоже дурик!', 1, 1606749600, 1606729494, 1606749600),
	(85, 'Всем добрый вечер!', 2, NULL, 1606736507, 1606755872),
	(86, 'Балбесы!', 2, 1606749576, 1606736519, 1606749576),
	(87, 'Ненужное Сообщение', 1, 1606749565, 1606746889, 1606749565),
	(88, 'Оскорбительное сообщение', 1, 1606749564, 1606746899, 1606749564),
	(89, 'требующее удаления сообщение', 1, 1606749563, 1606746910, 1606749563),
	(90, 'Ругательство в эфире', 1, 1606749563, 1606746928, 1606749563),
	(91, 'Спам, мат и блудня', 1, 1606749561, 1606746938, 1606749561);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Дамп структуры для таблица yii-chat-bd.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii-chat-bd.user: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'XskhJFTW3-Eku90TqXp0NWLk1mmOySpr', '$2y$13$aufou6DCQzB2B5I7Xe2HBuLkwGSlmh.N5i8zbhHnQGM3VeRmKm2f6', NULL, 'admin@yii-cat.phpdev.xyz', 'admin', 1606572907, 1606754221),
	(2, 'user', 'LCeWxSFT8HeY1fxcvXDN-3BrrCAOqMxP', '$2y$13$T75XpGVBM5A6RBHKfHFz8ewNwxK2O7XJl7f1KP3vGGol3HjGoPGHy', NULL, 'user@fg.gg', NULL, 1606720492, 1606755686),
	(3, 'user2', 'o9RV9CawdyDrR2d6W5yNEbKtRVOo-YZZ', '$2y$13$HZ.JcTKnShXKVnFOkrsYMek5hchOE3KPI9D4an809ScUm/P5I1KbK', NULL, 'user2@fg.gg', NULL, 1606720510, 1606720510);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
