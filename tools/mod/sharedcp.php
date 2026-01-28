<!DOCTYPE HTML>
<html>
	<head>
		<title>Shared Creator Points</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Shared Creator Points</h1>

			<table><tr><th>Level ID</th><th>Shared Users</th></tr>
<?php

include "../../incl/lib/connection.php";

$query = $db->prepare("SELECT * FROM cpshares ORDER BY levelID DESC");
$query->execute();
$result = $query->fetchAll();

$users = array();
$levels = array();

$shares = array();

foreach ($result as $col)
{
	if (array_key_exists($col['levelID'], $levels) == false)
	{
		$queryLevel = $db->prepare("SELECT userName, userID FROM levels WHERE levelID = :id");
		$queryLevel->execute([':id' => $col['levelID']]);
		$levels[$col['levelID']] = $queryLevel->fetchAll()[0];
	}

	if (array_key_exists($col['userID'], $users) == false)
	{
		$queryName = $db->prepare("SELECT userName FROM users WHERE userID = :id");
		$queryName->execute([':id' => $col['userID']]);
		$users[$col['userID']] = $queryName->fetchAll()[0]['userName'];
	}

	if (array_key_exists($col['levelID'], $shares) == false)
		$shares[$col['levelID']] = array();
	array_push($shares[$col['levelID']], $col['userID']);
}

foreach ($shares as $id => $share)
{
	echo "<tr><td>".$id." (".$levels[$id]['userName']." - ".$levels[$id]['userID'].")</td><td>";

	//var_dump($share);

	foreach ($share as $user)
	{
		echo $user.' ('.$users[$user].'), ';
	}

	echo '</td></tr>';

	//echo "<tr><td>".$col['levelID']." (".$levels[$col['levelID']]['userName']." - ".$levels[$col['levelID']]['userID'].")</td><td>".$users[$col['userID']]." (".$col['userID'].")</td></tr>";
}

?>
			</table>
		</div>
	</body>
</html>