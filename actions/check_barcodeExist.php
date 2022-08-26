<?php
    include '../modules/session.php';
    $conn = $pdo->open();


        $requestedbarcode  = $_REQUEST['text_1'];
        try {
            $stmt = $conn->prepare("SELECT count(id) as totalrow FROM tbl_receiving_dept WHERE barcode = :barcode AND dept_name = :dept_name");
            $stmt->execute(['barcode'=>$requestedbarcode, 'dept_name'=>$userdeptname ]);
            $result=$stmt->fetch();
            
            if($result['totalrow'] == 0) {
                $output = 'false';
            }else{
                $output = 'true';
            }
        }catch (PDOException $e) {
            $output = 'false';

        }
        echo $output;
        $pdo->close();
        exit();


    // $registeredEmail = array('jenson1@jenson.in', 'jenson2@jenson.in', 'jenson3@jenson.in', 'jenson4@jenson.in', 'jenson5@jenson.in');



    // if( in_array($requestedEmail, $registeredEmail) ){
    //     echo 'false';
    // }
    // else{
    //     echo 'true';
    // }


    // $pdo->close();
    // exit();

?>