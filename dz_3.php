<?php

/*
 * Следующие задания требуется воспринимать как ТЗ (Техническое задание)
 * p.s. Разработчик, помни! 
 * Лучше уточнить ТЗ перед выполнением у заказчика, если ты что-то не понял, чем сделать, переделать, потерять время, деньги, нервы, репутацию.
 * Не забывай о навыках коммуникации :)
 * 
 * Задание 1
 * - Создайте массив $date с пятью элементами
 * - C помощью генератора случайных чисел забейте массив $date юниксовыми метками
 * - Сделайте вывод сообщения на экран о том, какой день в сгенерированном массиве получился наименьшим, а какой месяц наибольшим
 * - Отсортируйте массив по возрастанию дат
 * - С помощью функция для работы с массивами извлеките последний элемент массива в новую переменную $selected
 * - C помощью функции date() выведите $selected на экран в формате "дд.мм.ГГ ЧЧ:ММ:СС"
 * - Выставьте часовой пояс для Нью-Йорка, и сделайте вывод снова, чтобы проверить, что часовой пояс был изменен успешно
 * 

 */
// Создаем массив $date
$arrlen = 5; //set array length

$date = array();

$i = 0;
while($i < $arrlen){
    mt_srand(time());
	$date[$i]=rand(1,time());
	$i++;
}
//print_r($date);

// Вычисляем наименьший день
$day=array();
for($i = 0; $i < $arrlen; $i++){
	$day[$i]=date('d', $date[$i]);
}
sort($day);
//print_r($day);
$minday=array_shift($day);
    echo "<p>Наименьшее число: {$minday}</p>\r\n";

// Вычисляем наибольший месяц
$month=array();
for($i = 0; $i < $arrlen; $i++){
	$month[$i]=date('m', $date[$i]);
}
sort($month);
//print_r($month);
$maxmon=array_pop($month);
    echo "<p>Наибольший месяц: {$maxmon}</p>\r\n";
    
// Сортируем массив $date
sort($date);

$selected=array_pop($date);
    echo "<p>Наибольшая дата в массиве: ".date('d.m.Y H:i:s', $selected)."<p/>\r\n";
    
// Выставляем часовой пояс
date_default_timezone_set('America/New_York');
    echo "<p>Часовой пояс изменен</p>\r\n";
    echo date_default_timezone_get()."<br/>\r\n";
    echo date('d.m.Y H:i:s', $selected);
    
    
    // Выставляем часовой пояс JS

var options = { timeZone: "America/New_York", timeZoneName: 'short'};
//date_default_timezone_set('America/New_York');
console.log ('Часовой пояс изменен');
console.log( selected.toLocaleString('ru-RU', options));