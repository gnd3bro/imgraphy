<?php
    require 'api.php';
    
    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $confirm = $_GET['confirm'];
    $uuid = $_GET['uuid'];

    $handle = sql_connect($keypath);
    
    if($confirm != "true" || empty($uuid)) {
        echo "{\"code\":\"error\",\"log\":\"invalid confirm\"}";
        exit;
    }

    if(!sql_query_img_set($handle, $uuid, "deprec", true)) {
        echo "{\"code\":\"error\",\"log\":\"sql update failed\"}";
        exit;
    }

    echo "{\"code\":\"success\",\"log\":\"게시물을 삭제하였습니다.\"}";
?>