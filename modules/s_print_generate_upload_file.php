
<?php
    ob_start(); 

    include 'session.php';
   
    require '../vendor/autoload.php';
    require_once('../TCPDF-master/tcpdf.php');

    $conn = $pdo->open();  
    $barcode = $_GET['barcode'];
    $barcodeorig = $_GET['barcodeorig'];
    $maxvers = $_GET['vers'];


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

$pdf->Image('../img/web/162918045116287627001627875343ss.JPG', 10, 5, 30, 20, 'JPG', '', '', true, 150, '', false, false, false, false, false, false);
$pdf->Image( "imgsbarcode/$barcode.jpg" , 120, 5, 70, 10, 'jpg', '', '', true, 150, 'right', false, false, false, false, false, false);
$pdf->Cell(155, 20, $barcode , 0, false, 'R', 0, '', 0, false, 'T', 'M');

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
$pdf->SetFont('dejavusans', '', 14, '', true);




try {
    $stmt_p2 = $conn->prepare("SELECT GROUP_CONCAT(barcode) as  bardcoded,
                            GROUP_CONCAT(order_of_business_id) as businessAll,
                            GROUP_CONCAT(description,'++++') as businessDesc,
                            GROUP_CONCAT((SELECT c.id FROM `tbl_setup_order_of_business` c WHERE c.order_of_business = order_of_business_id )) as businessId,
                            GROUP_CONCAT( SUBSTRING_INDEX(  SUBSTRING_INDEX(  barcode ,'-',-2)    ,'-',-1) ) as  businessdescid
                                
                                FROM search_order_of_business 
                                WHERE barcode = :barcode");
    $stmt_p2->execute(['barcode'=>$barcodeorig]);
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

            $pdf->writeHTML($output_p2.$x, false, false, false, false, '');



            // if (!file_exists("../modules/forum/".$order_of_business_code."/".$value)) {
            //     mkdir("../modules/forum/". $order_of_business_code."/".$value, 0777);
            // }
        }

    }
    }catch (PDOException $e) {
        $output_p2.$x = die($e->getMessage());
    }

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
