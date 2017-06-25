--
-- База данных: `socialdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `SOCIAL_alias`
--

CREATE TABLE IF NOT EXISTS `SOCIAL_alias` (
  `alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` tinyint(4) NOT NULL,
  `id` bigint(20) NOT NULL,
  PRIMARY KEY (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `SOCIAL_user`
--

CREATE TABLE IF NOT EXISTS `SOCIAL_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `pass` varchar(30) COLLATE utf8_bin NOT NULL,
  `email` varchar(30) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Структура таблицы `SOCIAL_city`
--

CREATE TABLE IF NOT EXISTS `SOCIAL_city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Структура таблицы `SOCIAL_friends`
--

CREATE TABLE IF NOT EXISTS `SOCIAL_friends` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `my_id` bigint(20) NOT NULL,
  `my_accept` tinyint(4) NOT NULL DEFAULT '1',
  `friend_id` bigint(20) NOT NULL,
  `friend_accept` tinyint(4) NOT NULL DEFAULT '0',
  `mycomments` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `SOCIAL_messages`
--

CREATE TABLE IF NOT EXISTS `SOCIAL_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_id` bigint(20) NOT NULL,
  `from_delete` tinyint(4) NOT NULL,
  `towhom_id` bigint(20) NOT NULL,
  `towhom_open` tinyint(4) NOT NULL,
  `towhom_delete` tinyint(4) NOT NULL,
  `text_message` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


