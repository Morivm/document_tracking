<?php
    include '../modules/session.php';
    $conn = $pdo->open();

    if(isset($_POST['pause_doc'])) {
        $barcode_id = $_POST['pause_txt_1'];
        $barcode    = $_POST['barcode'];
        $remarks    = $_POST['pause_txt_2'];

        try {

            $dtime = date("Y-m-d H:i:s");   

            $stmt1 = $conn->prepare("INSERT into tbl_pause(dept_name,pause_reason,barcode,pause_dateTime,pause_status) VALUES(:dept_name, :pause_reason, :barcode, :pause_dateTime, :pause_status)");
            $stmt1->execute(['dept_name'=>$userdeptname, 'pause_reason'=>$remarks, 'barcode'=>$barcode, 'pause_dateTime'=>$dtime, 'pause_status'=>'Pause' ]);
            
            $stmt2 = $conn->prepare("UPDATE vw_doc set vw_doc.Due = :Due , STATUS = 'PAUSED' where (vw_doc.RecievedFrom = :RecievedFrom or vw_doc.froms = :froms or vw_doc.dept_code = :dept_code) and vw_doc.STATUS <> 'RECEIVED' and vw_doc.barcode = :barcode and vw_doc.received_id = :received_id");
            $stmt2->execute(['Due'=>'2999-12-31 23:59:59.000', 'RecievedFrom'=>$userdeptname, 'froms'=>$userdeptname, 'dept_code'=>$usedeptcode, 'barcode'=>$barcode, 'received_id'=>$barcode_id ]);

            $output = array("success", "Success", "Document Succesfully Paused");


        }catch(PDOException $e) {

            $output = array("error", "Error Found", $e->getMessage());
        }

        echo json_encode($output);
        $pdo->close();
    }

    if(isset($_POST['play_doc'])) {

        $barcode    = $_POST['play_txt_1'];
        $_status    = "";

        try {
            $dtime = date("Y-m-d H:i:s");   

            $stmt1 = $conn->prepare("SELECT vw_doc.received_id as rec_id from vw_doc where vw_doc.RecievedFrom = :RecievedFrom and vw_doc.STATUS = 'PAUSED' order by vw_doc.received_id desc");
            $stmt1->execute(['RecievedFrom'=>$userdeptname ]);
            $result1 = $stmt1->fetch();
            $dtGetId = $result1['rec_id'];
                    
            $_receiveId = $dtGetId;

            $stmt2 = $conn->prepare("SELECT barcode FROM tbl_doc_created WHERE barcode = :barcode and created_status = 'Active'");
            $stmt2->execute(['barcode'=>$barcode]);
            $count2 = $stmt2->rowCount();
            if($count2 != 0) {
                $_status = "RETURN";

            }else{
                $_status = "PENDING";
            }
    

            $stmt3 = $conn->prepare("SELECT vw_doc.Barcode as barcode from vw_doc where vw_doc.RecievedFrom = :RecievedFrom and vw_doc.STATUS = 'PAUSED' order by vw_doc.received_id desc");
            $stmt3->execute(['RecievedFrom'=>$userdeptname ]);
            $dtGetAllReceiving = $stmt3->rowCount();

            $stmt4 = $conn->prepare("SELECT pause_id from tbl_pause where dept_name = :dept_name and barcode = :barcode order by pause_id desc");
            $stmt4->execute(['dept_name'=>$userdeptname, 'barcode'=>$barcode ]);
            $result4 = $stmt4->fetch();
            $dtLastRec = $result4['pause_id'];


            $stmt5 = $conn->prepare("UPDATE tbl_pause set pause_status = :pause_status, continue_dateTime = :continue_dateTime where dept_name = :dept_name and pause_id = :pause_id");
            $stmt5->execute(['pause_status'=>'Continue', 'continue_dateTime'=>$dtime, 'dept_name'=>$userdeptname, 'pause_id'=>$dtLastRec ]);


            if($dtGetAllReceiving != 0) {
                $stmt6 = $conn->prepare("EXEC usp_add_due");
                $stmt6->execute();
                $result6= $stmt6->fetch();
                $dtdue  = $result6['DatePlus2WorkDays'];
                $datetimedue = $dtdue;
                $tme    =date("H:i:s");   

                $stmt7 = $conn->prepare("UPDATE vw_doc set vw_doc.due = :due where vw_doc.RecievedFrom = :RecievedFrom and vw_doc.STATUS = 'PAUSED' and vw_doc.received_id = :received_id ");
                $stmt7->execute(['due'=>$datetimedue, 'RecievedFrom'=>$userdeptname, 'received_id'=>$_receiveId]);

                $stmt7 = $conn->prepare("UPDATE vw_doc set vw_doc.STATUS = :STATUS where vw_doc.RecievedFrom = :RecievedFrom and vw_doc.STATUS = 'PAUSED' and vw_doc.received_id = :received_id");
                $stmt7->execute(['STATUS'=>$_status, 'RecievedFrom'=>$userdeptname, 'received_id'=>$_receiveId]);
                
            }

            $output = array("success", "Success", "Succesfully Continued");
            
        }catch(PDOException $e) {

            $output = array("error", "Error Found", $e->getMessage());
        }
        echo json_encode($output);
        $pdo->close();

    }

?>