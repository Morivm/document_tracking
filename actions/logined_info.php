<?php
    include '../modules/session.php';

    $conn = $pdo->open();
    
    if (isset($_POST['checklogined'])) {

        try{ 
      
                $stmt = $conn->prepare("SELECT * FROM vw_nowlogined WHERE row1 = :row1");
                $stmt->execute(['row1'=>$userid]);
                
                while($row = $stmt->fetchObject())
                {   
                    $output[] = array(
                        $row->row8, 
                        $row->row9,
                        $row->row10, 
                        $row->row11,
                        $row->row12,
                        $row->row13,
                        $row->row7,
                        $row->row4,

                    );
                }
        } catch(PDOException $e) {
            $output = die($e->getMessage());
        }   
        
            echo json_encode($output);
            $pdo->close();
    }
    if (isset($_POST['changepassword'])) {

        $newpass = $_POST['log_new_pass'];
        $oldpass = $_POST['log_old_pass'];
        $hashpass   = password_hash($newpass, PASSWORD_DEFAULT);

        try{ 
            $stmt = $conn->prepare("SELECT password FROM tbl_users WHERE id =:id");
            $stmt->execute(['id'=>$userid]);
            $dbpass = $stmt->fetch();

            if(password_verify($oldpass ,$dbpass['password'])){
                
                $stmt2 = $conn->prepare("UPDATE tbl_users SET password = :password WHERE id = :id");
                $stmt2->execute(['password'=>$hashpass, 'id'=>$userid]);
                $output = array(1, "Password Succesfully Changed", "You can now login with your new password.");
            }else{
                $output = array(0, "Old password is incorrect", "Please Enter your old password Correctly.");
            }

        } catch(PDOException $e) {
            $output = array(0, die($e->getMessage()));
        }
        
            echo json_encode($output);
            $pdo->close();


        // $output = "hh";
        // try{ -        //     $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE id =:id");
        //     $stmt->execute(['id'=>$userid]);
        //     while($row = $stmt->fetchObject())
        //     {
        //         $output[] = array(
        //             $row->lastname, 
        //             $row->firstname,
        //             $row->middlename, 
        //             $row->suffix,
        //             $row->photo,
        //             $row->photo_ext
        //         );
        //     }
        // } catch(PDOException $e) {
        //     $output = die($e->getMessage());
        // }

        // echo json_encode($newpass);
        // $pdo->close();
    }
    if (isset($_POST['checkWebsetup'])) {
        try{ 
            $stmt = $conn->prepare("SELECT top 1 * FROM tbl_web_setup ORDER BY id DESC");
            $stmt->execute();
            $countrow = $stmt->rowCount();
            if($countrow == 0){
                $output[] = array(
                    "no_image.png",
                    "Itrack Asset"
                );
            }else{
                while($row = $stmt->fetchObject())
                {
                    $output[] = array(
                        $row->image_name, 
                        $row->web_name
                    );
                }
            }
        } catch(PDOException $e) {
            $output = die($e->getMessage());
        } 
            echo json_encode($output);
            $pdo->close();
    }
?>