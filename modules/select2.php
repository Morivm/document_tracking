<?php
    include '../modules/session.php';

    $conn = $pdo->open();

    if($_POST['form']=="select_department") {
        try {
            $stmt = $conn->prepare("SELECT * FROM vw_setup_department where row4 = :row4");
            $stmt->execute(['row4'=>1]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output[] = array(0,"No Available Departments");
            }else{
                while ($row = $stmt->fetchObject()) {
                    $output[] = array(
                        $row->row1,
                        $row->row3 .' ('. $row->row2.')'
                    );
                }
            }
            }catch (PDOException $e) {
                $output = die($e->getMessage());
            }
            echo json_encode($output);
            exit();
            $pdo->close();
    }

    if($_POST['form']=="select_contractname") {
        try {
            $stmt = $conn->prepare("SELECT * FROM vw_contract_types WHERE row3 = :row3");
            $stmt->execute(['row3'=>1]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output[] = array(0,"No Contracts Found");
            }else{
                while ($row = $stmt->fetchObject()) {
                    $output[] = array(
                        $row->row1,
                        $row->row2
                    );
                }
            }
            }catch (PDOException $e) {
                $output = die($e->getMessage());
            }
            echo json_encode($output);
            exit();
            $pdo->close();
    }

    if($_POST['form']=="select_type_of_person") {
        try {
            $stmt = $conn->prepare("SELECT * FROM vw_type_of_person WHERE row3 = :row3");
            $stmt->execute(['row3'=>1]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output[] = array(0,"No Available Type of Person");
            }else{
                while ($row = $stmt->fetchObject()) {
                    $output[] = array(
                        $row->row1,
                        $row->row2
                    );
                }
            }
            }catch (PDOException $e) {
                $output = die($e->getMessage());
            }
            echo json_encode($output);
            exit();
            $pdo->close();
    }
    
    if($_POST['form']=="select_orderofbusiness") {
        try {
            $stmt = $conn->prepare("SELECT row1, row2 FROM vw_order_of_business WHERE row3 = :row3");
            $stmt->execute(['row3'=>1]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output[] = array(0,"No Order of Business Selected");
            }else{
                while ($row = $stmt->fetchObject()) {
                    $output[] = array(
                        $row->row1,
                        $row->row2
                    );
                }
            }
            }catch (PDOException $e) {
                $output = die($e->getMessage());
            }
            echo json_encode($output);
            exit();
            $pdo->close();
    }
    
    if($_POST['form']=="select_commitee") {
        try {
            $stmt = $conn->prepare(" SELECT row1,row2 FROM vw_setup_committee WHERE row3 = :row3");
            $stmt->execute(['row3'=>1]);
            $count = $stmt->rowCount();
            if($count == 0) {
                $output[] = array(0,"No Committee Setup.");
            }else{
                while ($row = $stmt->fetchObject()) {
                    $output[] = array(
                        $row->row1,
                        $row->row2
                    );
                }
            }
            }catch (PDOException $e) {
                $output = die($e->getMessage());
            }
            echo json_encode($output);
            exit();
            $pdo->close();
    }



    // if($_POST['form']=="sel_depwithcode") {
    //     try {
    //         $stmt = $conn->prepare("SELECT * FROM tbl_departments");
    //         $stmt->execute();
    //         $count = $stmt->rowCount();
    //         if($count == 0) {
    //             $output[] = array(0,"No Available Departments");
    //         }else{
    //             while ($row = $stmt->fetchObject()) {
    //                 $output[] = array(
    //                     $row->dept_code,
    //                     $row->dept_code ."-". $row->dept_name
    //                 );
    //             }
    //         }
    //         }catch (PDOException $e) {
    //             $output = die($e->getMessage());
    //         }
    //         echo json_encode($output);
    //         exit();
    //         $pdo->close();
    // }


    
    // if($_POST['form']=="sel_depwithcodeforuser") {
    //     try {

    //         if($userrole == "User") {

    //             $stmt = $conn->prepare("SELECT * FROM tbl_departments  where dept_name = :dept_name");
    //             $stmt->execute(['dept_name'=>$userdeptname]);
    //         }else{
    //             $stmt = $conn->prepare("SELECT * FROM tbl_departments");
    //             $stmt->execute();
    //         }
    
    //         $count = $stmt->rowCount();
    //         if($count == 0) {
    //             $output[] = array(0,"No Available Departments");
    //         }else{
    //             while ($row = $stmt->fetchObject()) {
    //                 $output[] = array(
    //                     $row->dept_code,
    //                     $row->dept_code ."-". $row->dept_name
    //                 );
    //             }
    //         }
    //         }catch (PDOException $e) {
    //             $output = die($e->getMessage());
    //         }
    //         echo json_encode($output);
    //         exit();
    //         $pdo->close();
    // }


    /* 
        ROLES
    */

    // if($_POST['form']=="sel_roles") {
    //     try {
    //         $stmt = $conn->prepare("SELECT role_id, roleName from tbl_role");
    //         $stmt->execute();
    //         $count = $stmt->rowCount();
    //         if($count == 0) {
    //             $output[] = array(0,"No Available Role");
    //         }else{
    //             while ($row = $stmt->fetchObject()) {
    //                 $output[] = array(
    //                     $row->roleName,
    //                     $row->roleName
    //                 );
    //             }
    //         }
    //         }catch (PDOException $e) {
    //             $output = die($e->getMessage());
    //         }
    //         echo json_encode($output);
    //         exit();
    //         $pdo->close();
    // }
    //.......................................................................................................................................
