
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


function showbusinessDescription($conn, $business_id_name, $barcodes) {

    try {
            $stmt_2 = $conn->prepare("SELECT order_of_business_id , order_of_business_code, added_date, ordering, description FROM 
                                        search_order_of_business
                                        WHERE order_of_business_id = :order_of_business_id
                                        AND order_of_business_code = :order_of_business_code
                                    order by     ordering asc
                                    ");
            $stmt_2->execute(['order_of_business_id'=>$business_id_name, 'order_of_business_code'=>$barcodes]);
            $count_2 = $stmt_2->rowCount();

            $output_2 = "";
            if($count_2 == 0) {
                $output_2[] = array(0,"No Details Found");
            }else{
                while ($row_2 = $stmt_2->fetchObject()) {
                    $output_2 .=
                        
                        "<br><i>".$row_2->description."</i><br/><br/>
                    ";
                }
            }
    }catch (PDOException $e) {
        $output_2 = die($e->getMessage());
    } 
    
    return $output_2;
    
}

function convtoLetter($str) {
$alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$newName = '';
do {
    $str--;
    $limit = floor($str / 26);
    $reminder = $str % 26;
    $newName = $alpha[$reminder].$newName;
    $str=$limit;
} while ($str >0);
    return $newName;
}
function showbusinessDetails($conn, $barcode) {

    try {
            $stmt_2 = $conn->prepare("SELECT distinct(order_of_business_id) as order_of_business_id  FROM `search_order_of_business` WHERE order_of_business_code = :order_of_business_code order by added_date asc");
            $stmt_2->execute(['order_of_business_code'=>$barcode]);
            $count_2 = $stmt_2->rowCount();

            $output_2 = "";
            if($count_2 == 0) {
                $output_2[] = array(0,"No Details Found");
            }else{
                $x = 'Z';


                while ($row_2 = $stmt_2->fetchObject()) {
                    $x++;
                    $output_2 .=
                        
                        "<b>".substr($x, 1).". &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_2->order_of_business_id."</b><br/>
                        ".showbusinessDescription($conn, $row_2->order_of_business_id, $barcode)."


                    ";
                }
            }
    }catch (PDOException $e) {
        $output_2 = die($e->getMessage());
    } 
    
    return $output_2;
    
}



try {
    $stmt_1 = $conn->prepare("SELECT *, func_Dateformat(order_of_business_date,2) as dateoforder FROM `tbl_generated_cover` WHERE order_of_business_code = :order_of_business_code");
    $stmt_1->execute(['order_of_business_code'=>$barcode]);
    $count_1 = $stmt_1->rowCount();

    $output_1 = "<br><br><br><br><br><br><br>";

    if($count_1 == 0) {
        $output_1[] = array(0,"No Order of Business");
    }else{
        while ($row_1 = $stmt_1->fetchObject()) {
            $output_1 = "
            <br> <br> <br> <br> <br> <br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>Order of Business</i></label><br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>".$row_1->dateoforder."</i>
            <br> <br>
            ";
            
        }
    }
    }catch (PDOException $e) {
        $output_1 = die($e->getMessage());
    }
    $output_res = $output_1;


$pdf->writeHTML($output_res, false, false, false, false, '');




try {
    $stmt_1 = $conn->prepare("SELECT *, func_Dateformat(order_of_business_date,2) as dateoforder FROM `tbl_generated_cover` WHERE order_of_business_code = :order_of_business_code");
    $stmt_1->execute(['order_of_business_code'=>$barcode]);
    $count_1 = $stmt_1->rowCount();

    $output_2 = "<br>";

    if($count_1 == 0) {
        $output_1[] = array(0,"No Order of Business");
    }else{
        while ($row_1 = $stmt_1->fetchObject()) {
            $output_2 .= showbusinessDetails($conn,  $barcode) ;
            
        }
    }
    }catch (PDOException $e) {
        $output_1 = die($e->getMessage());
    }
    $output_res2 = $output_2;

$pdf->setFont('dejavusans', '', 10);
$pdf->writeHTML($output_res2, false, false, false, false, '');


$pdf->AddPage();


try {
    $stmt_p2 = $conn->prepare("SELECT GROUP_CONCAT(barcode) as  bardcoded,
                            GROUP_CONCAT(order_of_business_id) as businessAll,
                            GROUP_CONCAT(description,'++++') as businessDesc,
                            GROUP_CONCAT((SELECT c.id FROM `tbl_setup_order_of_business` c WHERE c.order_of_business = order_of_business_id )) as businessId,
                            GROUP_CONCAT( SUBSTRING_INDEX(  SUBSTRING_INDEX(  barcode ,'-',-2)    ,'-',-1) ) as  businessdescid
                                
                                FROM search_order_of_business 
                                WHERE order_of_business_code = :order_of_business_code");
    $stmt_p2->execute(['order_of_business_code'=>$barcode]);
    $count_p2 = $stmt_p2->rowCount();

    if($count_p2 == 0) {
        $output_p2 = "No Data Found";
    }else{
        $resultp2 = $stmt_p2->fetch();

        $string = $resultp2['bardcoded'];
        $string = preg_replace('/\.$/', '', $string);
        $array = explode(',', $string); 

        $string2 = $resultp2['businessAll'];
        $string2 = preg_replace('/\.$/', '', $string2);
        $array2 = explode(',', $string2); 
  
        $string3 = $resultp2['businessDesc'];
        $string3 = preg_replace('/\.$/', '', $string3);
        $array3 = explode('++++', $string3); 

        $string4 = $resultp2['businessId'];
        $string4 = preg_replace('/\.$/', '', $string4);
        $array4 = explode(',', $string4); 
        
        $string5 = $resultp2['businessdescid'];
        $string5 = preg_replace('/\.$/', '', $string5);
        $array5 = explode(',', $string5); 


        $x = 0;
        // $n = "Z";

        $output_p2 = "";
        $output_p23 = "";
        for($i=0; $i<count($array); $i++)
        {


            $x++;
            // $n++;
            $output_p2.$x = "<br>";
            // $output_p2.$x .="$value test<br>";
            $pdf->setFont('dejavusans', '', 10);
            $pdf->Image('../img/web/162918045116287627001627875343ss.JPG', 10, 5, 30, 20, 'JPG', '', '', true, 150, '', false, false, false, false, false, false);
            $pdf->Image( "imgsbarcode/".$array[$i].".jpg" , 120, 5, 70, 10, 'jpg', '', '', true, 150, 'right', false, false, false, false, false, false);
            $pdf->Cell(155, 20, $array[$i] , 0, false, 'R', 0, '', 0, false, 'T', 'M');
         
            $pdf->Multicell(0,70,""); 

            $font_size = $pdf->pixelsToUnits('150');

            $pdf->SetFont ('helvetica', '', $font_size , '', 'default', true );
            $pdf->Cell(0, 0,  $array2[$i] , 0, 1, 'C', 0, '', 0);

            $font_size2 = $pdf->pixelsToUnits('150');
            $pdf->SetFont ('helvetica', '', $font_size2 , '', 'default', true );
            $pdf->Cell(0, 0, "(".convtoLetter($array4[$i])."-".$array5[$i] .")", 0, 1, 'C', 0, '', 0);


            // $pdf->MultiCell(55, 5, ltrim($array3[$i],','), 0, 'J', 0, 2, '' ,'', true);
     
        //    $pdf->MultiCell(200, 55, ltrim($array3[$i]), 0, 'J', false, 1, 0, true, 0, false, true, 100,  'M', true);



            $pdf->AddPage();
            $pdf->writeHTML($output_p2.$x, false, false, false, false, '');



            // if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
            //     mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);
            // }
        }

    }
    }catch (PDOException $e) {
        $output_p2.$x = die($e->getMessage());
    }


// $pdf->setFont('dejavusans', '', 10);


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




//     $stmt_4 = $conn->prepare("SELECT COUNT(row1) as numrows FROM vw_search_commitees WHERE row8 = :row8");
//     $stmt_4 -> execute(['row8'=>$barcode]);
//     $result_4 = $stmt_4->fetch();

//     if($result_4['numrows'] == 0) {
// $tbl3 = <<<EOD
// <br><br><br><br><br><br><br><br>
// <table border="1"  cellpadding="9">
// <tr nobr="true">
// <td style="text-align: center; font-weight: bold;">No Committe's Included</td>
// </tr>
// </table>
// EOD;
// }else{
//     $resCom = "";
//     $stmt_1_1 = $conn->prepare("SELECT * FROM vw_search_commitees WHERE row8 = :row8");
//     $stmt_1_1->execute(['row8'=>$barcode]);
 
//     while ($row_1_1 = $stmt_1_1->fetchObject()) {
//         $resCom .= "<tr>
//                         <td>$row_1_1->row3</td>
//                         <td>$row_1_1->row6</td>
//                         <td>$row_1_1->row5</td>
//                     </tr>";
//     }
 
//     $tbl3 = <<<EOD
//     <table cellspacing="0" cellpadding="5" border="1">
//         <tr>
//             <td>Committe</td>
//             <td>Position</td>
//             <td>Name</td>
//         </tr>
//         $resCom
//     </table>
//     EOD;
    

// }

// $pdf->writeHTML($tbl3, true, false, false, false, '');


    // $pdf->Output(__DIR__ . "\\pr\\$barcode.pdf", 'I');
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
