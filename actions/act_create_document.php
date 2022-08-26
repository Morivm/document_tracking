<?php
    include "../modules/session.php";
    require '../vendor/autoload.php';
 

    $conn = $pdo->open();
	$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
    /* CREATE DOCUMENTS */

    if(isset($_POST['tmp_receivingdept'])) {
        
        $barcode        = $_POST['barcode'];        $receiving_dept = $_POST['receiving_dept'];

        try{
            if(empty($barcode)) {
                $output = array("error","Error Found", "Please Reload Page First");
            }else if(empty($receiving_dept)) {
                $output = array("error","Error Found", "Empty Department");
            }else {
                $stmt = $conn->prepare("SELECT count(id) as numrows FROM tmp_receiving_dept WHERE barcode_id = :barcode_id AND dept_name = :dept_name AND useradded = :useradded");
                $stmt->execute(['barcode_id'=>$barcode, 'dept_name'=>$receiving_dept, 'useradded'=>$userid]);
                $result = $stmt->fetch();
                if($result['numrows'] > 0) {
                    $output = array("error", "You Can Only Include 1 Department at a time", $receiving_dept." Already Included");
                }else{
                    $stmt2 = $conn->prepare("INSERT INTO tmp_receiving_dept(barcode_id, dept_name, status, useradded) VALUES (:barcode_id, :dept_name, :status, :useradded)");
                    $stmt2->execute(['barcode_id'=>$barcode, 'dept_name'=>$receiving_dept, 'status'=>'NOT YET TURN', 'useradded'=>$userid]);
         
                        $stmt3 = $conn->prepare("UPDATE tmp_receiving_dept SET status = :status WHERE barcode_id = :barcode_id AND id in(SELECT TOP (1) id 
                        FROM tmp_receiving_dept 
                        WHERE barcode_id= :barcode_id2
                        AND useradded = :useradded
                        ORDER BY id ASC)");
                        $stmt3->execute(['status'=>'TURN', 'barcode_id'=>$barcode, 'barcode_id2'=>$barcode, 'useradded'=>$userid]);
                        $output = array("success", "Success", $receiving_dept." Succesfully Included", $barcode);

           

                    // $stmt = $conn->prepare("SELECT count(id) as numrows2 FROM tmp_receiving_dept WHERE barcode_id = :barcode_id ");
                    // $stmt->execute(['barcode_id'=>$barcode]);
                    // $result2 = $stmt->fetch();
 
                    // if($result2['numrows2'] == 1) {
                    //     $stmt = $conn->prepare("INSERT INTO tmp_receiving_dept(barcode_id, dept_name, status) VALUES (:barcode_id, :dept_name, :status )");
                    //     $stmt->execute(['barcode_id'=>$barcode, 'dept_name'=>$receiving_dept, 'status'=>'NOT YET TURN']);
                    // }else{
                    //     $stmt = $conn->prepare("INSERT INTO tmp_receiving_dept(barcode_id, dept_name, status) VALUES (:barcode_id, :dept_name, :status )");
                    //     $stmt->execute(['barcode_id'=>$barcode, 'dept_name'=>$receiving_dept, 'status'=>'TURN']);
                    // }

                
                }

            }

        }
        catch (PDOException $e){
            $output = array("error",$e->getMessage(), "Please Reload Page First");
        }

        echo json_encode($output);
        $pdo->close();
    }
    if(isset($_POST['remove_tmp_receivingdept'])) {
        
        $id        = $_POST['id'];

        try{

            $stmt = $conn->prepare("SELECT dept_name ,barcode_id FROM tmp_receiving_dept WHERE id = :id");
            $stmt->execute(['id'=>$id]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output = array("error","Error Found","Data Already Removed");
            }else{
                $result = $stmt->fetch();
                $barcode_id = $result['barcode_id'];
                $deptname   = $result['dept_name'];

                $stmt = $conn->prepare("DELETE FROM tmp_receiving_dept WHERE id = :id");
                $stmt->execute(['id'=>$id]);
                
                $stmt2 = $conn->prepare("UPDATE tmp_receiving_dept SET status = :status WHERE barcode_id = :barcode_id AND id in(SELECT TOP (1) id 
                                        FROM tmp_receiving_dept 
                                        WHERE barcode_id= :barcode_id2
                                        ORDER BY id ASC)");
                $result3 = $stmt2->execute(['status'=>'TURN', 'barcode_id'=>$barcode_id, 'barcode_id2'=>$barcode_id]);

                $stmt11 = $conn->prepare("SELECT  top(1) dept_name  FROM  tmp_receiving_dept WHERE barcode_id = :barcode_id order by id desc");
                $stmt11->execute(['barcode_id'=>$barcode_id]);
                $result11 = $stmt11->fetch();

                if($result3) {
                    $output = array("success","Success",$deptname." Succesfully Removed",$barcode_id, (empty($result11['dept_name']) ? "" :$result11['dept_name'] )  );
                }else{
                    $output = array("error","Error Found",$result);
                }
      
            }

        }
        catch (PDOException $e){
            $output = array("error",$e->getMessage(), "Please Reload Page First");
        }

        echo json_encode($output);
        $pdo->close();
    }
    if(isset($_POST['create_doc'])) {
        
        $barcode        = $_POST['text_2'];
        $doctype2       = $_POST['text_3'];
        $doctypetxt     = strtoupper($_POST['text3_0']);
        $title          = ucwords($_POST['text_4']);
        $decription     = ucwords($_POST['text_9']);
        $receivedby2     = $userempname;
        $receivedbytxt  = ucwords($userempname);
        

 
        $finalapprov    = $_POST['text_5'];
        $delimiter      = " ";
        $str            = '';

        $doctype        = "";
        $receivedby     = "";
        try{
            ($receivedby2 == "OTHERS") ?  $receivedby =  $receivedbytxt : $receivedby = $receivedby2;


            // $output = array("error", "ito", $receivedby);
            if($doctype2 =="OTHERS") {
                $t=time();
                $doctype =  $doctypetxt;
                $doccode =  $usedeptcode.firststrconcat($doctypetxt).date("Ymd",$t).$t;


                $stmt00 = $conn->prepare("SELECT doctype_code from tbl_doctype where doctype_code =:doctype_code");
                $stmt00->execute(['doctype_code'=>$doccode]);
                $count00 = $stmt00->rowCount();

                if($count00 > 0) {

                    $output = array("error","Error Found","The Document type Code you try to enter is either on the list already.");

                }else{

                    $stmt01 = $conn->prepare("EXEC usp_add_docType 
                    @doctype_name = :doctype_name,
                    @doctype_code = :doctype_code,
                    @doctype_duration = :doctype_duration,
                    @dept_code  = :dept_code");
                    $stmt01->execute(['doctype_name'=>$doctypetxt, 'doctype_code'=>$doccode, 'doctype_duration'=>'72', 'dept_code'=>$usedeptcode]);

                    
                    $stmt0 = $conn->prepare("SELECT COUNT(id) AS numrows  FROM tmp_receiving_dept WHERE barcode_id = :barcode_id");
                    $stmt0->execute(['barcode_id'=>$barcode]);
                    $result0 = $stmt0->fetch();
    
                    if($result0['numrows'] == 0) {
                        $output = array("error","Error Found", "Please Select atleast 1 Departments to Continue");
                    }else{
                        $path = "../img/barcodes/$barcode";
                        file_put_contents("../modules/imgsbarcode/$barcode.jpg", $generator->getBarcode($barcode, $generator::TYPE_CODE_128));
                        
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        
                            
                            $files = array_filter($_FILES['text_8']['name']);
                            $total_count = count($_FILES['text_8']['name']);
            
                            for( $i=0 ; $i < $total_count ; $i++ ) {
                                $tmpFilePath = $_FILES['text_8']['tmp_name'][$i];
                                if ($tmpFilePath != ""){
                                    $newFilePath = $path."/". str_replace(' ', '_', $_FILES['text_8']['name'][$i]);
                                    $getattachmentname =  str_replace(' ', '_', $_FILES['text_8']['name'][$i]);
                                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                        $str .= $getattachmentname . $delimiter;
                                    }
                                }
                            }
                    
            
                            $stmt = $conn->prepare("EXEC dbo.usp_add_receiving_dept2
                                                    @Barcode = :Barcode,
                                                    @dept_name = :dept_name,
                                                    @STATUS = :STATUS");
                            $stmt->execute(['Barcode'=>$barcode, 'dept_name'=>'', 'STATUS'=>'' ]);
            
                                
                            $stmt4 = $conn->prepare("SELECT top(1) dept_name FROM tbl_receiving_dept WHERE barcode = :barcode AND status =:status");
                            $stmt4->execute(['barcode'=>$barcode, 'status'=>'TURN']);
                            $result4 = $stmt4->fetch();
                                
                                $stmt5 = $conn->prepare("EXEC dbo.usp_add_recieved
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
                                $stmt5->execute(['Barcode'=>$barcode, 'doctype_code'=>$doctype, 'dept_code'=>$usedeptcode,
                                    'RecievedFrom'=>$result4['dept_name'], 'RecievedBy'=>$receivedby, 'recievedDate'=>date('Y-m-d H:i:s'),
                                    'ProjectTitle'=>$title, 'ProjectDuration'=>24, 'ProjectPrice'=>'',
                                    'PLM'=>$finalapprov, 'Description'=>$decription, 'STATUS'=>'PENDING',
                                    'trans_stat'=>0
                                ]);
            
            
                                $stmt6 = $conn->prepare("SELECT dbo.DAYSADDNOWK(GETDATE(), 24) as Due from tbl_recieved where barcode = :barcode");
                                $stmt6->execute(['barcode'=>$barcode]);
                                $result6 = $stmt6->fetch();
                                
                                $stmt7 = $conn->prepare("UPDATE tbl_recieved SET due = :due WHERE barcode = :barcode");
                                $stmt7->execute(['due'=>$result6['Due'], 'barcode'=>$barcode ]);
            
                                $stmt8 = $conn->prepare("UPDATE tbl_documentMovement SET attachment = :attachment, doccreated_start = :doccreated_start WHERE barcode = :barcode");
                                $stmt8->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doccreated_start'=>$userdeptname, 'barcode'=>$barcode]);
                            $output = array("success","Success","Document Succesfully Created",$barcode);
                        }else{
                            $output = array("error","Error Found","Unable To Save Please Reload the page first");
                        }
                    }


                }
            } else{

                $doctype =$doctype2;

                $stmt0 = $conn->prepare("SELECT COUNT(id) AS numrows  FROM tmp_receiving_dept WHERE barcode_id = :barcode_id");
                $stmt0->execute(['barcode_id'=>$barcode]);
                $result0 = $stmt0->fetch();

                if($result0['numrows'] == 0) {
                    $output = array("error","Error Found", "Please Select atleast 1 Departments to Continue");
                }else{
                    $path = "../img/barcodes/$barcode";
                    file_put_contents("../modules/imgsbarcode/$barcode.jpg", $generator->getBarcode($barcode, $generator::TYPE_CODE_128));
                    
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    
                        
                        $files = array_filter($_FILES['text_8']['name']);
                        $total_count = count($_FILES['text_8']['name']);
        
                        for( $i=0 ; $i < $total_count ; $i++ ) {
                            $tmpFilePath = $_FILES['text_8']['tmp_name'][$i];
                            if ($tmpFilePath != ""){
                                $newFilePath = $path."/". str_replace(' ', '_', $_FILES['text_8']['name'][$i]);
                                $getattachmentname =  str_replace(' ', '_', $_FILES['text_8']['name'][$i]);
                                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                    $str .= $getattachmentname . $delimiter;
                                }
                            }
                        }
                
        
                        $stmt = $conn->prepare("EXEC dbo.usp_add_receiving_dept2
                                                @Barcode = :Barcode,
                                                @dept_name = :dept_name,
                                                @STATUS = :STATUS");
                        $stmt->execute(['Barcode'=>$barcode, 'dept_name'=>'', 'STATUS'=>'' ]);
        
                            
                        $stmt4 = $conn->prepare("SELECT top(1) dept_name FROM tbl_receiving_dept WHERE barcode = :barcode AND status =:status");
                        $stmt4->execute(['barcode'=>$barcode, 'status'=>'TURN']);
                        $result4 = $stmt4->fetch();
                            
                            $stmt5 = $conn->prepare("EXEC dbo.usp_add_recieved
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
                            $stmt5->execute(['Barcode'=>$barcode, 'doctype_code'=>$doctype, 'dept_code'=>$usedeptcode,
                                'RecievedFrom'=>$result4['dept_name'], 'RecievedBy'=>$receivedby, 'recievedDate'=>date('Y-m-d H:i:s'),
                                'ProjectTitle'=>$title, 'ProjectDuration'=>24, 'ProjectPrice'=>'',
                                'PLM'=>$finalapprov, 'Description'=>$decription, 'STATUS'=>'PENDING',
                                'trans_stat'=>0
                            ]);
        
        
                            $stmt6 = $conn->prepare("SELECT dbo.DAYSADDNOWK(GETDATE(), 24) as Due from tbl_recieved where barcode = :barcode");
                            $stmt6->execute(['barcode'=>$barcode]);
                            $result6 = $stmt6->fetch();
                            
                            $stmt7 = $conn->prepare("UPDATE tbl_recieved SET due = :due WHERE barcode = :barcode");
                            $stmt7->execute(['due'=>$result6['Due'], 'barcode'=>$barcode ]);
        
                            $stmt8 = $conn->prepare("UPDATE tbl_documentMovement SET attachment = :attachment, doccreated_start =:doccreated_start  WHERE barcode = :barcode");
                            $stmt8->execute(['attachment'=>$barcode.".pdf"." ".$str, 'doccreated_start'=>$userdeptname, 'barcode'=>$barcode ]);
                        $output = array("success","Success","Document Succesfully Created",$barcode);
                    }else{
                        $output = array("error","Error Found","Unable To Save Please Reload the page first");
                    }
                }

            }
    
        }
        catch (PDOException $e){

            if ( strpos($e->getMessage(), "Cannot insert duplicate key") ) {

                $output = array("error","Error Found", "The Document Type you just created is either on a list already");
            }else{
                $output = array("error","Error Found",$e->getMessage());
            }
                
        }

        echo json_encode($output);

        $pdo->close();
    }

    /* ON PAGE LOAD  */
    if(isset($_POST['cleartmptbl'])) {
        
        $barcode_id        = $_POST['barcode_id'];

        try{

            $stmt = $conn->prepare("SELECT id AS numrows FROM tmp_receiving_dept WHERE barcode_id = :barcode_id AND useradded = :useradded");
            $stmt->execute(['barcode_id'=>$barcode_id, 'useradded'=>$userid]);
            $result = $stmt->rowCount();
            if($result == 0 ) {
                $stmt=$conn->prepare("TRUNCATE table tmp_receiving_dept");
                $stmt->execute();
                $output= array("success","Success",$stmt);
            }else{
                $stmt=$conn->prepare("DELETE FROM  tmp_receiving_dept  WHERE barcode_id != :barcode_id AND useradded  = :useradded");
                $stmt->execute(['barcode_id'=>$barcode_id, 'useradded'=>$userid]);
                $output= array("success","Success",$stmt);
            }

        } catch (PDOException $e){
            $output = array("error",$e->getMessage(), "Please Reload Page First");
        }

        echo json_encode($output);
        $pdo->close();
    }

    /* DOCUMENT TYPE ON CHANGE */

    if(isset($_POST['chg_tmp_tbl_bcode'])) {
        
        $barcode        = strtoupper($_POST['newbarcode']);

        try{
            $stmt = $conn->prepare("UPDATE tmp_receiving_dept SET barcode_id = :barcode_id WHERE useradded = :useradded");
            $stmt->execute(['barcode_id'=>$barcode, 'useradded'=>$userid]);
            if($stmt) {
                $output = array("success", "Success", "Succesfully Updated brcode");
            }else{
                $output = array("error", "Error Found", "Please Reload Your Page");
            }

        } catch (PDOException $e){
            $output = array("error",$e->getMessage(), "Please Reload Page First");
        }

        echo json_encode($output);
        $pdo->close();
    }


    /* TABLES */
    if(isset($_POST['tmp_receiving_dept'])) {
        $draw        = intval(0);
        $data        = array();
    

        $barcode = $_POST['tmp_receiving_dept_barcode'];


        $stmt = $conn->prepare("SELECT * From tmp_receiving_dept where barcode_id = :barcode_id");
        $stmt->execute(['barcode_id'=>$barcode]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['id'];
            $row2           = $row['dept_name'];

            $row3   = "<button type='button' class='btn btn-danger btn-actions' data-action='delete_tmp' data-id='$row1'>Delete</button>";


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
    }
    if(isset($_POST['pendingDocs'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT 
            a.received_id, 
            a.barcode,
            b.doctype_name,
            a.ProjectTitle,
            ( select dept_name from tbl_departments where dept_code = a.dept_code) as depfrom,
            a.RecievedFrom,
            b.[duration(hrs)] as durationhrs,
            FORMAT (c.dDate, 'dd/MM/yyyy hh:mm:ss tt') as date_created,
            FORMAT (a.recievedDate, 'dd/MM/yyyy hh:mm:ss tt') as date_received,
            FORMAT (a.Due, 'dd/MM/yyyy hh:mm:ss tt') as date_due,
            c.receivedBy,
            a.STATUS
        from 
            tbl_recieved a
        left join
            tbl_docType b on b.doctype_code = a.doctype_code
        left join
            tbl_documentMovement c on c.barcode = a.Barcode
        
        WHERE
            a.STATUS = 'PENDING'
        AND
            c.doc_from = :doc_from
        and
            c.receivedBy is null
            
        group by a.Barcode, a.received_id, b.doctype_name, a.ProjectTitle, a.RecievedFrom, b.[duration(hrs)], c.dDate, a.recievedDate, a.Due, a.STATUS, receivedBy , a.dept_code


        ");

        $stmt->execute(['doc_from'=>$userempname]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['received_id'];
            $row2           = $row['barcode'];
            $row3           = $row['doctype_name'];
            $row4           = $row['ProjectTitle'];
            $row5           = $row['depfrom'];
            $row6           = $row['RecievedFrom'];
            $row7           = $row['durationhrs'];
            $row8           = $row['date_created'];
            $row9           = $row['date_received'];
            $row10          = $row['date_due'];
            $row11          = $row['receivedBy'];
            $row12          = $row['STATUS'];


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
                "row11"=>$row11,
                "row12"=>$row12,
            );
        }

            $response = array(
                "aaData" => $data
            );

        echo json_encode($response);
        $pdo->close();
    }

?>

