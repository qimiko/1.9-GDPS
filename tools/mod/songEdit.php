
<!DOCTYPE HTML>
<html>
	<head>
		<title>Song Edit - 1.9 GDPS</title>
		<?php include "../../../../incl/_style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/_nav.php"; ?>

		<div class="smain">
			<h1>Song Edit</h1>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();

$stage = !empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["songID"]);

$username = $_POST["userName"] ?? '';
$password = $_POST["password"] ?? '';

$baseForm = "<p>This tool is mod-only!</p><form action='' method='post'>
	<input class='smain' type='text' placeholder='Username' name='userName' value='$username'><br>
	<input class='smain' type='password' placeholder='Password' name='password' value='$password'><br>
	<input class='smain' type='text' placeholder='Song ID' name='songID'><br>
	<input class='smain' type='submit' value='Load'>
</form>";

if ($stage == false)
{
	echo $baseForm;
}
else if ($stage AND empty($_POST["songName"]))
{
	$pass = GeneratePass::isValidUsrname($_POST["userName"], $_POST["password"]);
	if ($pass == 1)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $_POST["userName"]]);
		if($query->rowCount()==0)
		{
			exit("<p>Account isn't mod</p>");
		}

		$query1 = $db->prepare("SELECT * FROM songsCombined WHERE ID=:songID");
		$query1->execute([':songID' => $_POST["songID"]]);
		if ($query->rowCount()==0)
		{
			exit("<p>Cannot find song, did you enter the name correctly?</p>");
		}

		$song = $query1->fetch();

		echo '
<form action="" method="post">
<input class="smain" type="text" placeholder="Username" name="userName" value="'.$_POST["userName"].'"><br>
<input class="smain" type="password" placeholder="Password" name="password" value="'.$_POST["password"].'"><br>
<input class="smain" type="text" placeholder="Song ID" name="songID" value="'.$_POST['songID'].'"><br>

<p>Loaded song!</p>

<input class="smain" type="text" placeholder="Song Name" name="songName" value="'.$song['name'].'"><br>
<input class="smain" type="text" placeholder="Author" name="songAuthor" value="'.$song['authorName'].'"><br>
<input class="smain" type="text" placeholder="Download URL" name="songDownload" value="'.$song['download'].'"><br>
<input class="smain" type="submit" value="Edit">
</form>';
	}
	else
	{
		echo "<p>Incorrect username or password</p>";
	}
}
else
{
	$pass = GeneratePass::isValidUsrname($_POST["userName"], $_POST["password"]);
	if ($pass == 1)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $_POST["userName"]]);
		if($query->rowCount()==0)
		{
			exit("<p>Account isn't mod</p>");
		}

		$songID = ExploitPatch::number($_POST["songID"]);

		$download = $gs->fixSongUrl($_POST["songDownload"]);
		if (!empty($_POST["songName"]) && !empty($_POST["songAuthor"])) {
			$name = ExploitPatch::remove($_POST["songName"]);
			$author = ExploitPatch::remove($_POST["songAuthor"]);

			$query = $db->prepare("UPDATE reuploadSongs SET name=:name, authorName=:author, download=:download WHERE ID=:songID");
			$query->execute([':name' => $name, ':author' => $author, ':download' => $download, ':songID' => $songID]);

			if ($query->rowCount() == 0) {
				$query = $db->prepare("UPDATE songs SET name=:name, authorName=:author, download=:download WHERE ID=:songID");
				$query->execute([':name' => $name, ':author' => $author, ':download' => $download, ':songID' => $songID]);
			}

			echo "$baseForm <p>Song $songID edited.</p>";
		} else {
			$query = $db->prepare("UPDATE reuploadSongs SET download=:download WHERE ID=:songID");
			$query->execute([':download' => $download, ':songID' => $songID]);

			if ($query->rowCount() == 0) {
				$query = $db->prepare("UPDATE songs SET download=:download WHERE ID=:songID");
				$query->execute([':download' => $download, ':songID' => $songID]);
			}

			echo "$baseForm <p>Song $songID download link edited.</p>";
		}
	}
}
?>
		</div>
	</body>
</html>