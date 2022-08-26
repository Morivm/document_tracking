<?php
    include '../modules/session.php';
    $conn = $pdo->open();


    if(isset($_POST['tbl_1'])) {
        $draw        = intval(0);
        $data        = array();
    
  
        $stmt = $conn->prepare("SELECT * from tbl_doc_created where dept_name = :dept_name and created_status = 'Active'");
        $stmt->execute(['dept_name'=>$userdeptname]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1               = $row['created_id'];
            $row2               = $row['barcode'];
            $row3               = $row['reason'];
            $row4               = date_format(date_create($row['created_datetime']),'m/d/Y g:i a');
            $row5               = $row['created_status'];
            $row6               = ($row['updated_datetime'] =="") ? "" : date_format(date_create($row['updated_datetime']),'m/d/Y g:i a');
            

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
                "row6"=>$row6,
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);    
        $pdo->close();
    }

    //............................................................................
    //.RRRRRRRRRR...EEEEEEEEEEE.ETTTTTTTTTTUUUU...UUUU..RRRRRRRRRR...NNNN...NNNN..
    //.RRRRRRRRRRR..EEEEEEEEEEE.ETTTTTTTTTTUUUU...UUUU..RRRRRRRRRRR..NNNNN..NNNN..
    //.RRRRRRRRRRR..EEEEEEEEEEE.ETTTTTTTTTTUUUU...UUUU..RRRRRRRRRRR..NNNNN..NNNN..
    //.RRRR...RRRRR.EEEE...........TTTT....UUUU...UUUU..RRRR...RRRRR.NNNNNN.NNNN..
    //.RRRR...RRRRR.EEEE...........TTTT....UUUU...UUUU..RRRR...RRRRR.NNNNNN.NNNN..
    //.RRRRRRRRRRR..EEEEEEEEEE.....TTTT....UUUU...UUUU..RRRRRRRRRRR..NNNNNNNNNNN..
    //.RRRRRRRRRRR..EEEEEEEEEE.....TTTT....UUUU...UUUU..RRRRRRRRRRR..NNNNNNNNNNN..
    //.RRRRRRRR.....EEEEEEEEEE.....TTTT....UUUU...UUUU..RRRRRRRR.....NNNNNNNNNNN..
    //.RRRR.RRRR....EEEE...........TTTT....UUUU...UUUU..RRRR.RRRR....NNNNNNNNNNN..
    //.RRRR..RRRR...EEEE...........TTTT....UUUU...UUUU..RRRR..RRRR...NNNN.NNNNNN..
    //.RRRR..RRRRR..EEEEEEEEEEE....TTTT....UUUUUUUUUUU..RRRR..RRRRR..NNNN..NNNNN..
    //.RRRR...RRRRR.EEEEEEEEEEE....TTTT.....UUUUUUUUU...RRRR...RRRRR.NNNN..NNNNN..
    //.RRRR....RRRR.EEEEEEEEEEE....TTTT......UUUUUUU....RRRR....RRRR.NNNN...NNNN..
    //............................................................................


    if(isset($_POST['check_ifapproved'])) {

        $barcode = $_POST['barcode'];
        try {
            
            $stmt1 = $conn->prepare("SELECT TOP(1) barcode from tbl_recieved where barcode = :barcode and STATUS = 'RECEIVED BY CREATOR' order by received_id desc");
            $stmt1->execute(['barcode'=>$barcode]);
            $count = $stmt1->rowCount();
            
            if($count == 0) {
                $output = array("error", "Error Found", "Please Received The Document First.");
            }else{
                $output = array("success", "Success", "Document Received");
            }


        }catch(PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
 
        echo json_encode($output);
        $pdo->close();

    }

    if(isset($_POST['check_doc_returned'])) {

        $barcode = $_POST['barcode'];
        try {
      
            $stmt1 = $conn->prepare("SELECT TOP(1) doctype_code,ProjectTitle,plm,description,RecievedBy,recievedDate from tbl_recieved where barcode = :barcode ORDER BY received_id ASC");
            $stmt1->execute(['barcode'=>$barcode]);
            $count = $stmt1->rowCount();
            
            if($count == 0) {
                $output = array("error", "Error Found", "Please Reload The Page");
            }else{
                $result1 = $stmt1->fetch();
                $output = array(
                            "success",
                            $barcode,
                            $result1['doctype_code'],
                            $result1['ProjectTitle'],
                            $result1['plm'],
                            $result1['description'],
                            $result1['RecievedBy'],
                            $result1['recievedDate']
                );
            }

        }catch(PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
 
        echo json_encode($output);
        $pdo->close();

    }

    if(isset($_POST['checkassignatories'])) {
        $draw        = intval(0);
        $data        = array();
        
        $barcode = $_POST['barcode'];
        $checking = $_POST['check'];

        if($checking == "old") {
            $stmt = $conn->prepare("SELECT * from tbl_receiving_dept where barcode = :barcode and status <> 'UPDATED' order by id asc");
            $stmt->execute(['barcode'=>$barcode]);
            $records = $stmt->fetchAll();
            $data = array();
            foreach($records as $row){
                $row1               = $row['id'];
                $row2               = $row['dept_name'];
                $row3               = "<button type='button' class='btn btn-primary btn-actions' data-action='delete_tmp' data-id='$row1' disabled>Delete</button>";
    
                $data[] = array(
                    "row1"=>$row1,
                    "row2"=>$row2,
                    "row3"=>$row3
                );
            }
            $response = array(
                "aaData" => $data
            );
            echo json_encode($response);    
            $pdo->close();
        }else if($checking == "new") {

            $stmt = $conn->prepare("SELECT * from tmp_receiving_dept where barcode_id = :barcode_id and status <> 'UPDATED' order by id asc");
            $stmt->execute(['barcode_id'=>$barcode]);
            $records = $stmt->fetchAll();
            $data = array();
            foreach($records as $row){
                $row1               = $row['id'];
                $row2               = $row['dept_name'];
                $row3               = "<button type='button' class='btn btn-primary btn-actions' data-action='delete_tmp' data-id='$row1'>Delete</button>";
    
                $data[] = array(
                    "row1"=>$row1,
                    "row2"=>$row2,
                    "row3"=>$row3
                );
            }
            $response = array(
                "aaData" => $data
            );
            echo json_encode($response);    
            $pdo->close();

        }else{
            $response = array("error", "error" , "error");
        }
  
       
    }

    if(isset($_POST['create_doc'])) {
        
        $barcode        = $_POST['text_2'];
        $doctype        = "";
        $projecttitle   = ucwords($_POST['text_4']);
        $receivedby2    = $_POST['text_6'];
        $receivedbytxt  = ucwords($_POST['text6_0']);
        $lastreceidep   = $_POST['text_5'];
        $txtdescrpiton  = ucwords($_POST['text_9']);
        
        $total_count    = count(array_filter($_FILES['text_10']['name']));

        $str            = '';
        $delimiter      = " ";

        $receivedby     = "";

        try {

            ($receivedby2 == "OTHERS") ?  $receivedby =  $receivedbytxt : $receivedby = $receivedby2;

            $_value = date("Y-m-d H:i:s");   

            $stmt01 = $conn->prepare("SELECT TOP(1) doctype_code,ProjectTitle,plm,description,RecievedBy,recievedDate from tbl_recieved where barcode = :barcode ORDER BY received_id ASC ");
            $stmt01->execute(['barcode'=>$barcode]);
            $result01 = $stmt01->fetch();
            $dtDocDetails_doctype   = $result01['doctype_code'];
            $dtDocDetails_recdate   = $result01['recievedDate'];
            $dtDocDetails_projtitle = $result01['ProjectTitle'];
            $dtDocDetails_plm       = $result01['plm'];
            $dtDocDetails_descrition= $result01['description'];

            $stm02 = $conn->prepare("SELECT top(1) doctype_name from tbl_docType where doctype_code = :doctype_code");
            $stm02->execute(['doctype_code'=>$dtDocDetails_doctype]);
            $result02 = $stm02->fetch();
            $dtDocType = $result02['doctype_name'];
            
            $stm03 = $conn->prepare("SELECT dept_name from tbl_receiving_dept where barcode = :barcode and status <> 'UPDATED' order by id asc");
            $stm03->execute(['barcode'=>$barcode]);
            $result03 = $stm03->fetch();
            $dtReceivingDept = $result03['dept_name'];

            
            $stm04 = $conn->prepare("SELECT top(1) doc_id, barcode from tbl_documentMovement where barcode = :barcode  order by doc_id desc");
            $stm04->execute(['barcode'=>$barcode]);
            $result04 = $stm04->fetch();
            $dtGetLastRecord = $result04['doc_id'];




            $stm05 = $conn->prepare("SELECT attachment from tbl_documentMovement where doc_id = :doc_id order by doc_id desc");
            $stm05->execute(['doc_id'=>$dtGetLastRecord]);
            $result05 = $stm05->fetch();
            $dtGetAttach = $result05['attachment'];


            $tbAttachmentsAttach = $dtGetAttach;

            $stmt1 = $conn->prepare("UPDATE tbl_receiving_dept set status = 'UPDATED' where barcode = :barcode and status <> 'UPDATED'");
            $stmt1->execute(['barcode'=>$barcode]);
       
            $stmt2 = $conn->prepare("EXEC dbo.usp_add_receiving_dept2
                                    @Barcode = :Barcode,
                                    @dept_name = :dept_name,
                                    @STATUS = :STATUS");
            $stmt2->execute(['Barcode'=>$barcode, 'dept_name'=>'', 'STATUS'=>'' ]);


            $stmt3 = $conn->prepare("SELECT top(1) id from tbl_receiving_dept where barcode = :barcode and status <> 'UPDATED' order by id asc");
            $stmt3->execute(['barcode'=>$barcode]);
            $result3 = $stmt3->fetch();
            $dtgetidtoupdate = $result3['id'];

            $stmt4 = $conn->prepare("UPDATE tbl_receiving_dept set status = 'TURN' where id = :id");
            $stmt4->execute(['id'=>$dtgetidtoupdate]);

            $stmt5 = $conn->prepare("SELECT top(1) [duration(hrs)] as duration from vw_doctype where doctype_name = :doctype_name");
            $stmt5->execute(['doctype_name'=>$dtDocType]);
            $result5 = $stmt5->fetch();
            $dtduration = $result5['duration'];

            $stmt6 = $conn->prepare("UPDATE tbl_recieved set status='UPDATED', ProjectTitle = :ProjectTitle where barcode = :barcode");
            $stmt6->execute(['ProjectTitle'=>$projecttitle, 'barcode'=>$barcode]);

            $stmt70 = $conn->prepare("SELECT top(1) dept_name FROM tbl_receiving_dept WHERE barcode = :barcode AND status =:status");
            $stmt70->execute(['barcode'=>$barcode, 'status'=>'TURN']);
            $result70 = $stmt70->fetch();
            $receivefrom = $result70['dept_name'];

            $stmt7 = $conn->prepare("EXEC dbo.usp_add_recieved
                                        @Barcode        = :Barcode,
                                        @doctype_code   = :doctype_code,
                                        @dept_code      = :dept_code,
                                        @RecievedFrom   = :RecievedFrom,
                                        @RecievedBy     = :RecievedBy,
                                        @recievedDate   = :recievedDate,
                                        @ProjectTitle   = :ProjectTitle,
                                        @ProjectDuration= :ProjectDuration,
                                        @ProjectPrice   = :ProjectPrice,
                                        @PLM            = :PLM,
                                        @Description    = :Description,
                                        @STATUS         = :STATUS,
                                        @trans_stat     = :trans_stat
                                    ");
            $stmt7->execute(['Barcode'=>$barcode, 'doctype_code'=>$dtDocDetails_doctype, 'dept_code'=>$usedeptcode,
                'RecievedFrom'=>$receivefrom, 'RecievedBy'=>$receivedby, 'recievedDate'=>$dtDocDetails_recdate,
                'ProjectTitle'=>$projecttitle, 'ProjectDuration'=>$dtduration, 'ProjectPrice'=>'',
                'PLM'=>$lastreceidep, 'Description'=>$txtdescrpiton, 'STATUS'=>'PENDING',
                'trans_stat'=>0
            ]);

            if ($dtduration != 0) {
                $stmt8 = $conn->prepare("SELECT top(1) dbo.DAYSADDNOWK(GETDATE(), '$dtduration') as Due from tbl_recieved where barcode = :barcode");
                $stmt8->execute(['barcode'=>$barcode]);
                $result8 = $stmt8->fetch();
                $dtdue = $result8['Due'];

                $dateTimeDue = $dtdue;

                $stmt9 = $conn->prepare("UPDATE tbl_recieved set due = :due where barcode = :barcode and status != :status");
                $stmt9->execute(['due'=>$dateTimeDue, 'barcode'=>$barcode, 'status'=>'UPDATED' ]);

            }


            if ($total_count >0) {
                
                $stmt10 = $conn->prepare("SELECT TOP(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                $stmt10->execute(['barcode'=>$barcode]);
                $result10 = $stmt10->fetch();
                $dtGetReceivedId = $result10['received_id'];

                for( $i=0 ; $i < $total_count ; $i++ ) {
                    $tmpFilePath = $_FILES['text_10']['tmp_name'][$i];
                    if ($tmpFilePath != ""){
                    $newFilePath = "../img/barcodes/$barcode/" . $_FILES['text_10']['name'][$i];
                    $getattachmentname =  str_replace(' ', '_', $_FILES['text_10']['name'][$i]);
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $str .= $getattachmentname . $delimiter;
                        }
                    }
                }
                

                $stmt11 = $conn->prepare("UPDATE tbl_documentMovement  set attachment = :attachment where doc_id = :doc_id");
                $stmt11->execute(['attachment'=>$barcode.".pdf ".$str, 'doc_id'=>$dtGetReceivedId]);


            }else{

                $all = "$barcode.pdf ";



                $fileList = glob("../img/barcodes/$barcode/*");
                foreach($fileList as $filename){
                    if(is_file($filename)){
                        $str = str_replace("../img/barcodes/$barcode/"," ",$filename. " ");
                        $all .= str_replace("$barcode.pdf","", str_replace("../img/barcodes/$barcode/"," ", $filename. " " ));
                    }   
                }


                $stmt10 = $conn->prepare("SELECT TOP(1) received_id from tbl_recieved where barcode = :barcode order by received_id desc");
                $stmt10->execute(['barcode'=>$barcode]);
                $result10 = $stmt10->fetch();
                $dtGetReceivedId = $result10['received_id'];


                $stmt11 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
                $stmt11->execute(['attachment'=>$all, 'doc_id'=>$dtGetReceivedId]);



            }


            $stmt12 = $conn->prepare("SELECT TOP(1) * from vw_print_report where barcode = :barcode order by received_id desc");
            $stmt12->execute(['barcode'=>$barcode]);
            $count12 = $stmt12->rowCount();


            $stmt13 = $conn->prepare("SELECT TOP(1) created_id from tbl_doc_created where barcode = :barcode order by created_id desc");
            $stmt13->execute(['barcode'=>$barcode]);
            $result13 = $stmt13->fetch();
            $dtGetLastDocCreated = $result13['created_id'];

            $stmt14 = $conn->prepare("UPDATE tbl_doc_created set created_status = :created_status, updated_datetime = :updated_datetime where barcode = :barcode and created_id = :created_id");
            $stmt14->execute(['created_status'=>'InActive', 'updated_datetime'=> $_value, 'barcode'=>$barcode, 'created_id'=>$dtGetLastDocCreated]);

            $output = array("success", "Success", "Update Complete", $barcode);



        }catch(PDOException $e) {

            $output = array("error", "Error Found", $e->getMessage());
        }


        echo json_encode($output);
        $pdo->close();
    }


//................................................................................................
//.....................................................llll............dddd.......................
//.....................................................llll............dddd.......................
//.....................................................llll............dddd.......................
//...cccccc....aaaaaa...nnnnnnnn....cccccc....eeeeee...llll.......ddddddddd...oooooo....cccccc....
//..cccccccc..aaaaaaaa..nnnnnnnnn..cccccccc..eeeeeeee..llll......dddddddddd.ooooooooo..cccccccc...
//.ccccc.cccccaaa.aaaaa.nnnn.nnnnnncccc.ccccceee.eeee..llll..... dddd.ddddd.oooo.oooooocccc.cccc..
//.cccc..ccc.....aaaaaa.nnnn..nnnnnccc..ccc.ceee..eeee.llll..... ddd...dddddooo...oooooccc..ccc...
//.cccc.......aaaaaaaaa.nnnn..nnnnnccc......ceeeeeeeee.llll..... ddd...dddddooo...oooooccc........
//.cccc......caaaaaaaaa.nnnn..nnnnnccc......ceeeeeeeee.llll..... ddd...dddddooo...oooooccc........
//.cccc..ccc.caaa.aaaaa.nnnn..nnnnnccc..ccc.ceee.......llll..... ddd...dddddooo...oooooccc..ccc...
//.ccccc.cccccaaa.aaaaa.nnnn..nnnnncccc.ccccceee..eeee.llll..... dddd.ddddd.oooo.oooooocccc.cccc..
//..ccccccccccaaaaaaaaa.nnnn..nnnn.ccccccccc.eeeeeeee..llll......dddddddddd.ooooooooo..ccccccccc..
//...cccccc...aaaaaaaaa.nnnn..nnnn..cccccc....eeeeee...llll.......ddddddddd...oooooo....cccccc....
//................................................................................................

    
    if(isset($_POST['cancel_doc'])) {

        $doctypename = $_POST['doctypename'];
        $barcode     = $_POST['barcode'];
        $reason      = $_POST['text_2_1'];
        $projtitle   = $_POST['doctitle'];
        $description = $_POST['description'];
        $plm         = $_POST['plm'];
        $filessonfolder = "";
        
        try {
            $_value = date("Y-m-d H:i:s");   



            $stmt1 = $conn->prepare("SELECT top(1) [duration(hrs)] as durationhrs from vw_doctype where doctype_name = :doctype_name");
            $stmt1->execute(['doctype_name'=>$doctypename]);
            $result1 = $stmt1->fetch();
            $dtduration = $result1['durationhrs'];
    

            $stmt2 = $conn->prepare("INSERT INTO tbl_doc_cancel(barcode,cancel_reason,cancel_datetime) VALUES(:barcode, :cancel_reason, :cancel_datetime)");
            $stmt2->execute(['barcode'=>$barcode, 'cancel_reason'=>$reason, 'cancel_datetime'=>$_value]);
 



            $stmt3 = $conn->prepare("SELECT TOP(1) doctype_code,ProjectTitle,plm,description,RecievedBy,recievedDate from tbl_recieved where barcode = :barcode ORDER BY received_id ASC");
            $stmt3->execute(['barcode'=>$barcode]);
            $result3 = $stmt3->fetch();
            $dtDocDetails_doctype = $result3['doctype_code'];
            
            $stmt4 = $conn->prepare("EXEC dbo.usp_add_recieved
                        @Barcode        = :Barcode,
                        @doctype_code   = :doctype_code,
                        @dept_code      = :dept_code,
                        @RecievedFrom   = :RecievedFrom,
                        @RecievedBy     = :RecievedBy,
                        @recievedDate   = :recievedDate,
                        @ProjectTitle   = :ProjectTitle,
                        @ProjectDuration= :ProjectDuration,
                        @ProjectPrice   = :ProjectPrice,
                        @PLM            = :PLM,
                        @Description    = :Description,
                        @STATUS         = :STATUS,
                        @trans_stat     = :trans_stat");
            $stmt4->execute(['Barcode'=>$barcode, 'doctype_code'=>$dtDocDetails_doctype, 'dept_code'=>$usedeptcode,
                'RecievedFrom'=>$userdeptname, 'RecievedBy'=>'', 'recievedDate'=>date('Y-m-d H:i:s'),
                'ProjectTitle'=>$projtitle, 'ProjectDuration'=>$dtduration, 'ProjectPrice'=>'',
                'PLM'=>$plm, 'Description'=>$description, 'STATUS'=>'PENDING',
                'trans_stat'=>0
            ]);


            $stmt5 = $conn->prepare("SELECT top(2) doc_id, receivedbyname from tbl_documentMovement where barcode = :barcode order by doc_id desc");
            $stmt5->execute(['barcode'=>$barcode]);
            $result5 = $stmt5->fetch();
            $dtGetDocId         = $result5['doc_id'];
            $dtGetDocrecname    = $result5['receivedbyname'];

            $_docId = $dtGetDocId;

            $stmt6 = $conn->prepare("UPDATE tbl_receiving_dept set status = 'CANCELLED' where barcode = :barcode");
            $stmt6->execute(['barcode'=>$barcode]);
 
        
            $stmt7 = $conn->prepare("SELECT TOP(1) created_id from tbl_doc_created where barcode = :barcode order by created_id desc");
            $stmt7->execute(['barcode'=>$barcode]);
            $result7 = $stmt7->fetch();
            $dtGetLastDocCreated = $result7['created_id'];

            $stmt8 = $conn->prepare("UPDATE tbl_doc_created set created_status = 'InActive', updated_datetime = :updated_datetime where barcode = :barcode and created_id = :created_id");
            $stmt8->execute(['updated_datetime'=>$_value, 'barcode'=>$barcode, 'created_id'=>$dtGetLastDocCreated ]);
       
            $stmt9 = $conn->prepare("SELECT top(1) * from vw_getProcessingTimeApproved where barcode = :barcode");
            $stmt9->execute(['barcode'=>$barcode]);
            $result9 = $stmt9->fetch();
            $dtGetDdate_totalhrs = $result9['TotalHoursText'];

            $stmt222 = $conn->prepare("SELECT top(1) doc_id from tbl_documentMovement where barcode = :barcode order by doc_id desc");
            $stmt222->execute(['barcode'=>$barcode]);
            $result222 = $stmt222->fetch();
            $getLastRecordMovement = $result222['doc_id'];


            $stmt10 = $conn->prepare("UPDATE tbl_documentMovement set Transac = :Transac, doc_to = :doc_to, [processingTime(mins)] =  '".$dtGetDdate_totalhrs."',  receivedByName= :receivedByName, receivedDate = :receivedDate, remarks = :remarks, receivedby = :receivedby where doc_id = :doc_id");
            $stmt10->execute(['Transac'=>"Cancelled By ".$userdeptname, 'doc_to'=>$userdeptname, 'receivedDate'=>$_value, 'remarks'=>$reason, 'receivedby'=>"Cancelled by ".$userempname, 'receivedByName'=>$userempname, 'doc_id'=>$_docId]);
       

         
        
            foreach(glob("../img/barcodes/$barcode/*.*") as $file) {
                $filessonfolder .= " ".$resStr = str_replace("../img/barcodes/$barcode/", "", $file); ;
            }

            $stmt6_6 = $conn->prepare("UPDATE tbl_documentMovement set attachment = :attachment where doc_id = :doc_id");
            $stmt6_6->execute(['attachment'=>$barcode.".pdf". " ".str_replace("$barcode.pdf ","" ,$filessonfolder), 'doc_id'=>$getLastRecordMovement]);



            $stmt11 = $conn->prepare("UPDATE tbl_recieved set status = 'CANCELLED' where barcode = :barcode and status <> 'UPDATED'");
            $stmt11->execute(['barcode'=>$barcode]);
       

            // $stmt12 = $conn->prepare("SELECT * from tbl_doc_created where dept_name = :dept_name and created_status = 'Active'");
            // $stmt12->execute(['dept_name'=>$userdeptname]);
            // $result12 = $stmt12->fetch();
            // $dtGetDocCreated = $result12['durationhrs'];

            $output = array("success", "Success", "Succesfully Cancelled");

         
        }catch(PDOException $e) {

            $output = array("error", "Error Found", $e->getMessage());
        }
        echo json_encode($output);
        $pdo->close();
    }
?>