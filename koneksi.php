<?php 
	$base_url='localhost/fer_uas';
	function connect(){
		$host = "localhost";
		$user = "root";
		$pass = "";
		$db = "fer_uas";
		return mysqli_connect($host, $user, $pass, $db);
	}

	$con = connect();

	if(!$con) {
		die("Koneksi gagal : ".mysql_connect_error());
	}
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
?>