<?php
    $timezone = "Asia/Manila";
    date_default_timezone_set($timezone);
 
    $web_company = "Doctrack";
    $web_company_site = "";
    $web_copyright_year = "2022";
    $web_ip = "2022";
    $web_version = "V.0.0.1";

    $web_conn_url       = ( file_exists("img/resources/setup/new.txt") ) ? "img/resources/setup/new.txt" :  "../img/resources/setup/new.txt";
    $web_textfile       = $web_conn_url;
    $web_textfileBODY   = file($web_textfile);

    $web_server     = preg_replace("/\r|\n/", "", $web_textfileBODY[1]);
    $web_db         = preg_replace("/\r|\n/", "", $web_textfileBODY[2]);
    $web_login      = preg_replace("/\r|\n/", "", $web_textfileBODY[3]);
    $web_passs      = preg_replace("/\r|\n/", "", $web_textfileBODY[4]);

    $conn_server = str_replace("DB_SERVER=","",$web_server);
    $conn_db = str_replace("DB_NAME=","",$web_db);
    $conn_login = str_replace("DB_LOGIN=","",$web_login);
    $conn_pass = str_replace("DB_PASSWORD=","",(empty($web_passs) ) ? " " : $web_passs  );
   
    $GLOBALS = array(
        'myServer' => $conn_server,
        'myDb' => $conn_db,
        'mylogin' => $conn_login,
        'mypass' => $conn_pass 
    );

    Class Database{ 
         
        protected $glob;
        public function __construct() {
            global $GLOBALS;
            $this->glob =& $GLOBALS;
        }

        private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
        protected $conn;
        
        public function open(){
            try{
                $this->conn = new PDO("mysql:host=".$this->getGlob()[0].";dbname=".$this->getGlob()[1], $this->getGlob()[2], $this->getGlob()[3], $this->options);
                return $this->conn;
                
            }
            catch (PDOException $e){
                echo "eerror found" . $e->getMessage();
            }
    
        }
        public function getGlob() {

            $out[0] = $this->glob['myServer'];
            $out[1] = $this->glob['myDb'];
            $out[2] = $this->glob['mylogin'];
            $out[3] = $this->glob['mypass'];

            return $out;
        }
        public function close(){
            $this->conn = null;
        }
        public function is_connected() { 
            $connected = @fsockopen("www.example.com", 80);
            if ($connected){
                $is_conn = true;
                fclose($connected);
            }else{
                $is_conn = false;
            }
            return $is_conn;
        }
        public function dateFormating($format ,$date){
         
            $dDate = date_create($date);

            if($format == "1") {
                return  date_format($dDate,"Y/m/d");
            }else if($format == "2") {
                return  date_format($dDate,"M/d/Y");
            }else{
                return  "Invalid Date Format.";
            }
 
        }

        public function timeAgo($timestamp)  {  
            $time_ago = strtotime($timestamp);  
            $current_time = time();  
            $time_difference = $current_time - $time_ago;  
            $seconds = $time_difference;  
            $minutes      = round($seconds / 60 );           // value 60 is seconds  
            $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
            $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
            $weeks          = round($seconds / 604800);          // 7*24*60*60;  
            $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
            $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
            if($seconds <= 60)  {  
                return "Just Now";  
            } else if($minutes <=60) {  
                if($minutes==1) {  
                    return "one minute ago";  
                }else{  
                return "$minutes minutes ago";  
                }  
            }else if($hours <=24){  
                if($hours==1)  
                    {  
                return "an hour ago";  
                }  
                    else  
                    {  
                return "$hours hrs ago";  
                }  
            }else if($days <= 7){  
                if($days==1)  
                    {  
                return "yesterday";  
                }  
                    else  
                    {  
                return "$days days ago";  
                }  
            }else if($weeks <= 4.3){  
                if($weeks==1)  
                    {  
                return "a week ago";  
                }  
                    else  
                    {  
                return "$weeks weeks ago";  
                }  
            }else if($months <=12) {  
                if($months==1)  {  
                    return "a month ago";  
                }else {  
                    return "$months months ago";  
                }  
            }else {  
                if($years==1) {  
                    return "one year ago";  
                }else {  
                    return "$years years ago";  
                }  
            }  
        }  

        public function genRandString($length) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }

$pdo = new Database();

?>