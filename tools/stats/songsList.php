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

$page = empty($_GET['searchPage']) ? 0 : (int)$_GET['searchPage'];

if (!empty($_GET['searchName'])) {
	$searchName = $_GET['searchName'];
	$query = $db->prepare("SELECT ID,name,download FROM reuploadSongs WHERE name LIKE :query OR authorName LIKE :query OR ID=:base ORDER BY ID DESC LIMIT 500");
	$query->bindValue(':offs', $page * 500, PDO::PARAM_INT);
	$query->execute([':query' => "%$searchName%", ':base' => $searchName]);
} else {
	$query = $db->prepare("SELECT ID,name,download FROM reuploadSongs ORDER BY ID DESC LIMIT 500 OFFSET :offs");
	$query->bindValue(':offs', $page * 500, PDO::PARAM_INT);
	$query->execute();
}

$result = $query->fetchAll();

echo "<p>Count: ".count($result).", Page: ".($page+1)."</p>";

foreach($result as &$song)
{
	$songHostname = parse_url($song['download'], PHP_URL_HOST) ?? 'Unknown';

	echo "<tr><td>".$song["ID"]."</td><td>".htmlspecialchars($song["name"],ENT_QUOTES)."</td><td><a href='".htmlspecialchars($song['download'])."'>".htmlspecialchars($songHostname)."</a></td></tr>";
}//4115655
?>
			</table><p>
<?php
if ($page > 0) {
	echo "<a href='?searchPage=". $page-1 ."'>Prev Page</a> &bull; ";
}

echo "<a href='?searchPage=". $page+1 ."'>Next Page</a>";
?>
		</p></div>
	</body>
</html>