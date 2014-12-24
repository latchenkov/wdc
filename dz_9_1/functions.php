<?php

// показ всех объявлений
function showAll(){
    $query = "SELECT id, date, title, price, seller_name FROM ads ORDER BY id";
    $res = mysql_query($query) or die ('Запрос не удался:'.mysql_error());
    $data = array();
    while($row = mysql_fetch_assoc($res)){
        //$row['date'] = strtotime($row['date'])+3600*3;
	$data[] = $row;
        
    }
return $data;
}

// добавление объявления
function newAd($new_ad){
    $query = "INSERT INTO ads (date, title, price, seller_name, private, email, allow_mails, phone, location_id, category_id, description)
              VALUES (now(), '$new_ad[title]', $new_ad[price], '$new_ad[seller_name]', $new_ad[private], '$new_ad[email]', $new_ad[allow_mails], '$new_ad[phone]', $new_ad[location_id], $new_ad[category_id], '$new_ad[description]')";
    mysql_query($query) or die ('Запрос не удался:'.mysql_error());
}


// редактирование объявления
function updateAd ($update_ad, $id){
    $query = "UPDATE ads SET
                title = '$update_ad[title]',
                price = '$update_ad[price]',
                seller_name = '$update_ad[seller_name]',
                private = $update_ad[private],
                email = '$update_ad[email]',
                allow_mails = $update_ad[allow_mails],
                phone = '$update_ad[phone]',
                location_id = $update_ad[location_id],
                category_id = $update_ad[category_id],
                description = '$update_ad[description]'
            WHERE id = $id";
    mysql_query($query) or die ('Запрос не удался:'.mysql_error());
}

// показ конкрентного объявления
function showAd($id){
    $query = "SELECT * FROM ads WHERE id = $id";
    $res = mysql_query($query) or die ('Запрос не удался:'.mysql_error());
	$row = mysql_fetch_assoc($res);
	return $row;
}
// удаление объявления
function delAd($id){
	$query = "DELETE FROM ads WHERE id = $id";
	mysql_query($query) or die ('Запрос не удался:'.mysql_error());
}

// список городов
function location_id(){
    $query = "SELECT id, location FROM locations ORDER BY location";
    $res = mysql_query($query) or die ('Запрос не удался:'.mysql_error());
    $data = array();
    while($row = mysql_fetch_assoc($res)){
        $data[$row['id']]=$row['location'];
    }
return $data;
}

// список подкатегорий
function label_id(){
    $query = "SELECT id, label FROM labels";
    $res = mysql_query($query) or die ('Запрос не удался:'.mysql_error());
    $data = array();
    while($row = mysql_fetch_assoc($res)){
        $data[$row['id']]=$row['label'];
    }
return $data;
}

// список категорий
function category_id(){
    $query = "SELECT id, label, category FROM categorys ";
    $res = mysql_query($query) or die ('Запрос не удался:'.mysql_error());
    $data = array();
    while($row = mysql_fetch_assoc($res)){
        $data[$row['label']][$row['id']]=$row['category'];
    }
return $data;
}



