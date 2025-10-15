<!DOCTYPE HTML>
<html>
	<head>
		<title>Epic Levels</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Epic Levels</h1>
			<table><tr><th>LevelID</th><th>Name</th><th>Author</th><th>Stars</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";

$query = $db->prepare("SELECT * FROM levels WHERE starEpic = 1 ORDER BY levelID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$level)
{
	echo "<tr><td>".htmlspecialchars($level["levelID"])."</td><td>".htmlspecialchars($level["levelName"])."</td><td>".htmlspecialchars($level["userName"])."</td><td>".htmlspecialchars($level["starStars"])."</td></tr>";
}
?>
			</table>
		</div>
	</body>