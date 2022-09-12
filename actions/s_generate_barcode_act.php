<?php
    include "../modules/session.php";
    require '../vendor/autoload.php';

    $conn = $pdo->open();
    $generator = new Picqer\Barcode\BarcodeGeneratorJPG();






    if(isset($_POST['generate_barcode'])) { 

        $usercid = $_POST['userc_id'];
        $typeofperson = $_POST['typeofperson'];
        $delimiter      = " ";



        try {
            if( $usercid == 0 || empty($usercid)) {
                $output = array("error", "Error Found", "Please Select a Person");

            }else if( $typeofperson == 0 || empty($typeofperson)) {
                $output = array("error", "Error Found", "Please Select a type");

            }else{

                $stmt = $conn->prepare("call sp_generate_barcode(:in_action , :in_userid, :in_typeofperson, :in_action_by)");
                $stmt->execute(['in_action'=>'generate', 'in_userid'=>$usercid, 'in_typeofperson'=>$typeofperson, 'in_action_by'=>$userid]);
                $result = $stmt->fetch();
                $stmt->closeCursor();
                if($stmt) {

                    $stmt2 = $conn->prepare("SELECT row2, row4 FROM vw_barcode_to_print WHERE row9 = :row9 AND row10 = :row10");
                    $stmt2->execute(['row9'=>0, 'row10'=>$userid]);
                    $rowcount2 = $stmt2->rowCount();
                    $result2 = $stmt2->fetchAll();

                        foreach ($result2 as $row2) {
                         
                            $barcode = $row2['row2']."_".$row2['row4'];
                            $path = "../img/barcodes/$barcode";
                            file_put_contents("../modules/imgsbarcode/$barcode.jpg", $generator->getBarcode($barcode, $generator::TYPE_CODE_128));



                                // mkdir($path, 0777, true);
                            
                                $files = $barcode;
                                $total_count = $rowcount2;
                
                                for( $i=0 ; $i < $total_count ; $i++ ) {
                                    $tmpFilePath =  $barcode[$i];
                                    if ($tmpFilePath != ""){
                                        $newFilePath = $path."/". str_replace(' ', '_', $barcode[$i]);
                                        $getattachmentname =  str_replace(' ', '_',  $barcode[$i]);
                                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                            $str .= $getattachmentname . $delimiter;
                                        }
                                    }
                                }
                            
                        }

                    $output = array($result['message_success'], $result['message_title'], $result['message_body']);

                }else{
                    $output = array("error", "Error Found", $stmt);

                }


               

            }



        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();

    }

    if(isset($_POST['update_print_bc'])) { 

        try {
    
                $stmt = $conn->prepare("call sp_generate_barcode(:in_action , :in_userid, :in_typeofperson, :in_action_by)");
                $stmt->execute(['in_action'=>'upbarcode', 'in_userid'=>NULL, 'in_typeofperson'=>NULL, 'in_action_by'=>$userid]);
                $result = $stmt->fetch();

                if($stmt) {
                    $output = array($result['message_success'], $result['message_title'], $result['message_body']);

                }else{ 
                    $output = array("error",  "Error Found", $stmt);
                }


        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();

    }

    if(isset($_POST['get_forms'])) {

        $contract_id  = $_POST['x'];

        
        try {
            $output = "";
    
            $stmt = $conn->prepare("SELECT row1, row3 FROM vw_contract_forms WHERE row2 = :row2");
            $stmt->execute(['row2'=>$contract_id]);
            $count = $stmt->rowCount();

            if($count == 0) {
                $output = array("error", "Error Found", "No Setup for this Contract");
            }else {

                foreach ($stmt as $row) {
                    $output .= "<input type='checkbox' id='v_".$row['row1']."' name='v_".$row['row1']."' value='Bike'>&nbsp;   <label for='v_".$row['row1']."'> ".$row['row3']."</label><br>" ;
                }
            }
        }catch (PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());
            
        }
        echo json_encode($output);
        $pdo->close();


    }


    if(isset($_POST['create_order_of_busineess'])) {


        $barcode                = $_POST['barcode'];
        $order_business_id      = $_POST['order_business_id'];
        $order_title            = $_POST['order_title'];
        $order_ordinance_code   = $_POST['order_ordinance_code'];
        $order_description      = $_POST['order_description'];
        
        try {
     
            if (empty($order_business_id)) {
                $output = array("error", "Error Found", "Order of Business is Required");
            }else   if (empty($order_title)) {
                $output = array("error", "Error Found", "Title is Required");
            }else   if (empty($order_ordinance_code)) {
                $output = array("error", "Error Found", "Ordinance Code is Required");
            }else {
                
                $stmt = $conn->prepare("INSERT INTO tmp_order_of_business(barcode, order_of_business_id, title, ordinance_code, description, added_by)
                                        VALUES(:barcode, :order_of_business_id, :title, :ordinance_code, :description, :added_by)");
                $stmt->execute(['barcode'=>$barcode, 'order_of_business_id'=>$order_business_id, 'title'=>$order_title,  'ordinance_code'=>$order_ordinance_code, 'description'=>$order_description, 'added_by'=>$userid ]);
                
                if($stmt) {
                    $output = array("success", "Success", "Successfully Added");
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


    if(isset($_POST['s_table_main1'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT * FROM vw_gen_order_business WHERE row9 = :row9");
        $stmt->execute(['row9'=>$userid]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['row1'];
            $row2           = $row['row3'];
            $row3           = $row['row4'];
            $row4           = $row['row5'];
            $row5           = $row['row6'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }



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
    // if(isset($_POST['s_table_main'])) {
    //     $draw        = intval(0);
    //     $data        = array();
    

    //     $stmt = $conn->prepare("SELECT * FROM vw_setup_sub_department WHERE row5 = :row5");
    //     $stmt->execute(['row5'=>1]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){
    //         $row1           = $row['row1'];
    //         $row2           = $row['row2'];
    //         $row3           = $row['row3'];
    //         $row4           = $row['row4'];
    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2,
    //             "row3"=>$row3,
    //             "row4"=>$row4
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }
?>