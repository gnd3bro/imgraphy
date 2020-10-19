<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");


    $confirm = $_GET['confirm'];
    



    if($confirm == "true") {
        $uuid = genuuid();
        $idgen = "user-$uuid";
        echo "{\"code\":\"success\",\"id\":\"user-$uuid\"}";
        
    }
    else{
        echo "{\"code\":\"error\",\"log\":\"idgenfailed\"}";

    }



?>