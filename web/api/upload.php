<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");
    
    $keypath = "../../key.json";
    $uuid = genuuid();
    $tag = $_POST['tag'];
    $license = $_POST['license'];
    $uploader = $_POST['uploader'];

    $tmp_dir = "../../tmp/$uuid";
    $img_dir = "../files/img/$uuid";
    $valid_ext = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    $exception = $_FILES['uploadfile']['error'];
    $file_name = $_FILES['uploadfile']['name'];
    $file_ext = strtolower(array_pop(explode('.', $file_name)));

    if($error != UPLOAD_ERR_OK) {
        echo "{\"code\":\"error\",\"log\":\"$exception\"}";
        exit;
    }

    if(!in_array($file_ext, $valid_ext)) {
        echo "{\"code\":\"error\",\"log\":\"올바르지 않은 파일($file_name.$file_ext) 입니다.\"}";
        exit;
    }

    if(!mkdir($tmp_dir)) {
        echo "{\"code\":\"error\",\"log\":\"mkdir failed\"}";
        exit;
    }

    if(!move_uploaded_file( $_FILES['uploadfile']['tmp_name'], "$tmp_dir/$uuid.$file_ext")) {
        echo "{\"code\":\"error\",\"log\":\"tmp file not found\"}";
        exit;
    }
    
    $tmp_img = "$tmp_dir/$uuid.$file_ext";
    $thumb_name = "../files/thumb/$uuid.$file_ext";
    
    $tmp_img_info = getimagesize($tmp_img);
    $mime = $tmp_img_info['mime'];
       
    $db_handle = sql_connect($keypath);
    if(!sql_query_img_insert($db_handle, $uuid, $file_ext, $tag, $license, $uploader)) {
        echo "{\"code\":\"error\",\"log\":\"sql insertion failed\"}";
        exit;
    }

    if(!rename($tmp_dir, $img_dir)) {
        echo "{\"code\":\"error\",\"log\":\"moving file failed\"}";
        exit;
    }

    if(!(file_exists("$img_dir/$uuid.$file_ext") && file_exists("$img_dir/$uuid.$file_ext"))) {
        echo "{\"code\":\"error\",\"log\":\"게시물 업로드를 실패하였습니다.\"}";
        exit;
    }

    convert($img_dir, $uuid, $file_ext, $thumb_name);
    echo "{\"code\":\"success\",\"log\":\"게시물이 업로드 되었습니다.\"}";
?>