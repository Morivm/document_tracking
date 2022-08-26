<?php
    include '../modules/session.php';
    $conn = $pdo->open();

    $deptname =    $userdeptname;
    $deptcode =    $usedeptcode;


 
    if(isset($_POST['transaction'])) {
        $barcode = $_POST['text_1'];
        $rec_by = ucwords($_POST['text_2']);
        $status = $_POST['text_3'];

        try {
            // dito ung forward
         

            $dtime = date("Y-m-d H:i:s");   
            
            if($status == "PENDING") {

                $stmt1 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                $stmt1->execute(['barcode'=>$barcode]);
                $result1 = $stmt1->fetch();
                $dtGetDocId= $result1['doc_id'];

                // $output = array("error","Suc Found", $dtGetDocId);

                if ($dtGetDocId != 0) {
                    
                    $docId = $dtGetDocId;

                    $stmt2 = $conn->prepare("UPDATE tbl_Recieved set status = 'RECEIVED' where received_id = :received_id");
                    $stmt2->execute(['received_id'=>$dtGetDocId]);

                    $stmt3 = $conn->prepare("UPDATE tbl_documentMovement set receivedDate = :receivedDate, receivedby = :receivedby, receivedbyName = :receivedbyName where doc_id =:doc_id");
                    $stmt3->execute(['receivedDate'=>$dtime, 'receivedby'=>'Received by '.$rec_by, 'receivedbyName'=>$rec_by, 'doc_id'=>$docId ]);
                    
                    $stmt4 = $conn->prepare("SELECT top(1) * from vw_getProcessingTime where barcode = :barcode order by doc_id desc");
                    $stmt4->execute(['barcode'=>$barcode]);
                    $result4 = $stmt4->fetch();
                    $dtGetDdate = $result4['TotalHoursText'];

                    $stmt5 = $conn->prepare("UPDATE tbl_documentMovement set [processingTime(mins)] = '".$dtGetDdate."'  where doc_id = :doc_id");
                    $stmt5->execute(['doc_id'=>$docId]);

                    
                    $stmt6 = $conn->prepare("SELECT top(1)* from vw_doc where barcode =  :barcode order by received_id desc");
                    $stmt6->execute(['barcode'=>$barcode]);
                    $result6 = $stmt6->fetch();
                    $lblDate    = $result6['recievedDate'];
                    $lblDate2   = $result6['doctype_name'];
                    $lblDate3   = $result6['Barcode'];
                    $lblDate4   = $result6['doctype_code'];
                    $lblDate5   = $result6['dept_code'];
                    $lblDate6   = $result6['ProjectTitle'];
                    $lblDate7   = $result6['Due'];
                    $lblDate8   = $result6['PLM'];
                    $lblDate9   = $result6['Description'];
                    
                    


                    $stmt7 = $conn->prepare("SELECT [duration(hrs)] as duration from vw_doctype where doctype_name = :doctype_name");
                    $stmt7->execute(['doctype_name'=>$lblDate2]);
                    $result7 = $stmt7->fetch();
                    $dtduration = $result7['duration'];

                    $stmt8 = $conn->prepare("SELECT attachment from tbl_documentMovement where doc_id = :doc_id");
                    $stmt8->execute(['doc_id'=>$dtGetDocId]);
                    $result8 = $stmt8->fetch();
                    $dtgetAttachs = $result8['attachment'];


                    $stmt9 = $conn->prepare("EXEC usp_add_recieved
                                            @Barcode = :Barcode,
                                            @doctype_code = :doctype_code,
                                            @dept_code = :dept_code,
                                            @RecievedFrom = :RecievedFrom,
                                            @RecievedBy = :RecievedBy,
                                            @recievedDate = :recievedDate,
                                            @ProjectTitle = :ProjectTitle,
                                            @ProjectDuration = :ProjectDuration,
                                            @ProjectPrice = :ProjectPrice,
                                            @PLM= :PLM,
                                            @Description = :Description,
                                            @STATUS = :STATUS,
                                            @trans_stat = :trans_stat");

                    $stmt9->execute([
                                    'Barcode'=>$lblDate3, 
                                    'doctype_code'=>$lblDate4,
                                    'dept_code'=>$lblDate5 , 
                                    'RecievedFrom'=>'',
                                    'RecievedBy'=>$userempname,
                                    'recievedDate'=>$lblDate,
                                    'ProjectTitle'=>$lblDate6,
                                    'ProjectDuration'=>$dtduration,
                                    'ProjectPrice'=>$lblDate7,
                                    'PLM'=>$lblDate8,
                                    'Description'=>$lblDate9,
                                    'STATUS'=>'PENDING',
                                    'trans_stat'=>'6'
                                    ]);
            
                    
                    $stmt10 = $conn->prepare("SELECT top(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                    $stmt10->execute(['barcode'=>$barcode]);
                    $result10 = $stmt10->fetch();
                    $getlastrecord = $result10['received_id'];

                    $stmt11 = $conn->prepare("EXEC usp_add_due");
                    $stmt11->execute();
                    $result11 = $stmt11->fetch();
                    $datetimedue = $result11['DatePlus2WorkDays'];
                    $tme =date('H:i:s');

                    $stmt12 = $conn->prepare("UPDATE tbl_recieved set due = :due where received_id = :received_id");
                    $stmt12->execute(['due'=>$datetimedue.' '.$tme, 'received_id'=>$getlastrecord ]);

                    $stmt13 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode =  :barcode order by doc_id desc");
                    $stmt13->execute(['barcode'=>$barcode]); 
                    $result13 = $stmt13->fetch();
                    $getLastRecordMovement =$result13['doc_id'];

                    $stmt13_1 = $conn->prepare("SELECT top(1) (select top(1) dept_name from tbl_departments where dept_code =dept_code ) AS dept_code from tbl_recieved where Barcode = :Barcode");
                    $stmt13_1->execute(['Barcode'=>$barcode]); 
                    $result13_1 = $stmt13_1->fetch();
                    $creatordep =$result13_1['dept_code'];

                

                    $stmt14 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment, doccreated_start = :doccreated_start, doccreated_to=:doccreated_to  where doc_id = :doc_id");
                    $stmt14->execute(['attachment'=>$dtgetAttachs, 'doccreated_start'=>$creatordep, 'doccreated_to'=>$userdeptname, 'doc_id'=>$getLastRecordMovement]); 

                    $output = array("success","Success", "Please process the document within 72HRS");

                }else{
                    $output = array("error,Error Found", "Please double check data.");

                }


            }else if($status =="RETURN"){

                
                $barcode = $_POST['text_1'];
                $rec_by = $_POST['text_2'];
                $status = $_POST['text_3'];
                
                $stmt1 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                $stmt1->execute(['barcode'=>$barcode]);
                $result1 = $stmt1->fetch();
                $dtGetDocId = $result1['doc_id'];

                if($dtGetDocId != 0) {
                    $_docId = $dtGetDocId;

                    $_username = $userdeptname;
                    $stmt0 = $conn->prepare("SELECT top(1) received_id, barcode,doctype_code,projecttitle,recievedDate from tbl_recieved where barcode = :barcode and tbl_recieved.RecievedFrom = :RecievedFrom order by received_id desc");
                    $stmt0->execute(['barcode'=>$barcode , 'RecievedFrom'=>$_username]);
                    $result0 = $stmt0->fetch();
                    $dtGetid = $result0['received_id'];

                    
                    $stmt13_2 = $conn->prepare("SELECT top(1) (select top(1) dept_name from tbl_departments where dept_code =dept_code ) AS dept_code from tbl_recieved where Barcode = :Barcode");
                    $stmt13_2->execute(['Barcode'=>$barcode]); 
                    $result13_2 = $stmt13_2->fetch();
                    $creatordep2 =$result13_2['dept_code'];


                    $stmt2 = $conn->prepare("UPDATE tbl_Recieved set status = 'RECEIVED BY CREATOR' where received_id = :received_id");
                    $stmt2->execute(['received_id'=>$dtGetid]);

                    $stmt3 = $conn->prepare("UPDATE tbl_documentMovement set receivedDate = :receivedDate , receivedby = :receivedby, receivedbyName = :receivedbyName,  doccreated_start = :doccreated_start, doccreated_to=:doccreated_to where doc_id = :doc_id");
                    $stmt3->execute(['receivedDate'=>$dtime, 'receivedby'=>'Received by '.$rec_by, 'receivedbyName'=>$rec_by, 'doccreated_start'=>$creatordep2, 'doccreated_to'=>$userdeptname,'doc_id'=>$_docId]);

                    $stmt4 = $conn->prepare("SELECT top(1) * from vw_getProcessingTime where barcode = :barcode order by doc_id desc");
                    $stmt4->execute(['barcode'=>$barcode]);
                    $result4 = $stmt4->fetch();
                    $dtGetDdate = $result4['TotalHoursText'];

                    $stmt5 = $conn->prepare("UPDATE tbl_documentMovement set [processingTime(mins)] = '".$dtGetDdate."'  where doc_id = :doc_id");
                    $stmt5->execute(['doc_id'=>$_docId]);

                    $output = array("success","Success", "Please process the document within 72HRS");


                }else{
                    $output = array("error", "Error Found", "Please double check data.");

                }


            }else{
                $output = array("error","Error Found", "Please Reload The page");

            }


            
        



        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();

    }

    if(isset($_POST['transaction_approved'])) {

        $_docId     = "";
        $barcode    = $_POST['barcode'];
        $keepby2    = $_POST['text_2_3'];
        $keepbytxt  = ucwords($_POST['text_2_30']);
        $remarks    = ucwords($_POST['text_2_4']);
        $docstats   = $_POST['text_2_5'];
        $delimiter      = " ";
        $str            = '';
        $files = array_filter($_FILES['text_2_2']['name']);
        $total_count = count($_FILES['text_2_2']['name']);

        $keepby = "";
        $dtNow = date("Y-m-d H:i:s");    
        try {
            ($keepby2 == "OTHERS") ? $keepby = $keepbytxt : $keepby = $keepby2;


            if($docstats == "transfer") {
             
                $Label11 = "";
                $stmt0 = $conn->prepare("SELECT top(1) id from tbl_receiving_dept where barcode = :barcode order by id desc");
                $stmt0->execute(['barcode'=>$barcode]);
                $result0 = $stmt0->fetch();
                $dtgelastid = $result0['id'];

                
                $stmt0_1 = $conn->prepare("SELECT dept_name,id from tbl_receiving_dept where barcode = :barcode and status = 'TURN'");
                $stmt0_1->execute(['barcode'=>$barcode]);
                $result0_1 = $stmt0_1->fetch();
                $dtcheckiflast1 = $result0_1['dept_name'];
                $dtcheckiflast2 = $result0_1['id'];

                if ($dtgelastid != $dtcheckiflast2) {
                    $next = "";
                    $stmt0_2 = $conn->prepare("SELECT id from tbl_receiving_dept where status = 'TURN' and barcode = :barcode");
                    $stmt0_2->execute(['barcode'=>$barcode]);
                    $result0_2 = $stmt0_2->fetch();
                    $dtgetlastreceiver = $result0_2['id'];

                    $next = $dtgetlastreceiver + 1;

                    $stmt0_3 = $conn->prepare("SELECT dept_name from tbl_receiving_dept where barcode = :barcode and id = :id");
                    $stmt0_3->execute(['barcode'=>$barcode, 'id'=>$next]);
                    $result0_3 = $stmt0_3->fetch();
                    $dtgetnext = $result0_3['dept_name'];
                    $Label11  = $dtgetnext;


                }else{

                    $Label11 = $dtcheckiflast1;
                }


                $stmt1 = $conn->prepare("SELECT top(1)* from vw_doc where barcode = :barcode order by received_id desc");
                $stmt1->execute(['barcode'=>$barcode]);
                $result1 = $stmt1->fetch();
                $lblPrice = $result1['Due'];

                if($lblPrice=="") {
                  
                    // $stmt2 = $conn->prepare("SELECT top(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                    // $stmt2->execute(['barcode'=>$barcode]);
                    // $result2 = $stmt2->fetch();
                    // $getLastRecord = $result2['received_id'];

                    // $stmt3 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                    // $stmt3->execute(['barcode'=>$barcode]);
                    // $result3 = $stmt3->fetch();
                    // $getLastRecordMovement = $result2['doc_id'];

                    // $stmt4 = $conn->prepare("UPDATE tbl_Recieved set RecievedFrom = :RecievedFrom where received_id = :received_id");
                    // $stmt4->execute(['RecievedFrom'=>$Label11, 'received_id'=>$getLastRecord]);
             
                    // $stmt5 = $conn->prepare("UPDATE tbl_documentMovement set remarks = :remarks, Transac = :Transac, doc_to = :doc_to where doc_id = :doc_id");
                    // $stmt5->execute(['remarks'=>$remarks, 'Transac'=>"Transfer To ".$Label11, 'doc_to'=>$userdeptname, 'doc_id'=>$getLastRecordMovement ]);
             
                    
                    // for( $i=0 ; $i < $total_count ; $i++ ) {
                    //     $tmpFilePath = $_FILES['text_2_2']['tmp_name'][$i];
                    //     if ($tmpFilePath != ""){
                    //         $newFilePath = "../img/barcodes/$barcode/" . str_replace(' ', '_', $_FILES['text_2_2']['name'][$i]);
                    //         $getattachmentname =  str_replace(' ', '_', $_FILES['text_2_2']['name'][$i]);
                    //         if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    //             $str .= $getattachmentname . $delimiter;
                    //         }
                    //     }
                    // }

                    // if ($str == ""){

              
                    //     $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                    //     $stmt6->execute(['attachment'=>$barcode.".pdf", 'doc_id'=>$getLastRecordMovement]);

                    // }else{
                    //     $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                    //     $stmt6->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doc_id'=>$getLastRecordMovement]);
                    // }

                 


                    // $stmt7 = $conn->prepare("SELECT top(1) id, barcode,dept_name,status from tbl_receiving_dept where barcode = :barcode and dept_name = :dept_name and status = :status order by id desc");
                    // $stmt7->execute(['barcode'=>$barcode, 'dept_name'=>$userdeptname, 'status'=>'TURN']);
                    // $result7 = $stmt7->fetch();
                    // $dtGetBarcode = $result7['id'];

                


                    // $stmt8 = $conn->prepare("UPDATE tbl_receiving_dept SET status = 'DONE' where id = :id");
                    // $stmt8->execute(['id'=>$dtGetBarcode]);


                    // $stmt9 = $conn->prepare("SELECT top(1) status from tbl_receiving_dept where barcode = :barcode order by id desc");
                    // $stmt9->execute(['barcode'=>$barcode]);
                    // $result9 = $stmt9->fetch();
                    // $dtchecklast = $result9['status'];

                    // if($dtchecklast =="NOT YET TURN") {
                    //     $dtGetBarcode + 1;

                    //     $stmt10 = $conn->prepare("UPDATE tbl_receiving_dept set status = 'TURN' where id = :id");
                    //     $stmt10->execute(['id'=>$dtGetBarcode]);

                    // }
                    // $output = array("success","Success","Tranfer no due");

                    $output = array("error","Error Found","Please Reload Your Page");
                }else{

            


                    $_val = $lblPrice;

                    $stmt1 = $conn->prepare("SELECT top(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                    $stmt1->execute(['barcode'=>$barcode]);
                    $result1 = $stmt1->fetch();
                    $getLastRecord = $result1['received_id'];

                    $stmt2 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                    $stmt2->execute(['barcode'=>$barcode]);
                    $result2 = $stmt2->fetch();
                    $getLastRecordMovement = $result2['doc_id'];



                    $stmt3 = $conn->prepare("UPDATE tbl_Recieved set RecievedFrom = :RecievedFrom where received_id = :received_id");
                    $stmt3->execute(['RecievedFrom'=>$Label11, 'received_id'=>$getLastRecord]);
                    
                    $stmt4 = $conn->prepare("UPDATE tbl_documentMovement set remarks = :remarks, Transac = :Transac , doc_to = :doc_to  where doc_id = :doc_id");
                    $stmt4->execute(['remarks'=>$remarks, 'Transac'=>'Transfer To ' .$Label11, 'doc_to'=>$userdeptname, 'doc_id'=>$getLastRecordMovement]);
                    

                     for( $i=0 ; $i < $total_count ; $i++ ) {
                        $tmpFilePath = $_FILES['text_2_2']['tmp_name'][$i];
                        if ($tmpFilePath != ""){
                        $newFilePath = "../img/barcodes/$barcode/" . $_FILES['text_2_2']['name'][$i];
                        $getattachmentname =  str_replace(' ', '_', $_FILES['text_2_2']['name'][$i]);
                            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                $str .= $getattachmentname . $delimiter;
                            }
                        }
                    }


                    if ($str != ""){

                        $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                        $stmt6->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doc_id'=>$getLastRecordMovement]);
                    
                        // $filessonfolder = "";
                
                        // foreach(glob("../img/barcodes/$barcode/*.*") as $file) {
                        //     $filessonfolder .= " ".$resStr = str_replace("../img/barcodes/$barcode/", "", $file); ;
                        // }

                        // $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                        // $stmt6->execute(['attachment'=>$barcode.".pdf". " ".str_replace("$barcode.pdf ","" ,$filessonfolder), 'doc_id'=>$getLastRecordMovement]);

                    }


                    $stmt7 = $conn->prepare("SELECT top(1) id, barcode,dept_name,status from tbl_receiving_dept where barcode = :barcode and dept_name = :dept_name and status = 'TURN' order by id desc");
                    $stmt7->execute(['barcode'=>$barcode, 'dept_name'=>$userdeptname]);
                    $result7 = $stmt7->fetch();
                    $dtGetBarcode = $result7['id'];

                


                    $stmt8 = $conn->prepare("UPDATE tbl_receiving_dept SET status = 'DONE' where id = :id");
                    $stmt8->execute(['id'=>$dtGetBarcode]);


                    $stmt9 = $conn->prepare("SELECT top(1) status from tbl_receiving_dept where barcode = :barcode order by id desc");
                    $stmt9->execute(['barcode'=>$barcode]);
                    $result9 = $stmt9->fetch();
                    $dtchecklast = $result9['status'];

                    if($dtchecklast =="NOT YET TURN") {
                        $plusdtGetBarcode =  $dtGetBarcode + 1;

                        $stmt10 = $conn->prepare("UPDATE tbl_receiving_dept set status = 'TURN' where id = :id");
                        $stmt10->execute(['id'=>$plusdtGetBarcode]);

                    }
                    

                    $output = array("success","Success","Succesfully Transfer to ".$Label11);
       
          
                }

            }else if($docstats == "approved") {
       
          



                if($keepby =="") {

                    $output = array("error","Error Found", "Keep By is Required");

                }else{

                    $stmt1 = $conn->prepare("UPDATE tbl_recieved set Status = 'Approved' where barcode = :barcode");
                    $stmt1->execute(['barcode'=>$barcode]);


                    $stmt2 = $conn->prepare("SELECT top(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                    $stmt2->execute(['barcode'=>$barcode]);
                    $result2 = $stmt2->fetch();
                    $getLastRecord = $result2['received_id'];


                    $stmt3 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                    $stmt3->execute(['barcode'=>$barcode]);
                    $result3 = $stmt3->fetch();
                    $getLastRecordMovement = $result3['doc_id'];

                    $stmt4 = $conn->prepare("UPDATE tbl_Recieved set RecievedFrom = :RecievedFrom where received_id = :received_id");
                    $stmt4->execute(['RecievedFrom'=>$userdeptname, 'received_id'=>$getLastRecord]);
        
                    $stmt5 = $conn->prepare("UPDATE tbl_documentMovement set remarks = :remarks, Transac = :Transac , doc_to = :doc_to where doc_id = :doc_id");
                    $stmt5->execute(['remarks'=>$remarks, 'Transac'=>"Approved and Kept By ".$userdeptname, 'doc_to'=>$userdeptname, 'doc_id'=>$getLastRecordMovement]);
        
                    $stmt6 = $conn->prepare("SELECT received_id, barcode,doctype_code,projecttitle,recievedDate from tbl_recieved where barcode = :barcode");
                    $stmt6->execute(['barcode'=>$barcode]);
                    $result6 = $stmt6->fetch();
                    $dtGetBarcode = $result6['barcode'];


                    $stmt7 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
                    $stmt7->execute(['barcode'=>$dtGetBarcode]);
                    $count7 = $stmt7->rowCount();
                    if ($count7  != 0 ) {
                        $result7 = $stmt7->fetch();
                        $_docId = $result7['doc_id'];

                        $stmt8 = $conn->prepare("UPDATE tbl_recieved set Status = 'KEPT' where barcode = :barcode");
                        $stmt8->execute(['barcode'=>$barcode]);

                        $stmt9 = $conn->prepare("UPDATE tbl_documentMovement set receivedDate = :receivedDate, receivedby = :receivedby where doc_id = :doc_id");
                        $stmt9->execute(['receivedDate'=>$dtNow, 'receivedby'=>"KEPT by ".$keepby, 'doc_id'=>$_docId]);

                        $stmt10 = $conn->prepare("SELECT top(1) * from vw_getProcessingTimeApproved where barcode = :barcode");
                        $stmt10->execute(['barcode'=>$dtGetBarcode]);
                        $result10 = $stmt10->fetch();
                        $dtGetDdate = $result10['TotalHoursText'];

                        $stmt11 = $conn->prepare("UPDATE tbl_documentMovement set [processingTime(mins)] = '".$dtGetDdate."'  where doc_id = :doc_id");
                        $stmt11->execute(['doc_id'=>$_docId]);


                            for( $i=0 ; $i < $total_count ; $i++ ) {
                                $tmpFilePath = $_FILES['text_2_2']['tmp_name'][$i];
                                if ($tmpFilePath != ""){
                                $newFilePath = "../img/barcodes/$barcode/" . $_FILES['text_2_2']['name'][$i];
                                $getattachmentname =  str_replace(' ', '_', $_FILES['text_2_2']['name'][$i]);
                                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                        $str .= $getattachmentname . $delimiter;
                                    }
                                }
                            }


                        // if ($str == ""){
                        //     $filessonfolder = "";
                    
                        //     foreach(glob("../img/barcodes/$barcode/*.*") as $file) {
                        //         $filessonfolder .= " ".$resStr = str_replace("../img/barcodes/$barcode/", "", $file); ;
                        //     }

                        //     $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                        //     $stmt6->execute(['attachment'=>$barcode.".pdf". " ".str_replace("$barcode.pdf ","" ,$filessonfolder), 'doc_id'=>$getLastRecordMovement]);

                        // }else{
                        //     $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                        //     $stmt6->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doc_id'=>$getLastRecordMovement]);
                        // }

                        
                        if ($str == ""){
                            $filessonfolder = "";
                    
                            foreach(glob("../img/barcodes/$barcode/*.*") as $file) {
                                $filessonfolder .= " ".$resStr = str_replace("../img/barcodes/$barcode/", "", $file); ;
                            }

                            $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                            $stmt6->execute(['attachment'=>$barcode.".pdf ".str_replace("$barcode.pdf ","" ,$filessonfolder), 'doc_id'=>$getLastRecordMovement]);

                        }else{
                            $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                            $stmt6->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doc_id'=>$getLastRecordMovement]);
                        }


                        
                        $output = array("success","Success", "Successfully Approved");
                    }else{

                        $output = array("error","Error Found", "Please Reload Page First");
                    }
                }

            }else{

                $output = array("error","Error Found", "Please Reload Page First");
            }


        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();

    }

    if(isset($_POST['downloadattach'])) {
        $barcode = $_POST['att_barcode'];
        $pcname = trim(shell_exec("wmic computersystem get username"));
        $pcadmin = substr($pcname, strrpos($pcname,"\\") + 1);


        try{
            $resourcecopy = recurse_copy("../img/barcodes/$barcode","C:/Users/$pcadmin/Documents/$barcode");
            if ($resourcecopy) {
                $output = array("success","Success", "C:/Users/$pcadmin/Documents/$barcode");
            }else{
                $output = array("error","Error Found", $resourcecopy);
            }

 
        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        $pdo->close();
        exit();
    }

    if(isset($_POST['reuploadattach'])) {
        $barcode = $_POST['att_barcode'];

        $dir = "../img/barcodes/$barcode";
        $leave_files = array("$barcode.pdf");

     
        try{

            foreach( glob("$dir/*") as $file ) {
                if( !in_array(basename($file), $leave_files) ){
                    unlink($file);
                }
            }
            $output = array("success","Success", "Succesfully Removed");
            // $resourcecopy = recurse_copy("../img/barcodes/$barcode","C:/Users/$pcadmin/Documents/$barcode");
            // if ($resourcecopy) {
            //     $output = array("success","Success", "C:/Users/$pcadmin/Documents/$barcode");
            // }else{
            //     $output = array("error","Error Found", $resourcecopy);
            // }

 
        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        $pdo->close();
        exit();
    }

    if(isset($_POST['rec_status'])) {
        $barcode = $_POST['att_barcode'];

        try{

            $stmt1 = $conn->prepare("SELECT top(1) status from tbl_receiving_dept where barcode = :barcode order by id desc");
            $stmt1->execute(['barcode'=>$barcode]);
            $result1 = $stmt1->fetch();

            $output = array("success","Success",$result1['status']);



            // $resourcecopy = recurse_copy("../img/barcodes/$barcode","C:/Users/$pcadmin/Documents/$barcode");
            // if ($resourcecopy) {
            //     $output = array("success","Success", "C:/Users/$pcadmin/Documents/$barcode");
            // }else{
            //     $output = array("error","Error Found", $resourcecopy);
            // }

 
        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());
        }

        echo json_encode($output);
        $pdo->close();
        exit();
    }


    if(isset($_POST['returncreator'])) {
        
        $barcode        = $_POST['barcode'];
        $remarks        = ucwords($_POST['text_3_1']);
        $userA          = ucwords($_POST['text_4_1']);
        $total_count    = count($_FILES['text_3_2']['name']); 
        $str            = '';
        $delimiter      = " ";
        try {

            $_value = date("Y-m-d H:i:s");   

             
            $stmt0 = $conn->prepare("SELECT top(1) (select top(1) dept_name from tbl_departments where dept_code = a.dept_code ) AS lbldepartment  from tbl_recieved a where a.Barcode= :Barcode");
            $stmt0->execute(['Barcode'=>$barcode]);
            $result0 = $stmt0->fetch();
            $lblDepartment = $result0['lbldepartment'];




        
            $stmt1 = $conn->prepare("SELECT top(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
            $stmt1->execute(['barcode'=>$barcode]);
            $result1 = $stmt1->fetch();
            $getLastRecord = $result1['received_id'];

            $stmt2 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
            $stmt2->execute(['barcode'=>$barcode]);
            $result2 = $stmt2->fetch();
            $getLastRecordMovement = $result2['doc_id'];

            
            $stmt3 = $conn->prepare("INSERT into tbl_doc_created(dept_name,barcode,created_datetime,created_status,reason, added_user) 
                                    VALUES 
                                    (:dept_name, :barcode, :created_datetime, :created_status, :reason, :added_user)");
            $stmt3->execute(['dept_name'=>$lblDepartment, 'barcode'=>$barcode, 'created_datetime'=>$_value, 'created_status'=>'Active', 'reason'=>$remarks, 'added_user'=>$userA]);

            $stmt4 =$conn->prepare("UPDATE tbl_Recieved set RecievedFrom = :RecievedFrom, STATUS = 'RETURN' where received_id = :received_id");
            $stmt4->execute(['RecievedFrom'=>$lblDepartment, 'received_id'=>$getLastRecord ]);

            $stmt5 = $conn->prepare("UPDATE tbl_documentMovement set remarks = :remarks, Transac = :Transac , doc_to = :doc_to where doc_id = :doc_id");
            $stmt5->execute(['remarks'=>$remarks ."<br><hr>". "&nbsp; &nbsp; &nbsp; &nbsp; USER: " .$userA, 'Transac'=>'Returned To '.$lblDepartment, 'doc_to'=>$lblDepartment, 'doc_id'=>$getLastRecordMovement]);

            for( $i=0 ; $i < $total_count ; $i++ ) {
                $tmpFilePath = $_FILES['text_3_2']['tmp_name'][$i];
                if ($tmpFilePath != ""){
                $newFilePath = "../img/barcodes/$barcode/" . $_FILES['text_3_2']['name'][$i];
                $getattachmentname =  str_replace(' ', '_', $_FILES['text_3_2']['name'][$i]);
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $str .= $getattachmentname . $delimiter;
                    }
                }
            }
           
            if ($str == ""){
                $filessonfolder = "";
        
                foreach(glob("../img/barcodes/$barcode/*.*") as $file) {
                    $filessonfolder .= " ".$resStr = str_replace("../img/barcodes/$barcode/", "", $file); ;
                }

                $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                $stmt6->execute(['attachment'=>$barcode.".pdf". " ".str_replace("$barcode.pdf ","" ,$filessonfolder), 'doc_id'=>$getLastRecordMovement]);

            }else{
                $stmt6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                $stmt6->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doc_id'=>$getLastRecordMovement]);
            }


  

            $output = array("success", "Success", "Successfully Return To ".$lblDepartment);

        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());


        } 

        echo json_encode($output);
        $pdo->close();

    }

    if(isset($_POST['tbl_1'])) {
        $draw        = intval(0);
        $data        = array();
    
  
        $stmt = $conn->prepare("SELECT *,  (Select top(1) received_id from tbl_recieved where barcode ='OCOOIR20220802134713' order by received_id desc) as lastid   FROM vw_doc where vw_doc.RecievedFrom = :RecievedFrom or vw_doc.froms = :froms or vw_doc.dept_code = :dept_code order by received_id desc");
        $stmt->execute(['RecievedFrom'=>$userdeptname, 'froms'=>$userdeptname,  'dept_code'=>$usedeptcode ]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['received_id'];
            $row2           = $row['Barcode'];
            $row3           = $row['doctype_name'];
            $row4           = $row['ProjectTitle'];
            $row5           = $row['doc_from']." "."(<i>".$row['RecievedBy']."</i>)";     
            $row6           = $row['RecievedFrom'];
            $row7           = date_format(date_create($row['Due']),'m/d/Y g:i a');
            $row8           = $row['STATUS'];
            $row9           = $row['receivedByName'];
            $row10          = $row['lastid'];
            $row11          = $row['doc_from'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
                "row6"=>$row6,
                "row7"=>$row7,
                "row8"=>$row8,
                "row9"=>$row9,
                "row10"=>$row10,
                "row11"=>$row11
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);    
        $pdo->close();
    }




?>