<html>
	<head>
		<title>Register Account - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Register Account</h1>

<?php
include "../../config/security.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/exploitPatch.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/mainLib.php";

$registerForm = <<<'EOD'
<form action="registerAccount.php" method="post">
	Username: <input type="text" name="username" maxlength=15 /> <br />
	Password: <input type="password" name="password" maxlength=20 /> <br/>
	Repeat Password: <input type="password" name="repeatpassword" maxlength=20 /> <br />
	Email: <input type="email" name="email" maxlength=50 /> <br />
	Repeat Email: <input type="email" name="repeatemail" maxlength=50 /> <br />
	<input type="submit" value="Register" />
</form>
EOD;

if(!isset($preactivateAccounts)){
	$preactivateAccounts = true;
}

// here begins the checks
if(!empty($_POST["username"]) AND !empty($_POST["email"]) AND !empty($_POST["repeatemail"]) AND !empty($_POST["password"]) AND !empty($_POST["repeatpassword"])){
	// catching all the input
	$username = ExploitPatch::remove($_POST["username"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$repeat_password = ExploitPatch::remove($_POST["repeatpassword"]);
	$email = ExploitPatch::remove($_POST["email"]);
	$repeat_email = ExploitPatch::remove($_POST["repeatemail"]);
	if(strlen($username) < 3){
		// choose a longer username
		echo "<p>Username should be more than 3 characters.</p>$registerForm";
	}elseif(strlen($password) < 6){
		// just why did you want to give a short password? do you wanna be hacked?
		echo "<p>Password should be more than 6 characters.</p>$registerForm";
	}else{
		// this checks if there is another account with the same username as your input
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $username]);
		$registred_users = $query->fetchColumn();
		if($registred_users > 0){
			// why did you want to make a new account with the same username as someone else's
			echo "<p>Username already taken.</p>$registerForm";
		}else{
			if($password != $repeat_password){
				// this is when the passwords do not match
				echo "<p>Passwords do not match.</p>$registerForm";
			}elseif($email != $repeat_email){
				// this is when the emails dont match
				echo "<p>Emails do not match.</p>$registerForm";
			}else{
				$gs = new mainLib();
				$ip = $gs->getIP();
				$query3 = $db->prepare("SELECT count(*) FROM accounts WHERE registerDate > :time AND ip = :ip");
				$query3->execute([':time' => time() - 300 /*5 minutes*/, ':ip' => $ip]);
				$ratelimit1 = $query3->fetchColumn();

				if ($ratelimit1 > 0) {
					echo "<p>Ratelimit reached.</p>$registerForm";
				} else {
					// hashing your password and registering your account
					$hashpass = password_hash($password, PASSWORD_DEFAULT);
					$query2 = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2, ip)
					VALUES (:userName, :password, :email, :time, :isActive, :gjp2, :ip)");
					$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email,':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp2' => GeneratePass::GJP2hash($password), ':ip' => $ip]);
					// there you go, you are registered.
					$activationInfo = $preactivateAccounts ? "No e-mail verification required, you can login." : "<a href='activateAccount.php'>Click here to activate it.</a>";
					echo "<p>Account registered. ${activationInfo}</p> <a href='..'>Go back to tools</a>";
				}
			}
		}
	}
}else{
	// this is given when we dont have an input
	echo $registerForm;
}
?>
		</div>
	</body>
</html>
