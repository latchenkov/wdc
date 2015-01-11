<?php
if (!file_exists('setting.php')){
    connectError();
}
require_once ('setting.php');

if (defined('DB_USER') && defined('DB_PASS') && defined('DB_HOST') && defined('DB_NAME')){
    // Подключаемся к БД.
    if (!isset($db)){
    $db = DbSimple_Generic::connect('mysqli://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME);
    $db->query("SET NAMES utf8");
    }
    // Устанавливаем обработчик ошибок.
    $db->setErrorHandler('databaseErrorHandler');
    $db->setLogger('myLogger');
}
else{
    connectError();
}

function connectError(){
    header("Refresh:15; url=install.php");
    exit("Параметры подключения к БД не заданы. Через 15 сек. Вы будете перенаправлены на страницу INSTALL.</br>
         Если автоматического перенаправления не происходит, нажмите <a href='install.php'>здесь</a>.");
}