<?php
    require 'api.php';

    $keypath = "../../key.json";

    $uuid = genuuid();
    $tag = $_POST['tag'];
    $license = $_POST['license'];
    $uploader = $_POST['uploader'];

    $tmp_dir = "../../tmp/$uuid";
    $img_dir = "../files/img/$uuid";
    $valid_ext = array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');

    $exception = $_FILES['uploadfile']['error'];
    $file_name = $_FILES['uploadfile']['name'];
    $file_ext = array_pop(explode('.', $file_name));

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
    
    $img_name = "$tmp_dir/$uuid.$file_ext";
    $info = getimagesize($img_name);
    $mime = $info['mime'];
    
    $img_width = (int)trim($info[0]);
    $img_height = (int)trim($info[1]);
    
    $new_img_name = "../files/thumb/$uuid.$file_ext";
    $new_width = $img_width;
    $new_height = $img_height;
    
    if($img_height > 128){
        $new_height = 128;
        $new_width = floor($img_width * $new_height/$img_height);
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
            throw new Exception('이미지타입이 없습니다.');
    }
    
    $new_img_resource = imagecreatetruecolor($new_width, $new_height);
    $img_resource = $create_function($img_name);
    imagecopyresampled($new_img_resource,$img_resource, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);
    $save_function($new_img_resource, $new_img_name, 9);
   
    $db_handle = sql_connect($keypath);
    if(!sql_query_img_insert($db_handle, $uuid, $file_ext, $tag, $license, $uploader)) {
        echo "{\"code\":\"error\",\"log\":\"sql insertion failed\"}";
        exit;
    }

    if(!rename($tmp_dir, $img_dir)) {
        echo "{\"code\":\"error\",\"log\":\"moving file failed\"}";
        exit;
    }
?>