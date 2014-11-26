<?php
/*
 * Следующие задания требуется воспринимать как ТЗ (Техническое задание)
 * p.s. Разработчик, помни! 
 * Лучше уточнить ТЗ перед выполнением у заказчика, если ты что-то не понял, чем сделать, переделать, потерять время, деньги, нервы, репутацию.
 * Не забывай о навыках коммуникации :)
 * 
 * Задание 1
 * - Вы проектируете интернет магазин. Посетитель на вашем сайте создал следующий заказ (цена, количество в заказе и остаток на складе генерируются автоматически):
 */
$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd=  parse_ini_string($ini_string, true);
//print_r($bd);

/*
 * 
 * - Вам нужно вывести корзину для покупателя, где указать: 
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, каково общее количество товара, какова общая сумма заказа
 * - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том, что нужного количества товара не оказалось на складе
 * - Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
 * 3) у каждого товара есть автоматически генерируемый скидочный купон diskont, используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%
 * 
 * В коде должно быть использовано:
 * - не менее одной функции
 * - не менее одного параметра для функции
 * операторы if, else, switch
 * статические и глобальные переменные в теле функции
 * 

 */
 // Извлекаем наименования товаров
 $name=array_keys($bd);
 $count=count($name);
 //print_r($name);
 
 // Функция вычисления скидки по акции
 function discount_action() {
	global $discount;
	global $discount_scr;
				$discount=0.7;
				$discount_scr='Акция<br/>30%';
}
 // Функция вычисления скидки по купону			
function discount($diskont) {
	global $discount;
	global $discount_scr;
		switch ($diskont){
			case 'diskont1':
				$discount=0.9;
				$discount_scr='10%';
					break;
			case 'diskont2':
				$discount=0.8;
				$discount_scr='20%';
					break;
			default:
				$discount=1;
				$discount_scr='-';
					break;
		}
}
			
  // Функция вычисления цены со скидкой
 function price ($price, $discount) {
		   $price=$price*$discount;
				return number_format($price, 2, '.','');
 }
 
  // Функция вычисления наличия на складе
 function instock ($qty, $instock) {
	global $fl_instock;
		if ($qty <= $instock){
			return 'На складе';
		}
			elseif ($instock==0) {
				$fl_instock=1;
					return 'Нет на складе';
			}	
				else {
					$fl_instock=1;
						return 'На складе '.$instock."<br/>из ".$qty.' заказанных';
				}
	
 }
 
 // Секция СКИДКИ
 $act_name='игрушка детская велосипед'; // наименование акционного товара
 $act_qty=3; // количество товара для акции
	if(in_array($act_name, $name) && $bd[$act_name]['количество заказано'] >= $act_qty) { 
		echo '<p>Внимание, акция! Вы заказали товар ' . '"' . $act_name . '"' .  " в количестве больше ".$act_qty." штук.<br/>\n\r
			     Вам предоставляется скидка 30% на этот товар.</p>\n\r";
	
	}
 
 // Таблица корзины
 
echo '<table border="1" >';
echo '<tr align="center"><td>№</td><td>Наименование<br/>товара</td><td>Скидка</td><td>Цена</td><td>Кол-во<br/>заказано</td><td>Наличие<br/>на складе</td><td>Сумма</td></tr>';
	
	for($i=0; $i<$count; $i++){
		$qty[$i]=$bd[$name[$i]]['количество заказано']; //заказанное количество товара
		$diskont=$bd[$name[$i]]['diskont']; //купон скидки
			if($name[$i]==$act_name && $qty[$i] >= $act_qty) { 
				$discount_type = 'discount_action';
			}
				else {
				$discount_type = 'discount';
				}
		$discount_type($diskont); //вычисляется скидка
			$price[$i]=price($bd[$name[$i]]['цена'], $discount); //вычисляется цена со скидкой
				$instock=instock ($qty[$i], $bd[$name[$i]]['осталось на складе']); //остаток на складе
					$summa[$i]=number_format(($price[$i]*$qty[$i]), 2, '.', ''); //стоимость товара
		echo '<tr align="center">
				<td>'.($i+1)."</td>
					<td>".$name[$i]."</td>
						<td>".$discount_scr."</td>
							<td>".$price[$i]."</td>   
								<td>".$qty[$i]."</td>
									<td>".$instock."</td>
										<td>".$summa[$i]."</td>
			</tr>";
	
	}
echo "</table>\n\r";


// Секция ИТОГО
echo '<table>';
	echo "<tr><td>ИТОГО по заказу:</td><td>- наименований: ".$count."</td></tr>";
	echo "<tr><td></td><td>- всего единиц товара: ".array_sum($qty)."</td></tr>";
	echo "<tr><td></td><td>- СУММА к оплате: ".number_format(array_sum($summa), 2, '.','')." руб.</td></tr>";
echo "</table>\n\r";
		 
// Секция УВЕДОМЛЕНИЯ

if ($fl_instock==1) {
	echo "<p>Внимание! В вашем заказе есть позиции, отсутствующие на складе.<br/>\n\r
	      Вернитесь в корзину и отредактируйте свой заказ.</p>\n\r";

}
