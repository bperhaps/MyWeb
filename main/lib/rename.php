<?php

include "functions.php";

$datas = json_decode($_POST["jsonParam"]);
$dir = $datas->dir;
$name = $datas->name;
$rename = $datas->rename;

if(renamef($id, $dir, $name, $rename))
        exit('{"result" : "같은 이름의 파일이 이미 존재하거나 이름을 변경하는데 오류가 있습니다."}');
else
        exit('{"result" : false}');
?>

 