<?php
header("Content-type: text/html; Charset=utf-8");
//POST

$news='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';
$news=  explode("\n", $news);
//print_r($news);

// Функция вывода всего списка новостей.

function print_news_all($news) {
	echo "<h2>Последние новости</h2>\n\r";
		foreach ($news as $print_news) {
			echo "<h4>".$print_news."</h4>\n\r";	
		}
}

// Функция вывода конкретной новости.

function print_news($id, $news) {
	echo "<h4>".$news[$id]."</h4>\n\r";
}
// Точка входа.
// Если новость присутствует - вывести ее на сайте, иначе мы выводим весь список

function content ($id, $news) {
	array_key_exists($id, $news)? print_news($id, $news):print_news_all($news);
}


?>

<form method="POST">
	<p>Введите номер новости
	<input type="text" name="id">
	<input type="submit" name="submit" value="Найти новость">
	</p>
</form>



<?php
// Был ли передан id новости в качестве параметра?
// Если параметр не введен в форму или не является численным- выводить 404 ошибку
if ($_POST){ 
    if(array_key_exists('id', $_POST) && is_numeric($_POST['id'])) {
		content ($_POST['id'], $news);
	}
	else { 
        header ($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
			echo '<h1>Error 404 Not Found</h1>
                  <p>The requested URL was not found on this server.</p>';
		exit;
	}
}
	
