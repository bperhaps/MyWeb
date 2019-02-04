<?php
include "lib/functions.php";
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link href="template/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">	
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
			<div class="text-right">
			<button type="button" class="btn btn-default btn-rounded m-b-10 default">save</button>
            <button type="button" class="btn btn-default btn-rounded m-b-10 default">back</button>
			</div>
			<textarea id="code"><?=getFileValue($id, $_GET['dir'], $_GET['file'])?></textarea>
    </div>
	
	</body>

</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="lib/codemirror.js"></script>
<script src="lib/cm-javascript.js"></script>
<script src="lib/htmlmixed.js"></script>
<script src="lib/vbscript.js"></script> 
<script src="lib/xml.js"></script>
<script src="lib/customjs.js"></script>
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
		else{
			location.href = "./list.php?dir=" + $.urlParam("dir");
		}
	});

	if($.urlParam("dir") == "")
                $("#path").text("<?=$id?>_HOME"+decodeURIComponent("/" + $.urlParam("file")));   
        else
                $("#path").text("<?=$id?>_HOME"+decodeURIComponent($.urlParam("dir") + "/" + $.urlParam("file")));

</script>

</head>
