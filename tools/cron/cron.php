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
if(function_exists("set_time_limit")) set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
include "autoban.php";
ob_flush();
flush();
include "deleteInvalidUsersAndSongs.php";
ob_flush();
flush();
include "songsCount.php";
ob_flush();
flush();
include "fixnames.php";
ob_flush();
flush();
echo "CRON done";
file_put_contents("../logs/cronlastrun.txt",time());
?>

		</div>
	</body>
</html>