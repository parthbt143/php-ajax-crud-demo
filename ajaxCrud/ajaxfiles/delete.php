<?php


 require 'connection.php';


 $id  = $_POST["id"];


 $query = "update tbl_user set is_delete = 1 where id = '{$id}'";

$delete = mysqli_query($connection,$query);

 echo json_encode([$id]);


?>