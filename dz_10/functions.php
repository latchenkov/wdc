<?php

// показ всех объявлений
function showAll($db){
    $data = $db->select("SELECT id, date, title, price, seller_name FROM ads ORDER BY id");
return $data;
}

// добавление объявления
function newAd($db, $new_ad){
    $db->query ("INSERT INTO ads (date, ?#) VALUES (now(), ?a)", array_keys($new_ad), array_values($new_ad));
}


// редактирование объявления
function updateAd ($db, $update_ad, $id){
    $db->query("UPDATE ads SET ?a WHERE id = ?d", $update_ad, $id);
}

// показ конкрентного объявления
function showAd($db, $id){
    $row = $db->selectRow("SELECT * FROM ads WHERE id = ?d", $id);
return $row;
}
// удаление объявления
function delAd($db, $id){
    $db-> query("DELETE FROM ads WHERE id = ?d", $id);
}

// список городов
function location_id($db){
    $data=$db->selectCol("SELECT id AS ARRAY_KEY , location FROM locations ORDER BY location");
return $data;
}

// список подкатегорий
function label_id($db){
    $data=$db->selectCol("SELECT id AS ARRAY_KEY, category FROM categorys WHERE parent_id IS NULL");
return $data;
}

// список категорий
function category_id($db){
    $res = $db->select("SELECT  id , parent_id ,  category  FROM categorys WHERE parent_id IS NOT NULL");
    foreach ($res as $v){
        $data[$v['parent_id']][$v['id']]=$v['category'];
    }
return $data;
}
