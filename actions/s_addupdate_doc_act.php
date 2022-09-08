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

        $stmt = $conn->prepare("SELECT * FROM vw_users_w_docs");
        $stmt->execute(['row6'=>1]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['row2'];
            $row2           = $row['row1'];
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


?>