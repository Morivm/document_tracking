
<?php
    ob_start(); 

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
$pdf->Image( "imgsbarcode/$barcode.jpg" , 120, 5, 70, 10, 'jpg', '', '', true, 150, 'right', false, false, false, false, false, false);
$pdf->Cell(155, 20, $barcode , 0, false, 'R', 0, '', 0, false, 'T', 'M');


$pdf->SetFont('dejavusans', '', 14, '', true);


function showbusinessDetails($conn, $id, $barcode, $pdf) {

    try {
        $stmt_2 = $conn->prepare("SELECT * FROM  vw_search_order_business WHERE row2 = :row2");
        $stmt_2->execute(['row2'=>$barcode]);
        $count_2 = $stmt_2->rowCount();

        $output_2 = "";
        if($count_2 == 0) {
            $output_2[] = array(0,"No Attributes for Business");
        }else{
            while ($row_2 = $stmt_2->fetchObject()) {
                $output_2 .= $row_2->row6 ;
            }
        }
        }catch (PDOException $e) {
            $output_2 = die($e->getMessage());
        }
        return "<p style='margin-left:100%'></i>" .$output_2 . "</i></p><br><br>";
       
    }



try {
    $stmt_1 = $conn->prepare("SELECT row1, row3 FROM  vw_search_order_business WHERE row2 = :row2");
    $stmt_1->execute(['row2'=>$barcode]);
    $count_1 = $stmt_1->rowCount();

    $output_1 = "<br><br><br><br><br><br><br>";
    $x = 'AZ';



    if($count_1 == 0) {
        $output_1[] = array(0,"No Order of Business");
    }else{
        while ($row_1 = $stmt_1->fetchObject()) {
            $x++;
            $output_1 .= "<b>". substr($x, 1).". ". $row_1->row3 .  "</b>".'<br>' . showbusinessDetails($conn, $row_1->row1, $barcode, $pdf)  ;
        }
    }

    // <td>' . showbusinessDetails($conn, $row_1->row1, $barcode)   . '</td>
    }catch (PDOException $e) {
        $output_1 = die($e->getMessage());
    }
    $output_res = $output_1;


$pdf->writeHTML($output_res, false, false, false, false, '');



// try {
//     $stmt_3 = $conn->prepare("SELECT * FROM vw_search_commitees WHERE row8 =:row8");
//     $stmt_3->execute(['row8'=>$barcode]);
//     $count_3 = $stmt_3->rowCount();

//     $output_3 = "<table  border='1'>
//                     <tr>
//                         <th>Committe</th>
//                     </tr>
//                 ";

//     if($count_3 == 0) {
//         $output_3[] = array(0,"No Details of committe's found");
//     }else{
//         while ($row_3 = $stmt_3->fetchObject()) {
//             $output_3 .= "" ;
//         }
//     }

//     $output_3 .="</table>";
//     // <td>' . showbusinessDetails($conn, $row_1->row1, $barcode)   . '</td>
//     }catch (PDOException $e) {
//         $output_1 = die($e->getMessage());
//     }
//     $output_res3 = $output_3;


// $pdf->writeHTML($output_res3, false, false, false, false, '');




    $stmt_4 = $conn->prepare("SELECT COUNT(row1) as numrows FROM vw_search_commitees WHERE row8 = :row8");
    $stmt_4 -> execute(['row8'=>$barcode]);
    $result_4 = $stmt_4->fetch();

    if($result_4['numrows'] == 0) {
$tbl3 = <<<EOD
<br><br><br><br><br><br><br><br>
<table border="1"  cellpadding="9">
<tr nobr="true">
<td style="text-align: center; font-weight: bold;">No Committe's Included</td>
</tr>
</table>
EOD;
}else{
    $resCom = "";
    $stmt_1_1 = $conn->prepare("SELECT * FROM vw_search_commitees WHERE row8 = :row8");
    $stmt_1_1->execute(['row8'=>$barcode]);
 
    while ($row_1_1 = $stmt_1_1->fetchObject()) {
        $resCom .= "<tr>
                        <td>$row_1_1->row3</td>
                        <td>$row_1_1->row6</td>
                        <td>$row_1_1->row5</td>
                    </tr>";
    }
 
    $tbl3 = <<<EOD
    <table cellspacing="0" cellpadding="5" border="1">
        <tr>
            <td>Committe</td>
            <td>Position</td>
            <td>Name</td>
        </tr>
        $resCom
    </table>
    EOD;
    

}

$pdf->writeHTML($tbl3, true, false, false, false, '');


    $pdf->Output(__DIR__ . "\\pr\\$barcode.pdf", 'F');



    $source = "../modules/pr/$barcode.pdf"; 
                
    $destination = "../img/barcodes/$barcode/$barcode.pdf"; 
    
    if( !copy($source, $destination) ) { 
        $output = array("error","Error Found" ,"File Cant be Copied");
    } 
    else { 
        $output = array("success","Success" ,"File Copied Succesfully");
    } 

  
?>
<script>   
        document.title = "Generating Please Wait...";

        window.close(); 
     
</script>
