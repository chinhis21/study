<?php
//check auth key for users between dates -output id which need flush
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/func.php';
$linkMySql=mysqlConnectNEW();

$check=mysqli_query($linkMySql, "SELECT * FROM `users2`");
while ($row=mysqli_fetch_assoc($check)){
    $b=mysqli_query($linkMySql, "SELECT * FROM `users` where `id`=".$row['id']." and `device_id`='".$row['device_id']."'");
    if($b && mysqli_num_rows($b)==0){
        echo $row['id'].',';
    }
}
