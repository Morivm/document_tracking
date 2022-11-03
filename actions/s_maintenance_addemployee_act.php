<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = ucwords($_POST['text_1']);
        $text_2     = ucwords($_POST['text_2']);
        $text_3     = ucwords($_POST['text_3']);
        $text_4     = $_POST['text_4'];
        $text_5     = $_POST['text_5'];
        $text_5     = $_POST['text_6'];
        

        try {
            if($action == "ADD") {

                $stmt0 = $conn->prepare("SELECT COUNT(id) as total_similarusername FROM tbl_users WHERE username = :username");
                $stmt0->execute(['username'=>$text_4]);
                $ftcstmt0 = $stmt0->fetch();

                if( $ftcstmt0['total_similarusername'] > 0) {
                    $output = array("error","Error Found", "Username or Password is not available.");
                }else {

                    $stmt1 = $conn->prepare("INSERT INTO tbl_users_detail(lastname, firstname,middlename)VALUES(:lastname, :firstname, :middlename )");
                    $stmt1->execute(['lastname'=>$text_1, 'firstname'=>$text_2, 'middlename'=>$text_3]);

                    if($stmt1) {

                        $stmt2 = $conn->prepare("SELECT id FROM tbl_users_detail WHERE lastname = :lastname AND firstname = :firstname AND middlename = :middlename");
                        $stmt2->execute(['lastname'=>$text_1, 'firstname'=>$text_2, 'middlename'=>$text_3]);
                        $ftcstmt2 = $stmt2->fetch();
                        $ids = $ftcstmt2['id'];

                        $stmt3 = $conn->prepare("INSERT INTO tbl_users(userid, usertype, username, password , added_by )VALUES(:userid, :usertype, :username, :password, :added_by )");
                        $stmt3->execute(['userid'=>$ids, 'usertype'=>1, 'username'=>$text_4, 'password'=>password_hash($text_5, PASSWORD_DEFAULT), 'added_by'=>$userid]);

                        if($stmt3) {
                            $output = array("success","Success", "Account Succesfully Added.");
                        }else{
                            $output = array("error","Error Found", "Theres a problem while inserting the details." . $stmt1);
                        }

                    }else {
                        $output = array("error","Error Found", "Theres a problem while inserting the details." . $stmt1);
                    }


                }

            }else if($action == "UPDATE") {

                $stmt0 = $conn->prepare("SELECT lastname, firstname, middlename FROM tbl_users_detail WHERE id = :id");
                $stmt0->execute(['id'=>$id ]);
                $ftcstmt0 = $stmt0->fetch();

                if( $ftcstmt0['lastname'] == $text_1 &&  $ftcstmt0['firstname'] == $text_2 &&  $ftcstmt0['middlename'] == $text_3) {
                    $output = array("error","Error Found", "No Changes Has been made.");
                }else {

                    $stmt = $conn->prepare("UPDATE tbl_users_detail SET lastname = :lastname , firstname = :firstname, middlename = :middlename WHERE id = :id");
                    $stmt->execute(['lastname'=>$text_1, 'firstname'=>$text_2, 'middlename'=>$text_3, 'id'=>$id ]);
                    if($stmt) {
                        
                        $output = array("success","Success", "Details Succesfully Changed.");
                    }else{
                        $output = array("error","Error Found", $result);
                    }
                }

            }else if($action == "UPDATE_PASS") {

                $stmt = $conn->prepare("UPDATE tbl_users SET password = :password  WHERE userid = :userid");
                $stmt->execute(['password'=>password_hash($text_5, PASSWORD_DEFAULT), 'userid'=>$id ]);
                if($stmt) {
                    
                    $output = array("success","Success", "Password Succesfully Changed.");
                }else{
                    $output = array("error","Error Found", $result);
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
    // if(isset($_POST['transaction1'])){

    //     $fullname     = $_POST['fullname'];
    //     $userid       = $_POST['userid'];
    //     $username     = $_POST['text1_1'];
    //     $password     = $_POST['text1_2'];
    //     $role         = $_POST['text1_3'];
    //     $getUsername  = $_POST['text1_5'];

    //     try {
    //         $stmt = $conn->prepare("SELECT count(user_id) as totalcount FROM tbl_user WHERE FullName = :FullName");
    //         $stmt ->execute(['FullName'=>$fullname]);
    //         $result = $stmt->fetch();
    //         $count = $result['totalcount'];
    //         if($count == 0) {
                
    //             $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
    //             $stmt111->execute(['UsersName'=>$username]);
    //             $result111 = $stmt111->fetch();
    //             $count111 = $result111['totalcount11'];

    //             if($count111 > 0 ) {

    //                 $output = array("error", "Please Try another credentials","Username or Password is Unavailable");
    //             }else{

    //                 $stmt = $conn->prepare("INSERT INTO tbl_user(user_id, FullName, UsersName, Password, role, position) VALUES
    //                 (:user_id, :FullName, :UsersName, HASHBYTES('SHA2_512', '".$password."') , :role, :position)");
    //                 $result = $stmt ->execute(['user_id'=>$userid,  'FullName'=>$fullname, 'UsersName'=>$username, 'role'=>$role, 'position'=>$role  ]);
                    
    //                 if($result) {
    //                     $output = array("success","Success", $fullname . " Succesfully Added As " .$role);
    //                 }else{
    //                     $output = array("error","Error Found", $result);
    //                 }


    //             }

    //         }else{

    //             if($username != $getUsername) {

                    
    //                 $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
    //                 $stmt111->execute(['UsersName'=>$username]);
    //                 $result111 = $stmt111->fetch();
    //                 $count111 = $result111['totalcount11'];

    //                 if($count111 > 0 ) {

    //                     $output = array("error", "Please Try another credentials","Username or Password is Unavailable");
    //                 }else{
    
    //                     $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName, Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
    //                     position = :position  WHERE FullName = :FullName");
    //                     $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                        
    //                     if($result) {
    //                         $output = array("success","Success", $fullname . " Succesfully Updated");
    //                     }else{
    //                         $output = array("error","Error Found", $result);
    //                     }

    
    //                 }

    //             }else{


    //                 $stmt = $conn->prepare("UPDATE tbl_user SET  Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
    //                     position = :position  WHERE FullName = :FullName");
    //                     $result = $stmt ->execute(['role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                        
    //                     if($result) {
    //                         $output = array("success","Success", $fullname . " Succesfully Updated");
    //                     }else{
    //                         $output = array("error","Error Found", $result);
    //                 }

    //             }



    //             // $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
    //             // $stmt111->execute(['UsersName'=>$username]);
    //             // $result111 = $stmt111->fetch();
    //             // $count111 = $result111['totalcount11'];


    //             // if($password == "") {
    //             //     $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName , role = :role,
    //             //     position = :position  WHERE FullName = :FullName");
    //             //     $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                    
    //             //     if($result) {
    //             //         $output = array("success","Success", $fullname . " Succesfully Updated");
    //             //     }else{
    //             //         $output = array("error","Error Found", $result);
    //             //     }



    //             // }else{

    //             //     $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName, Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
    //             //     position = :position  WHERE FullName = :FullName");
    //             //     $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                    
    //             //     if($result) {
    //             //         $output = array("success","Success", $fullname . " Succesfully Updated");
    //             //     }else{
    //             //         $output = array("error","Error Found", $result);
    //             //     }



    //             // }

                
              
    //         }
    //     }catch (PDOException $e) {
    //         $output = array("error","Error Found", $e->getMessage());

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }
    // if(isset($_GET['viewinfo'])){

    //     $fullname     = $_GET['fullname'];

    //     try {

    //         $stmt = $conn->prepare("SELECT count(user_id) as totalcount FROM tbl_user WHERE FullName = :FullName");
    //         $stmt ->execute(['FullName'=>$fullname]);
    //         $result = $stmt->fetch();
    //         $count = $result['totalcount'];
    //         /* USERNAME || PASSWORD || ROLE || POSITION */
    //         if($count == 0) {
    //             $output = array("success",$count,"". "", "No Position");
    //         }else{
                
    //             $stmt = $conn->prepare("SELECT  UsersName, role, position from tbl_user where FullName = :FullName");
    //             $stmt ->execute(['FullName'=>$fullname]);

    //             $result1 = $stmt->fetch();
    //             $output = array("success",$count, $result1['UsersName'], $result1['role'], $result1['position']);
    //         }

    //     }catch (PDOException $e) {
    //         $output = array("error","Error Found", $e->getMessage());

    //     }
    //     echo json_encode($output);
    //     $pdo->close();
    //     exit();
    // }
    if(isset($_POST['s_table_main'])) {
        $draw        = intval(0);
        $data        = array();
    

        $stmt = $conn->prepare("SELECT
                                    a.id,
                                    CONCAT_WS(' ', a.lastname, a.firstname, a.middlename) AS fname,
                                    a.account_status,
                                    `func_fullname`(b.added_by) AS added_by,
                                    a.added_date,
                                    a.lastname,
                                    a.firstname,
                                    a.middlename,
                                    b.username
                                    
                                FROM `tbl_users_detail` a
                                LEFT JOIN `tbl_users` b ON  a.id = b.userid
                                WHERE b.deleted_by = 0
                                AND  a.id != :id ");
        $stmt->execute(['id'=>$userid]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['id'];
            $row2           = $row['fname'];
            $row3           = ($row['account_status'] == 1) ? "<label class='text-success'>Active</label>" : "<label class='text-danger'>Inactive</label>";
            $row4           = $row['added_by'];
            $row5           = $row['added_date'];
            $row6           = $row['lastname'];
            $row7           = $row['firstname'];
            $row8           = $row['middlename'];
            $row9           = $row['username'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
                "row6"=>$row6,
                "row7"=>$row7,
                "row8"=>$row8,
                "row9"=>$row9
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