<?php

include '../modules/session.php';
$conn = $pdo->open();

$draw        = intval(0);
$data        = array();



function ApprovedFirstTrans($conn, $barcode, $dateString) {


    $concatedOutput = "";

    $stmt = $conn->prepare("SELECT top(1) Transac, 
                                doc_from as creator,
                                barcode as Barcode,
                                ProjectTitle AS title,
                                (select doctype_name from tbl_docType where doctype_code = documentType) as document_type,
                                (SELECT top(1) Description from tbl_recieved where Barcode = barcode order by received_id asc) as briefDesc,
                                ((select top(1)  STUFF((
                                                                                                                    SELECT ',' + md.dept_name
                                                                                                                    FROM tbl_receiving_dept md
                                                                                                                    WHERE m.barcode = md.barcode
                                                                                                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '') from tbl_receiving_dept m
                                                                                                            where m.barcode = barcode)

                                                                                                            ) as allAsignatories,
                                REPLACE(attachment, ' ', ' , ') as attachedFile,
                                    CONCAT(' ','  &nbsp; &nbsp; &nbsp; &nbsp;', '<b >Creator </b>', doc_from, ' <br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Barcode:</b>', barcode , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Title:</b>', ProjectTitle , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Document Type:</b>', (select doctype_name from tbl_docType where doctype_code = documentType) , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Attachments:</b>', REPLACE(attachment, ' ', ',')   , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Brief Description:</b>', (SELECT top(1) Description from tbl_recieved where Barcode = barcode order by received_id asc) , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Assignatories:</b>', ((select top(1)  STUFF((
                                                                                                                    SELECT ',' + md.dept_name
                                                                                                                    FROM tbl_receiving_dept md
                                                                                                                    WHERE m.barcode = md.barcode
                                                                                                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '') from tbl_receiving_dept m
                                                                                                            where m.barcode = barcode)

                                                                                                            )  , '<br>'

                            ) as top_transaction from tbl_documentMovement where barcode = :barcode and convert(varchar,dDate,120) = :dDate order by dDate asc");
    $stmt->execute(['barcode'=>$barcode, 'dDate'=>$dateString]);
    $result = $stmt->fetch();

    // $concat_top = $result['top_transaction']. "<h4 class='text-danger'> <b>&nbsp; &nbsp; &nbsp; &nbsp;Action: </b>". $result['Transac']. "</h4>". "<hr>";
    $concat_top = "
    <div class='table-responsive'>
        <table class='table table-striped table-bordered  mt-1'>
            <thead>
                <tr>
                    <th scope='col' style='width: 20%'>Creator</th>
                    <th scope='col'>".$result['creator']."</th>
                </tr>
                <tr>
                    <th scope='col'>Barcode</th>
                    <th scope='col'>".$result['Barcode']."</th>
                </tr>
                <tr>
                    <th scope='col'>Title</th>
                    <th scope='col'>".$result['title']."</th>
                </tr>
                <tr>
                    <th scope='col'>Document Type</th>
                    <th scope='col'>".$result['document_type']."</th>
                </tr>
                <tr>
                    <th scope='col'>Attached Files</th>
                    <th scope='col'>".substr($result['attachedFile'], 0, -2) .  "</th>
                </tr>
                <tr>
                    <th scope='col'>Brief Description</th>
                    <th scope='col'>".$result['briefDesc']."</th>
                </tr>
                <tr>
                    <th scope='col'>Assignatories</th>
                    <th scope='col'>".$result['allAsignatories']."</th>
                </tr>
                <tr class='text-success'>
                    <th scope='col'>Action</th>
                    <th scope='col'>".$result['Transac']."</th>
                </tr>
            </thead>                                            
        </table>
    </div>
    ";
    $concatedOutput = $concat_top ;


    

    return "<h4>".$concatedOutput."<h4>";
}
function ApprovedMidTrans($conn, $barcode, $dateString) {

    $concatedOutput = "";
    $attachment_updated = "";

    $stmt2_1 = $conn->prepare("SELECT 
                                        a.receivedByName as receivers,
                                        REPLACE(a.transac, 'Transfer to', ' ') as receiverDept,
                                        REPLACE(attachment, ' ', ' , ') as attachmentReceived,
                                        [processingTime(mins)] as prc_time,
                                        CONCAT(' ', 
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Receiver: </b>', a.receivedByName, 'of', REPLACE(a.transac, 'Transfer to', ' '),'<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Attachments Received: </b>', REPLACE(a.attachment, ' ', ','), '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Processing Time: </b>', [processingTime(mins)] , '<br>'
                                                ) as mid_transaction,
                                                a.attachment,
                                                a.receivedByName

                                FROM tbl_documentMovement a
                                WHERE
                                    a.barcode = :barcode
                                AND
                                    a.receivedDate = :receivedDate
                                ");

    $stmt2_1->execute(['barcode'=>$barcode, 'receivedDate'=>$dateString]);
    $result2_1 = $stmt2_1->fetch();
    $result2_1_attachment   = str_replace(' ', '', $result2_1['attachment']);
    $result2_1_receiver     = $result2_1['receivedByName'];


    $stmt2_2 = $conn->prepare("SELECT remarks, attachment, transac, receivedBy from tbl_documentMovement where barcode = :barcode and  convert(varchar,dDate,120) = :convDate");
    $stmt2_2->execute(['barcode'=>$barcode, 'convDate'=>$dateString]);
    $result2_2 = $stmt2_2->fetch();
    $result2_2_attachment_withcomma = str_replace(' ', ' , ', $result2_2['attachment']);
    $result2_2_attachment = str_replace(' ', '', $result2_2['attachment']);



    if($result2_1_attachment == $result2_2_attachment) {
        $attachment_updated = "";
    }else{
        $attachment_updated = "<tr>
                                    <th scope='col'>$result2_1_receiver's Uploaded File</th>
                                    <th scope='col'>".substr(substr(str_replace($barcode.'.pdf', '', $result2_2_attachment_withcomma), 0, -2) ,2)   ."</th>
                                </tr>";
                                // substr($result2_2_attachment_withcomma, 0, -2)
    }
    // <label class='text-warning'>&nbsp; &nbsp; &nbsp; &nbsp; <b>$result2_1_receiver's Uploaded Attachments:</b> ".$result2_2_attachment_withcomma."</label>";
    if ($result2_2['remarks'] == "") {
    
        $th_remarks = "";

    }else{
        $th_remarks =
                    "<tr>
                        <th scope='col'>".$result2_1_receiver."'s Remark</th>
                        <th scope='col'>".$result2_2['remarks'] ."</th>
                    </tr>";
        
    }




    $concatedOutput = "<div class='table-responsive'>
                            <table class='table table-striped table-bordered  mt-1'>
                                <thead>
                                    <tr>
                                        <th scope='col' style='width: 20%'>Receiver</th>
                                        <th scope='col'>".$result2_1['receivers']." of ".$result2_1['receiverDept']."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Processing Time</th>
                                        <th scope='col'>".$result2_1['prc_time']."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>$result2_1_receiver's Received Files</th>
                                        <th scope='col'>".substr($result2_1['attachmentReceived'], 0, -2)."</th>
                                    </tr>
                                    $th_remarks
                                    $attachment_updated
                                    <tr class='text-success'>
                                        <th scope='col'>Action</th>
                                        <th scope='col'>".$result2_2['transac']."</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>";
                        
                        
    // $concatedOutput  = $result2_1['mid_transaction'] .
    // "<label class='text-warning'>&nbsp; &nbsp; &nbsp; &nbsp; <b>$result2_1_receiver's Remark : </b>" .$result2_2['remarks'] ."</label>"."<br>".
    // $attachment_updated. 
    // "<label class='text-danger'><b>&nbsp; &nbsp; &nbsp; &nbsp; Action: </b>" .$result2_2['transac']."</label><br>";


    // return "<label>".$concatedOutput."<label><hr>";
    return $concatedOutput;
}
function PendingFirstTrans($conn, $barcode, $dateString) {


    $concatedOutput = "";

    $stmt = $conn->prepare("SELECT top(1) Transac, 
                            a.doc_from as creator,
                            a.barcode as Barcode,
                            a.ProjectTitle as title, 
                            (select doctype_name from tbl_docType where doctype_code = documentType)  as document_type,
                            REPLACE(a.attachment, ' ', ',')  as  attachedFile,
                            ((select top(1)  STUFF((
                                                                                                                    SELECT ',' + md.dept_name
                                                                                                                    FROM tbl_receiving_dept md
                                                                                                                    WHERE m.barcode = md.barcode
                                                                                                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '') from tbl_receiving_dept m
                                                                                                            where m.barcode = a.barcode)

                                                                                                            )  as  allAsignatories,
                            (SELECT top(1) Description from tbl_recieved where Barcode = a.barcode order by received_id asc) as briefDesc,
                                    CONCAT(' ','  &nbsp; &nbsp; &nbsp; &nbsp;', '<b >Creator </b>', doc_from, ' <br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Barcode:</b>', barcode , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Title:</b>', ProjectTitle , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Document Type:</b>', (select doctype_name from tbl_docType where doctype_code = documentType) , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Attachments:</b>', REPLACE(attachment, ' ', ',')   , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Brief Description:</b>', (SELECT top(1) Description from tbl_recieved where Barcode = a.barcode order by received_id asc) , '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp;', '<b>Assignatories:</b>', ((select top(1)  STUFF((
                                                                                                                    SELECT ',' + md.dept_name
                                                                                                                    FROM tbl_receiving_dept md
                                                                                                                    WHERE m.barcode = md.barcode
                                                                                                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '') from tbl_receiving_dept m
                                                                                                            where m.barcode = a.barcode)

                                                                                                            )  , '<br>'

                            ) as top_transaction from tbl_documentMovement a where a.barcode = :barcode and convert(varchar,a.dDate,120) = :dDate order by dDate asc");
    $stmt->execute(['barcode'=>$barcode, 'dDate'=>$dateString]);
    $result = $stmt->fetch();

    $concat_top = "    <div class='table-responsive'>
    <table class='table table-striped table-bordered  mt-1'>
        <thead>
            <tr>
                <th scope='col' style='width: 20%'>Creator</th>
                <th scope='col'>".$result['creator']."</th>
            </tr>
            <tr>
                <th scope='col'>Barcode</th>
                <th scope='col'>".$result['Barcode']."</th>
            </tr>
            <tr>
                <th scope='col'>Title</th>
                <th scope='col'>".$result['title']."</th>
            </tr>
            <tr>
                <th scope='col'>Document Type</th>
                <th scope='col'>".$result['document_type']."</th>
            </tr>
            <tr>
                <th scope='col'>Attached Files</th>
                <th scope='col'>".substr($result['attachedFile'], 0, -2) .  "</th>
            </tr>
            <tr>
                <th scope='col'>Brief Description</th>
                <th scope='col'>".$result['briefDesc']."</th>
            </tr>
            <tr>
                <th scope='col'>Assignatories</th>
                <th scope='col'>".$result['allAsignatories']."</th>
            </tr>

        </thead>                                            
    </table>
</div>";



    // $concatedOutput = $concat_top ;




    

    return $concat_top;
}
function CancelledMidTrans($conn, $barcode, $dateString) {

    $concatedOutput = "";
    $attachment_updated = "";

    $stmt2_1 = $conn->prepare("SELECT CONCAT(' ', 
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Receiver: </b>', a.receivedByName, 'of',   REPLACE(REPLACE(a.transac, 'Transfer to', ' '), 'Cancelled By', ' ')     ,'<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Attachments Received: </b>', REPLACE(a.attachment, ' ', ','), '<br>',
                                                    '&nbsp; &nbsp; &nbsp; &nbsp; <b>Processing Time: </b>', [processingTime(mins)] , '<br>'
                                                ) as mid_transaction,
                                                a.attachment,
                                                a.receivedByName

                                FROM tbl_documentMovement a
                                WHERE
                                    a.barcode = :barcode
                                AND
                                    a.receivedDate = :receivedDate
                                ");

    $stmt2_1->execute(['barcode'=>$barcode, 'receivedDate'=>$dateString]);
    $result2_1 = $stmt2_1->fetch();
    $result2_1_attachment   = str_replace(' ', '', $result2_1['attachment']);
    $result2_1_receiver     = $result2_1['receivedByName'];


    $stmt2_2 = $conn->prepare("SELECT remarks, attachment, transac, receivedBy from tbl_documentMovement where barcode = :barcode and  convert(varchar,dDate,120) = :convDate");
    $stmt2_2->execute(['barcode'=>$barcode, 'convDate'=>$dateString]);
    $result2_2 = $stmt2_2->fetch();
    $result2_2_attachment_withcomma = str_replace(' ', ',', $result2_2['attachment']);
    $result2_2_attachment = str_replace(' ', '', $result2_2['attachment']);



    if($result2_1_attachment !== $result2_2_attachment) {
        $attachment_updated = "<label class='text-warning'>&nbsp; &nbsp; &nbsp; &nbsp; <b>$result2_1_receiver's Uploaded Attachments:</b> ".$result2_2_attachment_withcomma."</label>";
    }else{
        $attachment_updated = "";
    }
   

    
    $concatedOutput  = $result2_1['mid_transaction'] .
    "<label class='text-warning'>&nbsp; &nbsp; &nbsp; &nbsp; <b>$result2_1_receiver's Remark : </b>" .$result2_2['remarks'] ."</label>"."<br>".
    $attachment_updated. 
    "<label class='text-danger'><b>&nbsp; &nbsp; &nbsp; &nbsp; Action: </b>" .$result2_2['transac']."</label><br>";


    return "<label>".$concatedOutput."<label><hr>";

}
if(isset($_POST['view_detailed_rep'])) {

    $status     = $_POST['status'];
    $barcode    = $_POST['barcode'];
    $output     = "";

    try {

        if($status == "APPROVED") {

            $stmt = $conn->prepare("SELECT  convert(varchar,dDate,120) AS dDate from tbl_documentMovement where barcode =:barcode order by dDate asc");
            $stmt->execute(['barcode'=>$barcode]);
            $result = $stmt->fetch();
            $resultdDate = $result['dDate'];
                $output .= "<i><h3>" . date("F j, Y, g:i a", strtotime($result['dDate']))."</h3></i>
                ".ApprovedFirstTrans($conn, $barcode, $result['dDate'])."
                <br>";



            $stmt1 = $conn->prepare("SELECT  convert(varchar,dDate,120) AS dDate  from tbl_documentMovement where barcode =:barcode and  convert(varchar,dDate,120) != :ddDate order by dDate asc");
            $stmt1->execute(['barcode'=>$barcode, 'ddDate'=>$resultdDate]);
            
            foreach ($stmt1 as $row1) {
                $output .= "<i><h3>" . date("F j, Y, g:i a", strtotime($row1['dDate'])) ."</h3></i>
                ".ApprovedMidTrans($conn, $barcode, $row1['dDate'])."
                <br>";
            } 

            $stmt2_3 = $conn->prepare("SELECT top(1) receivedBy as last_trans, doccreated_to  from tbl_documentMovement where barcode = :barcode order by doc_id desc");
            $stmt2_3->execute(['barcode'=>$barcode]);
            $result2_3 = $stmt2_3->fetch();
            $receivedby2_3 = $result2_3['last_trans'];
            $keptbydept2_3 = $result2_3['doccreated_to'];
            $output .= "<h4 class='text-success pull-right'>&nbsp; &nbsp; &nbsp; &nbsp; <i>- $receivedby2_3<br> </i></h4> <h4 class='text-success pull-right'><i>( $keptbydept2_3 )</i></h4> ";
        

        }else if($status == "PENDING"){ 

            $stmt = $conn->prepare("SELECT  convert(varchar,dDate,120) AS dDate from tbl_documentMovement where barcode =:barcode order by dDate asc");
            $stmt->execute(['barcode'=>$barcode]);
            $result = $stmt->fetch();
            $resultdDate = $result['dDate'];
                $output .= "<i><h3>" . date("F j, Y, g:i a", strtotime($result['dDate'])) ."</h3></i>
                ".PendingFirstTrans($conn, $barcode, $result['dDate'])."
                <br>";

        }else if($status == "CANCELLED"){ 


            $stmt = $conn->prepare("SELECT  convert(varchar,dDate,120) AS dDate from tbl_documentMovement where barcode =:barcode order by dDate asc");
            $stmt->execute(['barcode'=>$barcode]);
            $result = $stmt->fetch();
            $resultdDate = $result['dDate'];
                $output .= "<i><h3>" . date("F j, Y, g:i a", strtotime($result['dDate'])) ."</h3></i>
                ".ApprovedFirstTrans($conn, $barcode, $result['dDate'])."
                <br>";

                $stmt1 = $conn->prepare("SELECT  convert(varchar,dDate,120) AS dDate  from tbl_documentMovement where barcode =:barcode and  convert(varchar,dDate,120) != :ddDate order by dDate asc");
                $stmt1->execute(['barcode'=>$barcode, 'ddDate'=>$resultdDate]);
                
                foreach ($stmt1 as $row1) {
                    $output .= "<i><h3>" . date("F j, Y, g:i a", strtotime($row1['dDate'])) ."</h3></i>
                    ".CancelledMidTrans($conn, $barcode, $row1['dDate'])."
                    <br>";
                } 
        }else{
            $output = array("error", "Error Found", "Please Reload your page");
        }


    }catch(PDOException $e) {
        $output = array("error", "Error Found", $e->getMessage());

    }


    echo json_encode($output);
    $pdo->close();
    exit;

}





?>