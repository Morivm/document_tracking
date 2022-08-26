<?php
    include "../modules/session.php";


    $conn = $pdo->open();

    
    function ConverttoBase($text,$conn) {

        $stmt22 = $conn->prepare("SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', HASHBYTES('SHA2_512', '$text')   )), 3, 32)  as stringed");
        $stmt22->execute();
        $result22 = $stmt22->fetch();

        return $result22['stringed'];
        exit();
    }


    if(isset($_POST['changeprofilepic']))   {
        $dc_name                = $_FILES['userImage']['name']; /* FILE NAME ON POST  */
        $allowed_file_extension = array("jpg"); /* ALLOWED FILE TYPE */
        $imageFileType          = pathinfo($dc_name,PATHINFO_EXTENSION); /* FILE TYPE / EXTENSION */
        $dc_doc                 = file_get_contents($_FILES['userImage']['tmp_name']); /* CONTENT OF FILE */
        $target_dir             = "../img/users/"; /* TARGET DIRECTORY WHERE FILE GOES */
        $target_file            = $target_dir.$userid.".".$imageFileType; /* NEW FILE NAME */
        $uploadOk = 1;

        if ($_FILES["userImage"]["size"] > 3000000) {
            $output= array("error","Error","Sorry, File is too large. Max Size 3MB.");
            $uploadOk = 0;
        }else if(! in_array($imageFileType, $allowed_file_extension)) {
            $output= array("error","Invalid File Format","Only .JPG file extension is allowed.");
            $uploadOk = 0;
        }else if ($uploadOk == 0) {
            $output= array("error","Error","Sorry, your file was not uploaded Please Reload the page.");
        }else  {

            
            if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file))  {
                $output = array("success","Success","Profile Picture Succesfully Changed","<img src='$target_file'>");
            }else{
                $output = array("error","Error Found","Sorry, there was an error uploading your file.");
            }
            
        }
        
        echo json_encode($output);
        exit();
    }


    if(isset($_POST['changepass'])) {

        $oldpass = $_POST['ch_oldpass'];
        $newpass = $_POST['ch_newpass'];

        try{

            $old = ConverttoBase($oldpass,$conn);


            $stmt = $conn->prepare("SELECT  SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', Password)), 3, 32)  as pass   FROM tbl_user where user_id = :user_id");
            $stmt->execute(['user_id'=>$userid]);
            $result = $stmt->fetch();
            $dbpass = $result['pass'];

            if($old == $dbpass) {

                $stmt3 = $conn->prepare("UPDATE tbl_user SET Password = HASHBYTES('SHA2_512','$newpass')  WHERE user_id = :user_id");
                $stmt3->execute(['user_id'=>$userid]);

                if($stmt3) {
                    $output = array("success", "Success", "Password Succesfully Changed");
                }else{
                    $output = array("success", "Success", $stmt3);
                }


            }else{
                $output = array("error","Error Found", "Incorrect Old Password");
            }



        }catch(PDOException $e) {

            $output = array("error","Error Found", $e->getMessage());
        }
    
        echo json_encode($output);
        $pdo->close();

    }

?>