<?php
    require 'api.php';

    $keypath = "../../key.json";

    $db_handle = sql_connect($keypath);
    $list = sql_query_img_list($db_handle);

    echo json_encode($list);
?>