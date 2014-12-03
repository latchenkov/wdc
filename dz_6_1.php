<?php
header("Content-type: text/html; Charset=utf-8");
// Без этих двух строк можно обойтись. Но, поскольку в форме в качестве значения передается числовой индекс, решил форму не менять, а сотворил некую имитацию БД. Для тренировки.
$location_id = array(999999 => 'Другой город', 641780 => 'Новосибирск', 641490 => 'Барабинск', 641510=>'Бердск', 641600=>'Искитим', 641630=>'Колывань', 641680=>'Краснообск', 641710=>'Куйбышев', 641760=>'Мошково', 641790=>'Обь', 641800=>'Ордынское', 641970=>'Черепаново');
$category_id = array(9 => 'Автомобили с пробегом', 109 => 'Новые автомобили', 14 => 'Мотоциклы и мототехника', 81 => 'Грузовики и спецтехника', 11 => 'Водный транспорт', 10 => 'Запчасти и аксессуары', 24 => 'Квартиры', 23 => 'Комнаты', 25 => 'Дома, дачи, коттеджи', 26 => 'Земельные участки', 85 => 'Гаражи и машиноместа', 42 => 'Коммерческая недвижимость', 86 => 'Недвижимость за рубежом', 111 => 'Вакансии (поиск сотрудников)', 112 => 'Резюме (поиск работы)', 114 => 'Предложения услуг', 115 => 'Запросы на услуги', 27 => 'Одежда, обувь, аксессуары', 29 => 'Детская одежда и обувь', 30 => 'Товары для детей и игрушки', 28 => 'Часы и украшения', 88 => 'Красота и здоровье', 21 => 'Бытовая техника', 20 => 'Мебель и интерьер', 87 => 'Посуда и товары для кухни', 82 => 'Продукты питания', 19 => 'Ремонт и строительство', 106 => 'Растения', 32 => 'Аудио и видео', 97 => 'Игры, приставки и программы', 31 => 'Настольные компьютеры', 98 => 'Ноутбуки', 99 => 'Оргтехника и расходники', 96 => 'Планшеты и электронные книги', 84 => 'Телефоны', 101 => 'Товары для компьютера', 105 => 'Фототехника', 33 => 'Билеты и путешествия', 34 => 'Велосипеды', 83 => 'Книги и журналы', 36 => 'Коллекционирование', 38 => 'Музыкальные инструменты', 102 => 'Охота и рыбалка', 39 => 'Спорт и отдых', 103 => 'Знакомства', 89 => 'Собаки', 90 => 'Кошки', 91 => 'Птицы', 92 => 'Аквариум', 93 => 'Другие животные', 94 => 'Товары для животных', 116 => 'Готовый бизнес', 40 => 'Оборудование для бизнеса');

session_start();

// Переносим данные из $_POST в $_SESSION	
	if (!isset($_SESSION['id_ad'])){
		$_SESSION['id_ad'] = 0;
	}

if (isset($_POST['main_form_submit'])) {
		$_SESSION['id_ad']++; 
		$id_ad = $_SESSION['id_ad']; // уникальный номер объявления в базе
			foreach ($_POST as $key => $value) {
				if ($key=='main_form_submit'){
					continue;
				}
			$_SESSION['bd'][$id_ad][$key] = trim(htmlspecialchars($value));
			}
		$_SESSION['bd'][$id_ad]['date'] = date('d.m.Y H:i:s');
	header("Location: dz_6_1.php");
		exit;
}
//print_r($_SESSION);

// Обработка команд на просмотр объявления и на удаление
if (isset($_GET['view'])){
    $_SESSION['view']=$_GET['view'];
    header("Location: dz_6_1.php");
exit;
}
if (isset($_GET['delete'])) {
    delete_item($_GET['delete']);
    header("Location: dz_6_1.php");
exit;
}		
	
// Функция удаления объявления
function delete_item($get_value) {
	unset($_SESSION['bd'][$get_value]);
}

