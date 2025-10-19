<!DOCTYPE HTML>
<html>
	<head>
		<title>Song List</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain nobox">
			<h1>Song List</h1>

			<p>
				<form action="" method="GET">
					<input type="text" name="searchName" placeholder="Song Name" />
					<input type="submit" value="Search" />
				</form>
			</p>

			<table><tr><th>ID</th><th>Name</th><th>Download</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";

if (!empty($_GET['searchName'])) {
	$searchName = $_GET['searchName'];
	$query = $db->prepare("SELECT ID,name,download FROM reuploadSongs WHERE name LIKE :query ORDER BY ID DESC");
	$query->execute([':query' => "%$searchName%"]);
} else {
	$query = $db->prepare("SELECT ID,name,download FROM reuploadSongs ORDER BY ID DESC");
	$query->execute();
}

$result = $query->fetchAll();

echo "<p>Count: ".count($result)."</p>";

foreach($result as &$song)
{
	$songHostname = parse_url($song['download'], PHP_URL_HOST) ?? 'Unknown';

	echo "<tr><td>".$song["ID"]."</td><td>".htmlspecialchars($song["name"],ENT_QUOTES)."</td><td><a href='".htmlspecialchars($song['download'])."'>".htmlspecialchars($songHostname)."</a></td></tr>";
}//4115655
?>
			</table>
		</div>
	</body>
</html>