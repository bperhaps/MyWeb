<?php
	include "functions.php";
	
	global $falsePath;
	
	$fname = $_GET['file'];
	$dir = $_GET['dir'];
	$type = $_GET['type'];
	
	
	$path = pathChecker($id, $dir, $fname);
	$path = str_replace("\ ", " ", $path);
	
	if($path == $falsePath){
		exit('{"result" : "다운로드 실패"}');
	}

	if(!checkFileExist($id, $dir, $fname))
		exit('헛짓 ㄴ');
	
	if($type == "directory") {
		exec("cp -r ".$path." /tmp/".$fname.$id);
		exec("cd /tmp && zip ".$fname.$id.".zip ./".$fname.$id);
		$path = "/tmp/".$fname.$id.".zip";
		$downfname = $fname.".zip";
	} else {
		$downfname = $fname;
	}
	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $downfname . '"');
	header('Content-Transfer-Encoding: binary');
	header('Content-length: ' . filesize($path));
	header('Expires: 0');
	header("Pragma: public");
	
	$fp = fopen($path, 'rb');
	fpassthru($fp);
	fclose($fp);
	
	if($type == "directory"){
                exec("rm -r /tmp/".$fname.$id." ".$path);
        }
	
?>
