
<?php
	session_start();
//        error_reporting(E_ALL);
//        ini_set("display_errors", 1);


	
	if(file_exists("../config.php")){
		include("../config.php");
	} else {
		include("../../config.php");
	}

	
	if(!$_SESSION["login"] && $_SERVER['REQUEST_URI'] != "/lib/loginAction.php")
		exit("<script>location.href('/')</script>");	
	$id = $_SESSION["id"];	
 
	$falsePath = "$apache_path/users/$id/";
	//$falsePath = "/home/$id/public_html";
	
    function checkUserDir($id) {
		//exec("ls /home", $list);
		$handle = opendir("../users");

		$files = array();
		
		while(false !== ($user = readdir($handle))) {
			if($user == $id){
				$flag = true;
			}
		}
/*

                $flag = false;

                foreach($list as $user){
                        if($user == $id){
                                $flag = true;
                                break; 
                        }
                }

                if(!$flag){
                        exec("./createUser ".$id, $test);
                }
*/
     }


	function checkFileExist($id, $dir, $fname){
		/*
		$sfname = split(".", $fname);
		if($sfname){
			$ext = $sfname[sizeof($sfname)-1];
			for($i=0; $i<sizeof($sfname)-1; $i++)
				$tmp = $sfname[$i].".";
			$tmp .= strtolower($ext);
			$fname = $tmp;
		}
		*/

		global $falsePath;

		$fpath = pathChecker($id, $dir, $fname);
		
		if($fpath == $falsePath)
			return true;

		$list = getLocalFiles($id, $dir);	
		
		
		
		foreach($list as $val){
//			$fileType = checkFileType($id, $dir, $val);
//			if($fileType == "f")
				if($val == $fname)
					return true;
		}
		
		return false;

	}
/*
	function checkFolderExist($id, $dir, $dname){
                $dpath =  pathChecker($id, $dir, $dname);

                if($dpath == $falsePath)
                        return true;
          
                $list = getLocalFiles($id, $dir);  
                
                foreach($list as $val){
                        $fileType = checkFileType($id, $dir, $val);
                        if($fileType == "d")
                                if($val == $dname)
                                        return true;
                }
                
                return false;
    
        }
*/


	function getList($id, $dir){	
	
		global $falsePath;
	
		$listTag="";

		$list = getLocalFiles($id, $dir);		


		foreach($list as $val){
			
			$fileType = checkFileType($id, $dir, $val);

			if($fileType == "d")
				$listTag .= "<tr><th scope=\"row\"><span class=\"type badge badge-success\">directory</span></th><td class=\"clickable\">".$val."</td><td>
			<div class=\"dropdown dwrap\">
                                    <a class=\"dropdown\" id=\"menu1\" data-toggle=\"dropdown\">▼</a>
                                    <ul class=\"dropdown-menu dropmenu\" role=\"menu\" aria-labelledby=\"menu1\">
										<li role=\"presentation\"><a role=\"menuitem\">rename</a></li>
										<li role=\"presentation\"><a role=\"menuitem\">download</a></li>
										<li role=\"presentation\"><a role=\"menuitem\">delete</a></li>
                                    </ul>
                                </div>
			</td></tr>";
			else
				$listTag .= "<tr><th scope=\"row\"><span class=\"type badge badge-success\">file</span></th><td class=\"clickable\">".$val."</td><td>
                                <div class=\"dropdown dwrap\">
                                    <a class=\"dropdown\" id=\"menu1\" data-toggle=\"dropdown\">▼</a>
                                    <ul class=\"dropdown-menu dropmenu\" role=\"menu\" aria-labelledby=\"menu1\">
                                        <li role=\"presentation\"><a role=\"menuitem\">modify</a></li>
										<li role=\"presentation\"><a role=\"menuitem\">rename</a></li>
										<li role=\"presentation\"><a role=\"menuitem\">download</a></li>
										<li role=\"presentation\"><a role=\"menuitem\">delete</a></li>
                                    </ul>
                                </div>
			<td></tr>";
		}


		return $listTag;
	}	

	function getLocalFiles($id, $dir){

		$src = pathChecker($id, $dir, null);
        
		$handle = opendir($src);
		
		$list = array();

		while(false !== ($fname = readdir($handle))){
			if($fname == "." || $fname == "..") continue;
			$list[] = $fname;
		}

		return $list;
	}
	
	function getFileValue($id, $dir, $fname){

		$src = pathChecker($id, $dir, $fname);

		global $falsePath;
		
		if($src == $falsePath)
			return "can not open this File";

		$file = fopen("$src", "r");
		
		$value = fread($file, filesize("$src"));
		
		return $value;
	}

	function pathChecker($id, $dir, $fname){

		global $falsePath;
		global $apache_path;	
		
	
		$rex = "/[!;|&`\\'\$,=\^%*]/";
	
		if($dir == null)
                        $dir = "";
		else{
			$dir = urldecode($dir);
			if(preg_match($rex, $dir))
                                return $falsePath;
            $dir .= "/";
			
		}
	
		if($fname == null)
			$fname = "";
		else{
			$fname = urldecode($fname);
			if(preg_match($rex, $fname))
				return $falsePath;
			else if(preg_match("/^\.(.*)/i", $fname) || preg_match("/htaccess/i", $fname))
				return $falsePath;
			else{
				$fname = "/$fname";

			}
	
		}

        $src = $falsePath.$dir.$fname;
		
		
		exec("readlink -f ".$src, $path);

		if(count($path))
			$path = $path[0];
		else
			return $falsePath;
		

		$reg_apache_path = str_replace("/", "\/", $apache_path);
		$regexp=$reg_apache_path."\/users\/".$id;

		if(!preg_match("/$regexp/", $path))
			return $falsePath;
		else{
			$src = trim($src);
			$src = str_replace(" ", "\\ ", $src);
			
			return $src;
		}
		
	}	
	
	function renamef($id, $dir, $name, $rename){
		
		global $falsePath;
		
		$nameSrc = pathChecker($id, $dir, $name);
		$renameSrc = pathChecker($id, $dir, $rename);
		
		if($nameSrc == $falsePath || $renameSrc == $falsePath)
			return true;
		
		$nameSrc = str_replace("\ ", " ", $nameSrc);
		$renameSrc = str_replace("\ ", " ", $renameSrc);
		
		if(checkFileExist($id, $dir, $rename))
			return true;
		else{
			rename($nameSrc, $renameSrc);
			return false;
		}
		
	}

	function checkFileType($id, $dir, $fname){


		$src = pathChecker($id, $dir, $fname);		

	
		$type = filetype($src);
		$regexp="/directory/";
	
		if($type == "dir")
			return "d";
		else
			return "f";
	}
	
	function getCapacity(){
		
		global $falsePath;
		
		$capacity = `du -s $falsePath	| awk '{print $1}'`;

		return $capacity;
	}

	
?>

