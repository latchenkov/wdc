<?php
header("Content-type: text/html; Charset=utf-8");
		
$project_root=$_SERVER['DOCUMENT_ROOT'];
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


session_start();
require ($project_root.'/functions.php'); // Подключаем файл с функциями

define('ADS_DB', 'ads_db.txt');

// Извлекаем файл в рабочий массив
$ads_db = file_get_serialize_contents (ADS_DB);


// Переносим данные из $_POST в файл
if (isset($_POST['main_form_submit'])) { // если была нажата кнопка
    $submit=$_POST['main_form_submit'];
	unset ($_POST['main_form_submit']);
    switch ($submit) { // выбор режима добавления или редактирования объявления
	case 'Подать объявление' :
            $id = (!isset($ads_db)) ? 0 : ($ads_db['max_ad']+1);// уникальный номер объявления в базе
            $ads_db['max_ad']=$id;
            $ads_db['db'][$id]['date'] = date('d.m.Y H:i:s'); // время подачи объявления
        break;
	case 'Сохранить изменения' :
            $id = $_SESSION['edit_id']; // номер редактируемого объявления
            unset($_SESSION['edit_id'], $ads_db['db'][$id]['allow_mails']);
            session_destroy();
	break;
    }
    foreach ($_POST as $key => $value) {
        $ads_db['db'][$id][$key] = trim(htmlspecialchars($value));
    }
file_put_serialize_contents(ADS_DB, $ads_db); // запись массива в файл
header("Location: dz_8.php");
exit;
}


// Удаление объявления
if (isset($_GET['delete'])) {
	$del_id=$_GET['delete'];
    delete_item($del_id, $ads_db, ADS_DB);
    header("Location: dz_8.php");
exit;
}		

// Вывод объявления
if (isset($_GET['show'])){
    $edit_id=$_GET['show'];
    $_SESSION['edit_id']=$edit_id;
    $smarty->assign('editAd', $ads_db['db'][$edit_id]);
}

$smarty->assign('location_sel', 641780); // Выбранный город по умолчанию
$smarty->assign('location_id', $location_id);
$smarty->assign('category_id', $category_id);
$smarty->assign('label_id', $label_id);
$smarty->assign('radio_id', $radio_id);

if (isset ($ads_db)) {
    $smarty->assign('showAd', $ads_db['db']);
}

$smarty->display('index.tpl');
