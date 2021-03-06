<?php

Class Model {
    
    private $registry;
    private $db;
    
    private $selectId = "SELECT id FROM users "
            . "WHERE ip=:ip AND useragent=:userAgent";
    private $selectProfile = "SELECT p.* FROM profiles p, users u WHERE u.id = :userId AND u.profile = p.id";
    private $addUser = "INSERT INTO users (ip, useragent)"
            . "VALUES(:ip, :userAgent)";
    private $addVisit = "INSERT INTO visits (userid, pageid, time, good, url)"
            . "VALUES(:userId, :pageId, :time, :goodId, :url)";
    private $lastVisit = "SELECT MAX(time) FROM visits "
            . "WHERE userid=:userId";
    private $profileExists = "SELECT p.id FROM profiles p, users u "
            . "WHERE p.id = u.profile AND u.id = :userId";
    private $createProfile = "INSERT INTO profiles(name, email, client, password, spam, phone, salt, birthday) "
            . "VALUES(:userName, :userEmail, :isClient, :userPassword, :spam, :phone, :salt, :birthday)";
    private $linkProfile = "UPDATE users SET profile = :profileId "
            . "WHERE id = :userId";
    private $updateProfile = "UPDATE profiles "
            . "SET name = :userName, email = :userEmail, client = :isClient, spam=:spam, phone=:phone, birthday = :birthday "
            . "WHERE id = (SELECT profile FROM users WHERE id = :userId)"; 
    private $emailExists = "SELECT count(*) FROM profiles "
            . "WHERE email = :userEmail AND name IS NOT NULL";
    private $checkUser = "SELECT count(*) FROM profiles "
            . "WHERE email = :userEmail AND password = :userPassword";
    private $selectProfileEmail = "SELECT * FROM profiles "
            . "WHERE email = :userEmail";
    private $getAllNews = "SELECT * FROM news WHERE action=:action ORDER BY time DESC";
    private $getNonClientNews = "SELECT * FROM news WHERE forClients=0 AND action=:action ORDER BY time DESC";
    private $addQuestion = "INSERT INTO questions(user, question, date) VALUES(:userId, :question, NOW())";
    private $selectCatalog = "SELECT id, name FROM ";
    private $updateGood = "UPDATE goods SET name=:name, description=:description, shortdesc=:shortdesc, firmId=:firmId, sale=:sale, howTo=:howTo, madeOf=:madeOf, problem=:problem, bestbefore=:bestbefore, precaution=:precaution, hidden=:hidden, popular=:popular WHERE id=:id";
    private $addGood = "INSERT INTO goods (name, description, shortdesc, firmId, sale, howTo, madeOf, problem, bestbefore, precaution, hidden, popular) VALUES (:name, :description, :shortdesc, :firmId, :sale, :howTo, :madeOf, :problem, :bestbefore, :precaution, :hidden, :popular)";
    private $linkGoodCat = "INSERT INTO `goods-categories` (goodId, categoryId) VALUES(:goodId, :catId)";
    private $linkGoodType = "INSERT INTO `goods-types` (goodId, typeId) VALUES(:goodId, :typeId)";
    private $linkGoodEff = "INSERT INTO `goods-effects` (goodId, effectId) VALUES(:goodId, :effId)";
    private $linkGoodProblem = "INSERT INTO `goods-problems` (goodId, problemId) VALUES(:goodId, :probId)";
    private $linkGoodST = "INSERT INTO `goods-skintypes` (goodId, skintypeId) VALUES(:goodId, :skintypeId)";
    private $linkGoodHT = "INSERT INTO `goods-hairtypes` (goodId, hairtypeId) VALUES(:goodId, :hairtypeId)";
    private $updateNews = "UPDATE news SET header=:header, text=:text, time=:time, forClients=:forClients, banner=:banner, end=:end, bannerlink=:bannerlink, action=:action WHERE id=:id";
    private $addNews = "INSERT INTO news (header, text, time, forClients, banner, end, bannerlink, action) VALUES (:header, :text, :time, :forClients, :banner, :end, :bannerlink, :action)";
    private $updateBlog = "UPDATE blogentries SET name=:name, text=:text, date=:date, author=:author, url=:url WHERE id=:id";
    private $addBlog = "INSERT INTO blogentries (name, text, date, author, url) VALUES (:name, :text, :date, :author, :url)";
    public $default = "cccccccccc";
    private $selectPopularGoods = "SELECT DISTINCT id FROM (SELECT id FROM goods WHERE popular=1 ORDER BY RAND() LIMIT 3) manual UNION SELECT tab.good AS id FROM (SELECT v.good, COUNT(DISTINCT v.id) FROM visits v JOIN `goods-sizes` gs ON v.good=gs.goodid JOIN warehouse w ON w.psid = gs.id JOIN goods g ON v.good=g.id WHERE v.pageid=30 AND v.good IS NOT NULL AND w.instock > w.onhold AND v.time >=DATE_SUB(curdate(), INTERVAL 1 MONTH) AND g.hidden=0 AND gs.hidden=0 GROUP BY 1 ORDER BY 2 DESC) tab LIMIT 8";
    
    function __construct($registry) {
        $this->registry = $registry;
        $this->db = new PDO('mysql:host=localhost;dbname='.$this->registry['dbname'].';charset=utf8', $this->registry['dbuser'], $this->registry['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    private function confirmPassword($hash, $salt, $password)
    {
        return $this->hashPassword($salt, $password) == $hash;
    }
 
    private function hashPassword($salt, $password)
    {
        return md5($salt . $password);
    }

    private function generateSalt()
    {
        return substr(md5(uniqid('some_prefix', true)), 1, 10);
    }
    
    private function executeQuery($query, $error) {
        try {
            $query->execute();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite($error);
            $this->registry['logger']->lwrite($e.getMessage);
        }
    }
    
    //Gets userId from DB or creates a new one if not exists
    function getUser() {
        $user = $_SESSION['user'];
        $userId = $user->id;
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            $ip = end(array_values(array_filter(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']))));
        }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
            $ip = $_SERVER["REMOTE_ADDR"]; 
        }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            $ip = $_SERVER["HTTP_CLIENT_IP"]; 
        }
        $ip=trim($ip);
        $agent = trim($_SERVER['HTTP_USER_AGENT']);

        //If userId is not set we're trying to get User ID from DB by his ip and agent
        if (!$userId) {
            $sqlSelect = $this->db->prepare($this->selectId);
            $sqlSelect->bindParam(':ip', $ip);
            $sqlSelect->bindParam(':userAgent', $agent);

            $this->executeQuery($sqlSelect, 'Error when getting userId from DB');
            $userId = $sqlSelect->fetchColumn();
            $sqlSelect->closeCursor();
        } else {
            //If user identified by cookies we update his ip and useragent
            if (is_numeric($userId)) {
                $sqlUpdate = $this->db->prepare('UPDATE users SET ip=:ip,useragent=:agent WHERE id=:id');
            } else {
                $sqlUpdate = $this->db->prepare('UPDATE users SET ip=:ip,useragent=:agent WHERE uuid=:id');
            }    
            $sqlUpdate->bindParam(':id', $userId);
            $sqlUpdate->bindParam(':ip', $ip);
            $sqlUpdate->bindParam(':agent', $agent);
            $this->executeQuery($sqlUpdate, 'Error when updating ip and useragent for userId='.$userId.' to ip='.$ip.' and agent='.$agent);
            $sqlUpdate->closeCursor();
        }
        //If user doesn't exist in DB we create it in Users table
        if (!$userId) {
            $this->registry['logger']->lwrite('Unable to find user by ip and agent');
            $this->registry['logger']->lwrite($ip);
            $this->registry['logger']->lwrite($agent);
            $sqlInsert = $this->db->prepare($this->addUser);
            $sqlInsert->bindParam(':ip', $ip);
            $sqlInsert->bindParam(':userAgent', $agent);
            $this->executeQuery($sqlInsert, 'Error when inserting new user to DB');
            $userId = $this->db->lastInsertId();
            $sqlInsert->closeCursor();
        //If user exists we're getting his info from Profiles table    
        }else{
            if (is_numeric($userId)) {
                $sqlSelect = $this->db->prepare("SELECT p.* FROM profiles p, users u WHERE u.id = :userId AND u.profile = p.id");
            } else {
                $sqlSelect = $this->db->prepare("SELECT p.* FROM profiles p, users u WHERE u.uuid = :userId AND u.profile = p.id");
            }
            $sqlSelect->bindParam(':userId', $userId);
            $this->executeQuery($sqlSelect, 'Error when selecting user properties from DB');
            $data = $sqlSelect->fetch();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->client = $data['client'];
            $user->password = $this->default;
            $user->spam = $data['spam'];
            $user->phone = $data['phone'];
            $user->bonus = $data['bonus'];
            $user->birthday = $data['birthday'];
            $sqlSelect->closeCursor();
        }
        if (!is_numeric($userId)) {
            $user->id = $this->getId($userId);
        } else {
            $user->id = $userId;
        }    
        $this->registry->remove('user');
        $this->registry->set('user', $user);
        if (is_numeric($userId)) {
            $userId = $this->getUUID($userId);
        }
        setcookie('user', $userId, 60*24*60*60+time(), "/");
    }
    
    function getUUID($userId) {
        $sqlSelect = $this->db->prepare("SELECT uuid FROM users WHERE id=:id");
        $sqlSelect->bindParam(':id', $userId);
        $this->executeQuery($sqlSelect, 'Error when selecting uuid from DB');
        $uuid = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($uuid) {
            return $uuid;
        } else {
            $uuid = uniqid('', true);
            $sqlUpdate = $this->db->prepare("UPDATE users SET uuid=:uuid WHERE id=:id");
            $sqlUpdate->bindParam(':id', $userId);
            $sqlUpdate->bindParam(':uuid', $uuid);
            $this->executeQuery($sqlUpdate, 'Error when setting uuid');
            $sqlUpdate->closeCursor();
            return $uuid;
        }
    }
    
    function getId($uuid) {
        $sqlSelect = $this->db->prepare("SELECT id FROM users WHERE uuid=:id");
        $sqlSelect->bindParam(':id', $uuid);
        $this->executeQuery($sqlSelect, 'Error when selecting id from DB');
        $id = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $id;
    }

    //Gets user's last visit from DB
    function getLastVisit() {
        $sqlLastVisit = $this->db->prepare($this->lastVisit);
        $sqlLastVisit->bindParam(':userId', $_SESSION['user']->id);
        $this->executeQuery($sqlLastVisit, 'Error when getting last visit from DB');
        $visit = $sqlLastVisit->fetchColumn();
        $sqlLastVisit->closeCursor();
        return $visit;
    }
    
    //Adds a record about visit
    function logVisit($pageId, $goodId=false, $url=false) {
        $time = date("Y-m-d H:i:s");
        $sqlLog = $this->db->prepare($this->addVisit);
        $sqlLog->bindParam(':userId', $_SESSION['user']->id);
        $sqlLog->bindParam(':pageId', $pageId);
        $sqlLog->bindParam(':time', $time); 
        if ($goodId) {
            $sqlLog->bindParam(':goodId', $goodId);
        } else {
            $sqlLog->bindValue(':goodId', null, PDO::PARAM_INT);
        }
        if ($url) {
            $sqlLog->bindParam(':url', urldecode($url));
        } else {
            $sqlLog->bindValue(':url', null, PDO::PARAM_INT);
        }
        $this->executeQuery($sqlLog, 'Error when logging a visit to DB');
        $sqlLog->closeCursor();
    }
    
    //Checks if profile exists for the user
    function checkProfile() {
        $sqlSelect = $this->db->prepare($this->profileExists);
        $sqlSelect->bindParam(':userId', $_SESSION['user']->id);
        $this->executeQuery($sqlSelect, 'Error when checking profile existence');
        $id = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();        
        if ($id) {
            return $id;
        }
        return 0;
    }
    
    //Updates user profile
    function updateUser($user) {
        //If profile doesn't exist then we create it and link to user
        if (!$this->checkProfile()) {
            $sqlCreate = $this->db->prepare($this->createProfile);
            $sqlCreate->bindParam(':userName', $user->name);
            $sqlCreate->bindParam(':userEmail', $user->email);
            if (!$user->client){
                $user->client = 0;
            }
            $sqlCreate->bindParam(':isClient', $user->client, PDO::PARAM_INT);
            $salt = $this->generateSalt();
            $password = $this->hashPassword($salt, $user->password);
            $sqlCreate->bindParam(':userPassword', $password);
            $user->password = $this->default;
            $sqlCreate->bindParam(':phone', $user->phone);
            $sqlCreate->bindParam(':salt', $salt);
            $sqlCreate->bindParam(':birthday', $user->birthday);
            if (!$user->spam){
                $user->spam = 0;
            }
            $sqlCreate->bindParam(':spam', $user->spam, PDO::PARAM_INT);
            $this->executeQuery($sqlCreate, 'Error when creating profile in DB');
            $profileId = $this->db->lastInsertId();
            $sqlCreate->closeCursor();
            $sqlLink = $this->db->prepare($this->linkProfile);
            $sqlLink->bindParam(":userId", $user->id);
            $sqlLink->bindParam(":profileId", $profileId);
            $this->executeQuery($sqlLink, 'Error when linking user to profile in DB');
            $sqlLink->closeCursor();   
        //Otherwise we just update the profile    
        } else {    
            $sqlUpdate = $this->db->prepare($this->updateProfile);
            $sqlUpdate->bindParam(':userName', $user->name);
            $sqlUpdate->bindParam(':userEmail', $user->email);
            $sqlUpdate->bindParam(':isClient', $user->client, PDO::PARAM_INT);
            $sqlUpdate->bindParam(':spam', $user->spam, PDO::PARAM_INT);
            $sqlUpdate->bindParam(':phone', $user->phone);
            $sqlUpdate->bindParam(':userId', $user->id);
            $this->registry['logger']->lwrite("Birthday is " . $user->birthday);
            $sqlUpdate->bindParam(':birthday', $user->birthday);
            $this->executeQuery($sqlUpdate, 'Error when updating user in DB');
            $sqlUpdate->closeCursor();
            //If user has changed his password
            if ($user->password != $this->default) {
                $this->setNewPassword($user->id, NULL, $user->password);
                $user->password = $this->default;
            }
        }
        return $user;
    }
    
    function updatePassword($userEmail) {
        $id = $this->getProfile($userEmail)['id'];
        $password = substr(md5(uniqid('some_prefix', true)), 1, 5);
        $this->registry['logger']->lwrite($id . '-' . $password);
        $this->setNewPassword(NULL,$id, $password);
        return $password;
    }
    
    private function setNewPassword($userId, $profileId, $password) {
        if ($userId) {
            $sqlUpdate = $this->db->prepare('UPDATE profiles SET password=:password, salt=:salt WHERE id = (SELECT profile FROM users WHERE id = :userId)');
            $sqlUpdate->bindParam(':userId', $userId);
        } else {
            $sqlUpdate = $this->db->prepare('UPDATE profiles SET password=:password, salt=:salt WHERE id = :userId');
            $sqlUpdate->bindParam(':userId', $profileId);
        }    
        $salt = $this->generateSalt();
        $sqlUpdate->bindParam(':salt', $salt);
        $sqlUpdate->bindParam(':password', $this->hashPassword($salt, $password));
        $this->executeQuery($sqlUpdate, 'Error when updating password for user ' . $userId);
        $sqlUpdate->closeCursor();
    }
    
    function checkEmailExists($userEmail) {
        $sqlSelect = $this->db->prepare($this->emailExists);
        $sqlSelect->bindParam(':userEmail', $userEmail);
        $this->executeQuery($sqlSelect, 'Error when checking email existence');
        $count = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($count > 0) {
            return true;
        }
        return false;
    }
    
    private function getProfile($email) {
        $sqlSelect = $this->db->prepare($this->selectProfileEmail);
        $sqlSelect->bindParam(":userEmail", $email);
        $this->executeQuery($sqlSelect, 'Error when selecting profile by email: ' . $email);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        return $data;
    }
    
    function login($user) {
        $data = $this->getProfile($user->email);
        $user->name = $data['name'];
        $user->client = $data['client'];
        $user->spam = $data['spam'];
        $user->phone = $data['phone'];
        $user->birthday = $data['birthday'];
        $user->password = $this->default;
        $sqlLink = $this->db->prepare($this->linkProfile);
        $sqlLink->bindParam(":userId", $user->id);
        $sqlLink->bindParam(":profileId", $data['id']);
        $this->executeQuery($sqlLink, 'Error when linking user to profile');
        $sqlLink->closeCursor();
        return $user;
    }
    
    function checkUser($userEmail, $userPassword) {
        $sqlSelect = $this->db->prepare('SELECT password, salt FROM profiles WHERE email=:userEmail');
        $sqlSelect->bindParam(':userEmail', $userEmail);
        $this->executeQuery($sqlSelect, 'Error when checking user existance');
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        if ($data) {
            if($this->confirmPassword($data['password'], $data['salt'], $userPassword)){
                return true;
            }
        }
        return false;
    }
    
    function getNews($action) {
        if ($this->registry['isClient']) {
            $sqlSelect = $this->db->prepare($this->getAllNews);
        } else {
            $sqlSelect = $this->db->prepare($this->getNonClientNews);
        }
        $sqlSelect->bindValue (':action', $action);
        $this->executeQuery($sqlSelect, 'Error when getting news from DB');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $news = new News($data['id'], $data['header'], $data['time'], $data['text'], $data['forClients'], $data['banner'], $data['end'], $data['bannerlink'], $data['action']);
            if (!$newsArray) {
                $newsArray = [$news];
            } else {
                array_push($newsArray, $news);
            }
        }
        $sqlSelect->closeCursor();
        return $newsArray;
    }
    
    function getNewsItem($newsId) {
        $sqlSelect = $this->db->prepare('SELECT * FROM news WHERE id=:newsId');
        $sqlSelect->bindParam(':newsId', $newsId);
        $this->executeQuery($sqlSelect, 'Error when getting news with id=' . $newsId);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        return new News($data['id'], $data['header'], $data['time'], $data['text'], $data['forClients'], $data['banner'], $data['end'], $data['bannerlink'], $data['action']);
    }    
    
    function addQuestion($userId, $question) {
        $sqlSelect = $this->db->prepare($this->addQuestion);
        $sqlSelect->bindParam(':userId', $userId);
        $sqlSelect->bindParam(':question', $question); 
        $this->executeQuery($sqlSelect, 'Error when adding a question');
        $sqlSelect->closeCursor();
    }
    
    function getCatalog($catName) {
        $sqlSelect = $this->db->prepare($this->selectCatalog . $catName);
        $this->executeQuery($sqlSelect, 'Error when getting ' . $catName);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $catsArray[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor(); 
        return $this->prepareArray($catsArray);       
    }
    
    private function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    
    private function prepareArray($array) {
        $preparedArray = $array;
        foreach($preparedArray as $key=>$value){
            if ($this->startsWith($value, "Все") or $this->startsWith($value, "Прочее")) {
                $keyAll = $key;
                $valueAll = $value;
                unset($preparedArray[$key]);
            }    
        }
        asort($preparedArray);
        if (isset($keyAll)) {
            $preparedArray[$keyAll] = $valueAll;
        }
        return $preparedArray;
    }
    
    function addGood($id, $name, $description, $shortdesc, $firmId, $sale, $madeOf, $howTo, $problem, $bestbefore, $precaution, $hidden, $popular) {
        if ($id) {
            $sqlInsert = $this->db->prepare($this->updateGood);
            $sqlInsert->bindParam(':id', $id);
        } else {
            $sqlInsert = $this->db->prepare($this->addGood);
        }
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':description', $description);
        $sqlInsert->bindParam(':shortdesc', $shortdesc);
        if ($firmId == 0) {
            $sqlInsert->bindValue(':firmId', null, PDO::PARAM_INT);
        } else {
            $sqlInsert->bindParam(':firmId', $firmId);
        }
        $sqlInsert->bindParam(':sale', $sale);
        $sqlInsert->bindParam(':howTo', $howTo);
        $sqlInsert->bindParam(':madeOf', $madeOf);
        $sqlInsert->bindParam(':problem', $problem);
        $sqlInsert->bindParam(':bestbefore', $bestbefore);
        $sqlInsert->bindParam(':precaution', $precaution);
        $sqlInsert->bindParam(':hidden', $hidden);
        $sqlInsert->bindParam(':popular', $popular);
        $this->executeQuery($sqlInsert, 'Error when adding/updating a good');
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
        $this->executeQuery($sqlInsert, 'Error when linking good '.$goodId.' and type '.$typeId);
        $sqlInsert->closeCursor();
    }    
    
    function linkGoodCat($goodId, $catId) {
        $sqlInsert = $this->db->prepare($this->linkGoodCat);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':catId', $catId);
        $this->executeQuery($sqlInsert, 'Error when linking good ' . $goodId . ' and category ' . $catId);
        $sqlInsert->closeCursor();
    }
        
    function linkGoodEff($goodId, $effId) {
        $sqlInsert = $this->db->prepare($this->linkGoodEff);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':effId', $effId);
        $this->executeQuery($sqlInsert, 'Error when linking good ' . $goodId . ' and effect ' . $effId);
        $sqlInsert->closeCursor();
    }
    
    function linkGoodProblem($goodId, $probId) {
        $sqlInsert = $this->db->prepare($this->linkGoodProblem);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':probId', $probId);
        $this->executeQuery($sqlInsert, 'Error when linking good ' . $goodId . ' and problem ' . $probId);
        $sqlInsert->closeCursor();
    }    

    function linkGoodST($goodId, $skintypeId) {
        $sqlInsert = $this->db->prepare($this->linkGoodST);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':skintypeId', $skintypeId);
        $this->executeQuery($sqlInsert, 'Error when linking good ' . $goodId . ' and skintype ' . $skintypeId);
        $sqlInsert->closeCursor();
    }

    function linkGoodHT($goodId, $hairtypeId) {
        $sqlInsert = $this->db->prepare($this->linkGoodHT);
        $sqlInsert->bindParam(':goodId', $goodId);
        $sqlInsert->bindParam(':hairtypeId', $hairtypeId);
        $this->executeQuery($sqlInsert, 'Error when linking good ' . $goodId . ' and hairtype ' . $hairtypeId);
        $sqlInsert->closeCursor();
    }
    
    function getGood($goodId) {
        $sqlSelect = $this->db->prepare("SELECT * FROM goods WHERE id=:goodId");
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when getting a product: ' . $goodId);
        if ($sqlSelect->rowCount() > 0) {
            $data = $sqlSelect->fetch();
            $sqlSelect->closeCursor(); 
            //Admin should see all goods
//            if ($this->registry['isadmin']) {
//                $hidden = 0;
//            } else {
                $hidden = $data['hidden'];
//            }
            $good=new Good($data['id'], trim($data['name']), trim($data['description']), trim($data['shortdesc']), trim($data['howTo']), trim($data['madeOf']), $data['sale'], $data['firmId'], trim($data['problem']), trim($data['bestbefore']), trim($data['precaution']), trim($data['url']), $hidden, $data['popular']);
            $good->cats = $this->getGoodCats($goodId);
            $good->supercats = $this->getGoodSuperCats($good);
            $good->effs = $this->getGoodEffs($goodId);
            $good->skintypes = $this->getGoodSTs($goodId);
            $good->hairtypes = $this->getGoodHTs($goodId);
            $good->sizes = $this->getGoodSizes($goodId);
            $good->types = $this->getGoodTypes($goodId);
            $good->problems = $this->getGoodProblems($goodId);
            $good->rating = $this->getGoodRating($goodId);
            return $good;
        } else {
            $sqlSelect->closeCursor(); 
            return NULL;
        }    
    }
    
    function getGoodSuperCats($good) {
        $supercats = array();
        foreach ($good->cats as $cat) {
            $supercat = $this->getSuperCatByCat($cat);
            $supercats[$supercat['id']] = $supercat['name'];
        }
        return $supercats;
    }
    
    function getSuperCatByCat($catId) {
        $sqlSelect = $this->db->prepare('SELECT sc.* FROM supercats sc, categories c WHERE c.supercatid=sc.id and c.id=:catId');
        $sqlSelect->bindParam(':catId', $catId);
        $this->executeQuery($sqlSelect, 'Error when getting supercat for cat id=' . $catId);
        $data = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        $sqlSelect->closeCursor();
        return $data;
    }
    
    function getGoodTypes($goodId) {
        $sqlSelect = $this->db->prepare('SELECT t.id, t.name FROM types t, `goods-types` gt WHERE t.id=gt.typeId AND gt.goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting types for product ' . $goodId);
        $types = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $types[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor();
        return $types;        
    }
    
    function getGoodSizes($goodId) {
        $sqlSelect = $this->db->prepare('SELECT gs.id, gs.size, w.price, w.instock, w.onhold, w.bestbefore, w.bbprice, gs.code, gs.sale FROM `goods-sizes` gs LEFT JOIN warehouse w ON gs.Id=w.psId WHERE gs.goodId=:goodId AND gs.hidden=0 ORDER BY w.price');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting sizes for product ' . $goodId);
        $sizes = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $size = new Size($data['id'], $data['size'], $data['price'], $data['sale'], $data['code'], $data['instock'], $data['onhold'], $data['bestbefore'], $data['bbprice']);
            $sizes[$data['id']]=$size;
        }
        $sqlSelect->closeCursor();
        return $sizes;
    }
    
    function getGoodCats($goodId) {
        $sqlSelect = $this->db->prepare('SELECT categoryId FROM `goods-categories` WHERE goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting categories for product ' . $goodId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['categoryId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getGoodEffs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT effectId FROM `goods-effects` WHERE goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting effects for product ' . $goodId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['effectId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }

    function getGoodProblems($goodId) {
        $sqlSelect = $this->db->prepare('SELECT problemId FROM `goods-problems` WHERE goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting problems for product ' . $goodId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['problemId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getGoodSTs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT skintypeId FROM `goods-skintypes` WHERE goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting skintypes for product ' . $goodId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['skintypeId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }

    function getGoodHTs($goodId) {
        $sqlSelect = $this->db->prepare('SELECT hairtypeId FROM `goods-hairtypes` WHERE goodId=:goodId');
        $sqlSelect->bindParam(':goodId', $goodId);
        $this->executeQuery($sqlSelect, 'Error when selecting hairtypes for product ' . $goodId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            array_push($catsArray, $data['hairtypeId']);
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function deleteGoodCat($goodId) {
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-types` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-categories` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-effects` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-hairtypes` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-skintypes` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete = $this->db->prepare('DELETE FROM `goods-problems` WHERE goodId=:goodId');
        $sqlDelete->execute(array(':goodId' => $goodId));
        $sqlDelete->closeCursor();
    }
    
    function getFirm($firmId) {
        $sqlSelect = $this->db->prepare('SELECT * FROM firms WHERE id=:firmId');
        $sqlSelect->bindParam(':firmId', $firmId);
        $this->executeQuery($sqlSelect, 'Error when getting a firm with id=' . $firmId);
        $data = $sqlSelect->fetch();
        if ($data) {
            $firm = new Firm($firmId, $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], $data['descAfter'], $data['h1']);
            $firm->goods = $this->getGoodsByFirm($firmId);
            $firm->categories = $this->prepareArray($this->getFirmCats($firmId));
        }    
        $sqlSelect->closeCursor();
        return $firm;
    }
    
    function getGoodsByFirm($firmId) {
        $sqlSelect = $this->db->prepare('SELECT id FROM goods WHERE firmId=:firmId');
        $sqlSelect->bindParam(':firmId', $firmId);
        $this->executeQuery($sqlSelect, 'Error when getting goods of firm with id=' . $firmId);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            if (!isset($goods)) {
                $goods = [$good];
            } else {
                array_push($goods, $good);
            }
        }
        $sqlSelect->closeCursor();
        return $goods;
    }
    
    function getFirmCats($firmId) {
        $sqlSelect = $this->db->prepare('SELECT DISTINCT cat.id, cat.name FROM categories cat, `goods-categories` gc, goods g WHERE cat.id=gc.categoryid AND gc.goodId=g.id and g.firmId=:firmId');
        $sqlSelect->bindParam(':firmId', $firmId);
        $this->executeQuery($sqlSelect, 'Error when getting categories of firm with id=' . $firmId);
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $catsArray[$data['id']]=$data['name'];
        }
        $sqlSelect->closeCursor();
        return $catsArray;
    }
    
    function getAllGoods() {
        $sqlSelect = $this->db->prepare('SELECT id FROM goods');
        $this->executeQuery($sqlSelect, 'Error when getting all goods');
        $goods=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            $goods[$data['id']]=$good;
        }
        $sqlSelect->closeCursor();
        return $goods;        
    }
    
    function addGoodSize($goodId, $gsId, $size, $price, $code, $instock, $sale, $bbsize, $bbprice) {
        if (!$code) {
            $code = null;
        }
        if ($gsId) {
            $sqlQuery = $this->db->prepare('UPDATE `goods-sizes` SET goodId=:goodId, size=:size, code=:code, sale=:sale WHERE id=:gsId');
            $sqlQuery->bindParam(':gsId', $gsId);
        } else {
            $sqlQuery = $this->db->prepare('INSERT INTO `goods-sizes`(goodId, size, code, sale) VALUES(:goodId,:size,:code,:sale)');
        }
        $sqlQuery->bindParam(':goodId', $goodId);
        $sqlQuery->bindParam(':size', $size);
        $sqlQuery->bindParam(':code', $code);
        $sqlQuery->bindParam(':sale', $sale);
        $this->executeQuery($sqlQuery, 'Error when updating/inserting size ' . $size .' for good '.$goodId);
        if (!$gsId) {
            $gsId = $this->db->lastInsertId();
        }
        $sqlQuery->closeCursor();
        $sqlSelect = $this->db->prepare('SELECT id FROM warehouse WHERE psId=:gsId');
        $sqlSelect->bindParam(':gsId', $gsId);
        $sqlSelect->execute();
        $warId = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($warId) {
            $sqlQuery2 = $this->db->prepare('UPDATE warehouse SET price=:price, instock=:instock, bestbefore=:bbsize, bbprice=:bbprice WHERE psId=:gsId');
        } else {
            $sqlQuery2 = $this->db->prepare('INSERT INTO warehouse(psId, price, instock, bestbefore, bbprice) VALUES (:gsId, :price, :instock, :bbsize, :bbprice)');
        }
        $sqlQuery2->bindParam(':gsId', $gsId);
        $sqlQuery2->bindParam(':price', $price);
        $sqlQuery2->bindParam(':instock', $instock);
        if ($bbsize) {
            $sqlQuery2->bindParam(':bbsize', $bbsize);
        } else {
            $sqlQuery2->bindValue(':bbsize', null, PDO::PARAM_INT);
        }
        $sqlQuery2->bindParam(':bbprice', $bbprice);
        
        $this->executeQuery($sqlQuery2, 'Error when updating/inserting warehouse data for goodsize '.$gsId);
        $sqlQuery2->closeCursor();
    }
    
    function getBranches() {
        $sqlSelect = $this->db->prepare('SELECT * FROM branches');
        $this->executeQuery($sqlSelect, 'Error when getting branches');
        $catsArray=array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $branch = New Branch($data['id'], $data['address'], $data['open'], $data['card'], $data['map']);
            $catsArray[$data['id']] = $branch;
        }
        $sqlSelect->closeCursor(); 
        return $catsArray;       
    }
    
    function saveOrder($userId, $name, $email, $phone, $branch, $takeDate, $takeTime, $address, $promo, $bonus, $paymentCard, $remarks, $goods) {
        $sqlInsert = $this->db->prepare('INSERT INTO orders(userId, name, email, phone, date, branchId, day, time, address, promoid, profileId, bonus, card, remarks) VALUES(:userId, :name, :email, :phone, :date, :branch, :takeDate, :takeTime, :address, :promo, :profileId, :bonus, :card, :remarks)');
        $sqlInsert->bindParam(':userId', $userId);
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':email', $email);
        $sqlInsert->bindParam(':phone', $phone);
        if ($branch) {
            $sqlInsert->bindParam(':branch', $branch);
        } else {
            $sqlInsert->bindValue(':branch', null, PDO::PARAM_INT);
        }
        $sqlInsert->bindParam(':takeDate', $takeDate);
        $sqlInsert->bindParam(':takeTime', $takeTime);
        $sqlInsert->bindParam(':address', $address);
        $promoId = $this->getPromoId(trim($promo));
        if ($promoId) {
            $sqlInsert->bindParam(':promo', $promoId);
        } else {
            $sqlInsert->bindValue(':promo', null, PDO::PARAM_INT);
        }
        $profile = $this->checkProfile();
        if ($profile == 0) {
            $sqlInsert->bindValue(':profileId', null, PDO::PARAM_INT);
        } else {
            $sqlInsert->bindParam(':profileId', $profile);
        }
        $sqlInsert->bindParam(':date',  date('Y-m-d H:i:s', time()));
        if (!$bonus) {
            $bonus = 0;
        }
        $sqlInsert->bindParam(':bonus', $bonus);
        $sqlInsert->bindParam(':card', $paymentCard);
        $sqlInsert->bindParam(':remarks', $remarks);
        $this->executeQuery($sqlInsert, 'Error when saving order');
        try{
            $orderId = $this->db->lastInsertId();
        } catch (Exception $e) {
            $this->registry['logger']->lwrite('Error when getting new order ID');
            $this->registry['logger']->lwrite($e);
            $orderId=0;
        }  
        $sqlInsert->closeCursor();
        if ($orderId) {
            $this->saveOrderedGoods($orderId, $goods);
        }
        return $orderId;
    }    
    
    function saveOrderedGoods($orderId, $cart) {
        $sqlInsert = $this->db->prepare('INSERT INTO `orders-goods`(sizeId, quantity, price, orderId, sale) VALUES(:sizeId, :quantity, :price, :orderId, :sale)');
        $sqlInsert->bindParam(':orderId', $orderId);
        foreach ($cart as $cartItem) {
            $sqlInsert->bindParam(':sizeId', $cartItem->sizeId);
            $sqlInsert->bindParam(':quantity', $cartItem->quantity);
            $sqlInsert->bindParam(':price', $cartItem->price);
            $sqlInsert->bindParam(':sale', $cartItem->sale);
            $this->executeQuery($sqlInsert, 'Error when saving ordered goods');
            $sqlInsert->closeCursor();
        }    
    }  
    
    function getTypeFirms($typeId) {
        $sqlSelect = $this->db->prepare('SELECT distinct g.firmId FROM  goods g, `goods-types` gt WHERE g.id = gt.goodId AND gt.typeId=:typeId');
        $sqlSelect->bindParam(':typeId', $typeId);
        $this->executeQuery($sqlSelect, 'Error when getting firms of type ' . $typeId);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($firms)) {
                $firms = [$data['firmId']];
            } else {
                array_push($firms, $data['firmId']);
            }
        }        
        $sqlSelect->closeCursor();
        return $firms;
    }   
       
    function addNews($id, $header, $text, $time, $forClients, $banner, $end, $bannerlink, $action) {
        if ($id) {
            $sqlInsert = $this->db->prepare($this->updateNews);
            $sqlInsert->bindParam(':id', $id);
        } else {
            $sqlInsert = $this->db->prepare($this->addNews);
        }
        $sqlInsert->bindParam(':header', $header);
        $sqlInsert->bindParam(':text', $text);
        $sqlInsert->bindParam(':time', $time);
        $sqlInsert->bindParam(':forClients', $forClients);
        $sqlInsert->bindParam(':banner', $banner);
        if ($end) {
            $sqlInsert->bindParam(':end', $end);
        } else {
            $sqlInsert->bindValue(':end', null, PDO::PARAM_INT);
        }
        $sqlInsert->bindParam(':bannerlink', $bannerlink);
        $sqlInsert->bindParam(':action', $action);
        $this->executeQuery($sqlInsert, 'Error when adding/updating a news record');
        if ($id) {
            $newsId=$id;
        } else {
            $newsId = $this->db->lastInsertId();
        }
        $sqlInsert->closeCursor();
        return $newsId;
    }
    
    function getPromoId($promo) {
        if ($promo) {
            $sqlSelect = $this->db->prepare('SELECT id FROM promos WHERE name=:name');
            $sqlSelect->bindParam(':name', strtolower($promo));
            $this->executeQuery($sqlSelect, 'Error when getting promo id');
            $promoId = $sqlSelect->fetchColumn();
            $sqlSelect->closeCursor();
            return $promoId;
        } else {
            return 0;
        }    
    }    
    
    private function getUserPromos($promoId, $userId) {
        $sqlSelect = $this->db->prepare('SELECT count(*) FROM orders WHERE userId=:userId AND promoId=:promoId');
        $sqlSelect->bindParam(':userId', $userId);
        $sqlSelect->bindParam(':promoId', $promoId);
        $this->executeQuery($sqlSelect, 'Error when getting orders for user '. $userId . ' with promo ' . $promoId);
        $userPromoOrders = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $userPromoOrders;
    }    
    
    private function getPromoCount($promoId) {
        $sqlSelect = $this->db->prepare('SELECT count FROM promos WHERE id=:promoId');
        $sqlSelect->bindParam(':promoId', $promoId);
        $this->executeQuery($sqlSelect, 'Error when getting count for promo ' . $promoId);
        $promoCount = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor(); 
        return $promoCount;
    }
    
    public function getPromoAmount($promoId) {
        $sqlSelect = $this->db->prepare('SELECT amount, percent FROM promos WHERE id=:promoId');
        $sqlSelect->bindParam(':promoId', $promoId);
        $this->executeQuery($sqlSelect, 'Error when getting amount for promo ' . $promoId);
        $promoAmount = [
            'amount' => 0,
            'percent' => 0
        ];
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor(); 
        $promoAmount['amount'] = $data['amount'];
        $promoAmount['percent'] = $data['percent'];
        return $promoAmount;
    }    
    
    private function getProfileUsers($profile) {
        $sqlSelect = $this->db->prepare('SELECT id FROM users WHERE profile=:profile');
        $sqlSelect->bindParam(':profile', $profile);
        $this->executeQuery($sqlSelect, 'Error when getting users for profile ' . $profile);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            if (!$users) {
                $users = [$data['id']];
            } else {
                array_push($users, $data['id']);
            }
        }
        $sqlSelect->closeCursor();
        return $users;
    }
    
    function checkPromo($promo) {
        $promoId = $this->getPromoId($promo);
        if ($promoId) {
            $userId = $_SESSION['user']->id;
            $promoCount = $this->getPromoCount($promoId) - $this->getUserPromos($promoId, $userId);
            $profile = $this->checkProfile();
            if ($profile) {
                $users = $this->getProfileUsers($profile);
                foreach($users as $user) {
                    if ($user <> $userId) {
                        $promoCount = $promoCount - $this->getUserPromos($promoId, $user);
                    }
                }
            }
            if ($promoCount > 0) {
                return $this->getPromoAmount($promoId);
            } else {
                return -1;
            }
        }    
        return 0;
    } 
    
    function getFirms() {
        $sqlSelect = $this->db->prepare('SELECT * FROM firms ORDER BY name');
        $this->executeQuery($sqlSelect, 'Error when getting firms');
        $firms = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $firm = New Firm($data['id'], $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], $data['descAfter'], $data['h1']);
            $firms[$data['id']] = $firm;
        }
        $sqlSelect->closeCursor();
        return $firms;
    }
    
    function getTypes() {
        $sqlSelect = $this->db->prepare('SELECT * FROM types ORDER BY name');
        $this->executeQuery($sqlSelect, 'Error when getting types');
        $types = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $type = New Firm($data['id'], $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], $data['descAfter'], '');
            $types[$data['id']] = $type;
        }
        $sqlSelect->closeCursor();
        return $types;        
    }
    
    function getObjectIdByUrl($object, $url) {
        $sqlSelect = $this->db->prepare('SELECT id FROM '.$object.' WHERE url=:url');
        $sqlSelect->bindParam(':url', $url);
        $this->executeQuery($sqlSelect, 'Error when getting '.$object.' with url='.$url);
        $firmId = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $firmId;
    }
    
    function logout($userId) {
        $sqlUpdate = $this->db->prepare('UPDATE users SET profile=NULL WHERE id=:userId');
        $sqlUpdate->bindParam(':userId', $userId);
        $this->executeQuery($sqlUpdate, 'Error when logging out user '.$userId);
        $sqlUpdate->closeCursor();
    }
    
    function getAllOrders() {
        $sqlSelect = $this->db->prepare('SELECT o.id FROM orders o');
        $this->executeQuery($sqlSelect, 'Error when getting all orders');
        $orders = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $order = $this->getOrder($data['id']);
            array_push($orders, $order);
        }    
        $sqlSelect->closeCursor();
        
        function cmp($a, $b) {
            return $b->id > $a->id;
        }
        //Orders should be sorted by id descendingly
        usort($orders, "cmp");
        return $orders;
    }
    
    function getUserOrders($userId) {
        $sqlSelect = $this->db->prepare('SELECT o.id, o.name, o.date, o.email, o.phone, s.name status, s.description statusdesc, p.name promo, IF (o.branchId=0, "Доставка", "Самовывоз") type, o.remarks, o.address FROM orders o LEFT JOIN statuses s ON o.status = s.id LEFT JOIN promos p ON o.promoId = p.id WHERE o.userId=:userId');
        $sqlSelect->bindParam(':userId', $userId);
        $this->executeQuery($sqlSelect, 'Error when getting orders for user '.$userId);
        $orders = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $order = New Order($data['id'], $data['date'], $data['status'], $data['type'], $data['promo'], $userId, 0, $data['statusdesc'], $data['email'],0, $data['name'], $data['phone'], $data['remarks'], $data['address']);
            array_push($orders, $order);
        }    
        $sqlSelect->closeCursor();
        
        //If a user has profile then we get all orders for it
        $profile = $this->checkProfile();
        if ($profile) {
            $sqlSelect = $this->db->prepare('SELECT o.id, o.name, o.date, o.email, o.phone, s.name status, s.description statusdesc, p.name promo, IF (o.branchId=0, "Доставка", "Самовывоз") type, o.remarks, o.address FROM orders o LEFT JOIN statuses s ON o.status = s.id LEFT JOIN promos p ON o.promoId = p.id WHERE o.profileId=:profileId AND o.userId <> :userId');
            $sqlSelect->bindParam(':userId', $userId);
            $sqlSelect->bindParam(':profileId', $profile);
            $this->executeQuery($sqlSelect, 'Error when getting orders for user '.$userId);
            while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
                $order = New Order($data['id'], $data['date'], $data['status'], $data['type'], $data['promo'], $userId, $profile, $data['statusdesc'], $data['email'], 0, $data['name'], $data['phone'], $data['remarks'], $data['address']);
                array_push($orders, $order);
            }    
            $sqlSelect->closeCursor();
        }
        
        //Orders should be sorted by id descendingly
        usort($orders, "cmp");
        
        return $orders;
    }
    
    function getOrder($orderId) {
        $sqlSelect = $this->db->prepare('SELECT o.id, o.name, o.date, o.email, o.phone, s.name status, s.description statusdesc, p.name promo, p.amount promoAmount, p.percent promoPercent, IF (o.branchId is null, "Доставка", "Самовывоз") type, o.userId, pr.name profileId, o.bonus, o.remarks, o.address FROM orders o LEFT JOIN statuses s ON o.status = s.id LEFT JOIN promos p ON o.promoId = p.id LEFT JOIN `orders-goods` og ON o.id=og.orderid LEFT JOIN profiles pr ON o.profileId=pr.id WHERE o.id=:orderId');
        $sqlSelect->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlSelect, 'Error when getting details for order '.$orderId);
        $data = $sqlSelect->fetch();
        $order = new Order($data['id'], $data['date'], $data['status'], $data['type'], 0, $data['userId'], $data['profileId'], $data['statusdesc'], $data['email'], $data['bonus'], $data['name'], $data['phone'], $data['remarks'], $data['address']);
        $order->goods = $this->getOrderGoods($orderId);
        //For INSTA promo-code we do not care about sale
        if (strcasecmp($data['promo'], 'INSTA') == 0) {
            $total = $order->getTotal();
        } else {
            $total = $order->getTotalNoSale();
        }
        if ($data['promoAmount']) {
            //If promo amount is more than 30% then it's 30%
            if ($data['promoAmount'] > $total * 0.3) {
                $promo = floor($total * 0.3);
            } else {
                $promo = $data['promoAmount'];
            }
        }
        else if ($data['promoPercent']) {
            $promo = floor($total * $data['promoPercent'] / 100);
        } else {
            $promo = 0;
        }
        $order->promo = $promo;
        $order->total = $order->getTotal() - $promo - $data['bonus'];
        $sqlSelect->closeCursor();
        
        return $order;
    }
    
    function getOrderGoods($orderId) {
        $sqlSelect = $this->db->prepare('SELECT og.quantity, og.price, s.size, s.code, s.id as sizeId, g.`name`, g.id, og.sale FROM `orders-goods` og LEFT JOIN `goods-sizes` s ON og.sizeid=s.id LEFT JOIN goods g ON s.goodId=g.id WHERE og.orderId=:orderId');
        $sqlSelect->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlSelect, 'Error when getting goods for order '.$orderId);
        $goods = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = New Orderedgood($data['id'], $data['name'], $data['size'], $data['price'], $data['quantity'], $data['code'], $data['sale'], $data['sizeId']);
            array_push($goods, $good);
        }    
        $sqlSelect->closeCursor();
        return $goods;
    } 
    
    function updateOrder($orderId, $statusId) {
        $sqlUpdate = $this->db->prepare('UPDATE orders SET status=:statusId WHERE id=:orderId');
        $sqlUpdate->bindParam(':statusId', $statusId);
        $sqlUpdate->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlUpdate, 'Error when setting status '.$statusId.' for order '.$orderId);
        $sqlUpdate->closeCursor();
    }
    
    function updateOrderGoodPrice($orderId, $sizeId, $price) {
        $sqlUpdate = $this->db->prepare('UPDATE `orders-goods` SET price=:price WHERE orderId=:orderId AND sizeId=:sizeId');
        $sqlUpdate->bindParam(':sizeId', $sizeId);
        $sqlUpdate->bindParam(':orderId', $orderId);
        $sqlUpdate->bindParam(':price', $price);
        $this->executeQuery($sqlUpdate, 'Error when updating price for size '.$sizeId.' for order '.$orderId);
        $sqlUpdate->closeCursor();
    }
    
    function updateOrderGoodQuantity($orderId, $sizeId, $quantity) {
        if ($quantity) {
            $sqlUpdate = $this->db->prepare('UPDATE `orders-goods` SET quantity=:quantity WHERE orderId=:orderId AND sizeId=:sizeId');
            $sqlUpdate->bindParam(':sizeId', $sizeId);
            $sqlUpdate->bindParam(':orderId', $orderId);
            $sqlUpdate->bindParam(':quantity', $quantity);
            $this->executeQuery($sqlUpdate, 'Error when updating quantity for size '.$sizeId.' for order '.$orderId);
            $sqlUpdate->closeCursor();
        } else {
            $sqlDelete = $this->db->prepare('DELETE FROM `orders-goods` WHERE orderId=:orderId AND sizeId=:sizeId');
            $sqlDelete->bindParam(':sizeId', $sizeId);
            $sqlDelete->bindParam(':orderId', $orderId);
            $this->executeQuery($sqlDelete, 'Error when deleting size ' . $sizeId . ' from order ' . $orderId);
            $sqlDelete->closeCursor();
        }    
    }

    function getCategory($id) {
        $sqlSelect = $this->db->prepare('SELECT * FROM categories WHERE id=:id');
        $sqlSelect->bindParam(':id', $id);
        $this->executeQuery($sqlSelect, 'Error when getting category with id=' . $id);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        if ($data) {
            $category = new Category($data['id'], $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], $data['supercatid'], $data['descAfter']);
        }
        return $category;
    }
    
    function getCategoryGoods($categoryId) {
        $sqlSelect = $this->db->prepare('SELECT DISTINCT goodid FROM `goods-categories` WHERE categoryId=:categoryId');
        $sqlSelect->bindParam(':categoryId', $categoryId);
        $this->executeQuery($sqlSelect, 'Error when getting goods of category with id=' . $categoryId);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['goodid']);
            if (!isset($goods)) {
                $goods = [$good];
            } else {
                array_push($goods, $good);
            }
        }
        $sqlSelect->closeCursor();
        return $goods;
    }
    
    function getCategories($scId) {
        if ($scId) {
            $sqlSelect = $this->db->prepare('SELECT * FROM categories WHERE supercatid=:scId ORDER BY name');
            $sqlSelect->bindParam(':scId', $scId);
        } else {
            $sqlSelect = $this->db->prepare('SELECT * FROM categories ORDER BY name');
        }

        $this->executeQuery($sqlSelect, 'Error when getting categories');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $category = New Category($data['id'], $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], $data['supercatid'], $data['descAfter']);
            if (!isset($categories)) {
                $categories = [$category];
            } else {
                array_push($categories, $category);
            }
        }   
        $sqlSelect->closeCursor();
        return $categories;
    }
    
    function getSuperCats() {
        $sqlSelect = $this->db->prepare('SELECT * FROM supercats WHERE hidden=0 ORDER BY name');
        $this->executeQuery($sqlSelect, 'Error when getting super cats');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $category = New Category($data['id'], $data['name'], $data['description'], $data['url'], $data['metaTitle'], $data['metaDescription'], $data['metaKeywords'], NULL, $data['descAfter']);
            if (!isset($categories)) {
                $categories = [$category];
            } else {
                array_push($categories, $category);
            }
        }   
        $sqlSelect->closeCursor();
        return $categories;
    }

    function getPopularGoods() {
        $sqlSelect = $this->db->prepare($this->selectPopularGoods);
        $this->executeQuery($sqlSelect, 'Error when getting popular goods');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            if (!isset($goods)) {
                $goods = [$good];
            } else {
                array_push($goods, $good);
            }
        }   
        $sqlSelect->closeCursor();
        return $goods;
    }
    
    function getGoodsByType($typeId) {
        $sqlSelect = $this->db->prepare('SELECT g.id FROM goods g JOIN `goods-types` gt ON g.id=gt.goodid WHERE gt.typeid=:typeId');
        $sqlSelect->bindParam('typeId', $typeId);
        $this->executeQuery($sqlSelect, 'Error when getting goods for type ' . $typeId);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $good = $this->getGood($data['id']);
            if (!isset($goods)) {
                $goods = [$good];
            } else {
                array_push($goods, $good);
            }
        }   
        $sqlSelect->closeCursor();
        return $goods;
    }
    
    function removeNews($newsId) {
        $sqlDelete = $this->db->prepare('DELETE FROM news WHERE id=:newsId');
        $sqlDelete->bindParam(':newsId', $newsId);
        $this->executeQuery($sqlDelete, 'Error when deleting news with id='.$newsId);
        $sqlDelete->closeCursor();
    }
    
    function updateBonus($orderId, $bonus) {
        $sqlSelect = $this->db->prepare('SELECT SUM(price*quantity) FROM `orders-goods` WHERE orderId=:orderId');
        $sqlSelect->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlSelect, 'Error when getting total for order '.$orderId);
        $total = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        $sqlSelect = $this->db->prepare('SELECT o.bonus,COALESCE(p.amount,0) amount, COALESCE(p.percent,0) percent FROM orders o left join promos p on o.promoid=p.id where o.id=:orderId');
        $sqlSelect->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlSelect, 'Error when getting promo for order '.$orderId);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        $this->registry['logger']->lwrite($data['bonus']);
        $total = $total - $data['amount'] - floor($total * $data['percent']/100) - $data['bonus'];
        $this->registry['logger']->lwrite($total);
        $newBonus = floor($total / 20);
        $sqlUpdate = $this->db->prepare('UPDATE profiles SET bonus=:bonus WHERE id in (SELECT profileId FROM orders WHERE id=:orderId)');
        $bonus += $newBonus;
        $sqlUpdate->bindParam(':bonus', $bonus);
        $sqlUpdate->bindParam(':orderId', $orderId);
        $this->executeQuery($sqlUpdate, 'Error when updating bonuses for order '.$orderId);
        $sqlUpdate->closeCursor();
        return $newBonus;
    }
    
    function flyerUsed($flyerId) {
        $sqlSelect = $this->db->prepare('SELECT IFNULL(profile, 0) FROM flyers WHERE id=:flyerId');
        $sqlSelect->bindParam(':flyerId', $flyerId);
        $this->executeQuery($sqlSelect, 'Error when checking flyer ' . $flyerId);
        $data = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $data;
    }
    
    function applyFlyer($userId, $flyerId) {
        $sqlSelect = $this->db->prepare('SELECT bonus FROM flyers WHERE id =:flyerId');
        $sqlSelect->bindParam(':flyerId', $flyerId);
        $this->executeQuery($sqlSelect, 'Error when getting bonus for flyer ' . $flyerId);
        $data = $sqlSelect->fetchColumn();
        $bonus = $data;
        $sqlSelect->closeCursor();
        $sqlSelect = $this->db->prepare('SELECT p.id FROM profiles p, users u WHERE p.id=u.profile AND u.id=:userId');
        $sqlSelect->bindParam(':userId', $userId);
        $this->executeQuery($sqlSelect, 'Error when getting profile for user ' . $userId);
        $profile = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        $sqlUpdate = $this->db->prepare('UPDATE profiles SET bonus=:bonus WHERE id=:profileId');
        $sqlUpdate->bindParam(':bonus', $bonus);
        $sqlUpdate->bindParam(':profileId', $profile);
        $this->executeQuery($sqlUpdate, 'Error when applying flyer ' . $flyerId . ' for profile ' . $profile);
        $sqlUpdate->closeCursor();
        $sqlUpdate = $this->db->prepare('UPDATE flyers SET profile=:profileId WHERE id=:flyerId');
        $sqlUpdate->bindValue(':profileId', $profile);
        $sqlUpdate->bindParam(':flyerId', $flyerId);
        $this->executeQuery($sqlUpdate, 'Error when linking flyer ' . $flyerId . ' with profile ' . $profile);
        $sqlUpdate->closeCursor();
    }
    
    function decreaseBonus($userId, $bonus) {
        $sqlUpdate = $this->db->prepare('UPDATE profiles SET bonus=:bonus WHERE id IN (SELECT profile FROM users WHERE id=:userId)');
        $sqlUpdate->bindParam(':bonus', $bonus);
        $sqlUpdate->bindParam(':userId', $userId);
        $this->executeQuery($sqlUpdate, 'Error when decreasing bonus for user ' . $userId);
        $sqlUpdate->closeCursor();
    }
    
    function getBlogEntries() {
        $sqlSelect = $this->db->prepare("SELECT * FROM blogentries ORDER BY date DESC");
        $this->executeQuery($sqlSelect, 'Error when getting blog entries');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $entry = new Blog($data['id'], $data['name'], $data['author'], $data['url'], $data['text'], $data['date'], $data['metaTitle'], $data['metaDescription']);
            if (!isset($entries)) {
                $entries = [$entry];
            } else {
                array_push($entries, $entry);
            }
        }   
        $sqlSelect->closeCursor();
        return $entries;
    }
    
    function getBlogEntry($entryId) {
        $sqlSelect = $this->db->prepare('SELECT * FROM blogentries WHERE id=:entryId');
        $sqlSelect->bindParam(':entryId', $entryId);
        $this->executeQuery($sqlSelect, 'Error when getting blog entry with id=' . $entryId);
        $entry = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        $blog = new Blog($entry['id'], $entry['name'], $entry['author'], $entry['url'], $entry['text'], $entry['date'], $entry['metaTitle'], $entry['metaDescription']);
        return $blog;
    }

    function addBlogEntry($id, $name, $author, $url, $text, $date) {
        if ($id) {
            $sqlInsert = $this->db->prepare($this->updateBlog);
            $sqlInsert->bindParam(':id', $id);
        } else {
            $sqlInsert = $this->db->prepare($this->addBlog);
        }
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':author', $author);
        $sqlInsert->bindParam(':url', $url);
        $sqlInsert->bindParam(':text', $text);
        $sqlInsert->bindParam(':date', $date);
        $this->executeQuery($sqlInsert, 'Error when adding/updating a blog entry');
        if ($id) {
            $blogId=$id;
        } else {
            $blogId = $this->db->lastInsertId();
        }
        $sqlInsert->closeCursor();
        return $blogId;
    }
    
    function removeBlog($blogId) {
        $sqlDelete = $this->db->prepare('DELETE FROM blogentries WHERE id=:blogId');
        $sqlDelete->bindParam(':blogId', $blogId);
        $this->executeQuery($sqlDelete, 'Error when deleting blog with id='.$blogId);
        $sqlDelete->closeCursor();
    }
    
    function getLastExportDate() {
        $sqlSelect = $this->db->prepare('SELECT 1c_last_date FROM common');
        $this->executeQuery($sqlSelect, 'Error when selecting last export date');
        $date = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        if (!$date['1c_last_date']) {
            $returnDate = new DateTime('2000-01-01');
        } else {
            $returnDate = new DateTime($date['1c_last_date']);
        }
        return $returnDate->format('Y-m-d H:i:s');
    }
    
    function setLastExportDate($date) {
        $sqlUpdate = $this->db->prepare('UPDATE common SET 1c_last_date = :lastDate');
        $sqlUpdate->bindParam(':lastDate', $date);
        $this->executeQuery($sqlUpdate, 'Error when setting last export date to ' . $date);
        $sqlUpdate->closeCursor();
    }

    function getExportSession() {
        $sqlSelect = $this->db->prepare('SELECT 1c_session FROM common');
        $this->executeQuery($sqlSelect, 'Error when selecting export session');
        $date = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        return $date['1c_session'];
    }
    
    function setExportSession($session) {
        $sqlUpdate = $this->db->prepare('UPDATE common SET 1c_session = :session');
        $sqlUpdate->bindParam(':session', $session);
        $this->executeQuery($sqlUpdate, 'Error when setting export session to ' . $session);
        $sqlUpdate->closeCursor();
    }

    function getTypeMeta($typeId) {
        $sqlSelect = $this->db->prepare('SELECT description, metaTitle, metaDescription, metaKeywords, descAfter FROM types WHERE id=:typeId');
        $sqlSelect->bindParam(':typeId', $typeId);
        $this->executeQuery($sqlSelect, 'Error when getting meta tags for type ' . $typeId);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        return $data;
    }
    
    function isGoodHidden($goodid) {
        $sqlSelect = $this->db->prepare('SELECT hidden FROM goods WHERE id=:goodid');
        $sqlSelect->bindParam(':goodid', $goodid);
        $this->executeQuery($sqlSelect, 'Error when getting hidden status for good ' . $goodid);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        return $data['hidden'];
    }
    
    function getSpamEmails() {
        $sqlSelect = $this->db->prepare('SELECT id, email FROM profiles WHERE spam=1');
        $this->executeQuery($sqlSelect, 'Error when getting spam emails');
        $emails = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $emails[$data['id']]=$data['email'];
        }
        $sqlSelect->closeCursor();
        return $emails;
    }
    
    function profileExists($id) {
        $sqlSelect = $this->db->prepare('SELECT count(*) FROM profiles WHERE id=:id');
        $sqlSelect->bindParam(':id', $id);
        $this->executeQuery($sqlSelect, 'Error when checking profile with id=' . $id);
        $exists = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $exists;
    }
    
    function unsubscribe($id) {
        $sqlUpdate = $this->db->prepare('UPDATE profiles SET spam=0 WHERE id=:id');
        $sqlUpdate->bindParam(':id', $id);
        $this->executeQuery($sqlUpdate, 'Error when unsubscribing profile with id=' . $id);
        $sqlUpdate->closeCursor();
    }
    
    function getUsersWithoutGeo() {
        $sqlSelect = $this->db->prepare('SELECT * FROM users WHERE country IS NULL AND bot=0 ORDER BY id DESC');
        $this->executeQuery($sqlSelect, 'Error when selecting non-geo users');
        $users = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $users[$data['id']]=$data['ip'];
        }
        $sqlSelect->closeCursor();
        return $users;
    }
    
    function updateGeoUser($id, $country, $city) {
        $sqlUpdate = $this->db->prepare('UPDATE users SET country=:country, city=:city WHERE id=:id');
        $sqlUpdate->bindParam(':id', $id);
        $sqlUpdate->bindParam(':country', $country);
        $sqlUpdate->bindParam(':city', $city);
        $this->executeQuery($sqlUpdate, 'Error when updating geo for user with id=' . $id);
        $sqlUpdate->closeCursor();
    }
    
    function getVocabulary() {
        $sqlSelect = $this->db->prepare('SELECT * FROM vocabulary ORDER BY name');
        $this->executeQuery($sqlSelect, 'Error when getting vocabulary items');
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($words)) {
                $words = [$data];
            } else {
                array_push($words, $data);
            }
        }   
        $sqlSelect->closeCursor();
        return $words;
    }
    
    function getVoc($id) {
        $sqlSelect = $this->db->prepare('SELECT * FROM vocabulary WHERE id=:id');
        $sqlSelect->bindParam(':id', $id);
        $this->executeQuery($sqlSelect, 'Error when getting vocabulary item with id='.$id);
        $data = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        $sqlSelect->closeCursor();
        return $data;
    }
    
    function addVoc($id, $name, $text) {
        if ($id) {
            $sqlInsert = $this->db->prepare('UPDATE vocabulary SET name=:name, value=:value WHERE id=:id');
            $sqlInsert->bindParam(':id', $id);
        } else {
            $sqlInsert = $this->db->prepare('INSERT INTO vocabulary(name, value) VALUES (:name, :value)');
        }
        $sqlInsert->bindParam(':name', $name);
        $sqlInsert->bindParam(':value', $text);
        $this->executeQuery($sqlInsert, 'Error when adding/updating a word to vocabulary');
        if ($id) {
            $vocId=$id;
        } else {
            $vocId = $this->db->lastInsertId();
        }
        $sqlInsert->closeCursor();
        return $vocId;
    }

    function removeVoc($id) {
        $sqlDelete = $this->db->prepare('DELETE FROM vocabulary WHERE id=:id');
        $sqlDelete->bindParam(':id', $id);
        $this->executeQuery($sqlDelete, 'Error when deleting vocabulary entry with id='.$id);
        $sqlDelete->closeCursor();
    }
  
    function insertVoc($string) {
        $newString = $string;
        $vocabulary = $this->getVocabulary();
        foreach($vocabulary as $word) {
            if (mb_stripos($newString, $word['name'], 0, 'UTF-8') !== false) {
                $newString = preg_replace('#'. mb_strtoupper($word['name']) . '#ius', '<a class="apopover" href="javascript:void(0);" data-toggle="popover" title="' . $word['name'] .'" data-content="' . strip_tags($word['value']) .'">' . $word['name'] . '</a>', $newString);
            }
        }
        return $newString;
    }
    
    function getGoodReviews($id) {
        if ($id) {
            $sqlSelect = $this->db->prepare('SELECT * FROM reviews WHERE goodid=:id ORDER BY date DESC,id DESC');
            $sqlSelect->bindParam(':id', $id);
        } else {
            $sqlSelect = $this->db->prepare('SELECT * FROM reviews WHERE goodid is NULL ORDER BY date DESC,id DESC');
        }    
        $this->executeQuery($sqlSelect, 'Error when getting reviews for good with id='.$id);
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($reviews)) {
                $reviews = [$data];
            } else {
                array_push($reviews, $data);
            }
        }   
        $sqlSelect->closeCursor();
        return $reviews;
    }
    
    function getGoodRating($id) {
        $sqlSelect = $this->db->prepare('SELECT AVG(clovers) FROM reviews WHERE goodid=:id');
        $sqlSelect->bindParam(':id', $id);
        $this->executeQuery($sqlSelect, 'Error when getting rating for good with id='.$id);
        $data = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        return $data;
        
    }
    
    function addReview($goodId, $reviewId, $clovers, $author, $text, $date) {
        if ($reviewId) {
            $sqlQuery = $this->db->prepare('UPDATE reviews SET clovers=:clovers, author=:author, text=:text, date=:date WHERE id = :reviewId');
            $sqlQuery->bindParam(':reviewId', $reviewId);
        } else {
            $sqlQuery = $this->db->prepare('INSERT INTO reviews(goodid, userid, text, author, date, clovers) VALUES (:goodId, :userId, :text, :author, :date, :clovers)');
            $sqlQuery->bindParam(':userId', $_SESSION['user']->id);
            if ($goodId) {
                $sqlQuery->bindParam(':goodId', $goodId);
            } else {
                $sqlQuery->bindValue(':goodId', null, PDO::PARAM_INT);
            }    
        }
        if ($clovers) {
            $sqlQuery->bindParam(':clovers', $clovers);
        } else {
            $sqlQuery->bindValue(':clovers', null, PDO::PARAM_INT);
        }    
        $sqlQuery->bindParam(':date', date('Y-m-d', strtotime($date)));
        $sqlQuery->bindParam(':author', $author);
        $sqlQuery->bindParam(':text', $text);
        $this->executeQuery($sqlQuery, 'Error when adding/updating a review for good with id='.$goodId);
        $sqlQuery->closeCursor();
    }
    
    function deleteReview($reviewId) {
        $sqlDelete = $this->db->prepare('DELETE FROM reviews WHERE id=:reviewId');
        $sqlDelete->bindParam(':reviewId', $reviewId);
        $this->executeQuery($sqlDelete, 'Error when deleting review with id=' . $reviewId);
        $sqlDelete->closeCursor();
    }
    
    function setOrderLink($id) {
        $sqlUpdate = $this->db->prepare('UPDATE orders SET link=:link WHERE id=:id');
        $sqlUpdate->bindParam(':id', $id);
        $rand = substr(md5(microtime()),rand(0,26),5);
        $sqlUpdate->bindParam(':link', $rand);
        $this->executeQuery($sqlUpdate, 'Error when setting a link for order id=' . $id);
        $sqlUpdate->closeCursor();
        return $rand;
    }
    
    function getOrderByLink($link) {
        $sqlSelect = $this->db->prepare('SELECT id FROM orders WHERE link=:link');
        $sqlSelect->bindParam(':link', $link);
        $this->executeQuery($sqlSelect, 'Error when getting order with link=' . $link);
        $data = $sqlSelect->fetchColumn();
        $sqlSelect->closeCursor();
        if ($data) {
            return $this->getOrder($data);
        } else {
            return null;
        }
    }
    
    function setSale($sale, $firms, $mentypes, $supercats, $cats) {
        $strUpdate = 'UPDATE goods SET sale = :sale ';
        $where = false;
        if (sizeof($firms)) {
            $strWhereFirms = 'firmid IN (';
            foreach ($firms as $id) {
                $strWhereFirms = $strWhereFirms . $id .',';
            }
            $strWhereFirms = rtrim($strWhereFirms, ", ") . ')';
            $where = true;
            $strUpdate = $strUpdate . ' WHERE ' . $strWhereFirms;
        }
        if (sizeof($supercats)) {
            $strWhereSC = 'id IN (SELECT DISTINCT goodid FROM `goods-categories` gc JOIN categories c ON gc.categoryid=c.id WHERE c.supercatid IN (';
            foreach ($supercats as $id) {
                $strWhereSC = $strWhereSC . $id .',';
            }
            $strWhereSC = rtrim($strWhereSC, ", ") . '))';
            if ($where) {
                $strUpdate = $strUpdate . ' AND ' . $strWhereSC;
            } else {
                $strUpdate = $strUpdate . ' WHERE ' . $strWhereSC;
                $where = true;
            }
        }
        if (sizeof($mentypes)) {
            $strWhereTypes = 'id IN (SELECT DISTINCT goodid FROM `goods-types` WHERE typeid IN (';
            foreach ($mentypes as $id) {
                $strWhereTypes = $strWhereTypes . $id .',';
            }
            $strWhereTypes = rtrim($strWhereTypes, ", ") . '))';
            if ($where) {
                $strUpdate = $strUpdate . ' AND ' . $strWhereTypes;
            } else {
                $strUpdate = $strUpdate . ' WHERE ' . $strWhereTypes;
                $where = true;
            }
        }
        if (sizeof($cats)) {
            $strWhereCats = 'id IN (SELECT DISTINCT goodid FROM `goods-categories` WHERE categoryid IN (';
            foreach ($cats as $id) {
                $strWhereCats = $strWhereCats . $id .',';
            }
            $strWhereCats = rtrim($strWhereCats, ", ") . '))';
            if ($where) {
                $strUpdate = $strUpdate . ' AND ' . $strWhereCats;
            } else {
                $strUpdate = $strUpdate . ' WHERE ' . $strWhereCats;
                $where = true;
            }
        }
        if (!in_array(21, $cats) && !in_array(34, $cats)) {
            if ($where) {
                $strUpdate = $strUpdate . ' AND id not in (select distinct goodid from `goods-categories` where categoryid in (21, 34))';
            } else {
                $strUpdate = $strUpdate . ' WHERE id not in (select distinct goodid from `goods-categories` where categoryid in (21, 34))';
            }
        }    
        $this->registry['logger']->lwrite($strUpdate);
        $sqlUpdate = $this->db->prepare($strUpdate);
        $sqlUpdate->bindParam(':sale', $sale);
        $this->executeQuery($sqlUpdate, 'Error when setting sale by the following query: ' . $strUpdate);
        $data = $sqlUpdate->rowCount();
        $sqlUpdate->closeCursor();
        return $data;
    }
    
    function getSizeByCode($code) {
        $sqlSelect = $this->db->prepare('SELECT gs.id, gs.size, w.price, w.instock, w.onhold, w.bestbefore, w.bbprice, gs.code, gs.sale FROM `goods-sizes` gs LEFT JOIN warehouse w ON gs.Id=w.psId WHERE gs.code=:code ORDER BY w.price');
        $sqlSelect->bindParam(':code', $code);
        $this->executeQuery($sqlSelect, 'Error when selecting sizes with code ' . $code);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        if ($data) {
            return new Size($data['id'], $data['size'], $data['price'], $data['sale'], $data['code'], $data['instock'], $data['onhold'], $data['bestbefore'], $data['bbprice']);
        } else {
            return null;
        }
    }

    function getSizeByExternalId($code) {
        $sqlSelect = $this->db->prepare('SELECT gs.id, gs.size, w.price, w.instock, w.onhold, w.bestbefore, w.bbprice, gs.code, gs.sale FROM `goods-sizes` gs LEFT JOIN warehouse w ON gs.Id=w.psId WHERE gs.external_id=:code ORDER BY w.price');
        $sqlSelect->bindParam(':code', $code);
        $this->executeQuery($sqlSelect, 'Error when selecting sizes with external_id ' . $code);
        $data = $sqlSelect->fetch();
        $sqlSelect->closeCursor();
        if ($data) {
            return new Size($data['id'], $data['size'], $data['price'], $data['sale'], $data['code'], $data['instock'], $data['onhold'], $data['bestbefore'], $data['bbprice']);
        } else {
            return null;
        }
    }

    function updateExternalId($sizeId, $externalId) {
        $sqlUpdate = $this->db->prepare('UPDATE `goods-sizes` SET external_id=:externalId WHERE id=:sizeId');
        $sqlUpdate->bindParam(':sizeId', $sizeId);
        $sqlUpdate->bindParam(':externalId', $externalId);
        $this->executeQuery($sqlUpdate, 'Error when setting external id ' . $externalId .' for size ' . $sizeId);
        $sqlUpdate->closeCursor();
    }
    
    function updateWarehouse($sizeId, $price, $quantity) {
        if ($quantity < 0) {
            $quantity = 0;
        }
        $sqlUpdate = $this->db->prepare('UPDATE warehouse SET price=:price, instock=:quantity WHERE psId=:sizeId');
        $sqlUpdate->bindParam(':sizeId', $sizeId);
        $sqlUpdate->bindParam(':price', $price);
        $sqlUpdate->bindParam(':quantity', $quantity);
        $this->executeQuery($sqlUpdate, 'Error when updating size ' . $sizeId .' setting price=' . $price . ' and quanity=' . $quantity);
        $sqlUpdate->closeCursor();
    }
    
    //Searches by substring and return goods that satisfy search
    function searchGoods($field, $criteria) {
        $sql = 'SELECT id FROM goods WHERE name LIKE :criteria';
        if (!isadmin) {
            $sql = $sql . ' AND hidden=0';
        }
        $sqlSelect = $this->db->prepare($sql);
        //$sqlSelect->bindParam(':field', $field);
        //str_replace("%", "", $criteria);
        $criteria = "%".$criteria."%";
        $this->registry['logger']->lwrite($criteria);
        $sqlSelect->bindValue(':criteria', $criteria, PDO::PARAM_STR);
        $this->executeQuery($sqlSelect, 'Error when searching goods by name including ' . $criteria);
        $goods = array();
        while ($data = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            $goods[$data['id']] = $this->getGood($data['id']);
        }        
        $sqlSelect->closeCursor();
        $this->registry['logger']->lwrite(sizeof($goods));
        return $goods;
    }
        
}