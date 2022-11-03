<?php
    include '../modules/session.php';
    $conn = $pdo->open();


    if(isset($_POST['getActiveUsers'])) {
        try{

            $stmt = $conn->prepare("SELECT COUNT(id) as total_active  FROM `tbl_users` WHERE deleted_by = 0");
            $stmt->execute();
            $ftcresult = $stmt->fetch();
    
            $output = array("success", "Success", $ftcresult['total_active']);


        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());

        } 

        echo json_encode($output);
        $pdo->close();
    }

    if(isset($_POST['getTotalCovers'])) {
        try{

            $stmt = $conn->prepare("SELECT COUNT(id) as total_covers  FROM `tbl_generated_cover` ");
            $stmt->execute();
            $ftcresult = $stmt->fetch();
    
            $output = array("success", "Success", $ftcresult['total_covers']);


        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());

        } 

        echo json_encode($output);
        $pdo->close();
    }

    if(isset($_POST['getRecentCovers'])) {
        try{

            $stmt = $conn->prepare("SELECT COUNT(id) as total_recent FROM `tbl_generated_cover`  WHERE generated_date  >= DATE(NOW() - INTERVAL 7 DAY)");
            $stmt->execute();
            $ftcresult = $stmt->fetch();
    
            $output = array("success", "Success", $ftcresult['total_recent']);


        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());

        } 

        echo json_encode($output);
        $pdo->close();
    }
    

    if(isset($_POST['getTotalUploaded'])) {
        try{

            $stmt = $conn->prepare("SELECT COUNT(a.id) + (SELECT COUNT(b.id) FROM `search_order_of_busines_files` b ) AS total_uploadedfile FROM `search_order_of_business` a");
            $stmt->execute();
            $ftcresult = $stmt->fetch();
    
            $output = array("success", "Success", $ftcresult['total_uploadedfile']);


        }catch(PDOException $e) {
            $output = array("error", "Error Found", $e->getMessage());

        } 
        echo json_encode($output);
        $pdo->close();
    }
    



    // if(isset($_POST['tbl1'])) {
    //     $draw        = intval(0);
    //     $data        = array();
  
    //     $stmt = $conn->prepare("SELECT * FROM vw_doc where vw_doc.RecievedFrom = :RecievedFrom or vw_doc.froms = :froms or vw_doc.dept_code = :dept_code ORDER BY recievedDate DESC, 'Date Received' desc, Barcode");

    //     $stmt->execute(['RecievedFrom'=>$userdeptname, 'froms'=>$userdeptname, 'dept_code'=>$usedeptcode]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){
    //         // $row1           = $row['received_id'];
    //         $row2           = $row['Barcode'];
    //         $row3           = $row['doctype_name'];
    //         $row4           = $row['ProjectTitle'];
    //         $row5           = $row['doc_from'] ." "."(<i>".$row['RecievedBy']."</i>)";
    //         $row6           = $row['RecievedFrom'];
    //         $row7           = $row['ProjectDuration'];
    //         $row8           = date_format(date_create($row['recievedDate']),'m/d/Y g:i a');
    //         $row9           = ($row['Date Received'] =="") ? ""  : date_format(date_create($row['Date Received']),'m/d/Y g:i a');
    //         $row10          = date_format(date_create($row['Due']),'m/d/Y g:i a');
    //         $row11          = $row['receivedByName'];
    //         $row12          = $row['STATUS'];
    //         $row13          = $row['Due'];
    //         $data[] = array(
    //             // "row1"=>$row1,
    //             "row2"=>$row2,
    //             "row3"=>$row3,
    //             "row4"=>$row4,
    //             "row5"=>$row5,
    //             "row6"=>$row6,
    //             "row7"=>$row7,
    //             "row8"=>$row8,
    //             "row9"=>$row9,
    //             "row10"=>$row10,
    //             "row11"=>$row11,
    //             "row12"=>$row12,
    //             "row13"=>$row13
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );
    //     echo json_encode($response);
    //     $pdo->close();
    // }
    // if(isset($_POST['tbl2'])) {
    //     $draw        = intval(0);
    //     $data        = array();
    
    //     $stmt = $conn->prepare("EXEC usp_select_approved 
    //                             @RecievedFrom = :RecievedFrom,
    //                             @dept_code = :dept_code");


    //     $stmt->execute(['RecievedFrom'=>$usedeptcode, 'dept_code'=>$userdeptname]);
    //     $records = $stmt->fetchAll();
    //     $data = array();
    //     foreach($records as $row){
    //         $row1           = '';
    //         $row2           = $row['Barcode'];
    //         $row3           = $row['doctype_name'];
    //         $row4           = $row['ProjectTitle'];
    //         $row5           = date_format(date_create($row['Date Created']),'m/d/Y g:i a');
    //         $row6           = date_format(date_create($row['Date Approved']),'m/d/Y g:i a');
    //         $row7           = $row['STATUS'];
    //         $row8           = $row['rec_by'];
            

    //         $data[] = array(
    //             "row1"=>$row1,
    //             "row2"=>$row2,
    //             "row3"=>$row3,
    //             "row4"=>$row4,
    //             "row5"=>$row5,
    //             "row6"=>$row6,
    //             "row7"=>$row7,
    //             "row8"=>$row8
    //         );
    //     }
    //     $response = array(
    //         "aaData" => $data
    //     );

    //     echo json_encode($response);
    //     $pdo->close();
    // }


?>