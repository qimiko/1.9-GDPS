<!DOCTYPE HTML>
<html>
	<head>
		<title>New Session</title>
		<?php include "../../../incl/_style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../incl/_nav.php"; ?>
		
		<div class="smain">
			<h1>Check Session</h1>
<?php
require_once "../incl/lib/GJPCheck.php";
include "../incl/lib/connection.php";		

if (!empty($_POST['accid'])) {
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	echo ($GJPCheck->check("", $_POST['accid']) == 1) ? "Session Exists" : "No Session Found";
} else {
	echo '<form action="" method="post">
			<input class="smain" type="text" placeholder="AccountID" name="accid"><br>
		<input class="smain" type="submit" value="Go"></form>';
}



?>
		</div>
	</body>
</html>