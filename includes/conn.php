<?php
    $timezone = "Asia/Manila";
    date_default_timezone_set($timezone);
 
    $web_company = "Doctrack";
    $web_company_site = "";
    $web_copyright_year = "2021";
    $web_ip = "2021";
    $web_version = "V.0.0.4";

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
    }

$pdo = new Database();

?>