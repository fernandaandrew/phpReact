<?php
header("Access-Control-Allow-Origin: *");
include 'koneksi.php';

$obj = json_decode(file_get_contents('php://input'),TRUE);
$id=null;

if(!(array_key_exists('id',$obj) || isset($_POST['id']))){
    
    echo json_encode('input tidak lengkap');
    return;
}else{
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }
    
    if(isset($obj['id'])){
        $id=$obj['id'];
    }
}


$sql = "DELETE FROM laporan WHERE id=?";
$stmt=$con->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

if($stmt->affected_rows>0)
{
  $arr=["result"=>"success"];
} else {
   $arr= ["result"=>"error","message"=>"sql error: $sql".$stmt->affected_rows];
}



echo json_encode($arr);
$stmt->close();
$con->close();
?>