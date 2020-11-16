<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $from = $_GET['from'];
    $max = $_GET['max'];

    $db_handle = sql_connect($keypath);

    if(empty($from)) {
        $from = "0";
    }

    if(empty($max)) {
        $max = "30";
    }

    $array_list = sql_query_img_recom($db_handle, $max, $from);
    
    $json_list = json_encode($array_list);

    echo $json_list;
?>