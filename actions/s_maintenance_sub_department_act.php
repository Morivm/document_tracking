<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = strtoupper($_POST['text_1']);
        $text_2     = strtoupper($_POST['text_2']);

        try {
            $stmt = $conn->prepare("CALL sp_setup_department(:in_id, :in_action, :in_param1, :in_param2, :in_action_by)");
            $stmt->execute(['in_id'=>$id, 'in_action'=>$action, 'in_param1'=>$text_1, 'in_param2'=>$text_2, 'in_action_by'=>$userid]);
            $result=$stmt->fetch();
      
            $output = array($result['response_type'], $result['response_title'], $result['response_message']);
        }catch (PDOException $e) {

            if (strpos($e, 'department_code') !== false) {
                $output = array("error","Please try new Department Code.", "Department Code Already Exist.");
            }else{
                $output = array("error","Error Found", $e->getMessage());
            }

            
          

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }
    if(isset($_POST['s_table_main'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT * FROM vw_setup_sub_department WHERE row5 = :row5");
        $stmt->execute(['row5'=>1]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['row1'];
            $row2           = $row['row2'];
            $row3           = $row['row3'];
            $row4           = $row['row4'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }
?>