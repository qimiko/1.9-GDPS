<html>
	<head>
		<title>Enable Legacy Authentication - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">

		<h1>Enable Legacy Authentication</h1>

<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/auth.php";
require_once "../../incl/lib/Captcha.php";

if (!empty($_POST['u']) AND !empty($_POST['p']))
{
	if(!Captcha::validateCaptcha())
		exit("<p>Invalid captcha response</p>");

	$pass = GeneratePass::isValidUsrname($_POST['u'], $_POST['p']);
	if ($pass)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");
		$query->execute([':userName' => $_POST['u']]);
		$accountId = $query->fetchColumn();

		$token = GeneratePass::assignLegacyToken($accountId);
		echo "<p>Token set! Use this token in place of the password when logging into a 2.2 client.</p> <p> <code>$token</code> </p> <p>Please keep it safe! For your security, you will not be able to view this token upon closing the page.</p>";
	}
	else
	{
		echo "INVALID USERNAME/PASSWORD.";
	}
} else {
	echo '<p>A legacy authentication token is required to use the 1.9 GDPS with 2.2 clients. Upon logging into this page, all previous tokens <em>will be reset</em>.</p>
	
		<form action="" method="post">
		<input class="smain" type="text" placeholder="Username" name="u"><br />
		<input class="smain" type="password" placeholder="Password" name="p"><br />';

	Captcha::displayCaptcha();

	echo '<input class="smain" type="submit" value="Go"></form>';
}

?>
		</div>
	</body>
</html>
