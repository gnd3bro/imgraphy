<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $from = $_GET['from'];
    $max = $_GET['max'];
    $userid = $_GET['userid'];

    $db_handle = sql_connect($keypath);

    if(empty($from)) {
        $from = "0";
    }

    if(empty($max)) {
        $max = "30";
    }

    if(empty($userid)) {
        echo "{\"code\":\"error\",\"log\":\"invaild userid\"}";
        exit;
    }

    $array_list = sql_query_img_liked($db_handle, $userid, $max, $from);
    
    $json_list = json_encode($array_list);

    echo $json_list;
?>