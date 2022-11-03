<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = ucwords($_POST['text_1']);

        try {
            if($action == "ADD") {

                $stmt0 = $conn->prepare("SELECT COUNT(id) as total_similarname FROM tbl_setup_order_of_business WHERE order_of_business = :order_of_business");
                $stmt0->execute(['order_of_business'=>$text_1]);
                $ftcstmt0 = $stmt0->fetch();

                if( $ftcstmt0['total_similarname'] > 0) {
                    $output = array("error","Error Found", "Order of Business name is not available.");
                }else {

                    $stmt1 = $conn->prepare("INSERT INTO tbl_setup_order_of_business(order_of_business, action_by, added_by)VALUES(:order_of_business, :action_by, :added_by )");
                    $stmt1->execute(['order_of_business'=>$text_1, 'action_by'=>$userid, 'added_by'=>$userid ]);

                    if($stmt1) {

                        $output = array("success","Success", "Order of Business Added Succesfully.");

                    }else {
                        $output = array("error","Error Found", "Theres a problem while inserting the details. " . $stmt1);
                    }


                }

            }else if($action == "UPDATE") {

                $stmt0 = $conn->prepare("SELECT order_of_business FROM tbl_setup_order_of_business WHERE id = :id");
                $stmt0->execute(['id'=>$id ]);
                $ftcstmt0 = $stmt0->fetch();

                if( $ftcstmt0['order_of_business'] == $text_1) {
                    $output = array("error","Error Found", "No Changes Has been made.");
                }else {

                    $stmt = $conn->prepare("UPDATE tbl_setup_order_of_business SET order_of_business = :order_of_business WHERE id = :id");
                    $stmt->execute(['order_of_business'=>$text_1, 'id'=>$id ]);
                    
                    if($stmt) {
                        $output = array("success","Success", "Details Succesfully Changed.");
                    }else{
                        $output = array("error","Error Found", $result);
                    }
                }
            }else if($action == "DELETE") {


                $stmt = $conn->prepare("UPDATE tbl_setup_order_of_business SET isAvailable = :isAvailable, deleted_by = :deleted_by , deleted_date = CURRENT_TIMESTAMP WHERE id = :id");
                $stmt->execute(['isAvailable'=>0, 'deleted_by'=>$userid, 'id'=>$id ]);
                
                if($stmt) {
                    $output = array("success","Success", "Successfully Deleted.");
                }else{
                    $output = array("error","Error Found", $stmt);
                }
              


            }else {
                $output = array("error","Error Found", "Please Reload Page");
            }



            
        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }


    if(isset($_POST['s_table_main'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT *, func_fullname(action_by) as added_by FROM tbl_setup_order_of_business WHERE isAvailable = :isAvailable ");
        $stmt->execute(['isAvailable'=>1]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['id'];
            $row2           = $row['order_of_business'];
            $row3           = ($row['isAvailable'] == 1) ? "<label class='text-success'>Active</label>" : "<label class='text-danger'>Removed</label>";
            $row4           = $row['added_by'];
            $row5           = $row['added_date'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }
    // if(isset($_POST['enDisableAct'])) {

    //     $emp_name   = $_POST['acctname'];
    //     $actstatus  = $_POST['acctstastus'];
        
    //     $updatestatsTR = ($actstatus == 0 ? "Enabled" : "Disabled");
    //     $updatestats = ($actstatus == 0 ? 1 : 0);

        
    //     try { 

    //         $stmt = $conn ->prepare("UPDATE tbl_employee SET isEnabled = :isEnabled FROM tbl_employee WHERE emp_name = :emp_name");
    //         $stmt->execute(['isEnabled'=>$updatestats , 'emp_name'=>$emp_name]);
    //         if($stmt) {
    //             $output = array("success", "Success", "Succesfully " .$updatestatsTR);
    //         }else{
    //             $output = array("error", "Error Found", "Please Reload the page first.");
    //         }


    //     }catch(PDOException $e) {
            

    //         $output = array("error", "Error Found", $e->getMessage());


    //     }
    //     echo json_encode($output);

    //     $pdo->close();
    // }

?>