<?php
	include "./lib/functions.php";

	if(isset($_GET['dir']))
		$dir = $_GET['dir'];
	else
		$dir = null;
?>

<html>
<head>
	<title>web education</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="template/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">	
<link href="template/css/style.css" rel="stylesheet">
<link href="template/css/lib/toastr/toastr.min.css" rel="stylesheet">

<style>
	
	a {
		cursor : pointer;
	}
	td.clickable{
		cursor : pointer;
	}
	
	.menubox .table td{
		padding : 0rem;
	}
	.menubox .table{
		background-color:white;
		width: 170px;
		max-width: 170px;
	}
	#drop {
		padding : 20px 20px;
		border : 1px dashed #b1b8bb;
		text-align : center;
		margin : auto 0;
		height : 100px;
		cursor : pointer;
	}
	#uploadForm{
		display:none;
	}
	.dropdown {
		right:20px;
	}
	.dropdown.th{
		right:7px;
	}
	.wrap{
		overflow:hidden;
		height:auto;
	}
	
	.dwrap{
		position : absolute;
	}
	.main-footer{
		font-size: 1px;
		bottom:0px;
	}
</style>
</head>
<body class="align">
<div class="container">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-title">
				<h1 id="path"></h1>
			</div>
			<div>
			<?php
				$capacity = getCapacity();
				$percent = (getCapacity()/10240)*100;		
			?>
			<table class="table">
			<tr>
				<td style="width:50%">
				<div class="progress">
					<div class="progress-bar bg-primary" style="width: <?=$percent?>%; height:6px;" role="progressbar">
					</div>

				</div>
				<?=number_format((float)($capacity/1024), 2, '.', '')."Mb/10Mb"?>
				</td>
			
				<td style="text-align:right">
				<button type="button" onclick="mypage()">myPage</button>
				
				<?php
								if(pathChecker($id, $dir, null) == $falsePath) echo "";
								else {
									echo '<button type="button" onclick="upper()">upper</button>'; } 
				?>
				</td>
			</tr>
			</table>
				
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive wrap">
				<table class="table table-hover ">
				<thead>
				<tr>
					<th>
						Type
					</th>
					<th class="col-md-6">
						Name
					</th>
					<th>
						<div class="dropdown dwrap">
							<a class="dropdown th" id="menu1" data-toggle="dropdown">menu</a>
							<ul class="dropdown-menu dropmenu" role="menu" aria-labelledby="menu1">
								<li role="presentation"><a role="menuitem">new file</a></li>
								<li role="presentation"><a role="menuitem">new folder</a></li>
								<li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#myModal">file upload</a></li>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a role="menuitem">logout</a></li>
							</ul>
						</div>
						</th>
					</tr>
					</thead>
					<tbody>
					<?=getList($id, $dir)?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<footer class="main-footer">
		<div class="pull-right hidden-xs">
			made by Minsung Son
		</div>
		<a href="https://github.com/bperhaps">https://github.com/bperhaps</a>
		</footer>
  
	</div>
	<ul class="dropdown-menu show dropmenu menubox file" role="menu">
		<li role="presentation"><a role="menuitem">modify</a></li>
		<li role="presentation"><a role="menuitem">rename</a></li>
		<li role="presentation"><a role="menuitem">delete</a></li>
		<li role="presentation"><a role="menuitem">download</a><li>
		<li role="presentation" class="divider"></li>
		<li role="presentation"><a role="menuitem">new file</a></li>
		<li role="presentation"><a role="menuitem">new folder</a></li>
		<li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#myModal">file upload</a></li>
	</ul>
	<ul class="dropdown-menu show dropmenu menubox background" role="menu">
		<li role="presentation"><a role="menuitem">new file</a></li>
		<li role="presentation"><a role="menuitem">new folder</a></li>
		<li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#myModal">file upload</a></li>
		<li role="presentation" class="divider"></li>
		<li role="presentation"><a role="menuitem">logout</a></li>
	</ul>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<h4 class="modal-title" id="myModalLabel">Upload File</h4>
				</div>
				<div class="modal-body">
					<form action='#' id="uploadForm" enctype='multipart/form-data' method='post'/>
						<input type="file" id="upload" name="files[]" multiple/>
					</form>
					<div id="drop" onclick="getElementById('upload').click()">
						Drop here your files.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload()">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	

	
	
	</body>


	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="./lib/customjs.js"></script>
	<script src="template/js/lib/bootstrap/js/popper.min.js"></script>
	<script src="template/js/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="template/js/lib/toastr/toastr.min.js"></script>
    <script src="template/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

	<script src='//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js'></script>
        <script>
	var toastInfo = {
    "positionClass": "toast-bottom-right",
    timeOut: 5000,
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "tapToDismiss": false
}


