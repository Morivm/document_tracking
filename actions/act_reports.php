<?php

include '../modules/session.php';
$conn = $pdo->open();

$draw        = intval(0);
$data        = array();


    $status     = $_GET['status'];
    $datefrom   = "";
    $dateto     = "";

    if($status == "APPROVED"){

        $stmt = $conn->prepare("EXEC usp_select_approved_report 
                                    @RecievedFrom   =   :RecievedFrom,
                                    @dept_code      =   :dept_code,
                                    @timefrom       =   :timefrom,
                                    @timeto         =   :timeto");

        $stmt->execute(['RecievedFrom'=>$usedeptcode, 'dept_code'=>$userdeptname, 'timefrom'=>$datefrom, 'timeto'=>$dateto ]);
        $records = $stmt->fetchAll();

    }else if($status == "PENDING"){

        $stmt = $conn->prepare("EXEC usp_select_pending_report 
                                    @RecievedFrom   =   :RecievedFrom,
                                    @dept_code      =   :dept_code,
                                    @timefrom       =   :timefrom,
                                    @timeto         =   :timeto");

        $stmt->execute(['RecievedFrom'=>$usedeptcode, 'dept_code'=>$userdeptname, 'timefrom'=>$datefrom, 'timeto'=>$dateto ]);
        $records = $stmt->fetchAll();

    }else if($status == "CANCELLED"){

        $stmt = $conn->prepare("SELECT a.Barcode as Barcode,
                                (select top(1) dept_name from tbl_departments where dept_code = dept_code) as doc_start,
		                        (SELECT TOP(1) convert(varchar,cancel_datetime,120) as cancel_datetime from tbl_doc_cancel where barcode = a.barcode) as 'Date Approved2',
                                (select top(1) ProjectTitle from tbl_documentMovement where barcode =  a.barcode ) as ProjectTitle
                                FROM 
                                    tbl_doc_created a
                                LEFT JOIN tbl_recieved ON tbl_recieved.Barcode = a.barcode
                                where  dept_name = :dept_name AND tbl_recieved.STATUS = 'CANCELLED'
                                GROUP BY a.Barcode,
                                a.dept_name,
                                a.created_status,
                                a.reason ,
                                a.created_datetime,
                                a.updated_datetime 
                                order by 
                                created_datetime DESC");


        $stmt->execute(['dept_name'=>$userdeptname ]);
        $records = $stmt->fetchAll();

    }else if($status == "PAUSED"){

    $stmt = $conn->prepare("SELECT 
                                a.barcode as Barcode,
                                (select top(1) ProjectTitle from tbl_documentMovement where barcode =  a.barcode ) as ProjectTitle,
                                convert(varchar,a.pause_dateTime,120) as 'Date Approved2',
                                a.dept_name as  doc_start 
                                from 
                                    tbl_pause a
                                where	dept_name = :dept_name order by pause_dateTime DESC ");

        $stmt->execute(['dept_name'=>$userdeptname]);
        $records = $stmt->fetchAll();

    }




        foreach($records as $row){
            $row1           = $row['Barcode'];
            $row2           = $row['ProjectTitle'];
            $row3           = $row['doc_start'];
            $row4           = $row['Date Approved2']; 
            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
            );
        }
        $response = array(
            "aaData" => $data
        );

        echo json_encode($response);
        $pdo->close();

  

?>