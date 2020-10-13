<?php
    require 'api.php';

    $keypath = "../../key.json";
    $page = $_GET['page'];
    $max = $_GET['max'];
    $keyword = $_GET['keyword'];

    $db_handle = sql_connect($keypath);

    if(empty($keyword)) {
        $array_list = sql_query_img_list($db_handle, $max, $page);
    } else {
        $array_list = sql_query_img_lookup($db_handle, $keyword, $max, $page);
    }
    
    $array_count = count($array_list);
    $json_list = json_encode($array_list);

    echo "{\"count\":\"$array_count\",\"list\":$json_list}";
?>