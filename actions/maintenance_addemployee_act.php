<?php
    include "../modules/session.php";

    $conn = $pdo->open();

    if(isset($_POST['transaction'])){

        $action     = $_POST['action'];
        $id         = $_POST['id'];
        $text_1     = ucwords($_POST['text_1']);
        $text_2     = ucwords($_POST['text_2']);
        $text_3     = $_POST['text_3'];
        $text_4     = strtolower($_POST['text_4']);
        $text_5     = $_POST['text_5'];
        

        $getEMAIL   = $_POST['getEmail'];
        $getMOBILE  = $_POST['getMobile'];



        

        try {
            if($action == "ADD") {

                $stmt0 = $conn->prepare("SELECT count(emp_id) as rowC from tbl_employee where emp_name = :emp_name");
                $stmt0->execute(['emp_name'=>$text_1 .', '. $text_2 ]);
                $result0 = $stmt0->fetch();
                $count0  = $result0['rowC'];
                if($count0 > 0) {
                    
                    $output = array("error","Error Found", $text_1.', '.$text_2 ." Already Saved");

                }else{
                    
                    $stmt0_1 = $conn->prepare("SELECT count(emp_id) as rowC from tbl_employee where email = :email");
                    $stmt0_1->execute(['email'=>$text_4]);
                    $result0_1 = $stmt0_1->fetch();
                    $count0_1  = $result0_1['rowC'];

                    if($count0_1 > 0) {
                        $output = array("error","Error Found", $text_4 ." Is not Available to use.");
                    }else{
                        $stmt0_2 = $conn->prepare("SELECT count(emp_id) as rowC from tbl_employee where mobile = :mobile");
                        $stmt0_2->execute(['mobile'=>$text_5]);
                        $result0_2 = $stmt0_2->fetch();
                        $count0_2  = $result0_2['rowC'];

                        if($count0_2 > 0) {
                    
                            $output = array("error","Error Found", $text_5 ." Is not Available to use.");
                        
                        }else{

                            $stmt = $conn->prepare("INSERT INTO tbl_employee(emp_name, dept_code, email, mobile)VALUES(:emp_name, :dept_code, :email, :mobile) ");
                            $result = $stmt->execute(['emp_name'=>$text_1 .', '. $text_2 , 'dept_code'=>$text_3, 'email'=>$text_4, 'mobile'=>$text_5]);

                            if($result) {
                                $output = array("success","Success", "Succesfully Added Employee ". $text_1.', '.$text_2);
                            }else{
                                $output = array("error","Error Found", $result);
                            }
                        }
                    }
                }
            }
            else if($action == "UPDATE") {

                if( $getEMAIL != $text_4) {
                    $stmt0_1 = $conn->prepare("SELECT count(emp_id) as rowC from tbl_employee where email = :email");
                    $stmt0_1->execute(['email'=>$text_4]);
                    $result0_1 = $stmt0_1->fetch();
                    $count0_1  = $result0_1['rowC'];

                    if($count0_1 > 0) {

                        $output = array("error","Error Found", $text_4 ." Is not Available to use.");
                    }else{

                        if( $getMOBILE != $text_5) {
                            
                            $stmt0_2 = $conn->prepare("SELECT count(emp_id) as rowC from tbl_employee where mobile = :mobile");
                            $stmt0_2->execute(['mobile'=>$text_5]);
                            $result0_2 = $stmt0_2->fetch();
                            $count0_2  = $result0_2['rowC'];


                        }
                    }

                }else{

                    


                }



                $stmt = $conn->prepare("UPDATE tbl_employee SET emp_name = :emp_name , dept_code = :dept_code WHERE emp_id = :emp_id");
                $result = $stmt->execute(['emp_name'=>$text_1 .', '. $text_2, 'dept_code'=>$text_3, 'emp_id'=>$id ]);
                if($result) {
                    
                    $stmt2 = $conn->prepare("UPDATE tbl_user SET FullName = :FullName  WHERE user_id = :user_id");
                    $result2 = $stmt2->execute(['FullName'=>$text_1 .', '. $text_2, 'user_id'=>$id ]);
                    

                    $output = array("success","Success", "Details Succesfully Updated");
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
    if(isset($_POST['transaction1'])){

        $fullname     = $_POST['fullname'];
        $userid       = $_POST['userid'];
        $username     = $_POST['text1_1'];
        $password     = $_POST['text1_2'];
        $role         = $_POST['text1_3'];
        $getUsername  = $_POST['text1_5'];

        try {
            $stmt = $conn->prepare("SELECT count(user_id) as totalcount FROM tbl_user WHERE FullName = :FullName");
            $stmt ->execute(['FullName'=>$fullname]);
            $result = $stmt->fetch();
            $count = $result['totalcount'];
            if($count == 0) {
                
                $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
                $stmt111->execute(['UsersName'=>$username]);
                $result111 = $stmt111->fetch();
                $count111 = $result111['totalcount11'];

                if($count111 > 0 ) {

                    $output = array("error", "Please Try another credentials","Username or Password is Unavailable");
                }else{

                    $stmt = $conn->prepare("INSERT INTO tbl_user(user_id, FullName, UsersName, Password, role, position) VALUES
                    (:user_id, :FullName, :UsersName, HASHBYTES('SHA2_512', '".$password."') , :role, :position)");
                    $result = $stmt ->execute(['user_id'=>$userid,  'FullName'=>$fullname, 'UsersName'=>$username, 'role'=>$role, 'position'=>$role  ]);
                    
                    if($result) {
                        $output = array("success","Success", $fullname . " Succesfully Added As " .$role);
                    }else{
                        $output = array("error","Error Found", $result);
                    }


                }

            }else{

                if($username != $getUsername) {

                    
                    $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
                    $stmt111->execute(['UsersName'=>$username]);
                    $result111 = $stmt111->fetch();
                    $count111 = $result111['totalcount11'];

                    if($count111 > 0 ) {

                        $output = array("error", "Please Try another credentials","Username or Password is Unavailable");
                    }else{
    
                        $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName, Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
                        position = :position  WHERE FullName = :FullName");
                        $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                        
                        if($result) {
                            $output = array("success","Success", $fullname . " Succesfully Updated");
                        }else{
                            $output = array("error","Error Found", $result);
                        }

    
                    }

                }else{


                    $stmt = $conn->prepare("UPDATE tbl_user SET  Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
                        position = :position  WHERE FullName = :FullName");
                        $result = $stmt ->execute(['role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                        
                        if($result) {
                            $output = array("success","Success", $fullname . " Succesfully Updated");
                        }else{
                            $output = array("error","Error Found", $result);
                    }

                }



                // $stmt111 = $conn->prepare("SELECT count(user_id) as totalcount11 from tbl_user where UsersName = :UsersName");
                // $stmt111->execute(['UsersName'=>$username]);
                // $result111 = $stmt111->fetch();
                // $count111 = $result111['totalcount11'];


                // if($password == "") {
                //     $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName , role = :role,
                //     position = :position  WHERE FullName = :FullName");
                //     $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                    
                //     if($result) {
                //         $output = array("success","Success", $fullname . " Succesfully Updated");
                //     }else{
                //         $output = array("error","Error Found", $result);
                //     }



                // }else{

                //     $stmt = $conn->prepare("UPDATE tbl_user SET UsersName = :UsersName, Password= HASHBYTES('SHA2_512', '".$password."') , role = :role,
                //     position = :position  WHERE FullName = :FullName");
                //     $result = $stmt ->execute(['UsersName'=>$username, 'role'=>$role, 'position'=>$role, 'FullName'=>$fullname ]);
                    
                //     if($result) {
                //         $output = array("success","Success", $fullname . " Succesfully Updated");
                //     }else{
                //         $output = array("error","Error Found", $result);
                //     }



                // }

                
              
            }
        }catch (PDOException $e) {
            $output = array("error","Error Found", $e->getMessage());

        }
        echo json_encode($output);
        $pdo->close();
        exit();
    }
    if(isset($_GET['viewinfo'])){

        $fullname     = $_GET['fullname'];

        try {

            $stmt = $conn->prepare("SELECT count(user_id) as totalcount FROM tbl_user WHERE FullName = :FullName");
            $stmt ->execute(['FullName'=>$fullname]);
            $result = $stmt->fetch();
            $count = $result['totalcount'];
            /* USERNAME || PASSWORD || ROLE || POSITION */
            if($count == 0) {
                $output = array("success",$count,"". "", "No Position");
            }else{
                
                $stmt = $conn->prepare("SELECT  UsersName, role, position from tbl_user where FullName = :FullName");
                $stmt ->execute(['FullName'=>$fullname]);

                $result1 = $stmt->fetch();
                $output = array("success",$count, $result1['UsersName'], $result1['role'], $result1['position']);
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
    

        $stmt = $conn->prepare("SELECT *, (select count(user_id) from tbl_user where Fullname =emp_name) as isuser FROM tbl_employee");
        $stmt->execute();
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1           = $row['emp_id'];
            $row2           = $row['emp_name'];
            $row3           = $row['dept_code'];
            $row4           = $row['isuser'];
            $row5           = $row['isEnabled'];
            $row6           = $row['email'];
            $row7           = $row['mobile'];
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
                "row6"=>$row6,
                "row7"=>$row7,
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
        $pdo->close();
    }

    if(isset($_POST['enDisableAct'])) {

        $emp_name   = $_POST['acctname'];
        $actstatus  = $_POST['acctstastus'];
        
        $updatestatsTR = ($actstatus == 0 ? "Enabled" : "Disabled");
        $updatestats = ($actstatus == 0 ? 1 : 0);

        
        try { 

            $stmt = $conn ->prepare("UPDATE tbl_employee SET isEnabled = :isEnabled FROM tbl_employee WHERE emp_name = :emp_name");
            $stmt->execute(['isEnabled'=>$updatestats , 'emp_name'=>$emp_name]);
            if($stmt) {
                $output = array("success", "Success", "Succesfully " .$updatestatsTR);
            }else{
                $output = array("error", "Error Found", "Please Reload the page first.");
            }


        }catch(PDOException $e) {
            

            $output = array("error", "Error Found", $e->getMessage());


        }
        echo json_encode($output);

        $pdo->close();
    }

?>