$(function() {
    $("#popbutton").click(function() {
        $('div.modal').modal();
    })
})

$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) return "";
    else return results[1] || "";
}



$(".menubox").hide();

$(document).on('contextmenu', function() {
    return false;
});

var menuboxFlag = true;


function menuboxCheck() {
    if (menuboxFlag) {
        $(".menubox").hide();
        menuboxFlag = false;
    }
}

var fileName = "";
var fileType = "";


$(".dropdown.dwrap").click(function() {
    fileName = $(this).parent().parent().children(".clickable").text();

    fileType = $(this).parent().parent().children("th").children("span").text();
});

$(".dropmenu a").click(function() {
    var func = $(this).text().trim();

    //$(".test").parent().parent().parent().parent().parent().children(".clickable").text()

    if (func == "delete") {
        deleteObj(fileName, fileType);
    } else if (func == "rename") {
        rename(fileName);
    } else if (func == "new file") {
        createFile();
    } else if (func == "download") {
    	download(fileName, fileType);
    } else if (func == "new folder") {
        createFolder();
    } else if (func == "modify") {

        if (fileType == "directory")
            location.href = $(location).attr("pathname") + "?dir=" + $.urlParam("dir") + "/" + fileName;
        else
            modify(fileName);
    } else if (func == "logout")
        logout();
    else
        return;
});

$("body").click(function() {
    menuboxCheck()
});

$("thead").mousedown(function(e) {

    let RIGHT = 3;

    switch (e.which) {


        case RIGHT:
            if (menuboxFlag)
                menuboxCheck();

            var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $(".menubox.background").width();
            var oHeight = $(".menubox.background").height();

            var divLeft = e.pageX + 10;
            var divTop = e.pageY + 5;

            if (divLeft + oWidth > sWidth) divLeft -= oWidth;
            if (divTop + oHeight > sHeight) divTop -= oHeight;

            if (divLeft < 0) divLeft = 0;
            if (divTop < 0) divTop = 0;

            $(".menubox.background").css({
                "top": divTop,
                "left": divLeft,
                "position": "absolute"
            }).show();

            menuboxFlag = true;
            break;
    }



});


$("td.clickable").mousedown(function(e) {
    var idx = $("td.clickable").index(this);
    fileName = $("td.clickable:eq(" + idx + ")").text();
    fileType = $(".type:eq(" + idx + ")").text();


    let RIGHT = 3;
    let LEFT = 1;

    switch (e.which) {

        case LEFT:

            if (menuboxFlag) {
                menuboxCheck();
                break;
            }

            if (fileType == "directory")
                location.href = $(location).attr("pathname") + "?dir=" + $.urlParam("dir") + "/" + fileName;
            else
                location.href = "/users/<?=$id?>" + $.urlParam("dir") + "/" + fileName;


            break;
        case RIGHT:
            if (menuboxFlag)
                menuboxCheck();

            var sWidth = window.innerWidth;
            var sHeight = window.innerHeight;

            var oWidth = $(".menubox.file").width();
            var oHeight = $(".menubox.file").height();

            var divLeft = e.pageX + 10;
            var divTop = e.pageY + 5;

            if (divLeft + oWidth > sWidth) divLeft -= oWidth;
            if (divTop + oHeight > sHeight) divTop -= oHeight;

            if (divLeft < 0) divLeft = 0;
            if (divTop < 0) divTop = 0;

            $(".menubox.file").css({
                "top": divTop,
                "left": divLeft,
                "position": "absolute"
            }).show();

            menuboxFlag = true;
            console.log(divTop, divLeft);
            break;
    }



});

function logout() {
    location.href = "./lib/logout.php";
}

function upper() {
    var dir = $.urlParam("dir");
    var split_dir = dir.split("/");
    var upper_dir = "";

    for (var i = 1; i < split_dir.length - 1; i++)
        upper_dir += "/" + split_dir[i];

    location.href = $(location).attr("pathname") + "?dir=" + upper_dir;
}

function mypage() {
    window.open("/users/<?=$id?>");
}