// Функция просмотра объявления
function view_item($get_value, $location_id, $category_id) {
	$item=$_SESSION['bd'][$get_value];
	return '<table>
			<tr>
				<td>Клиент:</td>
				<td>'. (($item['private']==1)? 'Частное лицо':'Компания') . '</td>
			</tr>
			<tr>
				<td><b>Ваше имя:</b></td>    
				<td>'.$item['seller_name'].'</td>
			</tr>
			<tr>
				<td>Электронная почта:</td>
				<td>'.$item['email'].'</td>
        	</tr>'.
			//<tr>
			//	<td></td>
			//	<td>'. (isset($item['allow_mails'])? 'Я не хочу получать вопросы по объявлению по e-mail':'Я хочу получать вопросы по объявлению по e-mail').'</td>
    		//</tr>
			'<tr>
				<td>Номер телефона:</td>
				<td>'.$item['phone'].'</td>
     
			</tr>
			<tr>
				<td>Город:</td>
				<td>'.$location_id[$item['location_id']].'</td>
      
			</tr>
			<tr>
				<td>Категория:</td>
				<td>'. $category_id[$item['category_id']].'</td>	
			</tr>
			<tr>
				<td>Название объявления:</td>
				<td>'.$item['title'].'</td>
    		</tr>
			<tr>
				<td>Описание объявления:</td>
				<td>'.$item['description'].'</td>
      		</tr>
			<tr>
				<td>Цена:</td>
				<td>'.number_format($item['price'], 2, '.', '') . ' руб.</td>
      		</tr>
			<tr>
				<td></td>
				<td> <a href="dz_6_1.php">Назад, к списку объявлений</a></td>
			</tr>
	</table>';

}

// Вывод объявления
if (isset($_SESSION['view'])){
        echo view_item($_SESSION['view'], $location_id, $category_id);
    unset($_SESSION['view']);
    exit;
}




?>


