<?php
include "lib/functions.php";
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="template/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">	
	<link href="template/css/lib/dropzone/dropzone.css" rel="stylesheet">
	<link href="template/css/style.css" rel="stylesheet">
</head>
<body>
	
	
	<body class="align">
	
	<div class="col-lg-12">
			 <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Dropzone</h4>
                                <h6 class="card-subtitle">For multiple file upload put class <code>.dropzone</code> to form.</h6>
                                <form id="upload" action="#" class="dropzone">
                                    <div class="fallback">
                                        <input name="myfile" type="file" multiple />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>

    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="lib/customjs.js"></script>
<script src="template/js/lib/dropzone/dropzone.js"></script>
<script>
$.urlParam = function(name){
                                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                                if (results==null) return "";
                                else return results[1] || "";
                        }
document.getElementById("upload").action = "./lib/fileUpload.php?dir=" + $.urlParam("dir");

$(function() {
    var mockFile = { name: "banner2.jpg", size: 12345 };
    var myDropzone = Dropzone
    myDropzone.options.addedfile.call(myDropzone, mockFile);
})

</script>

</head>
