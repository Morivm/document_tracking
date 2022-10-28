<?php
    include "../modules/session.php";
    $conn = $pdo->open();

    $output = "";

    $orderofbusiness_code = $_GET['orderofbusinesscode'];
    $nameoffile = $orderofbusiness_code.time();



    function getLastVersio($conn, $barcode) {

        $output = "";
        $lastpdfs = $conn->prepare("SELECT  a.barcode,  MAX(a.version_no)  AS mxvers, (SELECT CONCAT(order_of_business_id, ' - ', ordering) FROM `search_order_of_business` WHERE barcode = a.barcode ) as nname FROM  search_order_of_busines_files a WHERE a.barcode =:barcode");
        $lastpdfs->execute(['barcode'=>$barcode]);
        $ftclastpdfs = $lastpdfs->fetch();
        $barcodeftclastpdfs = $ftclastpdfs['barcode'] ."-". $ftclastpdfs['mxvers'] ;


        if($ftclastpdfs['barcode'] == "") {
            $lastpdfs2 = $conn->prepare("SELECT  barcode, order_of_business_id, ordering FROM  search_order_of_business WHERE barcode =:barcode order by id DESC");
            $lastpdfs2->execute(['barcode'=>$barcode]);
            $ftclastpdfs2 = $lastpdfs2->fetch();
            $barcodeftclastpdfs2 = $ftclastpdfs2['barcode'];

            $output .= "../scanned_docs/$barcodeftclastpdfs2.pdf++";


            
        }else{
            $output .= "../scanned_docs/$barcodeftclastpdfs.pdf++";
 
        }


        return $output;

    }





    $stmtpdfs = $conn->prepare("SELECT barcode FROM search_order_of_business WHERE order_of_business_code = :order_of_business_code order by id DESC");
    $stmtpdfs->execute(['order_of_business_code'=>$orderofbusiness_code]);

    
    while($rowpdfs = $stmtpdfs->fetchObject()) {

        $output .= getLastVersio($conn,  $rowpdfs->barcode);
    }





    // $newStr = implode("++", $output);
    $arr = explode("++", $output);




    if (!file_exists("../zips/$nameoffile")) {
        mkdir("../zips/$nameoffile", 0777);

        foreach ($arr as $row) {

            if( $row != "" ) {
    
                $det =  $row . "++";
    
                $replacestr = str_replace('++', '', $det);
        
        
                $replacecopied =  str_replace("../scanned_docs/", "../zips/$nameoffile/", $replacestr);
        
                if ( copy($replacestr, $replacecopied) ) {
                    echo "copy saved <hr />";
                }else{
                    echo "copy failed <hr />";
                }
            }
        }


    } else {
        echo "The directory $nameoffile exists.";
    }




    $rootPath = realpath("../zips/$nameoffile");



    $zip = new ZipArchive();
    $zip->open($nameoffile.".zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
    

    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($files as $name => $file)
    {

        if (!$file->isDir())
        {

            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
    

            $zip->addFile($filePath, $relativePath);
        }
    }
    

 
    header( "Location: $nameoffile.zip" );
    unlink("../zips/$nameoffile");


    // $zipname = $nameoffile."zip";
    // $zip = new ZipArchive;
    // $zip->open($zipname, ZipArchive::CREATE);
    // if ($handle = opendir('.')) {
    //   while (false !== ($entry = readdir($handle))) {
    //     if ($entry != "." && $entry != ".." && !strstr($entry,'.php')) {
    //         $zip->addFile($entry);
    //     }
    //   }
    //   closedir($handle);
    // }



    // header('Content-Type: application/zip');
    // header("Content-Disposition: attachment; filename=$nameoffile.zip");
    // header('Content-Length: ' . filesize($zipname));
    // header("Location: $nameoffile.zip");



    // ignore_user_abort(true);

    
    // unlink("$nameoffile".".zip");

    $zip->close();
?>