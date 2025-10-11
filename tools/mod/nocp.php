<?php
include "../../incl/lib/connection.php";

?>

<html>

<body>
<table>
<tr>
<th>Level</th>
<th>Author</th>
<th>Points</th>
</tr>
<?php
$query = $db->prepare("SELECT levelID, userID, starStars, starFeatured, starEpic FROM levels WHERE giveNoCP = 1");
$query->execute();
$result = $query->fetchAll();

foreach ($result as $level) {
    $points = ($level["starStars"] != 0) + ($level["starFeatured"] != 0) + ($level["starEpic"] != 0) * 2;
    echo "<tr><td>{$level['levelID']}</td><td>{$level['userID']}</td><td>$points</td></tr>";
}

?>
</body>
</html>
