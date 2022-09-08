<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    $draw        = intval(0);
    $data        = array();


    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = strtoupper($_POST['text_1']);
        $text_2     = strtoupper($_POST['text_2']);
        $text_3     = $_POST['text_3'];
        $text_4     = strtoupper($_POST['text_4']);
        $text_5     = strtoupper($_POST['text_5']);
        $text_6     = strtoupper($_POST['text_6']);
        try {
            if($action == "ADD") {
                $stmt = $conn->prepare("EXEC dbo.usp_add_docType @doctype_name = :doctype_name, @doctype_code = :doctype_code,
                                        @doctype_duration = :doctype_duration, @dept_code = :dept_code");
                $result = $stmt->execute(['doctype_name'=>$text_1, 'doctype_code'=>$text_2, 'doctype_duration'=>$text_3, 'dept_code'=>$text_4 ]);

                if($result) {
                    $output = array("success","Success", "Succesfully Save". $text_1);
                }else{
                    $output = array("error","Error Found", $result);
                }
            }else if($action == "UPDATE") {
                $stmt = $conn->prepare("EXEC dbo.usp_update_docType @doctype_name = :doctype_name, @doctype_code = :doctype_code,
                                @duration = :duration, @dept_code = :dept_code,
                                @olddoctype_name = :olddoctype_name, @olddoctype_code = :olddoctype_code");
                $result = $stmt->execute(['doctype_name'=>$text_1, 'doctype_code'=>$text_2, 'duration'=>$text_3, 'dept_code'=>$text_4,
                                        'olddoctype_name'=>$text_5, 'olddoctype_code'=>$text_6
                                        ]);
                if($result) {
                    $output = array("success","Success", "Succesfully Updated". $text_5);
                }else{
                    $output = array("error","Error Found", $result);
                }
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