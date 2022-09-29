<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    
    $draw        = intval(0);
    $data        = array();

 



    // if(isset($_POST['add_comment'])){

    //     try {

    //         $message = $_POST['message'];
    //         $session_forum_id = $_POST['session_forum_id'];

    //         if(empty($message)) {

    //             $output = array("error", "Error Found", "Please Include your Comment.");
    //         }else{

    //             $stmt = $conn->prepare("SELECT isAvailable FROM tbl_activities WHERE barcode = :barcode");
    //             $stmt ->execute(['barcode'=>$session_forum_id]);
    //             $count = $stmt->rowCount();

    //             if($count == 0){
    //                 $output = array("error", "Please Reload the page", "Invalid Session");
    //             }else{
    //                 $ftcstmt = $stmt->fetch();
    //                 if($ftcstmt['isAvailable'] == 0) {
    //                     $output = array("error", "This Session already ended.", "You Cannot add comment.");
    //                 }else {
                   

    //                     $stmt2 = $conn->prepare("INSERT INTO tbl_forum(forum_id, comment_by, attachment, messages)VALUES(:forum_id, :comment_by, :attachment, :messages)");
    //                     $stmt2->execute(['forum_id'=>$session_forum_id, 'comment_by'=>$userid, 'attachment'=>'', 'messages'=>$message]);

    //                     if($stmt2) {
    //                         $stmt3 = $conn->prepare("SELECT * FROM tbl_forum WHERE forum_id = :forum_id");

    //                         $output = array("success", 
    //                         "
    //                          ".viewForum($session_forum_id, $conn, $userid)."

    //                         ", "Comment Added");
    //                     }else{

    //                         $output = array("error", "Error Found", $stmt2);
    //                     }

    //                 }

    //             }
            
    //         }


    //         // $filename = glob("../scanned_docs/*");

    //         // if ( $filename) {
    //         //     foreach($filename as $value) {
    //         //         $stmt = $conn->prepare("INSERT INTO tbl_documents (document_name, users_id, document_type) VALUES(:document_name, (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)),     (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )           ) ON DUPLICATE KEY UPDATE    
    //         //         users_id=  (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)) , document_type = (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )          ");
    //         //         $stmt->execute(['document_name'=>$value]);

    //         //         $output = array("success", "Success", "Syncing Success...");
    //         //     }

    //         // } else {
 
    //         // }
    

    //     }catch (PDOException $e) {

    //         $output = array("error","Error Found", $e->getMessage());

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }
    

    // if(isset($_POST['upload_att'])){
    //     $session_forum_id       = $_POST['barcode'];
    //     $barcode                = $_POST['barcode'];
    //     $dc_name                = $_FILES['file']['name']; /* FILE NAME ON POST  */
    //     $allowed_file_extension = array("pdf","doc","docx","png","jpg"); /* ALLOWED FILE TYPE */
    //     $imageFileType          = pathinfo($dc_name,PATHINFO_EXTENSION); /* FILE TYPE / EXTENSION */
    //     $dc_doc                 = file_get_contents($_FILES['file']['tmp_name']); /* CONTENT OF FILE */
    //     $target_dir             = "../modules/forum/$barcode/"; /* TARGET DIRECTORY WHERE FILE GOES */
    //     $target_file            = $target_dir.$barcode.$userid."_".time().".".$imageFileType;
    //     $uploadOk = 1;


    //     try {
    //         if (file_exists($target_dir.$target_file))  { 
    //             $output= array("error","Sorry","You Can Try To Rename Your File or Reload the page.");
    //             $uploadOk = 0;
        
    //         }else if ($_FILES["file"]["size"] > 3000000) {
    //             $output= array("error","Sorry", "File is too large. Max Size 3MB");
    //             $uploadOk = 0;
    //         }else if(! in_array($imageFileType, $allowed_file_extension)) {
    //             $output= array("error","Invalid File Format","Please See allowed file type before uploading.");
    //             $uploadOk = 0;
    //         }else if ($uploadOk == 0) {
    //             $output= array("error","Sorry", "Your file was not uploaded.");
    //         }else  {

    //             if (!file_exists("../modules/forum/$barcode/")) {
    //                 mkdir("../modules/forum/".$barcode, 0777);

    //                     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))  {

    //                         $stmt_up = $conn->prepare("INSERT INTO tbl_forum(forum_id,comment_by, attachment, attachment_ext) VALUES (:forum_id, :comment_by, :attachment, :attachment_ext) ");
    //                         $stmt_up->execute(['forum_id'=>$barcode, 'comment_by'=>$userid, 'attachment'=>$target_file, 'attachment_ext'=>$imageFileType]);

    //                         if($stmt_up) {
    //                             $output = array("success", 
    //                             "
    //                              ".viewForum($session_forum_id, $conn, $userid)."
    
    //                             ", "Attachment Added");
    //                         }else{
    //                             $output = array("error","Sorry",$stmt_up ." Found");
    //                         }
                
    //                     }else{
    //                         $output = array("error","Sorry","There was an error uploading your file.");
    //                     }

    //                 $output= array("success","Success", "Success Directory");
    //             } else {
                   
                    
    //                 if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))  {

    //                     $stmt_up = $conn->prepare("INSERT INTO tbl_forum(forum_id,comment_by, attachment, attachment_ext) VALUES (:forum_id, :comment_by, :attachment, :attachment_ext) ");
    //                     $stmt_up->execute(['forum_id'=>$barcode, 'comment_by'=>$userid, 'attachment'=>$target_file, 'attachment_ext'=>$imageFileType]);

    //                     if($stmt_up) {
    //                         $output = array("success", 
    //                         "
    //                          ".viewForum($session_forum_id, $conn, $userid)."

    //                         ", "Attachment Added");
    //                     }else{
    //                         $output = array("error","Sorry",$stmt_up ." Found");
    //                     }
            
    //                 }else{
    //                     $output = array("error","Sorry","There was an error uploading your file.");
    //                 }

    //             }



          
                
    //         }
    

    //     }catch (PDOException $e) {

    //         $output = array("error","Error Found", $e->getMessage());

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }
    


    function getvwFilesUpdate($conn, $orderOfbusinessCode, $barcode) {

    
        $output = "";

        $vwUpdatedfilemax = $conn->prepare("SELECT * FROM search_order_of_busines_files WHERE order_of_business_code = :order_of_business_code AND barcode = :barcode ORDER BY version_no DESC LIMIT 1");
        $vwUpdatedfilemax->execute(['order_of_business_code'=>$orderOfbusinessCode, 'barcode'=>$barcode]);
        $countvwUpdatedfileMAX = $vwUpdatedfilemax->rowCount();

        if($countvwUpdatedfileMAX == 0) {
            $output .= "No Versions of this file uploaded yet.";
        }else{

            while ($row2 = $vwUpdatedfilemax->fetchObject()) {

                $newbarcode = $row2->barcode."-".$row2->version_no;
                $output .="<label class='text-primary font-weight-bold'>Versions of File</label>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Barcode</th>
                            <th scope='col'>Added Date</th>
                            <th scope='col'>Added Date</th>
                            <th scope='col'>Action</th>
                        </tr>
                    </thead>
                    <tbody> ";
    
                $output .="<tr>
                            <td>$newbarcode</td>
                            <td>$row2->date_uploaded <label class='text-success'><i>(Latest)</i></label></td>
                            <td>$row2->uploaded_by</td>
                            <td><a href='#'>View</a></td>
                        </tr>";
    


                $vwUpdatedfile = $conn->prepare("SELECT * FROM search_order_of_busines_files WHERE order_of_business_code = :order_of_business_code AND barcode = :barcode AND version_no != :version_no  ORDER BY version_no DESC");
                $vwUpdatedfile->execute(['order_of_business_code'=>$orderOfbusinessCode, 'barcode'=>$barcode, 'version_no'=>$row2->version_no ]);
                $countvwUpdatedfile = $vwUpdatedfile->rowCount();
    
                if($countvwUpdatedfile == 0) {
                    $output .= "";
                }else {
    
                    while ($row3 = $vwUpdatedfile->fetchObject()) {

                        $newbarcode3 = $row3->barcode."-".$row3->version_no;
                        $output .="<tr>
                            <td>$newbarcode3</td>
                            <td>$row3->date_uploaded</td>
                            <td>$row3->uploaded_by</td>
                            <td><a href='#'>View</a></td>
                        </tr>";
                    }
                }
                

            }

      

            
        }




        // $vwUpdatedfile = $conn->prepare("SELECT * FROM search_order_of_busines_files WHERE order_of_business_code = :order_of_business_code AND barcode = :barcode ORDER BY version_no DESC");
        // $vwUpdatedfile->execute(['order_of_business_code'=>$orderOfbusinessCode, 'barcode'=>$barcode]);
        // $countvwUpdatedfile = $vwUpdatedfile->rowCount();

        // if($countvwUpdatedfile == 0) {
        //     $output .= "No Versions of this file uploaded yet.";
        // }else {

            



            // while ($row2 = $vwUpdatedfile->fetchObject()) {

            //     $newbarcode = $row2->barcode."-".$row2->version_no;
            //     $lastversion =  $row2->version_no;
            //     // $stringlatest = ( $row2->version_no < $lastversion) ? "Latest" : "";

                // $output .="<tr>
                //                 <td>$newbarcode</td>
                //                 <td><i> $lastversion</i></td>
                //                 <td>$row2->uploaded_by</td>
                //                 <td><a href='#'>View</a></td>
                //             </tr>";

            // }

            $output .="</tbody></table>";
        // }


        return $output;

    }

    if(isset($_POST['vw_files'])) {

        $orderofbuinesscode = $_POST['businesscode'];
        $barcode = $_POST['barcode'];
        
        try {
            $stmt = $conn->prepare("SELECT  barcode, added_date, added_by
                                FROM 
                                search_order_of_business
                                WHERE order_of_business_code = :order_of_business_code and barcode = :barcode");
            $stmt->execute(['order_of_business_code'=>$orderofbuinesscode, 'barcode'=>$barcode]);
            $count = $stmt->rowCount();

            if($count == 0) {
                $output = array("error", "Error Found", "Failed to get the file.");

            }else {
                while ($row = $stmt->fetchObject()) {
                    $output = array("success","success",

                        "
                        <label class='text-primary font-weight-bold'>Original File</label>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th scope='col'>Barcode</th>
                                    <th scope='col'>Added Date(Original)</th>
                                    <th scope='col'>Added Date</th>
                                    <th scope='col'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>$row->barcode</td>
                                <td>$row->added_date</td>
                                <td>$row->added_by</td>
                                <td><a href='#'>View</a></td>
                            </tr>
                        </table><br/>
                        
                        ".getvwFilesUpdate($conn, $orderofbuinesscode, $barcode)."
                        
                        "
                    );
                }

            }

        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
        }
        
        echo json_encode($output);
        $pdo->close();

        // $records = $stmt->fetchAll();
        // $data = array();
        // foreach($records as $row){

        //     $row1           = $row['row6'];
        //     $row2           = "  <a href='".$row['row2']."' target='_blank'> Click to Download </a>";

        //     $data[] = array(
        //         "row1"=>$row1,
        //         "row2"=>$row2
        //     );
        // }
        // $response = array(
        //     "aaData" => $data
        // );
     
    }


    if(isset($_POST['gen_page_cover'])) {

    
        $order_of_business_code                 =$_POST['order_of_business_code'];
        $barcode                                =$_POST['barcode'];
        // $or_code                               =$order_of_business_code  ;

        try {


            $stmt = $conn->prepare("SELECT ");


            
            if (!file_exists("../modules/forum/".$order_of_business_code)) {
                mkdir("../modules/forum/" . $order_of_business_code, 0777);

                $files = $order_of_business_code;
                $path = "../img/barcodes/$order_of_business_code";
                $put = file_put_contents("../modules/imgsbarcode/$order_of_business_code.jpg", $generator->getBarcode($order_of_business_code, $generator::TYPE_CODE_128));
                    $tmpFilePath =  $order_of_business_code;
                    if ($tmpFilePath != ""){
                        $newFilePath = $path."/". str_replace(' ', '_', $order_of_business_code);
                        $getattachmentname =  str_replace(' ', '_',  $order_of_business_code);
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $str .= $getattachmentname . $delimiter;
                        }
                    }

        
                // $stmt = $conn->prepare("CALL sp_generate_cover_photo(:in_action, :in_barcode, :in_order_business_date, :in_action_by)");

                // $stmt->execute(['in_action'=>'generate', 'in_barcode'=>$order_of_business_code, 'in_order_business_date'=>$order_of_business_date, 'in_action_by'=>$userid]);

                // $result = $stmt->fetch();
                
                // $string = $result['barcodeloop'];

                // if($stmt) {
                //     $stmt->closeCursor();
                //     $string = preg_replace('/\.$/', '', $string); 
                //     $array = explode(',', $string); 
                //     foreach($array as $value) 
                //     {
                //         if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
                //             mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);

                //             $selectallbusiness = $conn ->prepare("SELECT GROUP_CONCAT(barcode) as allbusiness FROM search_order_of_business 
                //             WHERE order_of_business_code = :order_of_business_code"); 
                
                //             $selectallbusiness->execute(['order_of_business_code'=>$or_code]);
                //             $resultallbusiness = $selectallbusiness->fetch();
                        
                
                //             $stringbusiness = $resultallbusiness['allbusiness'];
                //             $stringbusiness = preg_replace('/\.$/', '', $stringbusiness);
                //             $arraybusiness = explode(',', $stringbusiness); 
                //             foreach($arraybusiness as $valuebusiness) //loop over values
                //             {
                               
                //                 $filesbusiness = $valuebusiness;
                //                 $pathbusiness = "../img/barcodes/$valuebusiness";
                //                 $put = file_put_contents("../modules/imgsbarcode/$valuebusiness.jpg", $generator->getBarcode($valuebusiness, $generator::TYPE_CODE_128));
                //                     $tmpFilePath =  $valuebusiness;
                //                     if ($tmpFilePath != ""){
                //                         $newFilePath = $path."/". str_replace(' ', '_', $valuebusiness);
                //                         $getattachmentname =  str_replace(' ', '_',  $valuebusiness);
                //                         if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                //                             $str .= $getattachmentname . $delimiter;
                //                         }
                //                     }
                    
                //                 if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
                //                     mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);
                //                 }
                //             }

                //         }
                //     }

                //     $output = array("success", "Please Wait", $order_of_business_code, $or_code );
                // }else{
                //     $output = array("error", "Error Found", $stmt);
                // }
                
            } else {
                $output = array("error", "Error Found", "Unable to create path.");
            }


        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();
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