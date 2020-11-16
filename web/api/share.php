<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $uuid = $_GET['uuid'];

    if(empty($uuid)) {
        echo "{\"code\":\"error\",\"log\":\"uuid\"}";
        exit;
    }

    $db_handle = sql_connect($keypath);

    if(!sql_query_shr_cnt($db_handle, $uuid)) {
        echo "{\"code\":\"error\",\"log\":\"failed to inc shrcnt\"}";
        exit;
    }
    
    echo "{\"code\":\"success\",\"log\":\"inc\"}";
?>