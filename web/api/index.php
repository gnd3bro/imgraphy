<?php
    require 'api.php';

    $keypath = "../../key.json";

    $db_handle = sql_connect($keypath);
    sql_query_img_insert($db_handle, "test", "testtag", 0, "testuser");
?>