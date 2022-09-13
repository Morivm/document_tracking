<?php
    include "../modules/session.php";

    $conn = $pdo->open();


    $barcode  = $_GET['barcode'];
    $stmt = $conn ->prepare("SELECT uploadId, uploadFile FROM `tblupload` WHERE uploadFileName = :uploadFileName");
    $stmt->execute(['uploadFileName'=>$barcode]);
    $result = $stmt->fetch();

    header('Content-Disposition: attachment; filename="'.basename($barcode).'"');
    header('Content-Type: application/pdf');
    // header ('Content-Length:'.filesize($file));
    echo readfile($result['uploadFile']);

    $pdo->close();
    exit;

?>