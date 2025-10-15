<!DOCTYPE HTML>
<html>
	<head>
		<title>Song List</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/_nav.php"; ?>
		
		<div class="smain">
			<h1>Song List</h1>
			<table><tr><th>ID</th><th>Name</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT ID,name FROM songsCombined WHERE ID BETWEEN 5000000 AND 10000000 ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();

echo "<p>Count: ".count($result)."</p>";

foreach($result as &$song)
{
	echo "<tr><td>".$song["ID"]."</td><td>".htmlspecialchars($song["name"],ENT_QUOTES)."</td></tr>";
}//4115655
?>
			</table>
		</div>
	</body>
</html>