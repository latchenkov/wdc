<?php
header("Content-type: text/html; Charset=utf-8");

require_once ('config.php');
require_once ($project_root.'/lib/connection.php'); // Подключаем БД

require ($project_root.'/lib/ads_class.php'); // Подключаем файл с функциями

// Создаем либо редактируем объявление
if (isset($_POST['seller_name']) && isset($_POST['description'])) { // если была нажата кнопка
    $post_ad = Ads::trimPOST($_POST);
        $ad=new Ads($post_ad);
        $ad->saveAd();
header("Location: index.php");
exit;
}

// Удаление объявления
if (isset($_GET['delete'])) {
    $del_id=(int)$_GET['delete'];
        Ads::delAdFromDb($del_id);
}

$instance = AdsStore::getInstance();
$instance->getAllAdsFromDb();

// Показ конкретного объявления
if (isset($_GET['show'])){
    $edit_id=(int)$_GET['show'];
        $instance->prepareForOutSingleAd($edit_id);
}

$instance -> prepareForOutDataForm() -> prepareForOutTableRow() -> display();