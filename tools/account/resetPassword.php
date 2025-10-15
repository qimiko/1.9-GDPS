<html>
	<head>
		<title>Lost Password</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Lost Password</h1>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "../../incl/lib/connection.php";
include_once "../../config/security.php";
include_once "../../config/email.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
include_once "../../incl/lib/defuse-crypto.phar";

// import phpmailer
require "../../../../../PHPMailer/src/Exception.php";
require "../../../../../PHPMailer/src/PHPMailer.php";
require "../../../../../PHPMailer/src/SMTP.php";

//reset
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (array_key_exists('email', $_POST))
	{
		$query = $db->prepare("SELECT email, accountID, userName, passwordResetKey, passwordResetTime FROM accounts WHERE email=:email");
		$query->execute([':email' => $_POST['email']]);

		if ($query->rowCount() == 0)
		{
			echo '<p>EMAIL NOT LINKED TO ANY ACCOUNT</p><form action="" method="post"><br><input type="text" name="email" placeholder="Email"><br><input type="submit" value="Get Reset Email"></form>';
		}
		else
		{
			$acc = $query->fetchAll()[0];
			
			//rate limit emails
			if ($acc['passwordResetTime'] > time() - 10 * 60)
			{
				$diff = 10 * 60 - (time() - $acc['passwordResetTime']);
				
				if ($diff > 60)
				{
					$t = (int)($diff / 60) . "m " . ($diff % 60) . "s";
				}
				else
				{
					$t = $diff . "s";
				}
				
				echo '<p>Please wait ' . $t . ' before requesting another reset</p><form action="" method="post"><br><input type="text" name="email" placeholder="Email"><br><input type="submit" value="Get Reset Email"></form>';
			}
			else //send email
			{
				if ($acc['passwordResetKey'] == '')
				{
					$acc['passwordResetKey'] = hash("sha256", random_bytes(16) . $acc['email']);

					$query = $db->prepare("UPDATE accounts SET passwordResetKey = :prk, passwordResetTime = :prt WHERE accountID = :accid");
					$query->execute([':prk' => $acc['passwordResetKey'], ':prt' => time(), ':accid' => $acc['accountID']]);
				}
				else
				{
					$query = $db->prepare("UPDATE accounts SET passwordResetTime = :prt WHERE accountID = :accid");
					$query->execute([':prt' => time(), ':accid' => $acc['accountID']]);
				}

				$email = new PHPMailer(true);
				$email->isSMTP();

				$email->Host = $smtp_domain;

				$email->SMTPAuth = true;

				$email->Username = $smtp_username;
				$email->Password = $smtp_password;

				$email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$email->Port = 587;

				$email->setFrom("support@19gdps.com", "1.9 GDPS Support");

				$email->Subject = "1.9 GDPS Password Reset";
				$email->addAddress($acc['email']);
				$email->Body = "Reset your password at the following link:\nhttps://19gdps.com/gdapi/tools/account/resetPassword.php?k=".$acc['passwordResetKey']."\n\nIf you did not request a password reset, please ignore this email!\nDo not reply to this email as the inbox is not monitored.";

				try {
					$response = $email->send();
					echo "<p>Success, check your email to continue. If you don't receive an email after 10 minutes, try again</p>";
				} catch (Exception $e) {
                                        $query = $db->prepare("UPDATE accounts SET passwordResetTime = 0 WHERE accountID = :accid");
                                        $query->execute([':accid' => $acc['accountID']]);

					echo "<p>Failed to send email, please contact @qimiko on Discord<br/>" . $e->getMessage() . "</p><a href=\"javascript:history.back()\">Back</a>";
				}
			}
		}
	}
	else if (array_key_exists('k', $_POST) && array_key_exists('password', $_POST))
	{
		$query = $db->prepare("SELECT email, accountID, userName FROM accounts WHERE passwordResetKey=:prk");
		$query->execute([':prk' => $_POST['k']]);
		
		//check password valid
		if ($query->rowCount() == 0)
		{
			echo '<p class="nobox">Expired password reset key! <a href="/gdapi/tools/account/resetPassword.php">Request another</a></p>';
		}
		else if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 20)
		{
			echo '<p class="nobox">Password must be between 6 & 20 characters long! <a href="/gdapi/tools/account/resetPassword.php?k='.$_POST['k'].'">Try again</a></p>';
		}
		else if (!ctype_alnum($_POST['password']))
		{
			echo '<p class="nobox">Password must be alpha-numeric! <a href="/gdapi/tools/account/resetPassword.php?k='.$_POST['k'].'">Try again</a></p>';
		}
		else //reset password
		{
			$acc = $query->fetchAll()[0];
			$newpass = $_POST['password'];
			
			if($cloudSaveEncryption == 1){
				$accountID = $acc["accountID"];
				$saveData = file_get_contents("../../data/accounts/$accountID");
				if(file_exists("../../data/accounts/keys/$accountID")){
					$protected_key_encoded = file_get_contents("../../data/accounts/keys/$accountID");
					$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
					$user_key = $protected_key->unlockKey($oldpass);
					try {
						$saveData = Crypto::decrypt($saveData, $user_key);
					} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
						exit("-2");	
					}
					$protected_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($newpass);
					$protected_key_encoded = $protected_key->saveToAsciiSafeString();
					$user_key = $protected_key->unlockKey($newpass);
					$saveData = Crypto::encrypt($saveData, $user_key);
					file_put_contents("../../data/accounts/$accountID",$saveData);
					file_put_contents("../../data/accounts/keys/$accountID",$protected_key_encoded);
				}
			}
			//creating pass hash
			$passhash = password_hash($newpass, PASSWORD_DEFAULT);
			$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE accountID=:accid");	
			$query->execute([':password' => $passhash, ':accid' => $acc["accountID"]]);
			GeneratePass::assignGJP2($accid, $newpass);

			$clearQuery = $db->prepare("DELETE FROM auth WHERE accountid=:accid");
			$clearQuery->execute([':accid' => $acc["accountID"]]);
			echo "<p class=\"nobox\">Password changed. <a href='accountManagement.php'>Account management</a></p>";
		}
	}
	else
	{
		echo '<p class="nobox">Something went wrong! <a href="/gdapi/tools/account/resetPassword.php">Reset Password</a></p>';
	}
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (array_key_exists('k', $_GET))
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE passwordResetKey=:prk");
		$query->execute([':prk' => $_GET['k']]);
		
		if ($query->rowCount() == 0)
		{
			echo '<p class="nobox">Expired password reset key! <a href="/gdapi/tools/account/resetPassword.php">Request another</a></p>';
		}
		else
		{
			echo '<form action="/gdapi/tools/account/resetPassword.php" method="post"><input type="password" name="password" placeholder="New Password"><input type="hidden" id="k" name="k" value="' . $_GET['k'] . '"><br><input type="submit" value="Reset"></form>';
		}
	}
	else
	{
		echo '<p>I hope you remember your email!</p><form action="" method="post"><input type="text" name="email" placeholder="Email"><br><input type="submit" value="Get Reset Email"></form>';
	}
}
else
{
	http_response_code(405);
	die("<pre>405</pre>");
}
?>
		</div>
	</body>
</html>
