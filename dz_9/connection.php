<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'test');
define('DB_PASS', '123');
define('DB_NAME', 'test');

mysql_connect(DB_HOST, DB_USER, DB_PASS) or die ("Нет подключения к серверу");
mysql_select_db(DB_NAME) or die ("Невозможно выбрать БД");
mysql_query("SET NAMES utf8") or die ("Не установлена кодировка");
//mysql_query("SET time_zone = '+03:00'") or die ("Не установлена кодировка");
