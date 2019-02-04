
document.querySelector('.sweet-ajax').onclick = function(){
    swal({
			html:true,
            title: "File Upload",
            text: "<div id=\"drop\">여기에 파일을 드랍하세요</div><script>document.write(\'test'\)</script>",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function(){
            setTimeout(function(){
                swal("Hey, your ajax request finished !!");
            }, 2000);
        });
};
 