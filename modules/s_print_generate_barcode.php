<style type="text/css">
        @media print
                {
                table {page-break-after:always}
                }
        </style>
<body onload="window.print()">
    

<?php

include 'session.php';
   
$conn = $pdo->open();  
$generated_by = $_GET['ids'];

try{ 


    $stmt = $conn->prepare("SELECT row2, row4, row5, row7 FROM vw_barcode_to_print WHERE row9 = :row9 AND row10 = :row10");
    $stmt->execute(['row9'=>0, 'row10'=>$userid]);
    // $count = $stmt->rowCount();
    $result = $stmt->fetch();
    
    // if($count == 0) {
    
    //     echo "No Results Found";
    // }else{
    
        $datas = array();
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //    echo $datas[] = $row['row2'];

            $rep_userid     = $row['row2'];
            $rep_doctype    = $row['row4'];
            $rep_username   = $row['row5'];
            $rep_doctypename   = $row['row7'];
            

            $path = $rep_userid."_" . $rep_doctype.".jpg";

            echo "
                <table>
                <br><br><br>
                <img src='imgsbarcode/$path' style='float: right;' width='300px'><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <center><label style='font-size: 80px;'><i>Properties of </i></label></center>
                <center><label style='font-size: 50px;'>$rep_username</label></center><br>
                <center><label style='font-size: 30px;'>($rep_doctypename)</label></center><br>
                </table>
            ";


        }
    
    
     
    // }

}catch(PDOException $e) {
    echo $e->getMessage();

}





$pdo->close();



?>

</body>

<script>
    setTimeout(function () { window.print(); }, 500);
    window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }

</script>