<form  method="post"  >
    <table>
			<tr>
				<td></td>
				<td><input type="radio" checked="" value="1" name="private">Частное лицо <input type="radio" value="0" name="private">Компания</td>
			</tr>
			<tr>
				<td><b>Ваше имя</b></td>    
				<td><input type="text" maxlength="40" value="" name="seller_name" required ></td>
			</tr>
			<tr>
				<td>Электронная почта</td>
				<td><input type="text" value="" name="email" required></td>
        	</tr>
			<tr>
				<td></td>
				<td><input type="checkbox" value="1" name="allow_mails" >Я не хочу получать вопросы по объявлению по e-mail</td>
    
			</tr>
			<tr>
				<td>Номер телефона</td>
				<td><input type="text"  value="" name="phone" required></td>
     
			</tr>
			<tr>
				<td>Город</td>
				<td>
					<select title="Выберите Ваш город" name="location_id" > 
						<option value="">-- Выберите город --</option>
						<option disabled="disabled">-- Города --</option>
						<option selected="" data-coords=",," value="641780">Новосибирск</option>   
						<option data-coords=",," value="641490">Барабинск</option>   
						<option data-coords=",," value="641510">Бердск</option>   
						<option data-coords=",," value="641600">Искитим</option>   
						<option data-coords=",," value="641630">Колывань</option>   
						<option data-coords=",," value="641680">Краснообск</option>   
						<option data-coords=",," value="641710">Куйбышев</option>   
						<option data-coords=",," value="641760">Мошково</option>   
						<option data-coords=",," value="641790">Обь</option>   
						<option data-coords=",," value="641800">Ордынское</option>   
						<option data-coords=",," value="641970">Черепаново</option>   
						<option value="999999">Выбрать другой...</option> 
					</select>
				</td>
      
			</tr>
			<tr>
				<td>Категория</td>
				<td>
					<select title="Выберите категорию объявления" name="category_id"  required>
						<option value="">-- Выберите категорию --</option>
							<optgroup label="Транспорт">	
								<option value="9">Автомобили с пробегом</option>
								<option value="109">Новые автомобили</option>
								<option value="14">Мотоциклы и мототехника</option>
								<option value="81">Грузовики и спецтехника</option>
								<option value="11">Водный транспорт</option>
								<option value="10">Запчасти и аксессуары</option>
							</optgroup>
							<optgroup label="Недвижимость">
								<option value="24">Квартиры</option>
								<option value="23">Комнаты</option>
								<option value="25">Дома, дачи, коттеджи</option>
								<option value="26">Земельные участки</option>
								<option value="85">Гаражи и машиноместа</option>
								<option value="42">Коммерческая недвижимость</option>
								<option value="86">Недвижимость за рубежом</option>
							</optgroup>
							<optgroup label="Работа">
								<option value="111">Вакансии (поиск сотрудников)</option>
								<option value="112">Резюме (поиск работы)</option>
							</optgroup>
							<optgroup label="Услуги">
								<option value="114">Предложения услуг</option>
								<option value="115">Запросы на услуги</option>
							</optgroup>
							<optgroup label="Личные вещи">
								<option value="27">Одежда, обувь, аксессуары</option>
								<option value="29">Детская одежда и обувь</option>
								<option value="30">Товары для детей и игрушки</option>
								<option value="28">Часы и украшения</option>
								<option value="88">Красота и здоровье</option>
							</optgroup>
							<optgroup label="Для дома и дачи">
								<option value="21">Бытовая техника</option>
								<option value="20">Мебель и интерьер</option>
								<option value="87">Посуда и товары для кухни</option>
								<option value="82">Продукты питания</option>
								<option value="19">Ремонт и строительство</option>
								<option value="106">Растения</option>
							</optgroup>
							<optgroup label="Бытовая электроника">
								<option value="32">Аудио и видео</option>
								<option value="97">Игры, приставки и программы</option>
								<option value="31">Настольные компьютеры</option>
								<option value="98">Ноутбуки</option>
								<option value="99">Оргтехника и расходники</option>
								<option value="96">Планшеты и электронные книги</option>
								<option value="84">Телефоны</option>
								<option value="101">Товары для компьютера</option>
								<option value="105">Фототехника</option>
							</optgroup>
							<optgroup label="Хобби и отдых">
								<option value="33">Билеты и путешествия</option>
								<option value="34">Велосипеды</option>
								<option value="83">Книги и журналы</option>
								<option value="36">Коллекционирование</option>
								<option value="38">Музыкальные инструменты</option>
								<option value="102">Охота и рыбалка</option>
								<option value="39">Спорт и отдых</option>
								<option value="103">Знакомства</option>
							</optgroup>
							<optgroup label="Животные">
								<option value="89">Собаки</option>
								<option value="90">Кошки</option>
								<option value="91">Птицы</option>
								<option value="92">Аквариум</option>
								<option value="93">Другие животные</option>
								<option value="94">Товары для животных</option>
							</optgroup>
							<optgroup label="Для бизнеса">
								<option value="116">Готовый бизнес</option>
								<option value="40">Оборудование для бизнеса</option>
							</optgroup>
					</select>
				</td>	
			</tr>
			<tr>
				<td>Название объявления</td>
				<td><input type="text" maxlength="50"  value="" name="title" required></td>
    		</tr>
			<tr>
				<td>Описание объявления</td>
				<td><textarea maxlength="3000" name="description" required></textarea></td>
      		</tr>
			<tr>
				<td>Цена</td>
				<td><input type="text" maxlength="9"  value="0" name="price" >&nbsp;руб.</td>
      		</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Подать объявление" name="main_form_submit" ></td>
			</tr>
	</table>
</form>

<hr/>

<?php
// Вывод списка объявлений
if (isset($_SESSION['bd'])){
	foreach ($_SESSION['bd'] as $id => $item){
		echo '<p>' . $item['date'] .' | ' . '<a href="dz_6_1.php?view=' . $id . '">' . $item['title'] . '</a>' .' | ' . number_format($item['price'], 2, '.', '') . ' руб.' . ' | ' . $item['seller_name'] .' | ' . '<a href="dz_6_1.php?delete=' . $id . '">Удалить</a>' . "</p>\n\r";
	}

}