<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    
    $draw        = intval(0);
    $data        = array();

 



    if(isset($_POST['add_comment'])){

        try {

            $message = $_POST['message'];
            $session_forum_id = $_POST['session_forum_id'];

            if(empty($message)) {

                $output = array("error", "Error Found", "Please Include your Comment.");
            }else{

                $stmt = $conn->prepare("SELECT isAvailable FROM tbl_activities WHERE barcode = :barcode");
                $stmt ->execute(['barcode'=>$session_forum_id]);
                $count = $stmt->rowCount();

                if($count == 0){
                    $output = array("error", "Please Reload the page", "Invalid Session");
                }else{
                    $ftcstmt = $stmt->fetch();
                    if($ftcstmt['isAvailable'] == 0) {
                        $output = array("error", "This Session already ended.", "You Cannot add comment.");
                    }else {
                   

                        $stmt2 = $conn->prepare("INSERT INTO tbl_forum(forum_id, comment_by, attachment, messages)VALUES(:forum_id, :comment_by, :attachment, :messages)");
                        $stmt2->execute(['forum_id'=>$session_forum_id, 'comment_by'=>$userid, 'attachment'=>'', 'messages'=>$message]);

                        if($stmt2) {
                            $stmt3 = $conn->prepare("SELECT * FROM tbl_forum WHERE forum_id = :forum_id");

                            $output = array("success", 
                            "
                             ".viewForum($session_forum_id, $conn, $userid)."

                            ", "Comment Added");
                        }else{

                            $output = array("error", "Error Found", $stmt2);
                        }

                    }

                }
            
            }


            // $filename = glob("../scanned_docs/*");

            // if ( $filename) {
            //     foreach($filename as $value) {
            //         $stmt = $conn->prepare("INSERT INTO tbl_documents (document_name, users_id, document_type) VALUES(:document_name, (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)),     (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )           ) ON DUPLICATE KEY UPDATE    
            //         users_id=  (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)) , document_type = (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )          ");
            //         $stmt->execute(['document_name'=>$value]);

            //         $output = array("success", "Success", "Syncing Success...");
            //     }

            // } else {
 
            // }
    

        }catch (PDOException $e) {

            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }
    

    if(isset($_POST['upload_att'])){
        $session_forum_id       = $_POST['barcode'];
        $barcode                = $_POST['barcode'];
        $dc_name                = $_FILES['file']['name']; /* FILE NAME ON POST  */
        $allowed_file_extension = array("pdf","doc","docx","png","jpg"); /* ALLOWED FILE TYPE */
        $imageFileType          = pathinfo($dc_name,PATHINFO_EXTENSION); /* FILE TYPE / EXTENSION */
        $dc_doc                 = file_get_contents($_FILES['file']['tmp_name']); /* CONTENT OF FILE */
        $target_dir             = "../modules/forum/$barcode/"; /* TARGET DIRECTORY WHERE FILE GOES */
        $target_file            = $target_dir.$barcode.$userid."_".time().".".$imageFileType;
        $uploadOk = 1;


        try {
            if (file_exists($target_dir.$target_file))  { 
                $output= array("error","Sorry","You Can Try To Rename Your File or Reload the page.");
                $uploadOk = 0;
        
            }else if ($_FILES["file"]["size"] > 3000000) {
                $output= array("error","Sorry", "File is too large. Max Size 3MB");
                $uploadOk = 0;
            }else if(! in_array($imageFileType, $allowed_file_extension)) {
                $output= array("error","Invalid File Format","Please See allowed file type before uploading.");
                $uploadOk = 0;
            }else if ($uploadOk == 0) {
                $output= array("error","Sorry", "Your file was not uploaded.");
            }else  {

                if (!file_exists("../modules/forum/$barcode/")) {
                    mkdir("../modules/forum/".$barcode, 0777);

                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))  {

                            $stmt_up = $conn->prepare("INSERT INTO tbl_forum(forum_id,comment_by, attachment, attachment_ext) VALUES (:forum_id, :comment_by, :attachment, :attachment_ext) ");
                            $stmt_up->execute(['forum_id'=>$barcode, 'comment_by'=>$userid, 'attachment'=>$target_file, 'attachment_ext'=>$imageFileType]);

                            if($stmt_up) {
                                $output = array("success", 
                                "
                                 ".viewForum($session_forum_id, $conn, $userid)."
    
                                ", "Attachment Added");
                            }else{
                                $output = array("error","Sorry",$stmt_up ." Found");
                            }
                
                        }else{
                            $output = array("error","Sorry","There was an error uploading your file.");
                        }

                    $output= array("success","Success", "Success Directory");
                } else {
                   
                    
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))  {

                        $stmt_up = $conn->prepare("INSERT INTO tbl_forum(forum_id,comment_by, attachment, attachment_ext) VALUES (:forum_id, :comment_by, :attachment, :attachment_ext) ");
                        $stmt_up->execute(['forum_id'=>$barcode, 'comment_by'=>$userid, 'attachment'=>$target_file, 'attachment_ext'=>$imageFileType]);

                        if($stmt_up) {
                            $output = array("success", 
                            "
                             ".viewForum($session_forum_id, $conn, $userid)."

                            ", "Attachment Added");
                        }else{
                            $output = array("error","Sorry",$stmt_up ." Found");
                        }
            
                    }else{
                        $output = array("error","Sorry","There was an error uploading your file.");
                    }

                }



          
                
            }
    

        }catch (PDOException $e) {

            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }
    


    // if(isset($_POST['view_documents'])){

    //     try {

    //         $filename = glob("../scanned_docs/*");

    //         if ( $filename) {
    //             foreach($filename as $value) {
    //                 $stmt = $conn->prepare("INSERT INTO tbl_documents (document_name, users_id, document_type) VALUES(:document_name, (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)),     (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )           ) ON DUPLICATE KEY UPDATE    
    //                 users_id=  (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)) , document_type = (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )          ");
    //                 $stmt->execute(['document_name'=>$value]);

    //                 $output = array("success", "Success", "Syncing Success...");
    //             }

    //         } else {
    //             $output = array("error", "Error Found", $filename );
    //         }
      

    //     }catch (PDOException $e) {

    //         $output = array("error","Error Found", $e->getMessage());

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }

    // if(isset($_POST['s_table_main'])) {

    //     $stmt = $conn->prepare("SELECT 
    //         b.barcode AS row1,
    //         GROUP_CONCAT(title, ' ',ordinance_code, ' ',description) AS row2,
    //         func_fullname(b.created_by) AS row3,
    //         `func_Dateformat`(created_date,3) AS row4,
    //         b.isAvailable AS row5
             
    //      FROM `search_order_of_business` a
    //      LEFT JOIN `tbl_activities` b ON b.barcode = a.barcode");
    //     $stmt->execute(['row6'=>1]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){
    //         $row1           = $row['row1'];
    //         $row2           = $row['row2'];
    //         $row3           = "Creator: ".$row['row3'];
    //         $row4           = $row['row4'];
    //         $row5           = $row['row5'];
    //         // $row5           = ($row['row5'] == 1 ) ? "Session On Going <image src='../img/web/circle_green.png' width='10px'> " :  "Session Down <image src='../img/web/circle_red.png' width='10px'>";
    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2,
    //             "row3"=>$row3,
    //             "row4"=>$row4,
    //             "row5"=>$row5

    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }


    // if(isset($_POST['s_table_main2'])) {

    //     $user_id = $_POST['view_userId'];


    //     $stmt = $conn->prepare("SELECT * FROM vw_users_docs WHERE row3 = :row3");
    //     $stmt->execute(['row3'=>$user_id]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){

    //         $row1           = $row['row6'];
    //         $row2           = "  <a href='".$row['row2']."' target='_blank'> Click to Download </a>";

    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }



    // if(isset($_POST['getFileondb'])) {

    //     $barcode = $_POST['barcode'];


    //     $stmt = $conn->prepare("SELECT * FROM vw_users_docs WHERE row3 = :row3");
    //     $stmt->execute(['row3'=>$user_id]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){

    //         $row1           = $row['row6'];
    //         $row2           = "  <a href='".$row['row2']."' target='_blank'> Click to Download </a>";

    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }



?>