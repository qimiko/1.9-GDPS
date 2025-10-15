<html>
	<head>
		<title>Set Moderator Status</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/_nav.php"; ?>
	
		<div class="smain">
	
			<h1>Set Moderator Status</h1>

			<a href="../stats/getUserInfo.php" target="_blank">Get AccountID</a>

			<form action="" method="post">
				<input class="smain" type="text" placeholder="Username" name="u"><br>
				<input class="smain" type="password" placeholder="Password" name="p"><br>
				<input class="smain" type="text" placeholder="AccountID" name="id"><br>
				<input class="smain" type="text" placeholder="Set Mod (0 = remove, 1 = give)" name="mod" value="1"><br>
				<input class="smain" type="submit" value="Go">
			</form>

<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/webhooks/webhook.php";
require_once "../../incl/lib/exploitPatch.php";

if (!empty($_POST['u']) AND !empty($_POST['p']) AND !empty($_POST['id']))
{
	$u = ExploitPatch::remove($_POST['u']);
	$p = ExploitPatch::remove($_POST['p']);

	$pass = GeneratePass::isValidUsrname($u, $p);

	$q = $db->prepare("SELECT isHeadAdmin FROM accounts WHERE userName = :un");
	$q->execute([':un' => $u]);
	$result = $q->fetch()[0];
	
	if ($pass)
	{
		if ($result == "1")
		{
			$id = ExploitPatch::number($_POST['id']);
			$mod = ExploitPatch::number($_POST['mod']);

			$query = $db->prepare("UPDATE accounts SET isAdmin = :mod WHERE accountID = :accid");
			$query->execute([':mod' => $mod, ':accid' => $id]);
			$affected = $query->rowCount();

			$modQuery = $db->prepare("SELECT roleID FROM roles WHERE roleName='mod'");
			$modQuery->execute();
			$roleId = $modQuery->fetchColumn();

			if ($mod) {
				$query = $db->prepare("INSERT INTO roleassign (roleID, accountID) VALUES (:roleid, :accid);");
				$query->execute([':roleid' => $roleId, ':accid' => $id]);
			} else {
				$query = $db->prepare("DELETE FROM roleassign WHERE roleID=:roleid AND accountID=:accid;");
				$query->execute([':roleid' => $roleId, ':accid' => $id]);
			}

			if ($affected)
			{
				$q = $db->prepare("SELECT userName FROM users WHERE extID = :accid");
				$q->execute([':accid' => $id]);
				
				$username = $q->fetch()[0];
				
				PostToHook("Mod Update", "Mod status for $username (".$_POST['id'].") updated to: ".$_POST['mod']);
		
				echo "SUCCESS. User affected: $username";
			}
			else
			{
				echo "FAILED, ZERO ROWS AFFECTED.";
			}
		}
		else
		{
			echo "USER NOT ADMIN.";
		}
	}
	else
	{
		echo "INVALID USERNAME/PASSWORD.";
	}
}
else
{
	echo "MISSING FIELDS.";
}

?>
		</div>
	</body>
</html>