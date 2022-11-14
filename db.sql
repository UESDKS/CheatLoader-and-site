-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.6.8-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.0.0.6504
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица hui.cheats
CREATE TABLE IF NOT EXISTS `cheats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Undetected',
  `filename` varchar(32) NOT NULL,
  `process` varchar(256) NOT NULL,
  `external` tinyint(1) DEFAULT NULL,
  `injection` varchar(32) NOT NULL,
  `creator` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.cheats: ~0 rows (приблизительно)

-- Дамп структуры для таблица hui.hwids
CREATE TABLE IF NOT EXISTS `hwids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hwid` varchar(32) NOT NULL,
  `reason` varchar(4096) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.hwids: ~0 rows (приблизительно)

-- Дамп структуры для таблица hui.keys
CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `hwid` varchar(32) DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'waiting',
  `subscribe` bigint(20) NOT NULL,
  `subscribeend` bigint(20) DEFAULT NULL,
  `cheat` int(11) NOT NULL,
  `firstip` varchar(32) DEFAULT NULL,
  `lastip` varchar(32) DEFAULT NULL,
  `creator` varchar(32) NOT NULL,
  `banreason` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.keys: ~0 rows (приблизительно)

-- Дамп структуры для таблица hui.loaders
CREATE TABLE IF NOT EXISTS `loaders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `version` varchar(32) NOT NULL DEFAULT '1',
  `file` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.loaders: ~2 rows (приблизительно)
INSERT INTO `loaders` (`id`, `name`, `version`, `file`) VALUES
	(1, 'main', '13', 'launcher.exe'),
	(5, 'LoaderName', '3', 'Loader.exe');

-- Дамп структуры для таблица hui.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hwid` varchar(64) NOT NULL,
  `key` varchar(32) DEFAULT NULL,
  `message` varchar(256) NOT NULL,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.logs: ~11 rows (приблизительно)
INSERT INTO `logs` (`id`, `hwid`, `key`, `message`, `ip`) VALUES
	(3, 'none', '0123456789', 'Zalupa Konya', '127.0.0.1'),
	(4, 'Hello from loader!', 'none', '0123456789', '127.0.0.1'),
	(5, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(6, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(7, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(8, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(9, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(10, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(11, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(12, '0123456789', 'none', 'Hello from loader!', '127.0.0.1'),
	(13, '0123456789', 'none', 'Hello from loader!', '127.0.0.1');

-- Дамп структуры для таблица hui.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` varchar(32) NOT NULL DEFAULT 'seller',
  `owner` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы hui.users: ~1 rows (приблизительно)
INSERT INTO `users` (`id`, `username`, `password`, `role`, `owner`) VALUES
	(1, 'Admin', 'admin', 'admin', 'God');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
