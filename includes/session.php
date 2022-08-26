<?php
	include 'conn.php';
	session_start();

	if(isset($_SESSION['doc_5fe2562907c4eafe29b4384343298787676'])){
		$web_conn_url       = "../img/resources/setup/new.txt";
		header('location: modules/dashboard');
	}
?>