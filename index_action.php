<?php
    include 'includes/session.php';
    $conn = $pdo->open();

    if(isset($_POST['btn_login'])){

        $username = $_POST['txt_username'];
        $password = $_POST['txt_password'];
		try{
            $stmt = $conn->prepare("SELECT * FROM vw_user_details WHERE row3 =:row3");
			$stmt->execute(['row3'=>$username]);
            $count = $stmt->rowCount();

            if($count) {
                $ftc_stmt = $stmt->fetch();
                if($ftc_stmt['row6']) {

                    if(password_verify($password, $ftc_stmt['row4'])){
                        
                        $_SESSION['doc_5fe2562907c4eafe29b4384343298787676'] = $ftc_stmt['row1'];
                        $_SESSION['user_id'] = $ftc_stmt['row1'];
                        $_SESSION['user_type'] = $ftc_stmt['row7'];
                        $_SESSION['user_fullname'] = $ftc_stmt['row5'];
                        $_SESSION['user_department'] = $ftc_stmt['row8'];

                        $output = array("success","Login Success", "Redirecting...");

                    }else{
                        $output = array("error","", "Incorrect Username or Password.");
                    }

                }else{
                    $output = array("error","", "Account Disabled by Administrator.");
                }


            }else {
                $output = array("error","", "Incorrect Username or Password.");
            }
        }
        catch(PDOException $e){
            $output = array("error","", $e->getMessage());
        }
        echo json_encode($output);
        $pdo->close();

    }






    // if(isset($_POST['add_superadmin'])){

    //     $sa_lastname        = ucwords($_POST['sa_lastname']);
    //     $sa_firstname       = ucwords($_POST['sa_firstname']);
    //     $sa_email           = strtolower($_POST['sa_email']);
    //     $sa_mobile          = $_POST['sa_mobile'];
    //     $sa_username        = $_POST['sa_username'];
    //     $sa_password        = $_POST['sa_password'];
    //     $sa_repassword      = $_POST['sa_repassword'];

    //     $url            =  "img/resources/setup/new.txt";
    //     $textfile       = $url;
    //     $textfileBODY   = file($textfile);
     
    //     $textdb_count   = preg_replace("/\r|\n/", "", $textfileBODY[0]);

    //     try{ 
    //         if(empty($sa_lastname)) {
    //             $output = array("error","Error","Last Name is required.");
    //         }else if(empty($sa_firstname)) {
    //             $output = array("error","Error","First Name is required.");
    //         }else if(!empty($sa_email) && !filter_var($sa_email, FILTER_VALIDATE_EMAIL)) {
    //             $output = array("error","Error","Invalid Email Address");
    //         }else if(!empty($sa_mobile) && !preg_match('/^\d+$/',$sa_mobile)) {
    //             $output = array("error","Error","Mobile No. must a Digit Only.");
    //         }else if(!empty($sa_mobile) && strlen($sa_mobile) < 9) {
    //             $output = array("error","Error","Contact Must be Maximum of 9 Digit");
    //         }else if(!empty($sa_mobile) && strlen($sa_mobile) > 9) {
    //             $output = array("error","Error","Contact Must be Maximum of 9 Digit");
    //         }else if(empty($sa_username)) {
    //             $output = array("error","Error","Username is Required");
    //         }else if(empty($sa_password)) {
    //             $output = array("error","Error","Passsword is Required"); 
    //         }else if(empty($sa_repassword)) {
    //             $output = array("error","Error","Please Re Enter Passsword"); 
    //         }else if($sa_password != $sa_repassword) {
    //             $output = array("error","Error","Passsword not Match.");
                
    //         }else{
    //             $conn->beginTransaction();

       
    //             $stmt = $conn->prepare("INSERT INTO tbl_employee(emp_name, dept_code, isEnabled, email, mobile)  OUTPUT INSERTED.emp_id VALUES 
    //                         (:emp_name, :dept_code, :isEnabled, :email, :mobile )");
    //             $stmt->execute(['emp_name'=>$sa_lastname.', '. $sa_firstname, 'dept_code'=>1, 'isEnabled'=>1, 'email'=>$sa_email, 'mobile'=> "+639".$sa_mobile ]);
     
       
    //             $stmt2 = $conn->prepare("INSERT INTO tbl_user(user_id, FullName, UsersName, Password, role, position) VALUES 
    //                         (  (select emp_id from tbl_employee where emp_name = :emp_name ) , :FullName, :UsersName,   HASHBYTES('SHA2_512', '".$sa_password."') , :role, :position )");
    //             $stmt2->execute(['emp_name'=>$sa_lastname.', '. $sa_firstname, 'FullName'=>$sa_lastname.', '. $sa_firstname, 'UsersName'=>$sa_username,  'role'=>'ADMIN', 'position'=>'ADMIN' ]);
            
    //             $strings = file_get_contents($url);

    //             $strreplace = str_replace($textdb_count, "COUNT="."1", $strings);

    //             file_put_contents($url ,$strreplace);
  
    //             $conn->commit();
              
    //             $output = array("success","Success","Succesfully Registered");
 
    //         }
    //     }catch(PDOException $e){
         
    //         if (strpos($e, 'unique_fullname') !== false) {

    //             $output = array("error","There is some problem in connection: ", "First Name and Last Name is not available.");  
      
    //         }else if (strpos($e, 'unique_email') !== false) {

    //             $output = array("error","There is some problem in connection: ", "Email Address is not Available.");  
        
    //         }else if (strpos($e, 'unique_mobile') !== false) {
   
    //             $output = array("error","There is some problem in connection: ", "Mobile # is not Available.");  
          
    //         }else if (strpos($e, 'unique_username') !== false) {
     
    //             $output = array("error","There is some problem in connection: ", "Username is not Available.");  
      
                
    //         }else{
    //             $output = array("error","There is some problem in connection: ",$e->getMessage());
        
    //         }
            
    //         $conn->rollback();
    //     }

     
    //     echo json_encode($output);
    //     $pdo->close();
    // }   

    // if(isset($_POST['check_str_conn'])){


    //     $cn_servername      = $_POST['conn_servername'];
    //     $cn_dbname          = $_POST['conn_databasename'];
    //     $cn_username        = $_POST['conn_databaseusername'];
    //     $cn_password        = $_POST['conn_databasepassword'];

    //     $url            =  "img/resources/setup/new.txt";
    //     $textfile       = $url;
    //     $textfileBODY   = file($textfile);
     
    //     $textdb_server  = preg_replace("/\r|\n/", "", $textfileBODY[1]);
    //     $textdb_name    = preg_replace("/\r|\n/", "", $textfileBODY[2]);
    //     $textdb_user    = preg_replace("/\r|\n/", "", $textfileBODY[3]);
    //     $textdb_pass    = preg_replace("/\r|\n/", "", $textfileBODY[4]);


    //     $db_server = str_replace("DB_SERVER=","",$textdb_server);
    //     $db_name = str_replace("DB_NAME=","",$textdb_name);
    //     $db_user = str_replace("DB_LOGIN=","",$textdb_user);
    //     $db_password = str_replace("DB_PASSWORD=","",$textdb_pass);
 
    //     if(password_verify($cn_password, $db_password)){
    //         $db_password2 = $cn_password;
    //     }else{
    //         $db_password2 =$db_password;
    //     }

    //     try{    
    //         if(empty($cn_servername)) {
    //             $output = array("error","Error","Servername is Required");
    //         }else if(empty($cn_dbname)) {
    //             $output = array("error","Error","Database Name is Required");
    //         }else if(empty($cn_username)) {
    //             $output = array("error","Error","Datasebase Login is Required");
    //         }else if(empty($cn_password)) {
    //             $output = array("error","Error","Datasebase Password is Required");
    //         }else{

    //             $conn = new PDO("sqlsrv:Server=$db_server;Database=$db_name", $db_user, $db_password2 );

    //             // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //             if($conn) {

    //                 $output = array("success","Success", "Connection Success");
    //             }else{
    //                 $output = array("error","Error", $conn);

    //             }
               

    //         }
            
    //     }catch(PDOException $e){

    //         if (strpos($e, 'Could not open a connection to SQL Server') !== false) {
    //             $output = array("error","There is some problem in connection: ", "Could not open a connection to SQL Server.");  
    //         }else if (strpos($e, 'Login failed for user') !== false) {

    //             $output = array("error","There is some problem in connection: ", "User Login or Password on database is incorrect.");  
    //         }else{
    //             $output = array("error","There is some problem in connection: ", $e->getMessage() );
    //         }
            
    //         $strings = file_get_contents($url);
    //         $strreplace = str_replace($textdb_server, "DB_SERVER=".$cn_servername, str_replace($textdb_name, "DB_NAME=".$cn_dbname,  str_replace($textdb_user, "DB_LOGIN=".$cn_username,  str_replace($textdb_pass, "DB_PASSWORD=".password_hash($cn_password, PASSWORD_DEFAULT) , $strings )     )   )  );
    //         file_put_contents($url ,$strreplace);
    //     }
    //     echo json_encode($output);
    // }   

 
    // if (isset($_POST['checkWebsetup'])) {
    //     try{ 
    //         $stmt = $conn->prepare("SELECT * FROM `tbl_web_setup` ORDER BY id DESC LIMIT 1");
    //         $stmt->execute();
    //         $countrow = $stmt->rowCount();
    //         if($countrow == 0){
    //             $output[] = array(
    //                 "no_image.png",
    //                 "Itrack Asset"
    //             );
    //         }else{
    //             while($row = $stmt->fetchObject())
    //             {
    //                 $output[] = array(
    //                     $row->image_name, 
    //                     $row->web_name
    //                 );
    //             }
    //         }
    //     } catch(PDOException $e) {
    //         $output = die($e->getMessage());
    //     }   
    
    //         echo json_encode($output);
    //         $pdo->close();
    // }



?>