<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $page = $_GET['page'];
    $max = $_GET['max'];
    $keyword = $_GET['keyword'];

    $db_handle = sql_connect($keypath);

    if(empty($page)) {
        $page = "0";
    }

    if(empty($max)) {
        $max = "20";
    }

    if(empty($keyword)) {
        $array_list = sql_query_img_list($db_handle, $max, $page);
    } else {
        $array_list = sql_query_img_lookup($db_handle, $keyword, $max, $page);
    }
    
    $json_list = json_encode($array_list);

    echo "$json_list";
?>