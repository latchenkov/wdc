<?php
header("Content-type: text/html; Charset=utf-8");

require_once ('config.php');
require_once ($project_root.'/lib/connection.php'); // Подключаем БД

require ($project_root.'/lib/ads_class.php'); // Подключаем файл с функциями

// Создаем либо редактируем объявление
if (isset($_POST['main_form_submit'])) { // если была нажата кнопка
    $submit=$_POST['main_form_submit'];
	unset ($_POST['main_form_submit']);
        
    $post_ad = ServiceFunction::trimPOST($_POST);
    
        switch ($submit) { // выбор режима добавления или редактирования объявления
            case 'Подать объявление' :
                Ad::newAd($db, $post_ad);
            break;
            case 'Сохранить изменения' :
                $id = (int)$_GET['edit']; // номер редактируемого объявления
                Ad::updateAd($db, $post_ad, $id);
            break;
        }
header("Location: index.php");
exit;
}

// Удаление объявления
if (isset($_GET['delete'])) {
	$del_id=(int)$_GET['delete'];
    Ad::delAd($db, $del_id);
    header("Location: index.php");
exit;
}		

// Показ конкретного объявления
if (isset($_GET['show'])){
    $edit_id=(int)$_GET['show'];
    $editAd = Ad::showAd($db, $edit_id);
        $smarty->assign('id', $edit_id);
        $smarty->assign('title', $editAd->getTitle());
        $smarty->assign('price', $editAd->getPrice());
        $smarty->assign('seller_name', $editAd->getSeller_name());
        $smarty->assign('description', $editAd->getDescription());
        $smarty->assign('email', $editAd->getEmail());
        $smarty->assign('phone', $editAd->getPhone());
        $smarty->assign('private', $editAd->getPrivate());
        $smarty->assign('allow_mails', $editAd->getAllow_mails());
        $smarty->assign('location_id', $editAd->getLocation_id());
        $smarty->assign('category_id', $editAd->getCategory_id());
}

$smarty->assign('location_sel', 641780); // Выбранный город по умолчанию
$smarty->assign('location', ServiceFunction::location_id($db));
$smarty->assign('category', ServiceFunction::category_id($db));
$smarty->assign('label', ServiceFunction::label_id($db));
$smarty->assign('radio_id', array ( 0 => 'Частное лицо', 1 => 'Компания'));

// Показ списка объявлений
$smarty->assign('showAd', Ads::showAll($db));

$smarty->display('index.tpl');
