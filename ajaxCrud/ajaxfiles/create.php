<?php

require 'connection.php';

$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$query = "INSERT INTO tbl_user (name,age,gender,address) values ('{$name}','{$age}','{$gender}','{$address}')";

$insert = mysqli_query($connection, $query) or die(mysqli_error($connection));
if($insert)
{
    $message = "User Inserted Successfully";
    echo json_encode($message);
}  

?>