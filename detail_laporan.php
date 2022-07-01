<?php
include 'koneksi.php';
    header("Access-Control-Allow-Origin: *");

    $obj = json_decode(file_get_contents('php://input'),TRUE);
    $id=null;
    
    if(!(isset($obj['id']) || isset($_GET['id']))){
        
        echo json_encode('input tidak lengkap');
        return;
    }else{
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        }
        
        if(isset($obj['id'])){
            $id=$obj['id'];
        }
    }

    $arr=null;
    $sql = "SELECT * FROM laporan WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();
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
    echo json_encode($arr);
    $stmt->close();
    $con->close();
?>

