<?php

header("Access-Control-Allow-Origin: *");
$arr = null;
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "coba";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
// Check connection
if ($conn->connect_error) {
  $arr= ["result"=>"error","message"=>"unable to connect"];
}

$json = file_get_contents('php://input');	
$obj = json_decode($json,true);

$username = $obj['username'];

$password = $obj['password'];


$sql = "SELECT * FROM users where username=? and password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",$username,$password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $r=mysqli_fetch_assoc($result);
    $arr=["result"=>"success","username"=>$r['username']];
} else {
    $arr= ["result"=>"error","message"=>"sql error: $sql",'REQUEST_METHOD'=>$_SERVER['REQUEST_METHOD'],$_POST];
}

echo json_encode($arr);
?>