function rename(fname) {
    var rename = prompt("Please enter a new name.", fname);
    if (rename == null)
        return;
    var url = "lib/rename.php";

    var params = new Object();

    params.name = fname;
    params.rename = rename;
    params.dir = $.urlParam("dir");

    var jsonData = JSON.stringify(params);

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
            jsonParam: jsonData
        },
        success: function(args) {
            if (args.result)
                alert(args.result);
            else
                location.reload();
        }
    });
}

function createFile() {
    var fname = prompt("Please enter a new file name", "ex) index.html");
    if (fname == null)
        return;
    var url = "lib/checkFileExist.php";

    var params = new Object();

    params.fname = fname;
    params.dir = $.urlParam("dir");

    var jsonData = JSON.stringify(params);

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
            jsonParam: jsonData
        },
        success: function(args) {
            if (args.result)
                alert(args.result);
            else
                location.href = "./createFile.php?dir=" + $.urlParam("dir") + "&file=" + fname;
        },
        error: function(e) {
            alert(e.responseText);
        }
    });
}

function createFolder() {
    var dname = prompt("please enter a new folder name", "ex) main");
    if (dname == null)
        return;
    var url = "lib/checkFolderExist.php";
    var params = new Object();

    params.dname = dname;
    params.dir = $.urlParam("dir");

    var jsonData = JSON.stringify(params);

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
            jsonParam: jsonData
        },
        success: function(args) {
            console.log(args);
            if (args.result)
                alert(args.result);
            else
                location.reload();
        },
        error: function(e) {
            alert(e.responseText);
        }
    });
}

function modify(fileName) {
    location.href = "./modifyCode.php?dir=" + $.urlParam("dir") + "&file=" + fileName;
}

function download(fileName, fileType){
	location.href = "./lib/download.php?dir=" + $.urlParam("dir") + "&file=" + fileName + "&type=" + fileType;
}

function deleteObj(fname, type) {
    var answer = confirm("Do you really want to delete " + type + " " + fname + " ?");

    if (!answer)
        return;

    var url = "./lib/removeFile.php";

    var params = new Object();

    params.fname = fname;
    params.dir = $.urlParam("dir");
    params.type = type;
    var jsonData = JSON.stringify(params);

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
            jsonParam: jsonData
        },
        success: function(args) {
            if (args.result) {
                location.reload();
            } else
                location.reload();
        },
        error: function(e) {
            alert(e.responseText);
        }
    });
}


if ($.urlParam("dir") == "")
    $("#path").text("<?=$id?>_HOME"+decodeURIComponent("/"));
else
    $("#path").text("<?=$id?>_HOME"+decodeURIComponent($.urlParam("dir")));


var drop = document.getElementById('drop');

drop.ondragover = function(e) {
    e.preventDefault();

};
drop.ondrop = function(e) {
    console.log(e);
    e.preventDefault();
    console.log(e.dataTransfer);
    var data = e.dataTransfer;
    var formData = new FormData();
    if (data.items) {
        for (var i = 0; i < data.items.length; i++) {
            if (data.items[i].kind == "file") {
                var file = data.items[i].getAsFile();

                if (file.size > 1048576) {
                    toastr.error('File is too large (Maximum 1MB)', file.name, toastInfo);
                    continue;
                }
				
				if((<?=(int)$capacity?> + file.size/1024) > 10240){
					toastr.error('Individual capacity exceeded. (Maxinum 10MB)', file.name, toastInfo);
                    continue;
				}
                formData.append('files[]', file);
            }
        }
        console.log(formData.values());
        $.ajax({
            url: 'lib/fileUpload.php?dir=' + $.urlParam("dir"),
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {

                    if (data[i].result == "success") {
                        console.log(data[i].msg, data[i].fname);
                        toastr.success(data[i].msg, data[i].fname, toastInfo);
                    } else
                        toastr.error(data[i].msg, data[i].fname, toastInfo);
                }
            }
        });
    } else { // File API 사용
        for (var i = 0; i < data.files.length; i++) {
            console.log(data.files[i]);
        }
    }
};

$(function() {
    $('#upload').bind('change', function() {
        $("#uploadForm")[0].action = 'lib/fileUpload.php?dir=' + $.urlParam("dir");
        $("#uploadForm").ajaxForm({
            dataType: 'json',

            success: function(data) {
                console.log(data);
                for (var i = 0; i < data.length; i++) {

                    if (data[i].result == "success") {
                        console.log(data[i].msg, data[i].fname);
                        toastr.success(data[i].msg, data[i].fname, toastInfo);
                    } else
                        toastr.error(data[i].msg, data[i].fname, toastInfo);
                }
            }
        }).submit();
    });
});
        </script>

</html>