//......................................................................................................dddd.......................ttt...
//......................................................................................................dddd......................tttt...
//......................................................................................................dddd......................tttt...
//.uuuu..uuuuu.sssssss....eeeeee..errrrrrr.....sssssss....aaaaaa..ammmmmmmmmmmmm....eeeeee.........ddddddddd..eeeeee..epppppppp.ppttttt..
//.uuuu..uuuuusssssssss..eeeeeeee.errrrrrr.... ssssssss..aaaaaaaa.ammmmmmmmmmmmmm..eeeeeeee.......dddddddddd.eeeeeeee.epppppppppppttttt..
//.uuuu..uuuuussss.ssss.seee.eeee.errrr....... sss.ssss.saaa.aaaaaammmm.mmmmmmmmm.meee.eeee...... dddd.ddddddeee.eeee.epppp.ppppp.tttt...
//.uuuu..uuuuusssss.....seee..eeeeerrr........ ssss.........aaaaaaammm..mmmm..mmmmmeee..eeee..... ddd...dddddeee..eeeeeppp...pppp.tttt...
//.uuuu..uuuuu.ssssss...seeeeeeeeeerrr.........ssssss....aaaaaaaaaammm..mmmm..mmmmmeeeeeeeee..... ddd...dddddeeeeeeeeeeppp...pppp.tttt...
//.uuuu..uuuuu..sssssss.seeeeeeeeeerrr..........sssssss.saaaaaaaaaammm..mmmm..mmmmmeeeeeeeee..... ddd...dddddeeeeeeeeeeppp...pppp.tttt...
//.uuuu..uuuuu......ssssseee......errr..............sssssaaa.aaaaaammm..mmmm..mmmmmeee........... ddd...dddddeee......eppp...pppp.tttt...
//.uuuuu.uuuuussss..ssssseee..eeeeerrr........ sss..sssssaaa.aaaaaammm..mmmm..mmmmmeee..eeee..... dddd.ddddddeee..eeeeepppp.ppppp.tttt...
//..uuuuuuuuuusssssssss..eeeeeeee.errr........ ssssssss.saaaaaaaaaammm..mmmm..mmmm.eeeeeeee.......dddddddddd.eeeeeeee.eppppppppp..ttttt..
//...uuuuuuuuu..ssssss....eeeeee..errr..........ssssss...aaaaaaaaaammm..mmmm..mmmm..eeeeee.........ddddddddd..eeeeee..epppppppp...ttttt..
//....................................................................................................................eppp...............
//....................................................................................................................eppp...............
//....................................................................................................................eppp...............
//....................................................................................................................eppp...............
//.......................................................................................................................................

    // if($_POST['form']=="select_processby") {
    //     try {
    //         $stmt = $conn->prepare(" SELECT  emp_name as emp_name FROM tbl_employee WHERE dept_code = :dept_code");
    //         $stmt->execute(['dept_code'=>$usedeptcode]);
    //         $count = $stmt->rowCount();
    //         if($count == 0) {
    //             $output[] = array(0,"No Available Employee");
    //         }else{
    //             while ($row = $stmt->fetchObject()) {
    //                 $output[] = array(
    //                     $row->emp_name,
    //                     $row->emp_name,
    //                 );
    //             }
    //         }
    //         }catch (PDOException $e) {
    //             $output = die($e->getMessage());
    //         }
    //         echo json_encode($output);
    //         exit();
    //         $pdo->close();
    // }


