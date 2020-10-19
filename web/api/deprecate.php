<?php
    require 'api.php';
    header("Content-Type: application/json; charset=UTF-8");


    $keypath = "../../key.json";
    $confirm = $_GET['confirm'];
    $uuid = $_GET['uuid'];

    $handle = sql_connect($keypath);
    

    if($confirm =="true" && $uuid == $uuid) {

        $query = "UPDATE `img_list` SET `deprec`= 1 WHERE `uuid` = '$uuid'";
        $result = mysqli_query($handle, $query);
        
        echo "{\"code\":\"success\",\"log\":\"increase update success\"}";
        exit;

    }
    else if($confirm == "false" && $uuid == $uuid){
        $query = "UPDATE `img_list` SET `deprec`= 0 WHERE `uuid` = '$uuid'";
        $result = mysqli_query($handle, $query);
        echo "{\"code\":\"success\",\"log\":\"decrease update success\"}";
        exit;


 

    }
    else{
        echo "{\"code\":\"error\",\"log\":\"confirm empty\"}";
        exit;
        
    }





?>