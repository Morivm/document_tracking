<?php
    include "../modules/session.php";

    $conn = $pdo->open();


    $barcode  = $_GET['barcode'];
    $stmt = $conn ->prepare("SELECT uploadId, uploadFile FROM `tblupload` WHERE uploadFileName = :uploadFileName");
    $stmt->execute(['uploadFileName'=>$barcode.".pdf"]);
    $result = $stmt->fetch();

    $fil = $result['uploadFile'];

    header('Content-Type: application/pdf');
    header("Content-Disposition: inline; filename=$barcode.pdf");
    echo $fil;

    $pdo->close();
    exit;

?>