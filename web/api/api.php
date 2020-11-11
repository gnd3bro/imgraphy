<?php
    function sql_connect($keypath) {
        $key_handle = fopen($keypath, "r");
        $key_json = fgets($key_handle);
        fclose($key_handle);

        $key = json_decode($key_json, true);

        return mysqli_connect($key["host"], $key["id"], $key["pw"], $key["db"]);
    }

    function sql_query_img($handle, $query) {
        $result = mysqli_query($handle, $query);
        $result_array = array();

        while($row = mysqli_fetch_assoc($result)) {
            array_push($result_array, $row);
        }

        return $result_array;
    }

    function sql_query_img_list($handle, $max, $from) {
        $query = "SELECT * FROM `img_list` WHERE `deprec` = 0 ORDER BY `date` DESC LIMIT $from, $max";

        return sql_query_img($handle, $query);
    }

    function sql_query_img_lookup($handle, $keyword, $max, $from) {
        $query = "SELECT * FROM `img_list` WHERE (`uploader` LIKE '%$keyword%' OR `tag` LIKE '%$keyword%') AND `deprec` = 0 ORDER BY `date` DESC LIMIT $from, $max";
        
        return sql_query_img($handle, $query);
    }

    function sql_query_img_insert($handle, $uuid, $ext, $tag, $license, $uploader) {
        $query = "INSERT INTO `img_list` (`uuid`, `ext`, `tag`, `license`, `uploader`) VALUES ('$uuid', '$ext', '$tag', $license, '$uploader')";
        $result = mysqli_query($handle, $query);
        
        return $result;
    }

    function sql_query_img_crement($handle, $uuid, $column, $type) {
        $op = "+";
        if($type == "dec") {
            $op = "-";
        }

        $query = "UPDATE `img_list` SET `$column` = `$column` $op 1 WHERE `uuid` = '$uuid'";
        $result = mysqli_query($handle, $query);
        
        return $result;
    }

    function sql_query_img_set($handle, $uuid, $column, $set) {
        $op = "1";
        if($set == false) {
            $op = "0";
        }

        $query = "UPDATE `img_list` SET `$column`= $op WHERE `uuid` = '$uuid'";
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
    
    function convert($img_dir, $uuid, $file_ext, $thumb_name) {
        try {
            exec("convert $img_dir/$uuid.$file_ext -coalesce -resize '30000@>' $thumb_name > /dev/null &");
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
?>