<meta charset="utf-8">
<?php
	session_start();

	include "../../config.php";
	include "dbConnect.php";	

	if(isset($_POST["id"]) || isset($_POST["password"])){
            $id = mysqli_escape_string($conn, $_POST["id"]);
            $pw = mysqli_escape_string($conn, $_POST["password"]);
	
	    $pw = hash("sha256", $id.$pw);
		
            $q = "select * from users where id='$id' and pw='$pw'";
            $arr = sendQuery($q);

            if(mysqli_num_rows($arr)==1){
                $arr = $arr->fetch_assoc();
		
                $_SESSION["id"] = $arr["homeid"];
		$_SESSION["login"] = true;
                exit('<script>location.href="../list.php"</script>');
            } else {
		exit('<script>alert("check your id and password");location.href="/"</script>');
            }
        } else {
		exit('<script>alert("check your id and password");location.href="/"</script>');

        }
?>
