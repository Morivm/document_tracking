<?php
    include "../modules/session.php";
    require '../vendor/autoload.php';

    $conn = $pdo->open();
    $generator = new Picqer\Barcode\BarcodeGeneratorJPG();




    if(isset($_POST['deletefirst_tmp'])) {

  
        try {
            $stmt = $conn->prepare("DELETE  FROM tmp_order_of_business WHERE added_by = :added_by ");
            $stmt->execute(['added_by'=>$userid]);

            if($stmt) {
                $output = array("success", "Success", "Temp Cleared");
            }  else{
                $output = array("error", "Error Found", $stmt);
            }


        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();
    }
    
    if(isset($_POST['getlastidofbusiness'])) {

        $order_of_business_id  = $_POST['order_of_business_id'];
        $order_of_business_code  = $_POST['order_of_business_code'];
        
        try {
            
            if($order_of_business_id == "" ) {

                $output = array("error", "Error Found", "Please Select Order Of Business.");
            }else{

                $stmt = $conn->prepare("SELECT max(ordering) as maxordering FROM tmp_order_of_business
                    WHERE order_of_business_id = :order_of_business_id AND 
                    order_of_business_code = :order_of_business_code AND
                    added_by = :added_by");

                $stmt->execute(['order_of_business_id'=>$order_of_business_id, 'order_of_business_code'=>$order_of_business_code, 'added_by'=>$userid ]);
                $result = $stmt->fetch();
                if($result) {
                    $output = array("success", "Success Found", $result['maxordering'] + 1);
                }else {
                    $output = array("error", "Error Found", "Please Reload Page First.");

                }
            }

           
        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();


    }



    // if(isset($_POST['generate_barcode'])) { 

    //     $usercid = $_POST['userc_id'];
    //     $typeofperson = $_POST['typeofperson'];
    //     $delimiter      = " ";



    //     try {
    //         if( $usercid == 0 || empty($usercid)) {
    //             $output = array("error", "Error Found", "Please Select a Person");

    //         }else if( $typeofperson == 0 || empty($typeofperson)) {
    //             $output = array("error", "Error Found", "Please Select a type");

    //         }else{

    //             $stmt = $conn->prepare("call sp_generate_barcode(:in_action , :in_userid, :in_typeofperson, :in_action_by)");
    //             $stmt->execute(['in_action'=>'generate', 'in_userid'=>$usercid, 'in_typeofperson'=>$typeofperson, 'in_action_by'=>$userid]);
    //             $result = $stmt->fetch();
    //             $stmt->closeCursor();
    //             if($stmt) {

    //                 $stmt2 = $conn->prepare("SELECT row2, row4 FROM vw_barcode_to_print WHERE row9 = :row9 AND row10 = :row10");
    //                 $stmt2->execute(['row9'=>0, 'row10'=>$userid]);
    //                 $rowcount2 = $stmt2->rowCount();
    //                 $result2 = $stmt2->fetchAll();

    //                     foreach ($result2 as $row2) {
                         
    //                         $barcode = $row2['row2']."_".$row2['row4'];
    //                         $path = "../img/barcodes/$barcode";
    //                         file_put_contents("../modules/imgsbarcode/$barcode.jpg", $generator->getBarcode($barcode, $generator::TYPE_CODE_128));



    //                             // mkdir($path, 0777, true);
                            
    //                             $files = $barcode;
    //                             $total_count = $rowcount2;
                
    //                             for( $i=0 ; $i < $total_count ; $i++ ) {
    //                                 $tmpFilePath =  $barcode[$i];
    //                                 if ($tmpFilePath != ""){
    //                                     $newFilePath = $path."/". str_replace(' ', '_', $barcode[$i]);
    //                                     $getattachmentname =  str_replace(' ', '_',  $barcode[$i]);
    //                                     if(move_uploaded_file($tmpFilePath, $newFilePath)) {
    //                                         $str .= $getattachmentname . $delimiter;
    //                                     }
    //                                 }
    //                             }
                            
    //                     }

    //                 $output = array($result['message_success'], $result['message_title'], $result['message_body']);

    //             }else{
    //                 $output = array("error", "Error Found", $stmt);

    //             }

    //         }



    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();

    // }

    // if(isset($_POST['update_print_bc'])) { 

    //     try {
    
    //             $stmt = $conn->prepare("call sp_generate_barcode(:in_action , :in_userid, :in_typeofperson, :in_action_by)");
    //             $stmt->execute(['in_action'=>'upbarcode', 'in_userid'=>NULL, 'in_typeofperson'=>NULL, 'in_action_by'=>$userid]);
    //             $result = $stmt->fetch();

    //             if($stmt) {
    //                 $output = array($result['message_success'], $result['message_title'], $result['message_body']);

    //             }else{ 
    //                 $output = array("error",  "Error Found", $stmt);
    //             }


    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();

    // }

    // if(isset($_POST['get_forms'])) {

    //     $contract_id  = $_POST['x'];

        
    //     try {
    //         $output = "";
    
    //         $stmt = $conn->prepare("SELECT row1, row3 FROM vw_contract_forms WHERE row2 = :row2");
    //         $stmt->execute(['row2'=>$contract_id]);
    //         $count = $stmt->rowCount();

    //         if($count == 0) {
    //             $output = array("error", "Error Found", "No Setup for this Contract");
    //         }else {

    //             foreach ($stmt as $row) {
    //                 $output .= "<input type='checkbox' id='v_".$row['row1']."' name='v_".$row['row1']."' value='Bike'>&nbsp;   <label for='v_".$row['row1']."'> ".$row['row3']."</label><br>" ;
    //             }
    //         }
    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();


    // }


    if(isset($_POST['create_order_of_busineess'])) {

        $order_business_id      = $_POST['order_business_id'];
        $order_description      = $_POST['order_description'];
        $order_business_code    = $_POST['order_business_code'];
        $ordering               = $_POST['ordering'];
        
        try {
     
            if (empty($order_business_id)) {
                $output = array("error", "Error Found", "Please Reload the page first.");
            }else   if (empty($order_description)) {
                $output = array("error", "Error Found", "Description is Required.");
            }else   if (empty($ordering)) {
                $output = array("error", "Error Found", "Please Reload the page first.");
            }else   if (empty($order_business_code)) {
                $output = array("error", "Error Found", "Please Reload the page first.");
            }else {
                
                $stmt = $conn->prepare("INSERT INTO tmp_order_of_business(order_of_business_id, order_of_business_code, ordering,  barcode, description, added_by)
                                        VALUES(:order_of_business_id, :order_of_business_code, :ordering, :barcode, :description, :added_by)");
                $stmt->execute(['order_of_business_id'=>$order_business_id, 'order_of_business_code'=>$order_business_code, 'ordering'=>$ordering,  'barcode'=>$order_business_code."-".$order_business_id."-".$ordering, 'description'=>$order_description, 'added_by'=>$userid ]);
                
                if($stmt) {

                    $stmt2 = $conn->prepare("SELECT MAX(ordering) as maxordering  FROM tmp_order_of_business

                                                WHERE order_of_business_id = :order_of_business_id 
                                                AND 
                                                order_of_business_code = :order_of_business_code
                                                AND
                                                added_by = :added_by");

                    $stmt2->execute(['order_of_business_id'=>$order_business_id, 'order_of_business_code'=>$order_business_code, 'added_by'=>$userid ]);

                    $result2 = $stmt2->fetch();
                    $output = array("success", "Success", "Successfully Added", $result2['maxordering'] + 1);


                }else {
                    $output = array("error", "Error Found", $stmt);
                }

            }

        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();


    }

    // if(isset($_POST['create_commitees'])) {
    //     $committee_id                = $_POST['committee_id'];
    //     try {
     
    //         if (empty($committee_id)) {
    //             $output = array("error", "Error Found", "Committee is Required");
    //         }else {
                
    //             $stmt = $conn->prepare("REPLACE  INTO tmp_committees (committee_id, userid, action_by)
    //                                     SELECT b.committee_id, b.id, $userid
    //                                     FROM tbl_users_detail b
    //                                     WHERE b.committee_id = :committee_id");
    //             $stmt->execute([ 'committee_id'=>$committee_id]);
                
    //             if($stmt) {
    //                 $output = array("success", "Success", "Commiteee Successfully Added");
    //             }else {
    //                 $output = array("error", "Error Found", $stmt);
    //             }

    //         }

    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    // }

    
    // if(isset($_POST['gen_cover_page'])) {

    //     $words = explode(" ", $userdeptname);
    //     $acronym = "";

    //     foreach ($words as $w) {
    //         $acronym .= mb_substr($w, 0, 1);
    //     }
    //     $barcode                =$acronym.$userid.time();

    //     try {

    //         $files = $barcode;
    //         $path = "../img/barcodes/$barcode";
    //         $put = file_put_contents("../modules/imgsbarcode/$barcode.jpg", $generator->getBarcode($barcode, $generator::TYPE_CODE_128));
    //             $tmpFilePath =  $barcode;
    //             if ($tmpFilePath != ""){
    //                 $newFilePath = $path."/". str_replace(' ', '_', $barcode);
    //                 $getattachmentname =  str_replace(' ', '_',  $barcode);
    //                 if(move_uploaded_file($tmpFilePath, $newFilePath)) {
    //                     $str .= $getattachmentname . $delimiter;
    //                 }
    //             }


    //         if($put) {

    //             $stmt = $conn->prepare("CALL sp_generate_cover_photo(:in_action, :in_barcode, :in_action_by)");
    //             $stmt->execute(['in_action'=>'generate','in_barcode'=>$barcode, 'in_action_by'=>$userid]);
    //             $result = $stmt->fetch();

    //             if($stmt) {
    //                 $output = array($result['message_success'], $result['message_title'], $result['message_body']);
    //             }  else{

    //                 $output = array("error", "Error Found", $stmt);
    //             }
    //         }else{

    //             $output = array("error", "Error Found", $put);
    //         }

    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    // }

    // if(isset($_POST['deletefirst_tmp'])) {

  
    //     try {
    //         $stmt = $conn->prepare("CALL sp_generate_cover_photo(:in_action, :in_barcode, :in_action_by)");
    //         $stmt->execute(['in_action'=>'deletefirst_tmps','in_barcode'=>'', 'in_action_by'=>$userid]);
    //         $result = $stmt->fetch();

    //         if($stmt) {
    //             $output = array($result['message_success'], $result['message_title'], $result['message_body']);
    //         }  else{
    //             $output = array("error", "Error Found", $stmt);
    //         }


    //     }catch (PDOException $e) {
    //         $output = array("error", "Error Found", $e->getMessage());
            
    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    // }


   

    if(isset($_POST['s_table_main1'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT * FROM vw_tmp_order_business WHERE row9 = :row9 ORDER BY row2 ASC, row4 ASC");
        $stmt->execute(['row9'=>$userid]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['row1'];
            $row2           = $row['row2'];
            $row3           = $row['row6'];

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }

    if(isset($_POST['delete_on_tmp'])) {

        $id                         = $_POST['id'];
        $order_of_business_code     = $_POST['order_of_business_code'];
        $order_of_business_id       = $_POST['order_of_business_id'];
        

        try {
            $stmt = $conn->prepare("DELETE  FROM tmp_order_of_business WHERE id = :id ");
            $stmt->execute(['id'=>$id]);

            if($stmt) {

                $stmt2 = $conn->prepare("SELECT max(ordering) as maxordering FROM tmp_order_of_business
                    WHERE order_of_business_id = :order_of_business_id AND 
                    order_of_business_code = :order_of_business_code AND
                    added_by = :added_by");

                $stmt2->execute(['order_of_business_id'=>$order_of_business_id, 'order_of_business_code'=>$order_of_business_code, 'added_by'=>$userid ]);
                $result2 = $stmt2->fetch();



                if($result2) {

                    if($result2['maxordering'] == 0) {
                        $output = array("success", "Success Found", "Succesfully Removed", 1);
                    }else{
                        $output = array("success", "Success Found", "Succesfully Removed", $result2['maxordering'] - 1);
                    }
                }else {
                    $output = array("error", "Error Found", $result2);

                }

            }  else{
                $output = array("error", "Error Found", $stmt);
            }


        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();
    }


    




    // if(isset($_POST['s_table_main2'])) {
    //     $draw        = intval(0);
    //     $data        = array();
    

    //     $stmt = $conn->prepare("SELECT * FROM vw_tmp_commitees WHERE row7 = :row7");
    //     $stmt->execute(['row7'=>$userid]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){
    //         $row1           = $row['row1'];
    //         $row2           = $row['row3'];
    //         $row3           = $row['row5'];
    //         $row4           = $row['row6'];
    //         // $row5           = $row['row6'];
    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2,
    //             "row3"=>$row3,
    //             "row4"=>$row4,
    //             // "row5"=>$row5
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }

    // if(isset($_POST['transaction'])){

    //     $action     = $_POST['action'];
    //     $id         = $_POST['id'];
    //     $text_1     = strtoupper($_POST['text_1']);
    //     $text_2     = strtoupper($_POST['text_2']);

    //     try {
    //         $stmt = $conn->prepare("CALL sp_setup_department(:in_id, :in_action, :in_param1, :in_param2, :in_action_by)");
    //         $stmt->execute(['in_id'=>$id, 'in_action'=>$action, 'in_param1'=>$text_1, 'in_param2'=>$text_2, 'in_action_by'=>$userid]);
    //         $result=$stmt->fetch();
      
    //         $output = array($result['response_type'], $result['response_title'], $result['response_message']);
    //     }catch (PDOException $e) {

    //         if (strpos($e, 'department_code') !== false) {
    //             $output = array("error","Please try new Department Code.", "Department Code Already Exist.");
    //         }else{
    //             $output = array("error","Error Found", $e->getMessage());
    //         }

            
          

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }
    


    if(isset($_POST['gen_cover_page'])) {

        $words = explode(" ", $userdeptname);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= mb_substr($w, 0, 1);
        }
        $order_of_business_code                =$_POST['order_of_business_code'];
        $order_of_business_date                =$_POST['order_of_business_date'];
        $or_code                               =$order_of_business_code  ;

        try {


            
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

        
                $stmt = $conn->prepare("CALL sp_generate_cover_photo(:in_action, :in_barcode, :in_order_business_date, :in_action_by)");

                $stmt->execute(['in_action'=>'generate', 'in_barcode'=>$order_of_business_code, 'in_order_business_date'=>$order_of_business_date, 'in_action_by'=>$userid]);

                $result = $stmt->fetch();
                
                $string = $result['barcodeloop'];

                if($stmt) {
                    $stmt->closeCursor();
                    $string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
                    $array = explode(',', $string); 
                    foreach($array as $value) 
                    {
                        if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
                            mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);

                            $selectallbusiness = $conn ->prepare("SELECT GROUP_CONCAT(barcode) as allbusiness FROM search_order_of_business 
                            WHERE order_of_business_code = :order_of_business_code"); 
                
                            $selectallbusiness->execute(['order_of_business_code'=>$or_code]);
                            $resultallbusiness = $selectallbusiness->fetch();
                        
                
                            $stringbusiness = $resultallbusiness['allbusiness'];
                            $stringbusiness = preg_replace('/\.$/', '', $stringbusiness);
                            $arraybusiness = explode(',', $stringbusiness); 
                            foreach($arraybusiness as $valuebusiness) //loop over values
                            {
                               
                                $filesbusiness = $valuebusiness;
                                $pathbusiness = "../img/barcodes/$valuebusiness";
                                $put = file_put_contents("../modules/imgsbarcode/$valuebusiness.jpg", $generator->getBarcode($valuebusiness, $generator::TYPE_CODE_128));
                                    $tmpFilePath =  $valuebusiness;
                                    if ($tmpFilePath != ""){
                                        $newFilePath = $path."/". str_replace(' ', '_', $valuebusiness);
                                        $getattachmentname =  str_replace(' ', '_',  $valuebusiness);
                                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                            $str .= $getattachmentname . $delimiter;
                                        }
                                    }
                    
                                if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
                                    mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);
                                }
                            }

                        }
                    }

                    $output = array("success", "Please Wait", $order_of_business_code, $or_code );
                }else{
                    $output = array("error", "Error Found", $stmt);
                }
                
            } else {
                $output = array("error", "Error Found", "Unable to create path.");
            }


        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();
    }
?>