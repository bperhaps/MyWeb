<?php

	include "functions.php";

	global $falsePath;
	
	$datas = json_decode($_POST["jsonParam"]);
	
	$fname = $datas->fname;
	$dir = $datas->dir;
	$code = $datas->code;
		
	$path = pathChecker($id, $dir, $fname);

	$path = str_replace("\ ", " ", $path);
	
	if($path == $falsePath){
		exit('{"result" : "홈페이지를 공격하실 경우 불이익이 있습니다."}');
	}

	
	$file = fopen("$path", "w");

	if(!$file) die ('{"result" : "홈페이지를 공격하실 경우 불이익이 있습니다."}');
	
	fwrite($file, $code);
	if(file_exists("/tmp/$id"))
		unlink("/tmp/$id");

	echo '{"result" : "save complete"}';

	fclose($file);

?>
