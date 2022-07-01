<?php

header("Access-Control-Allow-Origin: *");
include 'koneksi.php';

$obj = json_decode(file_get_contents('php://input'),TRUE);

$deskripsi = $obj['deskripsi'];
$id=null;

if(isset($_POST['id'])){
    $id=$_POST['id'];
}

if(isset($obj['id'])){
    $id=$obj['id'];
};

if(isset($obj['deskripsi'])){
    $deskripsi=$obj['deskripsi'];
};

$sql="UPDATE laporan set deskripsi=? where id=?";
$stmt=$con->prepare($sql);
$stmt->bind_param("si",$deskripsi,$id);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    $con_2=connect();
    $sql = "SELECT * FROM laporan WHERE id=?";
    $stmt_2 = $con_2->prepare($sql);
    $stmt_2->bind_param('i',$id);
    $stmt_2->execute();
    $result = $stmt_2->get_result();
    $data=[];
    if ($result->num_rows > 0) {
        while($r=mysqli_fetch_assoc($result))
        {
            $r['urls'] = $base_url."/". $r['image'] .'.jpg';
            array_push($data,$r);
        }
        $arr=["result"=>"success","data"=>$data[0]];
    } else {
        $arr= ["result"=>"error","message"=>"sql error: $sql"];
    }   
} else {
    $arr=["result"=>"fail","Error"=>$con->error];
}       
echo json_encode($arr); 