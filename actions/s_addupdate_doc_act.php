<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    
    $draw        = intval(0);
    $data        = array();


    if(isset($_POST['view_documents'])){

        try {

            $filename = glob("../scanned_docs/*");

            if ( $filename) {
                foreach($filename as $value) {
                    $stmt = $conn->prepare("INSERT INTO tbl_documents (document_name, users_id, document_type) VALUES(:document_name, (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)),     (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )           ) ON DUPLICATE KEY UPDATE    
                    users_id=  (SELECT SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name )),'../scanned_docs/',''), '_', 1)) , document_type = (SELECT  REPLACE( SUBSTRING_INDEX(REPLACE(SUBSTRING(:document_name, LOCATE('../scanned_docs/', :document_name  )),'../scanned_docs/',''), '_', -1) ,'.pdf', ''  ) )          ");
                    $stmt->execute(['document_name'=>$value]);

                    $output = array("success", "Success", "Syncing Success...");
                }

            } else {
                $output = array("error", "Error Found", $filename );
            }
      

        }catch (PDOException $e) {

            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }

    if(isset($_POST['s_table_main'])) {

        $stmt = $conn->prepare("SELECT 
            b.barcode AS row1,
            GROUP_CONCAT(title, ' ',ordinance_code, ' ',description) AS row2,
            func_fullname(b.created_by) AS row3,
            `func_Dateformat`(created_date,3) AS row4,
            b.isAvailable AS row5
             
         FROM `search_order_of_business` a
         LEFT JOIN `tbl_activities` b ON b.barcode = a.barcode");
        $stmt->execute(['row6'=>1]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['row1'];
            $row2           = $row['row2'];
            $row3           = "Creator: ".$row['row3'];
            $row4           = $row['row4'];
            $row5           = $row['row5'];
            // $row5           = ($row['row5'] == 1 ) ? "Session On Going <image src='../img/web/circle_green.png' width='10px'> " :  "Session Down <image src='../img/web/circle_red.png' width='10px'>";
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


    if(isset($_POST['s_table_main2'])) {

        $user_id = $_POST['view_userId'];


        $stmt = $conn->prepare("SELECT * FROM vw_users_docs WHERE row3 = :row3");
        $stmt->execute(['row3'=>$user_id]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){

            $row1           = $row['row6'];
            $row2           = "  <a href='".$row['row2']."' target='_blank'> Click to Download </a>";

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }



    if(isset($_POST['getFileondb'])) {

        $barcode = $_POST['barcode'];


        $stmt = $conn->prepare("SELECT * FROM vw_users_docs WHERE row3 = :row3");
        $stmt->execute(['row3'=>$user_id]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){

            $row1           = $row['row6'];
            $row2           = "  <a href='".$row['row2']."' target='_blank'> Click to Download </a>";

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }



?>