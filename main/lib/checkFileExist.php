<?php

include "functions.php";

$datas = json_decode($_POST["jsonParam"]);
$dir = $datas->dir;
$fname = $datas->fname;

if(checkFileExist($id, $dir, $fname))
	exit('{"result" : "파일이 이미 존재하거나 파일을 생성하는데 오류가 있습니다."}');
else
	exit('{"result" : false}');
?>
