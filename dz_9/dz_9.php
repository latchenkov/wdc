<?php
error_reporting (E_ALL & ~E_DEPRECATED);
header("Content-type: text/html; Charset=utf-8");


$project_root=$_SERVER['DOCUMENT_ROOT'];
$smarty_dir=$project_root.'/dz_9/smarty/';

// put full path to Smarty.class.php
require($smarty_dir.'/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';

require_once ('connection.php'); // Подключаем БД

require ('functions.php'); // Подключаем файл с функциями




// Переносим данные из $_POST в БД
if (isset($_POST['main_form_submit'])) { // если была нажата кнопка
    $submit=$_POST['main_form_submit'];
	unset ($_POST['main_form_submit']);
            $post_ad = array();
            $int = array('price', 'private', 'allow_mails', 'location_id', 'category_id');
            if (!isset($_POST['allow_mails'])){$_POST['allow_mails']=0;}
        foreach ($_POST as $key => $value) {
            if (in_array($key, $int)){
                $post_ad[$key] = trim((int)$value);
            }
            else{
                $post_ad[$key] = trim(htmlspecialchars($value));    
            }
        }
    switch ($submit) { // выбор режима добавления или редактирования объявления
	case 'Подать объявление' :
            newAd($post_ad);
        break;
	case 'Сохранить изменения' :
            $id = (int)$_GET['edit']; // номер редактируемого объявления
            updateAd($post_ad, $id);
        break;
    }
header("Location: dz_9.php");
exit;
}

// Удаление объявления
if (isset($_GET['delete'])) {
	$del_id=(int)$_GET['delete'];
    delAd($del_id);
    header("Location: dz_9.php");
exit;
}		

// Вывод объявления
if (isset($_GET['show'])){
    $edit_id=(int)$_GET['show'];
    $editAd = showAd($edit_id);
    $smarty->assign('editAd', $editAd);
}

$smarty->assign('location_sel', 641780); // Выбранный город по умолчанию
$smarty->assign('location_id', location_id());
$smarty->assign('category_id', category_id());
$smarty->assign('label_id', label_id());
$smarty->assign('radio_id', array ( 0 => 'Частное лицо', 1 => 'Компания'));

// Показ списка объявлений
$ads_db = showAll();
//date_default_timezone_set('Europe/Moscow');
if (isset ($ads_db)) {
    $smarty->assign('showAd', $ads_db);
}

$smarty->display('index.tpl');
