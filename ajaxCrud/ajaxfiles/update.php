<?php


  require 'connection.php';
 
  $id = $_POST['id'];
  $name = $_POST['name'];
  $age = $_POST['age'];
  $address = $_POST['address'];
  $gender = $_POST['gender'];
  
  $query = "update tbl_user set name = '{$name}' , age = '{$age}' , address = '{$address}' , gender = '{$gender}' where id = '{$id}'";
  
  $update = mysqli_query($connection, $query);
  if($update)
  {
      $message = "User Updated Succesfully ";
      echo json_encode($message);
  }
?>