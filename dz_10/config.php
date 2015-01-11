<?php

$project_root=__DIR__;

$smarty_dir=$project_root.'/smarty/';

// put full path to Smarty.class.php
require($smarty_dir.'/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';

## Подключение к БД.
require_once $project_root."/dbsimple/config.php";
require_once "DbSimple/Generic.php";

//Подключаем библиотеку
require_once ($project_root.'/FirePHP/FirePHP.class.php');
//Инициализируем класс FirePHP
$firePHP = FirePHP::getInstance(true);
//Устанавливаем активность. Если выключить (false), то отладочные сообщения
//не будут отображаться в FireBug
$firePHP ->setEnabled(true);


// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
    exit();
}

// Код логгера
function myLogger($db, $sql, $caller) {
    global $firePHP;
    if (isset($caller['file'])){
    $firePHP -> group("at ".@$caller['file'].' line '.@$caller['line']);
    }
    $firePHP -> log ($sql);
    if (isset($caller['file'])){
    $firePHP -> groupEnd();
    }
}

// Код обработчика ошибок для инсталлера.
function installErrorHandler()
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    $_SESSION['success']= FALSE;
    echo "<p>При установке дампа базы данных произошла ошибка.</br>
            Проверьте данные соединения с БД и попробуйте еще раз.</br>
            <a href='install.php'>Вернуться назад</a>"; 
    exit();
}