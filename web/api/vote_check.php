<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $keypath = "../../key.json";
    $uuid = $_GET['uuid'];
    $userid = $_GET['userid'];

    if(empty($uuid) || empty($userid)) {
        echo "{\"code\":\"error\",\"log\":\"uuid, userid\"}";
        exit;
    }

    $db_handle = sql_connect($keypath);

    $result = sql_query_vote_check($db_handle, $uuid, $userid);
    
    if(!$result) {
        echo "{\"code\":\"error\",\"log\":\"failed\"}";
        exit;
    }

    $data = $result["COUNT(*)"];

    echo "{\"code\":\"success\",\"log\":\"$data\"}";
?>