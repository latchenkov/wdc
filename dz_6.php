<?php
header("Content-type: text/html; Charset=utf-8");
$location_id = array(641780 => 'Новосибирск', 641490 => 'Барабинск', 641510=>'Бердск', 641600=>'Искитим', 641630=>'Колывань', 641680=>'Краснообск', 641710=>'Куйбышев', 641760=>'Мошково', 641790=>'Обь', 641800=>'Ордынское', 641970=>'Черепаново');
$category_id_1 = array(9 => 'Автомобили с пробегом', 109 => 'Новые автомобили', 14 => 'Мотоциклы и мототехника', 81 => 'Грузовики и спецтехника', 11 => 'Водный транспорт', 10 => 'Запчасти и аксессуары' );
$category_id_2 = array(24 => 'Квартиры', 23 => 'Комнаты', 25 => 'Дома, дачи, коттеджи', 26 => 'Земельные участки', 85 => 'Гаражи и машиноместа', 42 => 'Коммерческая недвижимость', 86 => 'Недвижимость за рубежом');
$category_id_3 = array( 111 => 'Вакансии (поиск сотрудников)', 112 => 'Резюме (поиск работы)');
$category_id_4 = array( 114 => 'Предложения услуг', 115 => 'Запросы на услуги');
$category_id_5 = array( 27 => 'Одежда, обувь, аксессуары', 29 => 'Детская одежда и обувь', 30 => 'Товары для детей и игрушки', 28 => 'Часы и украшения', 88 => 'Красота и здоровье');
$category_id_6 = array( 21 => 'Бытовая техника', 20 => 'Мебель и интерьер', 87 => 'Посуда и товары для кухни', 82 => 'Продукты питания', 19 => 'Ремонт и строительство', 106 => 'Растения' );
$category_id_7 = array( 32 => 'Аудио и видео', 97 => 'Игры, приставки и программы', 31 => 'Настольные компьютеры', 98 => 'Ноутбуки', 99 => 'Оргтехника и расходники', 96 => 'Планшеты и электронные книги', 84 => 'Телефоны', 101 => 'Товары для компьютера', 105 => 'Фототехника' );
$category_id_8 = array( 33 => 'Билеты и путешествия', 34 => 'Велосипеды', 83 => 'Книги и журналы', 36 => 'Коллекционирование', 38 => 'Музыкальные инструменты', 102 => 'Охота и рыбалка', 39 => 'Спорт и отдых', 103 => 'Знакомства' );
$category_id_9 = array( 89 => 'Собаки', 90 => 'Кошки', 91 => 'Птицы', 92 => 'Аквариум', 93 => 'Другие животные', 94 => 'Товары для животных' );
$category_id_10 = array( 116 => 'Готовый бизнес', 40 => 'Оборудование для бизнеса');

session_start();

// Переносим данные из $_POST в $_SESSION	
if (!isset($_SESSION['id_ad'])){
	$_SESSION['id_ad'] = 0;
}

if (isset($_POST['main_form_submit'])) { // если была нажата кнопка
	$submit=$_POST['main_form_submit'];
		switch ($submit) { // выбор режима добавления или редактирования объявления
			case 'Подать объявление' :
				
				$id = $_SESSION['id_ad']; // уникальный номер объявления в базе
				$_SESSION['id_ad']++;
					$_SESSION['bd'][$id]['date'] = date('d.m.Y H:i:s'); // время подачи объявления
			break;
			case 'Сохранить изменения' :
				$id = $_SESSION['edit_id']; // номер редактируемого объявления
				unset($_SESSION['edit_id'], $_SESSION['bd'][$id]['allow_mails']);
			break;
		}
		
			foreach ($_POST as $key => $value) {
				if ($key=='main_form_submit'){
					continue;
				}
			$_SESSION['bd'][$id][$key] = trim(htmlspecialchars($value));
			}
		
	header("Location: dz_6.php");
		exit;
}


// Обработка команд на просмотр объявления и на удаление
if (isset($_GET['show'])){
    $_SESSION['show']=$_GET['show'];
    header("Location: dz_6.php");
exit;
}
if (isset($_GET['delete'])) {
	$del=$_GET['delete'];
    delete_item($del);
    header("Location: dz_6.php");
exit;
}		
	
// Функция удаления объявления
function delete_item($get_value) {
	unset($_SESSION['bd'][$get_value]);
}



