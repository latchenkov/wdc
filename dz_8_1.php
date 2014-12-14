<?php
header("Content-type: text/html; Charset=utf-8");
$location_id = array(641780 => 'Новосибирск', 641490 => 'Барабинск', 641510=>'Бердск', 641600=>'Искитим', 641630=>'Колывань', 641680=>'Краснообск', 641710=>'Куйбышев', 641760=>'Мошково', 641790=>'Обь', 641800=>'Ордынское', 641970=>'Черепаново');
$label_id = array( 'Транспорт', 'Недвижимость', 'Работа', 'Услуги', 'Личные вещи', 'Для дома и дачи', 'Бытовая электроника', 'Хобби и отдых', 'Животные', 'Для бизнеса' );
$category_id = array( array(9 => 'Автомобили с пробегом', 109 => 'Новые автомобили', 14 => 'Мотоциклы и мототехника', 81 => 'Грузовики и спецтехника', 11 => 'Водный транспорт', 10 => 'Запчасти и аксессуары' ),
						array(24 => 'Квартиры', 23 => 'Комнаты', 25 => 'Дома, дачи, коттеджи', 26 => 'Земельные участки', 85 => 'Гаражи и машиноместа', 42 => 'Коммерческая недвижимость', 86 => 'Недвижимость за рубежом'),
						array( 111 => 'Вакансии (поиск сотрудников)', 112 => 'Резюме (поиск работы)'),
						array( 114 => 'Предложения услуг', 115 => 'Запросы на услуги'),
						array( 27 => 'Одежда, обувь, аксессуары', 29 => 'Детская одежда и обувь', 30 => 'Товары для детей и игрушки', 28 => 'Часы и украшения', 88 => 'Красота и здоровье'),
						array( 21 => 'Бытовая техника', 20 => 'Мебель и интерьер', 87 => 'Посуда и товары для кухни', 82 => 'Продукты питания', 19 => 'Ремонт и строительство', 106 => 'Растения' ),
						array( 32 => 'Аудио и видео', 97 => 'Игры, приставки и программы', 31 => 'Настольные компьютеры', 98 => 'Ноутбуки', 99 => 'Оргтехника и расходники', 96 => 'Планшеты и электронные книги', 84 => 'Телефоны', 101 => 'Товары для компьютера', 105 => 'Фототехника' ),
						array( 33 => 'Билеты и путешествия', 34 => 'Велосипеды', 83 => 'Книги и журналы', 36 => 'Коллекционирование', 38 => 'Музыкальные инструменты', 102 => 'Охота и рыбалка', 39 => 'Спорт и отдых', 103 => 'Знакомства' ),
						array( 89 => 'Собаки', 90 => 'Кошки', 91 => 'Птицы', 92 => 'Аквариум', 93 => 'Другие животные', 94 => 'Товары для животных' ),
						array( 116 => 'Готовый бизнес', 40 => 'Оборудование для бизнеса'));
$radio_id = array ( 0 => 'Частное лицо', 1 => 'Компания');
		
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

define('ADS_DB', 'ads_db.txt');

// Извлекаем файл в рабочий массив	
if (file_exists(ADS_DB)){
	$ini_string = file_get_contents(ADS_DB);
		if (!$ini_string) { exit('Ошибка чтения файла'); }
    $ads_db = unserialize($ini_string);
    if (!$ads_db) { exit('Неверный формат файла'); }
}


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
	$del=$_GET['delete'];
    delete_item($del, $ads_db, ADS_DB);
    header("Location: dz_8.php");
exit;
}		
	
// Функция удаления объявления
function delete_item($get_value, $ads_db, $filename) {
	unset($ads_db['db'][$get_value]);
    file_put_serialize_contents($filename, $ads_db);
}


// Функция записи содержимого массива в файл
function file_put_serialize_contents($filename, $array) {
	if(!file_put_contents($filename, serialize($array))) { exit('Ошибка записи файла'); }
} 

// Вывод объявления
if (isset($_GET['show'])){
	$edit_id=$_GET['show'];
	$_SESSION['edit_id']=$edit_id;
	$smarty->assign('editAd', $ads_db['db'][$edit_id]);
}

$smarty->assign('location_sel', 641780);

$smarty->assign('location_id', $location_id);
$smarty->assign('category_id', $category_id);
$smarty->assign('label_id', $label_id);
$smarty->assign('radio_id', $radio_id);

if (isset ($ads_db)) {
$smarty->assign('showAd', $ads_db['db']);
}


$smarty->display('index.tpl');
