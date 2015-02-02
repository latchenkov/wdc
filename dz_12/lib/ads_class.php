<?php

class Ads {
    protected $id;
    protected $date;
    protected $title;
    protected $price;
    protected $seller_name;
    protected $description;
    protected $email;
    protected $phone;
    protected $type;
    protected $allow_mails;
    protected $location_id;
    protected $category_id;
        
    public function __construct(array $ad) {
        if(isset($ad['id'])){
            $this->id=$ad['id'];
        }
        if(isset($ad['date'])){
            $this->date=$ad['date'];
        }
        else {
        $this->date = date('YmdHis');
        }
        $this->title = $ad['title'];
        $this->price = $ad['price'];
        $this->seller_name = $ad['seller_name'];
        $this->description = $ad['description'];
        $this->email = $ad['email'];
        $this->phone = $ad['phone'];
        $this->type = $ad['type'];
        $this->allow_mails = $ad['allow_mails'];
        $this->location_id = $ad['location_id'];
        $this->category_id = $ad['category_id'];
    }
    
    public function saveAd() {
        global $db;
        $vars = get_object_vars($this);
        $db->query('REPLACE INTO ads(?#) VALUES(?a)',  array_keys($vars),  array_values($vars));
    }
    
    public static function trimPOST (array $post){
        $data = array();
            $int = array('id', 'price', 'type', 'allow_mails', 'location_id', 'category_id');
            if (!isset($post['allow_mails'])){$post['allow_mails']=0;}
        foreach ($post as $key => $value) {
            if (in_array($key, $int)){
                $data[$key] = trim((int)$value);
            }
            else{
                $data[$key] = trim(strip_tags($value));    
            }
        }
        return $data;
    }
    
    // удаление объявления
    public static function delAdFromDb($id){
        global $db;
        $db-> query("DELETE FROM ads WHERE id = ?d", $id);
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
    
    public function getObjectParam() {
        return get_object_vars($this);
    }

}

class privateAds extends Ads {
    protected $type = 0;
            
        public function __construct(array $ad) {
            if(isset($ad['id'])){
              $this->id=$ad['id'];
            }
            if(isset($ad['date'])){
                $this->date=$ad['date'];
            }
            else {
            $this->date = date('YmdHis');
            }
            $this->title = $ad['title'];
            $this->price = $ad['price'];
            $this->seller_name = $ad['seller_name'];
            $this->description = $ad['description'];
            $this->email = $ad['email'];
            $this->phone = $ad['phone'];
            $this->allow_mails = $ad['allow_mails'];
            $this->location_id = $ad['location_id'];
            $this->category_id = $ad['category_id'];
        }
    
}

class corporateAds extends Ads {
    protected $type = 1;
            
        public function __construct(array $ad) {
            if(isset($ad['id'])){
              $this->id=$ad['id'];
            }
            if(isset($ad['date'])){
                $this->date=$ad['date'];
            }
            else {
            $this->date = date('YmdHis');
            }
            $this->title = $ad['title'];
            $this->price = $ad['price'];
            $this->seller_name = $ad['seller_name'];
            $this->description = $ad['description'];
            $this->email = $ad['email'];
            $this->phone = $ad['phone'];
            $this->allow_mails = $ad['allow_mails'];
            $this->location_id = $ad['location_id'];
            $this->category_id = $ad['category_id'];
        }
    
} 

class AdsStore{
    private static $instance=NULL;
    private $ads=array();
    
    public static function getInstance() { // Создаем экземпляр AdsStore
        if(self::$instance == NULL){
            self::$instance = new AdsStore();
        }
        return self::$instance;
    }
    
    public function addAds(Ads $ad) { // Добавляем объект Ads в хранилище
        if(!($this instanceof AdsStore)){
            die('Нельзя использовать этот метод в конструкторе классов');
        }
        $this->ads[$ad->getId()]=$ad;
    }
    
    public function getAllAdsFromDb() { // Извлекаем все объявления из БД
        global $db;
        $all = $db->select('SELECT * FROM ads ORDER BY id');
        foreach ($all as $value){
            switch ($value['type']) {
                case 0 : // Частное объявление
                    $ad = new privateAds($value);
                break;
                case 1 : // Объявление компании
                    $ad = new corporateAds($value);
                break;
            }
        self::addAds($ad); //помещаем объекты в хранилище
        }
        return self::$instance;
    }
    
    public function prepareForOutSingleAd($id) { // Готовим к выводу выбранное объявление
        global $smarty;
        $ad = $this->ads[$id];
        foreach ($ad->getObjectParam() as $key => $val){
            $smarty->assign($key, htmlspecialchars($val));
        }    
    }
    
    public function prepareForOutTableRow() {
        global $smarty;
        $row='';
        foreach ($this->ads as $value) {
            $smarty->assign('ad',$value);
                if ($value instanceof privateAds){
                    $row.=$smarty->fetch('table_row_private.tpl');
                }
                elseif ($value instanceof corporateAds) {
                    $row.=$smarty->fetch('table_row_corporate.tpl');
                }
        }
        $smarty->assign('ads_rows',$row);
        return self::$instance;
    }
    
    public function display() {
        global $smarty;
        $smarty->display('index.tpl');
    }

    public function prepareForOutDataForm() {
        global $smarty;
        $smarty->assign('location_sel', 641780); // Выбранный город по умолчанию
        $smarty->assign('location', self::getLocationList());
        $smarty->assign('category', self::getCategorylist());
        $smarty->assign('label', self::getLabelList());
        $smarty->assign('radio_id', array ( 0 => 'Частное лицо', 1 => 'Компания'));
    
        return self::$instance;
    }
    
    // список городов
    public function getLocationList(){
        global $db;
        $data=$db->selectCol("SELECT id AS ARRAY_KEY , location FROM locations ORDER BY location");
    return $data;
    }

    // список подкатегорий
    public function getLabelList(){
        global $db;
        $data=$db->selectCol("SELECT id AS ARRAY_KEY, category FROM categorys WHERE parent_id IS NULL");
    return $data;
    }

    // список категорий
    public function getCategorylist(){
        global $db;
        $res = $db->select("SELECT  id , parent_id ,  category  FROM categorys WHERE parent_id IS NOT NULL");
        $data = array();
            foreach ($res as $v){
                $data[$v['parent_id']][$v['id']]=$v['category'];
            }
        return $data;
    }
}