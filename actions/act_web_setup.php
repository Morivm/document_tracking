<?php

    

    include '../modules/session.php';
    $conn = $pdo->open();

    function getLastwebimg($conn) {
        try{
            $stmt = $conn->prepare("SELECT top(1) image_name, image_ext FROM tbl_web_setup ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt ->fetch();
            $count = $stmt->rowCount();
            if($count == 0) {
                return "no_image.png";
            }else{
                return $result['image_name'];
            }
        }  
        catch(PDOException $e){
            $output = array(0,$e->getMessage());
        }

    }
    if(isset($_POST['chg_web_pht'])){
        $form_photo             = $_FILES['web_icon']['name'];
        // $form_photo_m           = $_FILES['m_web_icon']['name'];

        $photo                  = time().$_FILES['web_icon']['name'];
        // $photo_m                = time().$_FILES['m_web_icon']['name'];

        $phot_extension         = pathinfo($form_photo, PATHINFO_EXTENSION);
        // $phot_extension_m       = pathinfo($form_photo_m, PATHINFO_EXTENSION);

        $noimage                = NULL;
        // $noimage_m              = NULL;

        $web_name               = $_POST['web_name'];
    
        $putimage = getLastwebimg($conn);

        try{
          
            move_uploaded_file($_FILES['web_icon']['tmp_name'], '../img/resources/webicon.png');

            $txt = $web_name;

            unlink( '../img/resources/webname.txt' );
            $myfile = file_put_contents('../img/resources/webname.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

            // Second option is this
            // $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
            // $txt = "user id date";
            // fwrite($myfile, "\n". $txt);
            // fclose($myfile);



            // $stmt =$conn->prepare("exec sp_websetup
            //     @image_name     = :image_name,
            //     @image_name_m   = :image_name_m,
            //     @image_ext      = :image_ext,
            //     @image_extm     = :image_extm,
            //     @web_name       = :web_name,
            //     @in_added_by    = :in_added_by");

            // $stmt->execute(['image_name'=>$photo,
            //     'image_name_m'=>$photo_m,
            //     'image_ext'=>$phot_extension,
            //     'image_extm'=>$phot_extension_m, 
            //     'web_name'=>$web_name,
            //     'in_added_by'=>$userid]);
            
            // $row = $stmt->fetch();
            $output = array("success", "Success", "Webpage Succesfully Updated Changes may affect once Page Was Closed.");

            // if($row['message_success']) {

            //     if(empty($form_photo)) {
            //         $photo  = getLastwebimg($conn);
            //         $phot_extension_m     = pathinfo($photo, PATHINFO_EXTENSION);
            //    }else{
            //        move_uploaded_file($_FILES['web_icon']['tmp_name'], '../img/web/'.$photo);
            //    }
   
            //    if(empty($form_photo_m)) {
            //        $photo_m  = getLastwebimg($conn);
            //        $phot_extension_m     = pathinfo($photo_m, PATHINFO_EXTENSION);
            //    }else{
            //        move_uploaded_file($_FILES['m_web_icon']['tmp_name'], '../img/web/'.$photo_m);
            //    }

            // }


        }catch(PDOException $e){
            $output = array("error","Error Found",$e->getMessage());
        }
    
        echo json_encode($output);
        $pdo->close();
    }




    /* ============================ WEB MAIL ======================= */


    if(isset($_POST['switch_mailer'])) {
        $switch_status  = $_POST['switch_status'];
        $url =  "../img/resources/setup/setup.txt";
        $strings = file_get_contents($url);
  
        try{
            if($switch_status == "Mailing=on") {
                $strreplace =  str_replace("Mailing=off", "Mailing=on", $strings);
            }else{
                $strreplace =  str_replace("Mailing=on", "Mailing=off", $strings);
            }
            file_put_contents($url ,$strreplace);
            $output = array("success","Success", "Mailing Status Changed");

        }catch(PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        exit();
    }

    if(isset($_POST['update_mailer'])) {

        $url =  "../img/resources/setup/setup.txt";
        $textfile = $url;
        $textfileBODY = file($textfile);
        $textusername = preg_replace("/\r|\n/", "", $textfileBODY[1]);
        $textpassword = preg_replace("/\r|\n/", "", $textfileBODY[2]);

        $mailer_username = $_POST['mailer_add'];
        $mailer_password = $_POST['mailer_pass'];

        $strings = file_get_contents($url);

        try{
            $strreplace = str_replace($textusername, "Mailing_address=".$mailer_username, str_replace($textpassword, "Mailing_password=".$mailer_password, $strings));
            // 
            file_put_contents($url ,$strreplace);
            $output = array("success","Success", $textusername);

        }catch(PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        exit();
    }

    if(isset($_POST['test_mailer'])) {

        // $url =  "../img/resources/setup/setup.txt";
        // $textfile = $url;
        // $textfileBODY = file($textfile);
        // $textusername = preg_replace("/\r|\n/", "", $textfileBODY[1]);
        // $textpassword = preg_replace("/\r|\n/", "", $textfileBODY[2]);

        // $mailer_username = $_POST['mailer_add'];
        // $mailer_password = $_POST['mailer_pass'];

        $email_address = $_POST['txt_2_0'];

        try{
            $sendmessage =  mailFormat($mail, "", "Testing", "This message is for test only", "The alt-body" , $email_address);

            if($sendmessage) {
                $output = array("success","Success", "Message Sent");
            }else{
                $output = array("error","Error Found", $sendmessage);
            }

        }catch(PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        exit();
    }
?>