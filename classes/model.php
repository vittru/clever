<?php

Class Model {
    
    private $registry;
    private $db;
    
    private $selectId = "SELECT id FROM users "
            . "WHERE ip=:ip AND useragent=:userAgent";
    private $selectProfile = "SELECT p.* "
            . "FROM profiles p, users u "
            . "WHERE u.id = :userId AND u.profile = p.id";
    private $addUser = "INSERT INTO users (ip, useragent)"
            . "VALUES(:ip, :userAgent)";
    private $addVisit = "INSERT INTO visits (userid, pageid, time)"
            . "VALUES(:userId, :pageId, :time)";
    private $lastVisit = "SELECT MAX(time) FROM visits "
            . "WHERE userid=:userId";
    private $profileExists = "SELECT count(p.id) FROM profiles p, users u "
            . "WHERE p.id = u.profile AND u.id = :userId";
    private $createProfile = "INSERT INTO profiles(name, email, client, password, spam, phone) "
            . "VALUES(:userName, :userEmail, :isClient, :userPassword, :spam, :phone)";
    private $linkProfile = "UPDATE users SET profile = :profileId "
            . "WHERE id = :userId";
    private $updateProfile = "UPDATE profiles "
            . "SET name = :userName, email = :userEmail, client = :isClient, password=:userPassword, spam=:spam, phone=:phone "
            . "WHERE id = (SELECT profile FROM users WHERE id = :userId)"; 
    private $emailExists = "SELECT count(*) FROM profiles "
            . "WHERE email = :userEmail";
    private $checkUser = "SELECT count(*) FROM profiles "
            . "WHERE email = :userEmail AND password = :userPassword";
    private $selectProfileEmail = "SELECT * FROM profiles "
            . "WHERE email = :userEmail";
    private $getAllNews = "select header, time, text from news order by time desc limit 10";
    private $getNonClientNews = "select headr, time, text from news where forClients=0 order by time desc limit 10";
    private $addQuestion = "INSERT INTO questions(user, question, date) VALUES(:userId, :question, NOW())";
    private $selectCatalog = "SELECT id, name FROM ";
    private $updateGood = "UPDATE goods SET name=:name, description=:description, shortdesc=:shortdesc, firmId=:firmId, sale=:sale, howTo=:howTo, madeOf=:madeOf, problem=:problem, bestbefore=:bestbefore, precaution=:precaution WHERE id=:id";
    private $addGood = "INSERT INTO goods (name, description, shortdesc, firmId, sale, howTo, madeOf, problem, bestbefore, precaution) VALUES (:name, :description, :shortdesc, :firmId, :sale, :howTo, :madeOf, :problem, :bestbefore, :precaution)";
    private $linkGoodCat = "INSERT INTO `goods-categories` (goodId, categoryId) VALUES(:goodId, :catId)";
    private $linkGoodType = "INSERT INTO `goods-types` (goodId, typeId) VALUES(:goodId, :typeId)";
    private $linkGoodEff = "INSERT INTO `goods-effects` (goodId, effectId) VALUES(:goodId, :effId)";
    private $linkGoodProblem = "INSERT INTO `goods-problems` (goodId, problemId) VALUES(:goodId, :probId)";
    private $linkGoodST = "INSERT INTO `goods-skintypes` (goodId, skintypeId) VALUES(:goodId, :skintypeId)";
    private $linkGoodHT = "INSERT INTO `goods-hairtypes` (goodId, hairtypeId) VALUES(:goodId, :hairtypeId)";
    
    
    function __construct($registry) {
        $this->registry = $registry;
        $this->db = new PDO('mysql:host=localhost;dbname='.$this->registry['dbname'].';charset=utf8', $this->registry['dbuser'], $this->registry['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    //Gets userId from DB or creates a new one if not exists
    function getUser() {
        $user = $_SESSION['user'];
        $userId = $user->id;
        //If userId is not set we're trying to get User ID from DB by his ip and agent
        if (!$userId) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $agent = $_SERVER['HTTP_USER_AGENT'];

            $sqlSelect = $this->db->prepare($this->selectId);
            $sqlSelect->bindParam(':ip', $ip);
            $sqlSelect->bindParam(':userAgent', $agent);

            try {
                $sqlSelect->execute();
            } catch (PDOException $e) {
                $this->registry['logger']->lwrite('Error when getting userId from DB');
                $this->registry['logger']->lwrite($e.getMessage);
            }
            $userId = $sqlSelect->fetchColumn();
            $sqlSelect->closeCursor();
        }
        //If user doesn't exist in DB we create it in Users table
        if (!$userId) {
            $sqlInsert = $this->db->prepare($this->addUser);
            $sqlInsert->bindParam(':ip', $ip);
            $sqlInsert->bindParam(':userAgent', $agent);
            try {            
                $sqlInsert->execute();
            } catch (PDOException $e){
                $this->registry['logger']->lwrite('Error when inserting new user to DB');
                $this->registry['logger']->lwrite($e->getMessage());
            }
            $userId = $this->db->lastInsertId();
            $sqlInsert->closeCursor();
        //If user exists we're getting his info from Profiles table    
        }else{
            $sqlSelect = $this->db->prepare($this->selectProfile);
            $sqlSelect->bindParam(':userId', $userId);
            try {
                $sqlSelect->execute();
                $data = $sqlSelect->fetch();
            } catch(PDOException $e) {
                $this->registry['logger']->lwrite('Error when selecting user properties from DB');
                $this->registry['logger']->lwrite($e->getMessage());
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->client = $data['client'];
            $user->password = $data['password'];
            $user->spam = $data['spam'];
            $user->phone = $data['phone'];
            $sqlSelect->closeCursor();
        }
        $user->id = $userId;
        $this->registry->remove('user');
        $this->registry->set('user', $user);
        setcookie('user', $userId, 60*24*60*60+time(), "/");
    }
    
    //Gets user's last visit from DB
    function getLastVisit() {
        $sqlLastVisit = $this->db->prepare($this->lastVisit);
        $sqlLastVisit->bindParam(':userId', $_SESSION['user']->id);
        try {
            $sqlLastVisit->execute();
        } catch (PDOException $e) {
            $this->registry['logger']->lwrite('Error when getting last visit from DB');
            $this->registry['logger']->lwrite($e->getMessage());
    }
        $visit = $sqlLastVisit->fetchColumn();
        $sqlLastVisit->closeCursor();
        return $visit;
    }
    
    //Adds a record about visit
    function logVisit($pageId) {
        $time = date("Y-m-d H:i:s");
        $sqlLog = $this->db->prepare($this->addVisit);
        $sqlLog->bindParam(':userId', $_SESSION['user']->id);
        $sqlLog->bindParam(':pageId', $pageId);
        $sqlLog->bindParam(':time', $time);        
        try{
            $sqlLog->execute();
        }catch(PDOException $e){
            $this->registry['logger']->lwrite('Error when logging a visit to DB');
            $this->registry['logger']->lwrite($e->getMessage());
        }
        $sqlLog->closeCursor();
    }
    
    //Checks if profile exists for the user
    function checkProfile() {
        $sqlSelect = $this->db->prepare($this->profileExists);
        $sqlSelect->bindParam(':userId', $_SESSION['user']->id);
        try{
            $sqlSelect->execute();
        }catch(PDOException $e){
            $this->registry['logger']->lwrite('Error when checking profile existence');
            $this->registry['logger']->lwrite($e->getMessage());
        }
        $count = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();        
        if ($count > 0) {
            return true;
        }
        return false;
    }
    
    //Updates user profile
    function updateUser() {
        //If profile doesn't exist then we create it and link to user
        if (!$this->checkProfile()) {
            $sqlCreate = $this->db->prepare($this->createProfile);
            $sqlCreate->bindParam(':userName', $_SESSION['user']->name);
            $sqlCreate->bindParam(':userEmail', $_SESSION['user']->email);
            if (!$_SESSION['user']->client){
                $_SESSION['user']->client = 0;
            }
            $sqlCreate->bindParam(':isClient', $_SESSION['user']->client, PDO::PARAM_INT);
            $sqlCreate->bindParam(':userPassword', $_SESSION['user']->password);
            $sqlCreate->bindParam(':phone', $_SESSION['user']->phone);
            if (!$_SESSION['user'].spam){
                $_SESSION['user']->spam = 0;
            }
            $sqlCreate->bindParam(':spam', $_SESSION['user']->spam, PDO::PARAM_INT);
            try {
                $sqlCreate->execute();
            } catch (PDOException $e) {
                $this->registry['logger']->lwrite('Error when creating profile in DB');
                $this->registry['logger']->lwrite($e->getMessage());            
            }
            $profileId = $this->db->lastInsertId();
            $sqlCreate->closeCursor();
            $sqlLink = $this->db->prepare($this->linkProfile);
            $sqlLink->bindParam(":userId", $_SESSION['user']->id);
            $sqlLink->bindParam(":profileId", $profileId);
            try {
                $sqlLink->execute();
            } catch (PDOException $e) {
                $this->registry['logger']->lwrite('Error when linking user to profile in DB');
                $this->registry['logger']->lwrite($e->getMessage());            
            }
            $sqlLink->closeCursor();   
        //Otherwise we just update the profile    
        } else {    
            $sqlUpdate = $this->db->prepare($this->updateProfile);
            $sqlUpdate->bindParam(':userName', $_SESSION['user']->name);
            $sqlUpdate->bindParam(':userEmail', $_SESSION['user']->email);
            $sqlUpdate->bindParam(':isClient', $_SESSION['user']->client, PDO::PARAM_INT);
            $sqlUpdate->bindParam(':userPassword', $_SESSION['user']->password);
            $sqlUpdate->bindParam(':spam', $_SESSION['user']->spam, PDO::PARAM_INT);
            $sqlUpdate->bindParam(':phone', $_SESSION['user']->phone);
            $sqlUpdate->bindParam(':userId', $_SESSION['user']->id);
            try {
                $sqlUpdate->execute();
            } catch (PDOException $e) {
                $this->registry['logger']->lwrite('Error when updating user in DB');
                $this->registry['logger']->lwrite($e->getMessage());            
            }
            $sqlUpdate->closeCursor();
        }    
    }
    
    function checkEmailExists($userEmail) {
        $sqlSelect = $this->db->prepare($this->emailExists);
        $sqlSelect->bindParam(':userEmail', $userEmail);
        try{
            $sqlSelect->execute();
        } catch (Exception $ex) {
            $this->registry['logger']->lwrite('Error when checking email existence');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $count = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($count > 0) {
            return true;
        }
        return false;
    }
    
    function login() {
        $sqlSelect = $this->db->prepare($this->selectProfileEmail);
        $sqlSelect->bindParam(":userEmail", $_SESSION['user']->email);
        try{
            $sqlSelect->execute();
            $data = $sqlSelect->fetch();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting profile by email');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $sqlSelect->closeCursor();
        $_SESSION['user']->name = $data['name'];
        $_SESSION['user']->client = $data['client'];
        $_SESSION['user']->spam = $data['spam'];
        $_SESSION['user']->phone = $data['phone'];
        $sqlLink = $this->db->prepare($this->linkProfile);
        $sqlLink->bindParam(":userId", $_SESSION['user']->id);
        $sqlLink->bindParam(":profileId", $data['id']);
        try {
            $sqlLink->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking user to profile');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $sqlLink->closeCursor();
    }
    
    function checkUser($userEmail, $userPassword) {
        $sqlSelect = $this->db->prepare($this->checkUser);
        $sqlSelect->bindParam(':userEmail', $userEmail);
        $sqlSelect->bindParam(':userPassword', $userPassword);        
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when checking user existance');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $count = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    function getNews() {
        if ($this->registry['isClient'])
            $sqlSelect = $this->db->prepare($this->getAllNews);
        else 
            $sqlSelect = $this->db->prepare($this->getNonClientNews);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting news from DB');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $news = new News($data['header'], $data['time'], $data['text']);
            if (!$newsArray)
                $newsArray = [$news];
            else
                array_push($newsArray, $news);
        }
        $this->registry['news']= $newsArray;
        $sqlSelect->closeCursor();
    }
    
    function addQuestion($userId, $question) {
        $sqlSelect = $this->db->prepare($this->addQuestion);
        $sqlSelect->bindParam(':userId', $userId);
        $sqlSelect->bindParam(':question', $question); 
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when adding a question');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $sqlSelect->closeCursor();
    }
    
    function getCatalog($catName) {
        $sqlSelect = $this->db->prepare($this->selectCatalog . $catName);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting ' . $catName);
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $catsArray[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor(); 
        return $this->prepareArray($catsArray);       
    }
    
    function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    
    function prepareArray($array) {
        $preparedArray = $array;
        foreach($preparedArray as $key=>$value){
            if ($this->startsWith($value, "Все") or $this->startsWith($value, "Прочее")) {
                $keyAll = $key;
                $valueAll = $value;
                unset($preparedArray[$key]);
            }    
        }
        asort($preparedArray);
        if($keyAll) $preparedArray[$keyAll]=$valueAll;
        return $preparedArray;
    }
    
    function addGood($id, $name, $description, $shortdesc, $firmId, $sale, $madeOf, $howTo, $problem, $bestbefore, $precaution) {
        if ($id) {
            $sqlInsert = $this->db->prepare($this->updateGood);
            $sqlInsert->bindParam(':id', $id);
        } else {
            $sqlInsert = $this->db->prepare($this->addGood);
        }
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':description', $description);
        $sqlInsert->bindParam(':shortdesc', $shortdesc);
        $sqlInsert->bindParam(':firmId', $firmId);
        $sqlInsert->bindParam(':sale', $sale);
        $sqlInsert->bindParam(':howTo', $howTo);
        $sqlInsert->bindParam(':madeOf', $madeOf);
        $sqlInsert->bindParam(':problem', $problem);
        $sqlInsert->bindParam(':bestbefore', $bestbefore);
        $sqlInsert->bindParam(':precaution', $precaution);
        try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when adding/updating a good');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        if ($id) {
            $goodId=$id;
        } else {
            $goodId = $this->db->lastInsertId();
        }
        $sqlInsert->closeCursor();
        return $goodId;
    }

    function linkGoodType($goodId, $typeId) {
        $sqlInsert = $this->db->prepare($this->linkGoodType);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':typeId', $typeId);
        try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good '.$goodId.' and type '.$typeId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }    
    
    function linkGoodCat($goodId, $catId) {
        $sqlInsert = $this->db->prepare($this->linkGoodCat);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':catId', $catId);
        try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good and category');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }
        
    function linkGoodEff($goodId, $effId) {
        $sqlInsert = $this->db->prepare($this->linkGoodEff);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':effId', $effId);
            try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good and effect');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }
    
    function linkGoodProblem($goodId, $probId) {
        $sqlInsert = $this->db->prepare($this->linkGoodProblem);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':probId', $probId);
            try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good and problem');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }    

    function linkGoodST($goodId, $skintypeId) {
        $sqlInsert = $this->db->prepare($this->linkGoodST);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':skintypeId', $skintypeId);
            try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good and skintype');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }

    function linkGoodHT($goodId, $hairtypeId) {
        $sqlInsert = $this->db->prepare($this->linkGoodHT);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':hairtypeId', $hairtypeId);
            try{
            $sqlInsert->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when linking good and hairtype');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }    
        $sqlInsert->closeCursor();
    }
    
    function getGood($goodId) {
        $sqlSelect = $this->db->prepare("SELECT * FROM goods WHERE id=" . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting a product');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $data = $sqlSelect->fetch();
        $good=new Good($goodId, trim($data['name']), trim($data['description']), trim($data['shortdesc']), trim($data['howTo']), trim($data['madeOf']), $data['sale'], $data['firmId'], trim($data['problem']), trim($data['bestbefore']), trim($data['precaution']));
        $good->cats = $this->getGoodCats($goodId);
        $good->effs = $this->getGoodEffs($goodId);
        $good->skintypes = $this->getGoodSTs($goodId);
        $good->hairtypes = $this->getGoodHTs($goodId);
        $good->sizes = $this->getGoodSizes($goodId);
        $good->types = $this->getGoodTypes($goodId);
        $good->problems = $this->getGoodProblems($goodId);
        
        $sqlSelect->closeCursor();    
        return $good;
    }
    
    function getGoodTypes($goodId) {
        $sqlSelect = $this->db->prepare('SELECT t.id, t.name FROM types t, `goods-types` gt WHERE t.id=gt.typeId AND gt.goodId='.$goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product types');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $types = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $types[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor();
        return $types;        
    }
    
    function getGoodSizes($goodId) {
        $sqlSelect = $this->db->prepare('SELECT gs.id, gs.size, w.price, w.instock, w.onhold, gs.code, gs.sale FROM `goods-sizes` gs LEFT JOIN warehouse w ON gs.Id=w.psId WHERE gs.goodId='.$goodId.' ORDER BY w.price');
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product sizes');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $sizes = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $size = new Size($data['id'], $data['size'], $data['price'], $data['sale'], $data['code'], $data['instock'], $data['onhold']);
            $sizes[$data['id']]=$size;
        }
        $sqlSelect->closeCursor();
        return $sizes;
    }
    
    function getGoodCats($goodId) {
        $sqlSelect = $this->db->prepare('SELECT categoryId FROM `goods-categories` WHERE goodId=' . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product categories');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['categoryId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getGoodEffs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT effectId FROM `goods-effects` WHERE goodId=' . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product effects');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['effectId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }

    function getGoodProblems($goodId) {
        $sqlSelect = $this->db->prepare('SELECT problemId FROM `goods-problems` WHERE goodId=' . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product problems');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['problemId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getGoodSTs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT skintypeId FROM `goods-skintypes` WHERE goodId=' . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product skintypes');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['skintypeId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }

    function getGoodHTs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT hairtypeId FROM `goods-hairtypes` WHERE goodId=' . $goodId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when selecting product hairtypes');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['hairtypeId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function deleteGoodCat($goodId) {
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-types` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-categories` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-effects` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-hairtypes` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-skintypes` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-problems` WHERE goodId=' . $goodId);
        $sqlDelete->execute();
        $sqlDelete->closeCursor();
    }
    
    function getFirm($firmId) {
        $sqlSelect = $this->db->prepare('SELECT name, description FROM firms WHERE id=' . $firmId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting a firm with id=' . $firmId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $data = $sqlSelect->fetch();
        $firm = new Firm($firmId, $data['name'], $data['description']);
        $firm->goods = $this->getGoodsByFirm($firmId);
        $firm->categories = $this->getFirmCats($firmId);
        $sqlSelect->closeCursor();
        return $firm;
    }
    
    function getGoodsByFirm($firmId) {
        $sqlSelect = $this->db->prepare('SELECT id FROM goods WHERE firmId=' . $firmId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting goods of firm with id=' . $firmId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        }   
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            if (!$goods)
                $goods = [$good];
            else
                array_push($goods, $good);
        }
        $sqlSelect->closeCursor();
        return $goods;
    }
    
    function getFirmCats($firmId) {
        $sqlSelect = $this->db->prepare('SELECT DISTINCT cat.id, cat.name FROM categories cat, `goods-categories` gc, goods g WHERE cat.id=gc.categoryid AND gc.goodId=g.id and g.firmId=' . $firmId);
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting categories of firm with id=' . $firmId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $catsArray[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getAllGoods() {
        $sqlSelect = $this->db->prepare('SELECT id FROM goods');
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting all goods');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }   
        $goods=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            $goods[$data['id']]=$good;
        }
        $sqlSelect->closeCursor();
        return $goods;        
    }
    
    function addGoodSize($goodId, $gsId, $size, $price, $code, $instock, $sale) {
        if (!$code)
            $code = null;
        if ($gsId) {
            $sqlQuery = $this->db->prepare('UPDATE `goods-sizes` SET goodId=:goodId, size=:size, code=:code, sale=:sale WHERE id='.$gsId);
        } else {
            $sqlQuery = $this->db->prepare('INSERT INTO `goods-sizes`(goodId, size, code, sale) VALUES(:goodId,:size,:code,:sale)');
        }
        $sqlQuery->bindParam(':goodId', $goodId);
        $sqlQuery->bindParam(':size', $size);
        $sqlQuery->bindParam(':code', $code);
        $sqlQuery->bindParam(':sale', $sale);
        try{
            $sqlQuery->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when updating/inserting size ' . $size .' for good '.$goodId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        } 
        if (!$gsId)
            $gsId = $this->db->lastInsertId();
        $sqlQuery->closeCursor();
        $sqlSelect = $this->db->prepare('SELECT id FROM warehouse WHERE psId='.$gsId);
        $sqlSelect->execute();
        $warId = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($warId)
            $sqlQuery2 = $this->db->prepare('UPDATE warehouse SET price=:price, instock=:instock WHERE psId=:gsId');
        else 
            $sqlQuery2 = $this->db->prepare('INSERT INTO warehouse(psId, price, instock) VALUES (:gsId, :price, :instock)');
        $sqlQuery2->bindParam(':gsId', $gsId);
        $sqlQuery2->bindParam(':price', $price);
        $sqlQuery2->bindParam(':instock', $instock);
        try{
            $sqlQuery2->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when updating/inserting warehouse data for goodsize '.$gsId);
            $this->registry['logger']->lwrite($e->getMessage()); 
        } 
        $sqlQuery2->closeCursor();
    }
    
    function getBranches() {
        $sqlSelect = $this->db->prepare('SELECT * FROM branches');
        try{
            $sqlSelect->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting branches');
            $this->registry['logger']->lwrite($e->getMessage()); 
        }
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $branch = New Branch($data['id'], $data['address'], $data['open'], $data['card']);
            $catsArray[$data['id']] = $branch;
        }
        $sqlSelect->closeCursor(); 
        return $catsArray;       
    }
    
    function saveOrder($userId, $name, $email, $phone, $branch, $takeDate, $takeTime, $address) {
        $sqlInsert = $this->db->prepare('INSERT INTO orders(userId, name, email, phone, date, branchId, day, time, address) VALUES(:userId, :name, :email, :phone, :date, :branch, :takeDate, :takeTime, :address)');
        $sqlInsert->bindParam(':userId', $userId);
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':email', $email);
        $sqlInsert->bindParam(':phone', $phone);
        $sqlInsert->bindParam(':branch', $branch);
        $sqlInsert->bindParam(':takeDate', $takeDate);
        $sqlInsert->bindParam(':takeTime', $takeTime);
        $sqlInsert->bindParam(':address', $address);
        $this->registry['logger']->lwrite(date('Y-m-d', time()));
        $sqlInsert->bindParam(':date',  date('Y-m-d', time()));
        try{
            $sqlInsert->execute();
            $orderId = $this->db->lastInsertId();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when saving order');
            $this->registry['logger']->lwrite($e->getMessage()); 
            $orderId=0;
        }  
        $sqlInsert->closeCursor();
        if ($orderId)
            $this->saveOrderedGoods($orderId);
        return $orderId;
    }    
    
    function saveOrderedGoods($orderId) {
        $sqlInsert = $this->db->prepare('INSERT INTO `orders-goods`(sizeId, quantity, price, orderId) VALUES(:sizeId, :quantity, :price, :orderId)');
        $sqlInsert->bindParam(':orderId', $orderId);
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['goods'][$cartItem->goodId];
            $size = $good->sizes[$cartItem->sizeId];
            $price = $size->getPrice($good->sale) * $cartItem->quantity;
            $sqlInsert->bindParam(':sizeId', $cartItem->sizeId);
            $sqlInsert->bindParam(':quantity', $cartItem->quantity);
            $sqlInsert->bindParam(':price', $price);
            try{
                $sqlInsert->execute();
            } catch (Exception $e) {
                $this->registry['logger']->lwrite('Error when saving ordered goods');
                $this->registry['logger']->lwrite($e->getMessage()); 
            }
            $sqlInsert->closeCursor();
        }    
    }    
}

