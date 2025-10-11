<!DOCTYPE HTML>
<html>
	<head>
		<title>Cron Job</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/_nav.php"; ?>
		
		<div class="smain">
			<h1>Cron Job</h1>

<?php

chdir(dirname(__FILE__));
set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
include "autoban.php";
ob_flush();
flush();
include "deleteInvalidUsersAndSongs.php";
ob_flush();
flush();
file_put_contents("../logs/cronlastrun.txt",time());
?>

		</div>
	</body>
</html>