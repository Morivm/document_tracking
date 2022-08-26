<?php
    include '../modules/session.php';
    $conn = $pdo->open();


    if(isset($_POST['advance_search'])) {
        
        $barcode    = $_POST['barcode'];
        $title      = $_POST['title'];

        $output     = "<table class='table table-striped table-hover  table-bordered'>
                            <thead class='cdtheadcolor'>
                                <tr>
                                    <th scope='col'>Barcode</th>
                                    <th scope='col'>Document Type</th>
                                    <th scope='col'>Document Title</th>
                                    <th scope='col'>From</th>
                                    <th scope='col'>Transaction</th>
                                    <th scope='col'>Datetime</th>
                                    <th scope='col'>Received By</th>
                                    <th scope='col'>Received Date</th>
                                    <th scope='col'>Remarks</th>
                                    <th scope='col'>Attachment</th>
                                    <th scope='col'>Processing Time(HRS)</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                  
        
        try {


            if (empty($barcode) &&  empty($title)) {
                $stmt1 = $conn->prepare("SELECT 
                                            a.barcode,
                                                (select doctype_name from tbl_docType where doctype_code = a.documentType ) as documentType,
                                                a.ProjectTitle,
                                                (select dept_name from tbl_departments where dept_code = (select dept_code from  tbl_employee where emp_name = a.doc_from) ) as Froms,
                                                a.Transac,
                                                dDate,
                                                receivedBy,
                                                receivedDate,
                                                remarks,
                                                attachment,
                                                [processingTime(mins)] as pro_hrs
                                            from 
                                                tbl_documentMovement a
                                            where
                                                doccreated_start = :doccreated_start
                                            or
                                                doccreated_to = :doccreated_to
                                            order by
                                                dDate desc");
                $stmt1->execute(['doccreated_start'=>$userdeptname, 'doccreated_to'=>$userdeptname]);
                $results1 = $stmt1->fetchAll();
                    foreach($results1 as $row1) {
                        $barcode        = $row1['barcode'];
                        $documentType   = $row1['documentType'];
                        $ProjectTitle   = $row1['ProjectTitle'];
                        $froms          = $row1['Froms'];
                        $transac        = $row1['Transac'];
                        $dDate          = ($row1['dDate'] == "") ? ""  :  date_format(date_create($row1['dDate']),'m/d/Y g:i a');
                        $receivedBy     = $row1['receivedBy'];
                        $receivedDate   = ($row1['receivedDate'] == "") ? ""  :  date_format(date_create($row1['receivedDate']),'m/d/Y g:i a');
                        $remarks        = $row1['remarks'];
                        $attachment     = $row1['attachment'];
                        $procctime      = $row1['pro_hrs'];

         
                        $output .=" <tr>
                                        <td>$barcode</td>
                                        <td>$documentType</td>
                                        <td>$ProjectTitle</td>
                                        <td>$froms</td>
                                        <td>$transac</td>
                                        <td>$dDate</td>
                                        <td>$receivedBy</td>
                                        <td>$receivedDate</td>
                                        <td>$remarks</td>
                                        <td>$attachment</td>
                                        <td>$procctime</td>
                      
                                    </tr>";

                    }
                $output .="</tbody></table>";

            }else{

                $stmt1 = $conn->prepare("SELECT 
                                            a.barcode,
                                            (select doctype_name from tbl_docType where doctype_code = a.documentType ) as documentType,
                                            a.ProjectTitle,
                                            (select dept_name from tbl_departments where dept_code = (select dept_code from  tbl_employee where emp_name = a.doc_from) ) as Froms,
                                            a.Transac,
                                            dDate,
                                            receivedBy,
                                            receivedDate,
                                            remarks,
                                            attachment,
                                            [processingTime(mins)] as pro_hrs
                                        from 
                                            tbl_documentMovement a
                                        
                                        where
                                            Barcode LIKE '%$barcode%' and ProjectTitle LIKE '%$title%'
                                        order by
                                            dDate desc");
                $stmt1->execute();
                $count1 = $stmt1->rowCount();
                if($count1 != 0) {
                    $stmt2 = $conn->prepare("SELECT 
                                                a.barcode,
                                                (select doctype_name from tbl_docType where doctype_code = a.documentType ) as documentType,
                                                a.ProjectTitle,
                                                (select dept_name from tbl_departments where dept_code = (select dept_code from  tbl_employee where emp_name = a.doc_from) ) as Froms,
                                                a.Transac,
                                                dDate,
                                                receivedBy,
                                                receivedDate,
                                                remarks,
                                                attachment,
                                                [processingTime(mins)] as pro_hrs
                                            from 
                                                tbl_documentMovement a
                                            
                                            where
                                                Barcode LIKE :Barcode and ProjectTitle LIKE :ProjectTitle
                                            order by
                                                dDate desc");
                    $stmt2->execute(['Barcode'=>"%".$barcode."%" , 'ProjectTitle'=> "%". $title ."%"]);
                    $results1 = $stmt1->fetchAll();
                    foreach($results1 as $row1) {
                        $barcode        = $row1['barcode'];
                        $documentType   = $row1['documentType'];
                        $ProjectTitle   = $row1['ProjectTitle'];
                        $froms          = $row1['Froms'];
                        $transac        = $row1['Transac'];
                        $dDate          = ($row1['dDate'] == "") ? ""  :  date_format(date_create($row1['dDate']),'m/d/Y g:i a');
                        $receivedBy     = $row1['receivedBy'];
                        $receivedDate   = ($row1['receivedDate'] == "") ? ""  :  date_format(date_create($row1['receivedDate']),'m/d/Y g:i a');
                        $remarks        = $row1['remarks'];
                        $attachment     = $row1['attachment'];
                        $procctime      = $row1['pro_hrs'];

         
                        $output .=" <tr>
                                        <td>$barcode</td>
                                        <td>$documentType</td>
                                        <td>$ProjectTitle</td>
                                        <td>$froms</td>
                                        <td>$transac</td>
                                        <td>$dDate</td>
                                        <td>$receivedBy</td>
                                        <td>$receivedDate</td>
                                        <td>$remarks</td>
                                        <td>$attachment</td>
                                        <td>$procctime</td>
                      
                                    </tr>";
                    }
                }else{
                   
                    $output .=" <tr>
                                    <td colspan='7'>No Results Found</td>
                                </tr>";
                }
               
            }
   
            $output .="</tbody></table>";

        }catch(PDOException $e) {

            $output = array("error","Error Found", $e->getMessage());

            
        }

        echo json_encode($output);
        $pdo->close();

    }


    if(isset($_POST['tbl_1'])) {
        $draw        = intval(0);
        $data        = array();
    
  
        $stmt = $conn->prepare("SELECT 
                                        a.barcode,
                                        (select doctype_name from tbl_docType where doctype_code = a.documentType ) as documentType,
                                        a.ProjectTitle,
                                        (select dept_name from tbl_departments where dept_code = (select dept_code from  tbl_employee where emp_name = a.doc_from) ) as Froms,
                                        a.Transac,
                                        dDate,
                                        receivedBy,
                                        receivedDate,
                                        remarks,
                                        attachment,
                                        [processingTime(mins)] as pro_hrs
                                    from 
                                        tbl_documentMovement a
                                    where
                                        doccreated_start = :doccreated_start
                                    or
                                        doccreated_to = :doccreated_to
                                    order by  receivedDate desc, dDate desc
                                        ");
                                      
        $stmt->execute(['doccreated_start'=>$userdeptname , 'doccreated_to'=>$userdeptname ]);
        $records = $stmt->fetchAll();
        $data = array();
        foreach($records as $row){
            $row1               = $row['barcode'];
            $row2               = $row['documentType'];
            $row3               = $row['ProjectTitle'];
            $row4               = $row['Froms'];
            $row5               = $row['Transac'];
            $row6               = ($row['dDate'] == "") ? ""  :  date_format(date_create($row['dDate']),'m/d/Y g:i a');
            $row7               = $row['receivedBy'];
            $row8               = ($row['receivedDate'] == "") ? ""  :  date_format(date_create($row['receivedDate']),'m/d/Y g:i a');
            $row9               = $row['remarks'];
            $row10              = $row['attachment'];
            $row11              = $row['pro_hrs'];

            $data[] = array(
                "row1"=>$row1,
                "row2"=>$row2,
                "row3"=>$row3,
                "row4"=>$row4,
                "row5"=>$row5,
                "row6"=>$row6,
                "row7"=>$row7,
                "row8"=>$row8,
                "row9"=>$row9,
                "row10"=>$row10,
                "row11"=>$row11
            );
        }
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);    
        $pdo->close();
    }

?>