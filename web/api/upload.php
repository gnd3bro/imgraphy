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
    $valid_ext = array('jpg', 'jpeg', 'png', 'gif');

    $exception = $_FILES['uploadfile']['error'];
    $file_name = $_FILES['uploadfile']['name'];
    $file_ext = strtolower(array_pop(explode('.', $file_name)));

    if($error != UPLOAD_ERR_OK) {
        echo "{\"code\":\"error\",\"log\":\"$exception\"}";
        exit;
    }

    if(!in_array($file_ext, $valid_ext)) {
        echo "{\"code\":\"error\",\"log\":\"invalid file extension\"}";
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
    $tmp_img_info = getimagesize($tmp_img);
    $mime = $tmp_img_info['mime'];
    
    $tmp_img_width = (int)trim($tmp_img_info[0]);
    $tmp_img_height = (int)trim($tmp_img_info[1]);
    
    $thumb_name = "../files/thumb/$uuid.$file_ext";
    $thumb_width = $tmp_img_width;
    $thumb_height = $tmp_img_height;
    
    if($tmp_img_height > 256){
        $thumb_height = 256;
        $thumb_width = floor($tmp_img_width * $thumb_height / $tmp_img_height);
    }

    switch ($mime) {
        case 'imge/jpeg':
            $create_function = 'imagecreatefromjpeg';
            $save_function = 'imagejpg';
            break;
        case 'image/jpeg':
            $create_function = 'imagecreatefromjpeg';
            $save_function = 'imagejpeg';
            break;
        
        case 'image/png':
            $create_function = 'imagecreatefrompng';
            $save_function = 'imagepng';
            break;
        
        case 'image/gif':
            $create_function = 'imagecreatefromgif';
            $save_function = 'imagegif';
            break;
        
        default:
            throw new Exception('invalid image type');
            echo "{\"code\":\"error\",\"log\":\"failed to gen thumbnail\"}";
            exit;
    }
    
    $thumb_img_resource = imagecreatetruecolor($thumb_width, $thumb_height);
    $tmp_img_resource = $create_function($tmp_img);

    imagecopyresampled($thumb_img_resource, $tmp_img_resource, 0, 0, 0, 0, $thumb_width, $thumb_height, $tmp_img_width, $tmp_img_height);
    
    $save_function($thumb_img_resource, $thumb_name, 9);
   
    $db_handle = sql_connect($keypath);
    if(!sql_query_img_insert($db_handle, $uuid, $file_ext, $tag, $license, $uploader)) {
        echo "{\"code\":\"error\",\"log\":\"sql insertion failed\"}";
        exit;
    }

    if(!rename($tmp_dir, $img_dir)) {
        echo "{\"code\":\"error\",\"log\":\"moving file failed\"}";
        exit;
    }

    if(file_exists("$img_dir/$uuid.$file_ext") & file_exists("$img_dir/$uuid.$file_ext")) {
        echo "{\"code\":\"success\",\"log\":\"uploaded\"}";
    }
?>