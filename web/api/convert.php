<?php

    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");


    $tmp_dir = "../../tmp/$uuid";
    $thumb_dir = "../files/thumb/$uuid";
    $img_dir = $argv[1];
    $uuid = $argv[2];
    $file_ext = $argv[3];


    exec("convert $img_dir/$uuid.$file_ext -coalesce -resize '30000@>' $tmp_dir.$file_ext");

    if(!rename("$tmp_dir.$file_ext", "$thumb_dir.$file_ext")) {
        echo "{\"code\":\"error\",\"log\":\"moving file failed\"}";
        exit;
    }



?>