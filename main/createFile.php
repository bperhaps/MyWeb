<?php
include "lib/functions.php";

$dir = $_GET['dir'];
$fname = $_GET['file'];
if(checkFileExist($id, $dir, $fname))
        exit('{"result" : "The file already exists or there is an error creating the file."}');

if(file_exists("/tmp/".$id.$fname)){
	$fp = fopen("/tmp/".$id, "r");
	$data = fread($fp, filesize("/tmp/".$id));
	echo "<script>alert(\"recovered prev file\")</script>";
	fclose($fp);
} else {
	$data = "<!doctype html>
<html>
        <head>
                <title>page</title>
                <meta charset=\"UTF-8\">
        </head>
        <body>
                hello html world!
        </body>
</html>
";
}

?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link href="template/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">	
	<link href="template/css/lib/toastr/toastr.min.css" rel="stylesheet">
	<link href="template/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="lib/codemirror.css">
	
	<style>
		.CodeMirror {
			border: 1px solid #eee;
			height:90%;
		}
	</style>
</head>
<body>
	
	
	<body class="align">
	
	<div class="col-lg-12">
			<h1 id="path"></h1>
			<form name=form> 
				<div class="text-right">
		                        <button type="button" class="btn btn-default btn-rounded m-b-10 default">preview</button>
		                        <button type="button" class="btn btn-default btn-rounded m-b-10 default">save</button>
		                        <button type="button" class="btn btn-default btn-rounded m-b-10 default">back</button>
	                        </div>

				<textarea id="code"><?=$data?></textarea>
				<input type="hidden" name="precode">
			</form>
    </div>
	
	</body>
	<!--
	
	<div class="wrap">
	<textarea id="code"><?=getFileValue($id, $_GET['dir'], $_GET['file'])?></textarea>
	</div>
	-->
</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="lib/codemirror.js"></script>
<script src="lib/cm-javascript.js"></script>
<script src="lib/htmlmixed.js"></script>
<script src="lib/vbscript.js"></script> 
<script src="lib/xml.js"></script>
<script src="lib/customjs.js"></script>
<script src="template/js/lib/toastr/toastr.min.js"></script>
<script>
	var mixedMode = {
		name: "htmlmixed",
		scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
				mode: null},
				{matches: /(text|application)\/(x-)?vb(a|script)/i,
				mode: "vbscript"}]
	};
	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		mode: mixedMode,
		selectionPointer: true,
		lineNumbers:true,
		viewportMargin: Infinity
	});
	
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

	setInterval(function(){
		$.ajax({
                                type: "POST",
                                url: "./lib/backup.php",
                                data: {
                                        data: editor.getValue()
                                },
                                success: function (args) {
                                        console.log(args);
					toastr.success(new Date().toLocaleString() + " Autosave", "<?=$fname?>", toastInfo);
                                },
                                error: function (e) {
                                       	console.log(e);
                                }
                 });
	}, 60000)

	$(".default").click(function(){
		if($(this).text() == "save"){
			var url = "lib/fileSave.php";

	                var params = new Object();
                
        	        params.fname = $.urlParam("file");
	                params.dir = $.urlParam("dir");
			params.code = editor.getValue();
        
	                var jsonData = JSON.stringify(params);
	                
	                $.ajax({
	                        type: "POST",
	                        url: url,
	                        dataType: "json",
	                        data: {
	                                jsonParam: jsonData
	                        },
	                        success: function (args) {
					alert(args.result);
	                        },
	                        error: function (e) {
	                                alert(e.responseText);
	                        }
	                });
			
		}
		else if($(this).text() == "back"){
			$.ajax({
                                url: "./lib/del.php",
                                success: function (args) {
					location.href = "./list.php?dir=" + $.urlParam("dir");
                                },
                                error: function (e) {
                                        alert(e.responseText);
                                }
                        });

		}
		else {
			document.form.precode.value = editor.getValue();
	                window.open('pre_view.html'); 
		}
	});

	if($.urlParam("dir") == "")
                $("#path").text("<?=$id?>_HOME"+decodeURIComponent("/" + $.urlParam("file")));   
        else
                $("#path").text("<?=$id?>_HOME"+decodeURIComponent($.urlParam("dir") + "/" + $.urlParam("file")));

</script>

</head>
