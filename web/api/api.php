<?php
    function sql_connect($keypath) {
        $key_handle = fopen($keypath, "r");
        $key_json = fgets($key_handle);
        fclose($key_handle);

        $key = json_decode($key_json, true);

        return mysqli_connect($key["host"], $key["id"], $key["pw"], $key["db"]);
    }

    function sql_query_img_list($handle) {
        $query = "SELECT * FROM `img_list`";
        $result = mysqli_query($handle, $query);
        $result_array = array();

        while($row = mysqli_fetch_assoc($result)) {
            array_push($result_array, $row);
        }

        return $result_array;
    }

    function sql_query_img_lookup($handle, $keyword) {
        $query = "SELECT * FROM `img_list` WHERE `uploader` LIKE '%$keyword%' OR `tag` LIKE '%$keyword%'";
        $result = mysqli_query($handle, $query);
        $result_array = array();

        while($row = mysqli_fetch_assoc($result)) {
            array_push($result_array, $row);
        }

        return $result_array;
    }

    function sql_query_img_insert($handle, $uuid, $ext, $tag, $license, $uploader) {
        $query = "INSERT INTO `img_list` (`uuid`, `ext`, `tag`, `license`, `uploader`) VALUES ('$uuid', '$ext', '$tag', $license, '$uploader')";
        $result = mysqli_query($handle, $query);
        
        return $result;
    }

    function genuuid() {
        return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
           mt_rand(0, 0xffffffff),
           mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
           mt_rand(0, 0xffff), mt_rand(0, 0xffffffff)
         );
     }
?>