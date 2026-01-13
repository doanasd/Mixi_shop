<?php
    $servername = "localhost";
    $usname = "root";
    $pass = "";
    $database = "mixi_shop";

    $conn = new mysqli($servername, $usname, $pass, $database);
    if ($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    } 
?>