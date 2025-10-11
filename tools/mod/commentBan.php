<html>
	<head>
		<title>Comment Ban</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/_nav.php"; ?>
	
		<div class="smain">
	
			<h1>Comment Ban</h1>

			<form action="" method="post">
				<input class="smain" type="text" placeholder="Username" name="u"><br>
				<input class="smain" type="password" placeholder="Password" name="p"><br>
				<input class="smain" type="text" placeholder="UserID" name="id"><br>
				<input class="smain" type="text" placeholder="Ban (0 = UnBan, 1 = Ban)" name="ban" value="1"><br>
				<input class="smain" type="submit" value="Go">
			</form>

<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/webhooks/webhook.php";

if (!empty($_POST['u']) AND !empty($_POST['p']) AND !empty($_POST['id']))
{
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($_POST['u'], $_POST['p']);
	
	$q = $db->prepare("SELECT isAdmin FROM accounts WHERE userName = :un");
	$q->execute([':un' => $_POST['u']]);
	$result = $q->fetch()[0];
	
	if (is_numeric($_POST['id']) && is_numeric($_POST['ban']))
	{
		if ($pass)
		{
			if ($result == "1")
			{
				$query = $db->prepare("UPDATE comments SET isSpam = :ban WHERE userID = :id");
				$query->execute([':ban' => $_POST['ban'], ':id' => $_POST['id']]);
				
				$query = $db->prepare("UPDATE users SET isCommentBanned = :ban WHERE userID = :id");
				$query->execute([':ban' => $_POST['ban'], ':id' => $_POST['id']]);
				$affected = $query->rowCount();
				
				if ($affected)
				{
					
					if ($_POST['ban'] != "0")
					{
						PostToHook("Account Update", "An account has been limited.");
					}
					else
					{
						PostToHook("Account Update", "Account limitation has been removed.");
					}
			
					echo "SUCCESS. User affected.";
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
		echo "INVALID, NON-NUMERIC INPUT";
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