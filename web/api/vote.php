<?php
    require 'api.php';

    $keypath = "../../key.json";
    $uuid = $_GET['uuid'];
    $column = $_GET['column'];
    $type = $_GET['type'];

    if(empty($uuid) || empty($column) || empty($type)) {
        echo "{\"code\":\"error\",\"log\":\"uuid, column[favcnt, shrcnt], type[inc, dec]\"}";
        exit;
    }

    $db_handle = sql_connect($keypath);

    if(sql_query_img_crement($db_handle, $uuid, $column, $type)) {
        echo "{\"code\":\"success\",\"log\":\"vote\"}";
    } else {
        echo "{\"code\":\"error\",\"log\":\"failed\"}";
    }
?>