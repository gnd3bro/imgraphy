<?php
    require 'api.php';

    header("Content-Type: application/json; charset=UTF-8");

    $confirm = $_GET['confirm'];
    
    if(!strcmp($confirm, "true")) {
        echo "{\"code\":\"error\",\"log\":\"user id genenration failed\"}";
        exit;
    }

    $idgen = "user-" . genuuid();

    echo "{\"code\":\"success\",\"id\":\"$idgen\"}";
?>