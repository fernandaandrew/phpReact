<?php
include 'koneksi.php';
header("Access-Control-Allow-Origin: *"); 

$obj = json_decode(file_get_contents('php://input'),TRUE);

if(!$obj){
    echo json_encode('input kosong');
    return;
}

if(!array_key_exists('username',$obj) && !array_key_exists('password',$obj)){
    echo json_encode('input tidak lengkap');
    return;
}

$username = $obj['username'];
$password = $obj['password'];

$sql = "SELECT * FROM users where username=? and password=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss",$username,$password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $r=mysqli_fetch_assoc($result);
    $arr=["status"=>"success","username"=>$r['username']];
} else {
    $arr= ["status"=>"error","message"=>"Login gagal"];
}

echo json_encode($arr);
?>