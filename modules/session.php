<?php
    include '../includes/conn.php';


    session_start();

    $conn = $pdo -> open();

    $userid         = "";
    $userempname    = "";
    $usedeptcode    = "";
    $userdeptname   = "";
    $userrole   = "";


    // $u_mailer_loc       =  "../img/resources/setup/setup.txt";
    // $u_mailer_file_body = file($u_mailer_loc);
    // $u_mailer_status    = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[0], strrpos($u_mailer_file_body[0], '=') + 1) );
    // $u_mailer_usern     = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[1], strrpos($u_mailer_file_body[1], '=') + 1) );
    // $u_mailer_passw     = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[2], strrpos($u_mailer_file_body[2], '=') + 1) );
    // $u_mailer_team      = preg_replace("/\r|\n/", "", substr($u_mailer_file_body[3], strrpos($u_mailer_file_body[3], '=') + 1) );
    

    if(!isset($_SESSION['doc_5fe2562907c4eafe29b4384343298787676']) || trim($_SESSION['doc_5fe2562907c4eafe29b4384343298787676']) == ''){
        header('location: ../index');
        exit();
    }else{
        $userid         = $_SESSION['user_id']; 
        $userempname    = $_SESSION['user_fullname']; 
        $usedeptcode    = ""; 
        $userdeptname   = $_SESSION['user_department'];  
        $userrole       = $_SESSION['user_type']; 
    }


    function checkUserimgExist($users_id) {

        $imageFolder    = "../img/users/$users_id.jpg";
        $NoimageFolder  = "../img/users/noimage.png";

        if (file_exists($imageFolder)) {
            return  $imageFolder;
        } else {
            return  $NoimageFolder;
        }
    }


    function viewForum($forum_id, $conn, $user) {
        $details = "";
        $stmt_forum = $conn->prepare("SELECT *, func_fullname(comment_by) as fname , func_Dateformat(comment_date,3)as datecomment FROM tbl_forum WHERE forum_id = :forum_id");
        $stmt_forum->execute(['forum_id'=>$forum_id]);
        $count = $stmt_forum->rowCount();
        if($count == 0) {
            $details .="<i>No Comments Yet.</i>";

        }else{


            while ($row = $stmt_forum->fetchObject()) {
                $userposition = $row->comment_by;
                $usercomment = ($row->messages =="") ? "<a href='$row->attachment' target='_blank'  style='color:white' title='click to view' data-toggle='tooltip' > ".substr($row->attachment, strrpos($row->attachment, '/') + 1)."</a>" : $row->messages ;
                $commentator_name =  ($row->comment_by == $user) ? "You" :  $row->fname;
                $commentator_date = $row->datecomment;
                
                
            //     <div class='pull-right mr-5 mt-1'>
            //     <div class='media'>
            //         <div class='media-left'><span class='avatar avatar-sm avatar-online rounded-circle'><img src='".checkUserimgExist($userposition)."' alt='avatar'><i></i></span></div>
            //         <div class='media-body ml-2'>
            //             <h6 class='media-heading'><span class='font-weight-bold'>$commentator_name</span> <i class='pull-r'>($commentator_date)</i></h6>
                        
            //             <p class='notification-text font-small-3 text-muted' style='background-color:red'><span style='color:white; paddint-top:100px'>$usercomment</span></p>
            //         </div>
            //     </div>
            // </div>
            // <br>


                if($userposition == $user) {

                    $userpositioning = "
                                        <div class='pull-right mt-1'>
                                            <li style='border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;background-color:#0C7CFF;' >
                                                <p style='font-size:15px; color:white'><b>$commentator_name</b> - $usercomment
                                                    </p><div align='right'>
                                                        - <small style='color:white'><em>$commentator_date</em></small>
                                                    </div>
                                                <p></p>
                                            </li>    
                                        </div>
                                        ";
                }else {
                    $userpositioning = "
                                        <div class='pull-left mt-1'>
                                            <li style='border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;background-color:#F0F0F0;' >
                                                <p style='font-size:15px; color:black'><b>$commentator_name</b> - $usercomment
                                                    </p><div align='right'>
                                                        - <small style='color:black'><em>$commentator_date</em></small>
                                                    </div>
                                                <p></p>
                                            </li>    
                                        </div>
                                        ";
                                        }


               $details .= "
                    <div class='row'>
                        <div class='col-md-12'>
                    
                            $userpositioning
                  
                        </div>
                    </div>
                           ";

            }
        }
        
        return $details;

    }


?>