// Вывод объявления
if (isset($_SESSION['show'])){
	$edit_id=$_SESSION['show'];
	$editAd=$_SESSION['bd'][$edit_id];
		unset($_SESSION['show']);
}
print_r($_SESSION);
?>
<form  method="post"  >
    <table>
			<tr>
				<td></td>
				<td><input type="radio" <?php echo (!isset($edit_id) || $editAd['private']==1) ? 'checked=""' : '';?> value="1" name="private">Частное лицо 
					<input type="radio" <?php echo (isset($edit_id) && $editAd['private']==0) ? 'checked=""' : '';?> value="0" name="private">Компания
				</td>
			</tr>
			<tr>
				<td><b>Ваше имя</b></td>    
				<td><input type="text" maxlength="40" value="<?php echo (isset($edit_id)) ? $editAd['seller_name'] : '';?>" name="seller_name" required ></td>
			</tr>
			<tr>
				<td>Электронная почта</td>
				<td><input type="email" value="<?php echo (isset($edit_id)) ? $editAd['email'] : '';?>" name="email" required></td>
        	</tr>
			<tr>
				<td></td>
				<td><input type="checkbox" <?php echo isset($editAd['allow_mails']) ? 'checked=""' : '';?> value="1" name="allow_mails" >Я не хочу получать вопросы по объявлению по e-mail</td>
    
			</tr>
			<tr>
				<td>Номер телефона</td>
				<td><input type="tel"  value="<?php echo (isset($edit_id)) ? $editAd['phone'] : '';?>" name="phone" required></td>
     
			</tr>
			<tr>
				<td>Город</td>
				<td>
					<select title="Выберите Ваш город" name="location_id" required  > 
						<option value="">-- Выберите город --</option>
						<option disabled="disabled">-- Города --</option>
							<?php
							$location_sel=641780;
							foreach ($location_id as $id => $location) {
								if (!isset($edit_id) && $id ==$location_sel ){ ?>
									<option <?php echo 'selected=""';?> data-coords=",," value="<?php echo $id;?>"><?php echo $location;?></option>
								<?php
								}
								else {?>
									<option <?php echo (isset($edit_id) && $editAd['location_id']==$id) ? 'selected=""' : '';?> data-coords=",," value="<?php echo $id;?>"><?php echo $location;?></option>   
						
								<?php
								}
							}	
								?>
					</select>
				</td>
      
			</tr>
			<tr>
				<td>Категория</td>
				<td>
					<select title="Выберите категорию объявления" name="category_id"  required>
						<option value="">-- Выберите категорию --</option>
							<optgroup label="Транспорт">
								<?php
								foreach ($category_id_1 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Недвижимость">
								<?php
								foreach ($category_id_2 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Работа">
								<?php
								foreach ($category_id_3 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Услуги">
								<?php
								foreach ($category_id_4 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>>
							</optgroup>
							<optgroup label="Личные вещи">
								<?php
								foreach ($category_id_5 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Для дома и дачи">
								<?php
								foreach ($category_id_6 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Бытовая электроника">
								<?php
								foreach ($category_id_7 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Хобби и отдых">
								<?php
								foreach ($category_id_8 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Животные">
								<?php
								foreach ($category_id_9 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
							<optgroup label="Для бизнеса">
								<?php
								foreach ($category_id_10 as $id => $category) {?>
								<option <?php echo (isset($edit_id) && $editAd['category_id']==$id) ? 'selected=""' : '';?> value="<?php echo $id;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</optgroup>
					</select>
				</td>	
			</tr>
			<tr>
				<td>Название объявления</td>
				<td><input type="text" maxlength="50"  value="<?php echo (isset($edit_id)) ? $editAd['title'] : '';?>" name="title" required></td>
    		</tr>
			<tr>
				<td>Описание объявления</td>
				<td><textarea maxlength="3000"  name="description" required><?php echo (isset($edit_id)) ? $editAd['description'] : '';?></textarea></td>
      		</tr>
			<tr>
				<td>Цена</td>
				<td><input type="text" maxlength="9"  value="<?php echo (isset($edit_id)) ? $editAd['price'] : '0';?>" name="price" >&nbsp;руб.</td>
      		</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="<?php if(!isset($edit_id)) {echo 'Подать объявление';}
													  else { echo 'Сохранить изменения'; $_SESSION['edit_id']=$edit_id;} ?>" name="main_form_submit" >
				</td>
			</tr>
	</table>
</form>

<hr/>

<?php
// Вывод списка объявлений
if (isset($_SESSION['bd'])){
	foreach ($_SESSION['bd'] as $id => $item){
		echo '<p>' . $item['date'] .' | ' . '<a href="dz_6.php?show=' . $id . '">' . $item['title'] . '</a>' .' | ' . number_format($item['price'], 2, '.', '') . ' руб.' . ' | ' . $item['seller_name'] .' | ' . '<a href="dz_6.php?delete=' . $id . '">Удалить</a>' . "</p>\n\r";
	}
}