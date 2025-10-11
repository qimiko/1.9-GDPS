<?php

chdir(dirname(__FILE__));

include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
$ep = new exploitPatch();
$stars = 0;
$count = 0;
$xi = 0;
$lbstring = "";
if(empty($_POST["gameVersion"])){
	$sign = "<> 'ffff'";
}else{
	$sign = "<> 'ffff'";
}
if(!empty($_POST["accountID"])){
	$accountID = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	$GJPCheck = new GJPCheck(); //gjp check
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult != 1){
		// exit("-1");
	}
}else{
	$accountID = $ep->remove($_POST["udid"]);
	if(is_numeric($accountID)){
		exit("-1");
	}
}

$type = $ep->remove($_POST["type"]);
if($type == "top" OR $type == "creators" OR $type == "relative")
{
	if($type == "top")
	{
		$query = "SELECT * FROM users WHERE isBanned = '0' AND stars > 0 AND isRegistered = '1' ORDER BY stars DESC LIMIT 100";
	}
	if($type == "creators")
	{
		$query = "SELECT * FROM users WHERE isCreatorBanned = '0' AND creatorPoints > 0 ORDER BY creatorPoints DESC LIMIT 100";
	}
	if($type == "relative")
	{
		$query = "SELECT * FROM users WHERE extID = :accountID";
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();
		$user = $result[0];
		$stars = (int)$user["stars"];
		if($_POST["count"]){
			$count = $ep->remove($_POST["count"]);
		}else{
			$count = 50;
		}
		$count = floor($count / 2);
		$query = "SELECT	A.* FROM	(
			(
				SELECT	*	FROM users
				WHERE stars <= $stars
				AND isBanned = 0
				AND isRegistered = 1
				ORDER BY stars DESC
				LIMIT $count
			)
			UNION
			(
				SELECT * FROM users
				WHERE stars >= $stars
				AND isBanned = 0
				AND isRegistered = 1
				ORDER BY stars ASC
				LIMIT $count
			)
		) as A
		ORDER BY A.stars DESC";
	}
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	if($type == "relative"){
		$user = $result[0];
		$extid = $user["extID"];
		$e = "SET @rownum := 0;";
		$query = $db->prepare($e);
		$query->execute();
		$f = "SELECT rank, stars FROM (
							SELECT @rownum := @rownum + 1 AS rank, stars, extID, isBanned
							FROM users WHERE isBanned = '0' AND isRegistered = '1' ORDER BY stars DESC
							) as result WHERE extID=:extid";
		$query = $db->prepare($f);
		$query->execute([':extid' => $extid]);
		$leaderboard = $query->fetchAll();
		//var_dump($leaderboard);
		$leaderboard = $leaderboard[0];
		$xi = $leaderboard["rank"] - 1;
	}
	foreach($result as &$user) {
		$extid = 0;
		if(is_numeric($user["extID"])){
			$extid = $user["extID"];
		}
		$xi++;
		
		$lbstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"].":52:0|";
		
	}
}

if($type == "week")
{
	$starsgain = array();
	$time = time() - 604800;
	$xi = 0;
	$query = $db->prepare("SELECT * FROM actions WHERE type = '9' AND timestamp > :time");
	$query->execute([':time' => $time]);
	$result = $query->fetchAll();
	foreach($result as &$gain)
	{
		if(!empty($starsgain[$gain["account"]]))
		{
			$starsgain[$gain["account"]] += $gain["value"];
		}
		else
		{
			$starsgain[$gain["account"]] = $gain["value"];
		}
	}
	arsort($starsgain);
	foreach ($starsgain as $userID => $stars)
	{
		if ($stars == 0 or $xi >= 100)
		{
			break;
		}
		$query = $db->prepare("SELECT * FROM users WHERE userID = :userID");
		$query->execute([':userID' => $userID]);
		$user = $query->fetchAll()[0];
		if($user["isBanned"] == 0 && $user["isRegistered"] == 1)
		{
			$xi++;
			$lbstring .= "1:".$user["userName"].":2:".$user["userID"].":4:-1:13:-1:17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$stars.":7:".$user["extID"]."|";
		}
	}  
}

if($type == "friends"){
	$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$people = "";
	foreach ($result as &$friendship) {
		$person = $friendship["person1"];
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
		}
		$people .= ",".$person;
	}
	$query = "SELECT * FROM users WHERE extID IN (:accountID $people ) ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	foreach($result as &$user){
		if(is_numeric($user["extID"])){
			$extid = $user["extID"];
		}else{
			$extid = 0;
		}
		$xi++;
		$lbstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."|";
	}
}
if($lbstring == ""){
	exit("-1");
}
$lbstring = substr($lbstring, 0, -1);
echo $lbstring;
?>
