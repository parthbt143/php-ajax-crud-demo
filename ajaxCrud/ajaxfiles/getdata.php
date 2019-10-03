<?php

require 'connection.php';


$num_rec_per_page = 5;


if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};


$start_from = ($page - 1) * $num_rec_per_page;


$total = "SELECT * FROM tbl_user where is_delete = 0";
$query = "SELECT * FROM tbl_user where is_delete = 0 Order By id desc LIMIT $start_from, $num_rec_per_page";

 
$select = mysqli_query($connection, $query);

while ($row = mysqli_fetch_array($select)) {

    $data[] = $row;
}


$respose['data'] = $data;


$result = mysqli_query($connection, $total);


$respose['total'] = mysqli_num_rows($result);


echo json_encode($respose);
?>