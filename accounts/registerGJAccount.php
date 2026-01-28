<?php
include "../config/security.php";
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/mainLib.php";
require_once "../incl/lib/wordFilter.php";

if(!isset($preactivateAccounts)){
	$preactivateAccounts = true;
}

if($_POST["userName"] != ""){
	//here im getting all the data
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$email = ExploitPatch::remove($_POST["email"]);
	$secret = "";
	//checking if username is within the GD length limit
	if(strlen($userName) > 20)
		exit("-4");

	if (WordFilter::checkBlocked($username))
		exit("-1");

	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	//rate limiting

	$gs = new mainLib();
	$ip = $gs->getIP();

	$query3 = $db->prepare("SELECT count(*) FROM accounts WHERE registerDate > :time AND ip = :ip");
	$query3->execute([':time' => time() - 300 /*5 minutes*/, ':ip' => $ip]);
	$ratelimit1 = $query3->fetchColumn();
	
	if ($ratelimit1 > 0)
	{
		echo "-13";
	}
	else if ($regusrs > 0)
	{
		echo "-2";
	}
	else
	{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$gjp2 = GeneratePass::GJP2hash($password);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2, ip)
		VALUES (:userName, :password, :email, :time, :isActive, :gjp, :ip)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp' => $gjp2, ':ip' => $ip]);
		echo "1";
	}
}
?>
