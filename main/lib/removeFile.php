<?php

	include "functions.php";

	global $falsePath;
	
	$datas = json_decode($_POST["jsonParam"]);
	
	$fname = $datas->fname;
	$dir = $datas->dir;
	$type = $datas->type;

	$path = pathChecker($id, $dir, $fname);
	$path = str_replace("\ ", " ", $path);
	
	if($path == $falsePath){
		exit('{"result" : "삭제 실패"}');
	}

	if($type == "file")
		unlink($path);
	else
		if(!rmdir($path)){
			exit('{"result" : "폴더에 파일이 남아있습니다. 파일을 지우고 다시 진행해주세요."}');
		}

	echo '{"result" : "remove complete"}';


?>
