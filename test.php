<?php
header("Content-type: text/html; Charset=utf-8");
 $ini_string='
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';осталось на складе = '.  mt_rand(0, 10).'; diskont = diskont'.  mt_rand(0, 2).';

';
                        var_dump($ini_string);                    
 $bd=  parse_ini_string($ini_string, true);
print_r($bd);
