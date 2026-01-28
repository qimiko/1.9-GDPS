<html>
	<head>
		<title>View Devices - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">

		<h1>View Active Devices</h1>

		<form action="" method="post">
			<input class="smain" type="text" placeholder="Username" name="u"><br>
			<input class="smain" type="password" placeholder="Password" name="p"><br>

			<?php
				require_once "../../incl/lib/Captcha.php";
				Captcha::displayCaptcha();
			?>

			<input class="smain" type="submit" value="Go">
		</form>

<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/auth.php";

if (!empty($_POST['u']) AND !empty($_POST['p']))
{
	if(!Captcha::validateCaptcha())
		exit("<p>Invalid captcha response</p>");

	$pass = GeneratePass::isValidUsrname($_POST['u'], $_POST['p']);

	if ($pass)
	{
		$query = $db->prepare("SELECT auth.authkey, auth.accountid, auth.created, auth.ip, accounts.userName FROM auth INNER JOIN accounts ON auth.accountid=accounts.accountID WHERE accounts.userName=:username ORDER BY auth.created DESC");
		$query->execute([':username' => $_POST['u']]);
		$result = $query->fetchAll();

		if (empty($result)) {
			echo "<p>No devices found!</p>";
		} else {
			$count = count($result);
			echo "<p>Found $count active devices!</p>";

			echo "<table><tr><th>Created</th><th>IP</th></tr>";

			foreach ($result as $key) {
				$currentTime = DateTime::createFromFormat('U', $key['created']);
				$formatted = $currentTime->format('D, M j Y \a\t H:i:s');

				echo "<tr><td>$formatted</td><td>{$key['ip']}</td></tr>";
			}

			echo "</table>";

			$initialAuthkey = $result[0]['authkey'];
			echo "<form method='POST' action=''><input type='hidden' name='authkey' value='$initialAuthkey' /><input type='hidden' name='mode' value='all' /><input type='submit' value='Log out of all devices' /></form>";
		}
	}
	else
	{
		echo "INVALID USERNAME/PASSWORD.";
	}
} else if (!empty($_POST['authkey']) && !empty($_POST['mode'])) {
	if ($_POST['mode'] == 'single') {
		Auth::revoke_auth($_POST['authkey']);
	} else if ($_POST['mode'] == 'all') {
		Auth::revoke_all_auth($_POST['authkey']);
	}

	echo "<p>Successfully logged out device!</p>";
}

?>
		</div>
	</body>
</html>
