<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $from = $_GET['from'];
    $max = $_GET['max'];
    $keyword = $_GET['keyword'];

    $db_handle = sql_connect($keypath);

    if(empty($from)) {
        $from = "0";
    }

    if(empty($max)) {
        $max = "30";
    }

    if(empty($keyword)) {
        $array_list = sql_query_img_list($db_handle, $max, $from);
    } else {
        $array_list = sql_query_img_lookup($db_handle, $keyword, $max, $from);
    }
    
    $json_list = json_encode($array_list);

    echo $json_list;
?>