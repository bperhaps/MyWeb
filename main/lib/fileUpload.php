<?php

include "functions.php";

global $falsePath;

$dir = urldecode($_GET["dir"]);

$uploads_dir = pathChecker($id, $dir, null);
$uploads_dir = str_replace("\ ", " ", $uploads_dir);

$dataArray = array();

if(!empty($_FILES)){
// 변수 정리

for($i=0; $i<count($_FILES['files']['name']); $i++){
	$error = $_FILES['files']['error'][$i];
	$name = $_FILES['files']['name'][$i];
	$size = $_FILES['files']['size'][$i];
	$tmppath = $_FILES['files']['tmp_name'][$i];
	$uploadPath = pathChecker($id, $dir, "\"$name\"");
	
	$ext = array_pop(explode('.', $name));

	
// 오류 확인
	if($uploadPath == $falsePath){
		array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일에 허용되지 않은 문자가 있거나 파일에 문제가 있습니다."));
		continue;
	}
	
	/*
	if(checkFileExist($id, $dir, $name)){
		array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "같은 이름의 파일이 존재합니다."));
		continue;
	}
	*/
	if( $error != UPLOAD_ERR_OK ) {
		switch( $error ) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일이 너무 큽니다. (최대 1MB))"));
				break;
			case UPLOAD_ERR_NO_FILE:
				array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일이 첨부되지 않았습니다."));
				break;
			default:
				array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일이 제대로 업로드되지 않았습니다."));	
		}
		continue;
	}
	
	if($size > 1048576){
		array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일이 너무 큽니다. (최대 1MB))"));
		continue;
	}
	
	if( (getCapacity() + $size/1024) > 10240 ){
		array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "개인 허용 용량을 초과했습니다. (최대 10MB)"));
		continue;
	}
	
	// 파일 이동
	move_uploaded_file($tmppath , "$uploads_dir/$name");
	//파일 형식 변경
	
	exec("file -bi $uploads_dir/$name", $test);
	
	if(preg_match("/text/", $test[0])){
		if(!preg_match("/utf-8/", $test[0])){
			exec("iconv -c -f euc-kr -t utf-8 $uploads_dir/$name > $uploads_dir/$name.msext.ExT");
			exec("mv \"$uploads_dir/$name.msext.ExT\" \"$uploads_dir/$name\"");
		}
	}
	
	array_push($dataArray, array("result" => "success" ,"fname" => "$name", "msg" => "파일 업로드 성공"));
	
}
} else {
	array_push($dataArray, array("result" => "error" ,"fname" => "$name", "msg" => "파일이 첨부되지 않았습니다."));
}
echo json_encode($dataArray, JSON_UNESCAPED_UNICODE);

?>
