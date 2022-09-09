<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    $draw        = intval(0);
    $data        = array();


    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = strtoupper($_POST['text_1']);

        try {

            $stmt = $conn->prepare("CALL sp_setup_document_type(:in_id, :in_action, :in_param1, :in_action_by)");
            $stmt->execute(['in_id'=>$id, 'in_action'=>$action, 'in_param1'=>$text_1, 'in_action_by'=>$userid ]);
            $result = $stmt->fetch();

            if($stmt) {
                $output = array($result['response_type'],$result['response_title'], $result['response_message']);
            }else{
                $output = array("error","Error Found", $stmt);
            }

        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }
    if(isset($_POST['s_table_main'])) {


        $stmt = $conn->prepare("SELECT * FROM vw_setup_document_type WHERE row3 = :row3");
        $stmt->execute(['row3'=>1]);

        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){ 
            $row1           = $row['row1'];
            $row2           = $row['row2'];

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }
?>