//.......................................................
//.ppppppppp....aaaaaa..auuu..uuuuu.sssssss....eeeeee....
//.pppppppppp..aaaaaaaa.auuu..uuuuuussssssss..eeeeeeee...
//.ppppp.pppppaaaa.aaaaaauuu..uuuuuusss.ssss.seee.eeee...
//.pppp...pppp....aaaaaaauuu..uuuuuussss.....seee..eeee..
//.pppp...pppp.aaaaaaaaaauuu..uuuuu.ssssss...seeeeeeeee..
//.pppp...ppppaaaaaaaaaaauuu..uuuuu..sssssss.seeeeeeeee..
//.pppp...ppppaaaa.aaaaaauuu..uuuuu......ssssseee........
//.ppppp.pppppaaaa.aaaaaauuuu.uuuuuusss..ssssseee..eeee..
//.pppppppppp.aaaaaaaaaa.uuuuuuuuuuussssssss..eeeeeeee...
//.ppppppppp...aaaaaaaaa..uuuuuuuuu..ssssss....eeeeee....
//.pppp..................................................
//.pppp..................................................
//.pppp..................................................
//.pppp..................................................
//.......................................................
// if($_POST['form']=="select_barcodes_pause") {
//     try {
//         $stmt = $conn->prepare("SELECT vw_doc.received_id as id, vw_doc.Barcode as barcode from vw_doc where vw_doc.RecievedFrom = :RecievedFrom and (vw_doc.STATUS = 'PENDING' OR vw_doc.STATUS = 'RETURN') order by vw_doc.received_id desc");
//         $stmt->execute(['RecievedFrom'=>$userdeptname]);
//         // $count = $stmt->rowCount();
//         // if($count == 0) {
//         //     $output[] = array(0,"No Barcodes Available");
//         // }else{
//            while ($row = $stmt->fetchObject()) {
//                 $output[] = array(
//                     $row->id,
//                     $row->barcode, 
//                 );
//             }
        
//         }catch (PDOException $e) {
//             $output = die($e->getMessage());
//         }
//         echo json_encode($output);
   
//         $pdo->close();
// }

// if($_POST['form']=="select_barcodes_play") {
//     try {
//         $stmt = $conn->prepare("SELECT vw_doc.Barcode as barcode from vw_doc where vw_doc.RecievedFrom = :RecievedFrom and vw_doc.STATUS = 'PAUSED' order by vw_doc.received_id desc");
//         $stmt->execute(['RecievedFrom'=>$userdeptname]);
//         // $count = $stmt->rowCount();
//         // if($count == 0) {
//         //     $output[] = array(0,"No Barcodes Available");
//         // }else{
//            while ($row = $stmt->fetchObject()) {
//                 $output[] = array(
//                     $row->barcode,
//                     $row->barcode, 
//                 );
//             }
        
//         }catch (PDOException $e) {
//             $output = die($e->getMessage());
//         }
//         echo json_encode($output);
   
//         $pdo->close();
// }

