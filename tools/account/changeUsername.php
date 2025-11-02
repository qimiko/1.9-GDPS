<html>
	<head>
		<title>Change Username - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Change Username</h1>
<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
//here im getting all the data
if(!empty($_POST["userName"]) && !empty($_POST["newusr"]) && !empty($_POST["password"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$newusr = ExploitPatch::remove($_POST["newusr"]);
	$password = ExploitPatch::remove($_POST["password"]);

	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == 1) {
		if(strlen($newusr) > 20)
			exit("Username too long - 20 characters max. <a href='changeUsername.php'>Try again</a>");
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName = :newUserName");
		$query->execute([":newUserName" => $newusr]);
		if($query->fetchColumn() > 0) exit("<p>Account with this nickname already exists!</p>");

		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");
		$query->execute([':userName' => $userName]);
		$accountId = $query->fetchColumn();

		$query = $db->prepare("UPDATE accounts SET username=:newusr WHERE userName=:userName");
		$query->execute([':newusr' => $newusr, ':userName' => $userName]);
		if($query->rowCount()==0){
			echo "Invalid password or nonexistent account. <a href=''>Try again</a>";
		}else{
			$query = $db->prepare('UPDATE users SET userName=:userName WHERE extID=:id');
			$query->execute([':userName' => $userName, ':id' => $accountId]);

			echo "<p>Username changed. Please refresh your login ingame to fully update your name.</p> <a href='..'>Go back to tools</a>";
		}
	}else{
		echo "Invalid password or nonexistent account. <a href=''>Try again</a>";
	}
}else{
	echo '<form action="" method="post">Old username: <input type="text" name="userName"><br>New username: <input type="text" name="newusr"><br>Password: <input type="password" name="password"><br><input type="submit" value="Change"></form>';
}
?>
		</div>
	</body>
</html>