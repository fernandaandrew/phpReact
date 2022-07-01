<?php
include 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');
$obj = json_decode(file_get_contents('php://input'),TRUE);


$username = '';
$deskripsi = '';
$image = '';

if(!$obj){
    echo json_encode('input kosong');
    return;
}

if(!array_key_exists('deskripsi',$obj) && !array_key_exists('username',$obj)){
    echo json_encode('input tidak lengkap');
    return;
}

if(isset($obj['deskripsi'])){
    $deskripsi = $obj['deskripsi'];
}


if(isset($obj['username'])){
    $username = $obj['username'];
}


if(isset($obj['image'])){
    $image = $obj['image'];
}

$tanggal = date("Y-m-d H:i:s");

$sql = "SELECT * FROM users WHERE username='$username'";
$check = mysqli_fetch_array(mysqli_query($con,$sql));

try {

    $arr = [];

    $sql = "INSERT INTO laporan(username, deskripsi, image, tanggal) VALUES (?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $username, $deskripsi, $image, $tanggal);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $arr = ['result' => 'success', 'id' => $con->insert_id];
    } else {
        $arr = ['result' => 'failed', 'error' => $con->error];
    }
    echo json_encode($arr);
    
} catch (\Throwable $th) {
    echo json_encode($th);
}
mysqli_close($con);
?>