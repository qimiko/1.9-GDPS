<!DOCTYPE HTML>
<html>
	<head>
		<title>Suggest List - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Suggest List</h1>

<?php
include "../../incl/lib/connection.php";
include "../../incl/lib/mainLib.php";
$gs = new mainLib();

$query = $db->prepare("SELECT suggestBy,suggestLevelId,suggestDifficulty,suggestStars,suggestFeatured,suggestAuto,suggestDemon,timestamp FROM suggest ORDER BY timestamp DESC");
$query->execute();
$result = $query->fetchAll();
echo '<table><tr><th>Time</th><th>Suggested by</th><th>Level ID</th><th>Difficulty</th><th>Stars</th><th>Featured</th></tr>';
foreach($result as &$sugg){
echo "<tr><td>".date("d/m/Y G:i", $sugg["timestamp"])."</td><td>".$gs->getAccountName($sugg["suggestBy"])."(".$sugg["suggestBy"].")</td><td>".htmlspecialchars($sugg["suggestLevelId"],ENT_QUOTES)."</td><td>".htmlspecialchars($gs->getDifficulty($sugg["suggestDifficulty"],$sugg["suggestAuto"],$sugg["suggestDemon"]), ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestStars"],ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestFeatured"],ENT_QUOTES)."</td></tr>";
}
echo "</table>";
?>
		</div>
	</body>
</html>