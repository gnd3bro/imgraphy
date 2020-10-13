<?php
    require 'api.php';

    $keypath = "../../key.json";
    $uuid = $_GET['uuid'];
    $column = $_GET['column'];
    $type = $_GET['type'];

    $db_handle = sql_connect($keypath);

    if(sql_query_img_crement($db_handle, $uuid, $column, $type)) {
        echo "{\"code\":\"success\",\"log\":\"vote\"}";
    } else {
        echo "{\"code\":\"error\",\"log\":\"failed\"}";
    }
?>