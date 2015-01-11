<?php
header("Content-type: text/html; Charset=utf-8");
session_start();
require_once ('config.php');

// Расположение файла дампа test.sql
$dump_file=$project_root."/db_backups/test.sql"; 

if (isset($_POST['submit'])) { // если была нажата кнопка
    $db_user=trim($_POST['db_user']);
    $db_password=trim($_POST['db_password']);
    $db_host=trim($_POST['db_host']);
    $db_name=trim($_POST['db_name']);

// Подключаемся к БД.
$db = DbSimple_Generic::connect("mysqli://{$db_user}:{$db_password}@{$db_host}/{$db_name}");
$db->query("SET NAMES utf8");

// Устанавливаем обработчик ошибок.
$db->setErrorHandler('installErrorHandler');
$db->setLogger('myLogger');


// Удаление всех таблиц из БД
$res=$db->selectCol("SHOW TABLES FROM ?#", $db_name);
if (!empty($res)){
    $db->query("SET foreign_key_checks = 0");
    $db->query("DROP TABLE ?# ", array_values($res));
}

// Парсим файл дампа и удаляем комментарии и пустые строки.
if (file_exists($dump_file)){
    $file=file($dump_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $c = count($file);
        for( $i = 0; $i < $c; $i++){
            if(substr(trim($file[$i]),0,2) == '--'){
            unset($file[$i]);
            }
        }
    $query = explode(';', implode ($file));
}
// Выполняем запросы из дампа БД
foreach ($query as $v){
    if (!empty($v)){
        $query=$db->query("{$v}");
    }
}

$string =
    "<?php \r\n"
        . "define('DB_USER',"."'".$db_user."'"."); \r\n"
        . "define('DB_PASS',"."'".$db_password."'"."); \r\n"
        . "define('DB_HOST',"."'".$db_host."'"."); \r\n"
        . "define('DB_NAME',"."'".$db_name."'"."); \r\n";
if(!file_put_contents('setting.php', $string)) { installErrorHandler(); }
$_SESSION['success']= TRUE;

header("Location: install.php");
exit;
}
if (isset($_SESSION['success'])){
$smarty->assign('success', $_SESSION['success']);
}
session_destroy();
$smarty->display('install.tpl');