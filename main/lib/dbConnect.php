<?php
//include_once("../../config.php");

error_reporting(E_ALL);
        ini_set("display_errors", 1);


$conn = mysqli_connect($host, $db_id, $db_pw, $db_name);

function sendQuery($q){
    global $conn;
    $result = mysqli_query($conn, $q);
    return $result;
}

function getQueryData($q){
    global $conn;
    $result = mysqli_query($conn, $q);
    $arr = $result->fetch_assoc();
    return $arr;
}
?>

