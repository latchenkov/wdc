<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'test');
define('DB_PASS', '123');
define('DB_NAME', 'test');

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ("Нет подключения к серверу");
mysqli_query($link, "SET NAMES utf8") or die ("Не установлена кодировка");

