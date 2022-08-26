<?php
	
	// include 'includes/conn.php';
	include 'session.php';
	// session_start();
	$conn = $pdo->open();

	// try{
	// 	$stmt = $conn->prepare("CALL sp_aed_login (:in_username,:in_password, :in_status, :in_type, :in_userid)");
	// 	$stmt->execute(['in_username'=>'', 'in_password' =>'', 'in_status'=>4, 'in_type'=>2, 'in_userid' => $_SESSION['admin_5fe2562907c4eafe29b438c1c7ddb59c8']]);
	// }
	// catch(PDOException $e){
	// 	$output = "There is some problem in connection: " . $e->getMessage();
	// }

    unset($_SESSION['doc_5fe2562907c4eafe29b4384343298787676']);
	
	header("Location: ../index.php");
	unlink('cache');

    exit;
?> 