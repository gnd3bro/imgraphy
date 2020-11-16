<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $uuid = $_GET['uuid'];
    $userid = $_GET['userid'];
    $type = $_GET['type'];

    if(empty($uuid) || empty($userid) || empty($type)) {
        echo "{\"code\":\"error\",\"log\":\"uuid, userid, type[inc, dec]\"}";
        exit;
    }

    $db_handle = sql_connect($keypath);

    if(!sql_query_vote($db_handle, $uuid, $userid, $type)) {
        echo "{\"code\":\"error\",\"log\":\"좋아요 등록에 실패했습니다.\"}";
        exit;
    }

    if(!sql_query_fav_cnt($db_handle, $uuid)) {
        echo "{\"code\":\"error\",\"log\":\"DB에 좋아요 반영을 실패했습니다.\"}";
        exit;
    }
    
    echo "{\"code\":\"success\",\"log\":\"좋아요 버튼을 누르셨습니다.\"}";
?>