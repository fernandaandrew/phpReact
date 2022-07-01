<?php
include 'koneksi.php';
header("Access-Control-Allow-Origin: *");
    $arr=null;

    $sql = "SELECT * FROM laporan";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data=[];
    if ($result->num_rows > 0) {
        while($r=mysqli_fetch_assoc($result))
        {
            $r['urls'] = $base_url ."/" .$r['image'] .'.jpg';
            array_push($data,$r);
        }
        $arr=["result"=>"success","data"=>$data];
    } else {
        $arr= ["result"=>"error","message"=>"sql error: $sql"];
    }
    echo json_encode($arr);
    $stmt->close();
    $con->close();
?>

