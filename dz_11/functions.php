<?php

class Ads {
    protected $id;
    protected $date;
    protected $title;
    protected $price;
    protected $seller_name;
        
    function __construct(array $row) {
        $this->id = $row['id'];
        $this->date = $row['date'];
        $this->title = $row['title'];
        $this->price = $row['price'];
        $this->seller_name = $row['seller_name'];
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getSeller_name() {
        return $this->seller_name;
    }
    // показ всех объявлений
    public static function showAll(DbSimple_Mysqli $db){
        $data = $db->select("SELECT id, date, title, price, seller_name FROM ads ORDER BY id");
        if (empty($data)){return null;}
        $allAds = array();
            foreach ($data as $row) {
                $allAds[] = new Ads($row);
            }
        return $allAds;
    }
}

class Ad extends Ads {
    protected $description;
    protected $email;
    protected $phone;
    private $private;
    private $allow_mails;
    private $location_id;
    private $category_id;
    
    function __construct(array $row) {
        parent::__construct($row);
            $this->description = $row['description'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->private = $row['private'];
            $this->allow_mails = $row['allow_mails'];
            $this->location_id = $row['location_id'];
            $this->category_id = $row['category_id'];
    }
    
    public function getDescription() {
        return $this->description;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getPrivate() {
        return $this->private;
    }
    public function getAllow_mails() {
        return $this->allow_mails;
    }
    public function getLocation_id() {
        return $this->location_id;
    }
    public function getCategory_id() {
        return $this->category_id;
    }

    // добавление объявления
    public static function newAd(DbSimple_Mysqli $db, $new_ad){
        $db->query ("INSERT INTO ads (date, ?#) VALUES (now(), ?a)", array_keys($new_ad), array_values($new_ad));
    }

    // редактирование объявления
    public static function updateAd (DbSimple_Mysqli $db, array $update_ad, $id){
        $db->query("UPDATE ads SET ?a WHERE id = ?d", $update_ad, $id);
    }

    // показ конкрентного объявления
    public static function showAd(DbSimple_Mysqli $db, $id){
        $row = $db->selectRow("SELECT * FROM ads WHERE id = ?d", $id);
            return new Ad($row);
    }
    
    // удаление объявления
    public static function delAd(DbSimple_Mysqli $db, $id){
        $db-> query("DELETE FROM ads WHERE id = ?d", $id);
    }
}

class ServiceFunction {
    
    // Обработка данных из массива POST
    public static function trimPOST (array $post){
        $data = array();
            $int = array('price', 'private', 'allow_mails', 'location_id', 'category_id');
            if (!isset($post['allow_mails'])){$post['allow_mails']=0;}
        foreach ($post as $key => $value) {
            if (in_array($key, $int)){
                $data[$key] = trim((int)$value);
            }
            else{
                $data[$key] = trim(htmlspecialchars($value));    
            }
        }
        return $data;
    }

    // список городов
    public static function location_id(DbSimple_Mysqli $db){
        $data=$db->selectCol("SELECT id AS ARRAY_KEY , location FROM locations ORDER BY location");
    return $data;
    }

    // список подкатегорий
    public static function label_id(DbSimple_Mysqli $db){
        $data=$db->selectCol("SELECT id AS ARRAY_KEY, category FROM categorys WHERE parent_id IS NULL");
    return $data;
    }

    // список категорий
    public static function category_id(DbSimple_Mysqli $db){
        $res = $db->select("SELECT  id , parent_id ,  category  FROM categorys WHERE parent_id IS NOT NULL");
        $data = array();
            foreach ($res as $v){
                $data[$v['parent_id']][$v['id']]=$v['category'];
            }
        return $data;
    }
}