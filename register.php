<?php
include 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');
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

$sql = "SELECT * FROM users WHERE username='$username'";
$check = mysqli_fetch_array(mysqli_query($con,$sql));

try {
    if(isset($check)){
        $email_exists_message = 'Username sudah terdaftar!!!';
        $json = json_encode($email_exists_message);
        echo $json ;
    }else{
        $sql = "INSERT INTO users (username,password) VALUES ('$username','$password')";
        if(mysqli_query($con,$sql)){
            $message = 'User baru berhasil ditambah';
            $json = json_encode($message);
            echo $json ;
        }else {
            echo json_encode('Gagal menambah user baru');
        }
        return;
    }
} catch (\Throwable $th) {
    echo json_encode($th);
}
mysqli_close($con);
?>