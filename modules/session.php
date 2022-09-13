<?php
    include '../includes/conn.php';


    session_start();

    $conn = $pdo -> open();

    $userid         = "";
    $userempname    = "";
    $usedeptcode    = "";
    $userdeptname   = "";
    $userrole   = "";


    // $u_mailer_loc       =  "../img/resources/setup/setup.txt";
    // $u_mailer_file_body = file($u_mailer_loc);
    // $u_mailer_status    = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[0], strrpos($u_mailer_file_body[0], '=') + 1) );
    // $u_mailer_usern     = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[1], strrpos($u_mailer_file_body[1], '=') + 1) );
    // $u_mailer_passw     = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[2], strrpos($u_mailer_file_body[2], '=') + 1) );
    // $u_mailer_team      = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[3], strrpos($u_mailer_file_body[3], '=') + 1) );
    

    if(!isset($_SESSION['doc_5fe2562907c4eafe29b4384343298787676']) || trim($_SESSION['doc_5fe2562907c4eafe29b4384343298787676']) == ''){
        header('location: ../index');
        exit();
    }else{
        $userid         = $_SESSION['user_id']; 
        $userempname    = $_SESSION['user_fullname']; 
        $usedeptcode    = ""; 
        $userdeptname   = $_SESSION['user_department'];  
        $userrole       = $_SESSION['user_type']; 
    }


    function checkUserimgExist($users_id) {

        $imageFolder    = "../img/users/$users_id.jpg";
        $NoimageFolder  = "../img/users/noimage.png";

        if (file_exists($imageFolder)) {
            return  $imageFolder;
        } else {
            return  $NoimageFolder;
        }
    }


?>