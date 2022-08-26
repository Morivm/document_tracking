
<?php
    include 'session.php';
   
    require '../vendor/autoload.php';
    require_once('../TCPDF-master/tcpdf.php');

    $conn = $pdo->open();  
    $barcode = $_GET['barcode'];

    // function copyDetails($newbarcode) {

    //     recurse_copy("$newbarcode.pdf","../img/barcodes/$newbarcode/"); 

    // }


    
    $generator      =   new Picqer\Barcode\BarcodeGeneratorJPG();
    $imgGenerated   =   '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128)) . '">';

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    $pdf->SetTitle("PROJECT PROPOSAL ".$barcode);
    $pdf->SetSubject('');
    $pdf->SetKeywords('PROJECT PROPOSAL');


    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 8, '', true);

// add a page
$pdf->AddPage();

// function getCompanyName($conn) {
//   try {       
//     $stmt = $conn->prepare("SELECT web_name FROM `tbl_web_setup` ORDER BY id DESC LIMIT 1");
//     $stmt -> execute();
//     $result = $stmt->fetch();
  
//       return $result['web_name'];
    
//   }catch(PDOException $e) {
//    return  $e->getMessage();
//   }
// }
// $barcodeGenerateimg = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128)) . '">';
// $compname = getCompanyName($conn);
$pdf->Image('../img/web/162918045116287627001627875343ss.JPG', 10, 5, 30, 20, 'JPG', '', '', true, 150, '', false, false, false, false, false, false);
$pdf->Image( "imgsbarcode/$barcode.jpg" , 70, 5, 130, 10, 'jpg', '', '', true, 150, '', false, false, false, false, false, false);
$pdf->Cell(155, 20, $barcode , 0, false, 'R', 0, '', 0, false, 'T', 'M');




try {     
    $stmt = $conn->prepare("SELECT TOP(1) count(*) as numrows  from vw_print_report where barcode = :barcode");
    $stmt -> execute(['barcode'=>$barcode]);
    $result = $stmt->fetch();

    if($result['numrows'] == 0) {
$tbl = <<<EOD
<br><br><br><br><br><br><br><br>
<table border="1"  cellpadding="9">
<tr nobr="true">
<td style="text-align: center; font-weight: bold;">No Results Found</td>
</tr>
</table>
EOD;
    }else{
        $stmt2 = $conn->prepare("SELECT TOP(1) *  from vw_print_report where barcode = :barcode order by received_id desc");
        $stmt2 -> execute(['barcode'=>$barcode]);
        $result2 = $stmt2->fetch();

        $current_date   = date("l jS \of F Y h:i:s A");
        $received_by    = $result2['RecievedBy'];
        $received_from  = $result2['RecievedFrom'];
        $projectTitle   = $result2['ProjectTitle'];
        $doctypename    = $result2['doctype_code'];
        $deptcode       = $result2['dept_code'];
        $receivedDate   = date('Y-m-d', strtotime($result2['recievedDate']));
        $briefDesc      = $result2['Description'];
        $recievers      = $result2['Receivers'];
        $resStr         = str_replace('O ', '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( ) ', $recievers);
        $attachment     = " ".$result2['Attachments'];
        $resAttach      = preg_replace("/\s+/", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $attachment);
        $tbl = <<<EOD
<br><br><br> <br><br><br>
<table border="1" cellpadding="9">
<tr nobr="true">
<th colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
$current_date</th>
</tr>
<tr nobr="true">
<th colspan="4"><b>DOCUMENT TYPE</b> &nbsp; &nbsp; &nbsp; $doctypename</th>
</tr>
<tr nobr="true">
<th>Created By</th>
<th colspan="3">$received_by</th>
</tr>
<tr nobr="true">
<th colspan="1">Department</th>
<th colspan="3">$deptcode</th>
</tr>
<tr nobr="true">
<th colspan="1">Project Title</th>
<th colspan="3">$projectTitle</th>
</tr>
<tr nobr="true">
<th colspan="1">Date Created</th>
<th colspan="3">$receivedDate</th>
</tr>
<tr nobr="true">
<th colspan="4"><b>Brief Description</b><br><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<i>$briefDesc</i>
</th>
</tr>
<tr nobr="true">
<th colspan="4"><b>Signatories</b>
<br>
$resStr
<br>
</th>
</tr>
<tr nobr="true">
<th colspan="4"><b>Attachments</b>
<br>

$resAttach
<br>
</th>
</tr>
</table>
<br /> <br /> <br />
EOD;
}
    $pdf->writeHTML($tbl, true, false, false, false, '');
    $pdf->Image('../img/web/footer.png', 10, 252, 190, 20, 'png', '', '', true, 150, '', false, false, false, false, false, false);
    // $pdf->Output($barcode.' '.date("Y-m-d"). '.pdf', 'I');


    $pdf->Output(__DIR__ . "\\pr\\$barcode.pdf", 'F');



    $source = "../modules/pr/$barcode.pdf"; 
                
    $destination = "../img/barcodes/$barcode/$barcode.pdf"; 
    
    if( !copy($source, $destination) ) { 
        $output = array("error","Error Found" ,"File Cant be Copied");
    } 
    else { 
        $output = array("success","Success" ,"File Copied Succesfully");
    } 

  
}catch(PDOException $e) {
  $output = $e->getMessage();
}
?>
<script>

        window.close(); 

</script>
Generating Please Wait...;