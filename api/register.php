<?php

chdir(dirname(__FILE__));

include "../config/security.php";
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";

$gs = new mainLib();
$ip = $gs->getIP();

if(!isset($preactivateAccounts)){
	$preactivateAccounts = true;
}

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20)
	{
		exit(json_encode(['success' => false, 'error' => 'username length not 3-20']));
	}
	
	if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 20)
	{
		exit(json_encode(['success' => false, 'error' => 'password length not 6-20']));
	}
	
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		exit(json_encode(['success' => false, 'error' => 'invalid email']));
	}
	
	//here im getting all the data
	$userName = ExploitPatch::remove($_POST["username"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$email = ExploitPatch::remove($_POST["email"]);
	$secret = "";
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	//rate limiting
	$query3 = $db->prepare("SELECT count(*) FROM accounts WHERE registerDate > :time AND ip = :ip");
	$query3->execute([':time' => time() - 300 /*5 minutes*/, ':ip' => $ip]);
	$ratelimit1 = $query3->fetchColumn();
	
	if ($ratelimit1 > 0)
	{
		exit(json_encode(['success' => false, 'error' => 'rate limit reached, try again later']));
	}
	else if ($regusrs > 0)
	{
		exit(json_encode(['success' => false, 'error' => 'username taken']));
	}
	else
	{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query2 = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2, ip)
		VALUES (:userName, :password, :email, :time, :isActive, :gjp2, :ip)");
		$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email,':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp2' => GeneratePass::GJP2hash($password), ':ip' => $ip]);
		exit(json_encode(['success' => true, 'message' => 'Successfully registered account']));
	}
}
else
{
	exit(json_encode(['success' => false, 'error' => 'invalid parameters']));
}
?>