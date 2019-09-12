<?php
    $host = DTB_HOST;
    $dtbuser = DTB_USER;
    $password = DTB_PASS;
    $database = DTB_NAME;

    $mysqli = new mysqli($host, $dtbuser, $password, $database) or die($mysqli->error);
?>