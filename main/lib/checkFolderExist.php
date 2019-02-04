<?php

include "functions.php";

$datas = json_decode($_POST["jsonParam"]);
$dir = $datas->dir;
$dname = $datas->dname;


if(checkFileExist($id, $dir, $dname))
	exit('{"result" : "폴더가 이미 존재하거나 폴더을 생성하는데 오류가 있습니다."}');
else{
	$path = str_replace("\ ", " ", pathChecker($id, $dir, $dname));
	mkdir($path);
	exit('{"result" : false}');
}
?>
