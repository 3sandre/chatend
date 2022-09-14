<?php 
    $conn = mysqli_connect("localhost", "root", "", "chat");
    if($conn){
        echo "Connected to db";
    }else{
        echo "Error";
    }
?>