<?php
header("Content-type: text/html; Charset=utf-8");

require_once ('config.php');
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
            newAd($db, $post_ad);
        break;
	case 'Сохранить изменения' :
            $id = (int)$_GET['edit']; // номер редактируемого объявления
            updateAd($db, $post_ad, $id);
        break;
    }
header("Location: index.php");
exit;
}

// Удаление объявления
if (isset($_GET['delete'])) {
	$del_id=(int)$_GET['delete'];
    delAd($db, $del_id);
    header("Location: index.php");
exit;
}		

// Вывод объявления
if (isset($_GET['show'])){
    $edit_id=(int)$_GET['show'];
    $editAd = showAd($db, $edit_id);
    $smarty->assign('editAd', $editAd);
}

$smarty->assign('location_sel', 641780); // Выбранный город по умолчанию
$smarty->assign('location_id', location_id($db));
$smarty->assign('category_id', category_id($db));
$smarty->assign('label_id', label_id($db));
$smarty->assign('radio_id', array ( 0 => 'Частное лицо', 1 => 'Компания'));

// Показ списка объявлений
$smarty->assign('showAd', showAll($db));

$smarty->display('index.tpl');
