<html>
	<head>
		<title>1.9 Tools</title>
		<?php include "../../../incl/_style.php"; ?>
		</head>
	
	<body>
		<?php include "../../../incl/_nav.php"; ?>
	
		<div class="smain nofooter">
			<h2>My Account</h2>
			<p>
				<a href="account/registerAccount.php">Register Account</a>
				<a href="account/changePassword.php">Change Password</a>
				<a href="account/changeUsername.php">Change Username</a>
				<a href="newSession.php">Make Session</a>
				<a href="account/resetPassword.php">Forgot Password</a>
				<a href="account/checkTokens.php">Active Devices</a>
			</p>

			<h2>Levels</h2>
			<p>
				<a href="stats/epicLevels.php">Epic Levels</a>
				<a href="levelReupload.php">Level Reupload</a>
				<a href="levelToGD.php">Level To GD</a>
				<a href="stats/myUnlistedLevels.php">Unlisted Levels</a>
				<a href="stats/mapPacks.php">Map Packs</a>
				<a href="stats/reportedLevels.php">Reported Levels</a>
				<a href="stats/comments.php">Level Comments</a>
				<a href="stats/suggestList.php">Sent Levels</a>
			</p>

			<h2>Songs</h2>
			<p><a href="songAdd.php">Song Reupload</a><a href="stats/songsList.php">Song List</a></p>
			
			<h2>Users</h2>
			<p><a href="stats/getUserInfo.php">Search Users</a><a href="stats/starGains.php">Star Gains</a><a href="stats/top24h.php">Top 24h</a><a href="stats/topWeek.php">Top Week</a><a href="stats/noLogIn.php">Unused Accounts</a></p>
			
			<h2>Other</h2>
			<p><a href="cron/cron.php">Cron Job</a><a href="cron/fixcps.php">Fix CPs</a><a href="cron/autoban.php">AutoBan</a><a href="cron/deleteInvalidUsersAndSongs.php">Cleanup</a><a href="stats/serverInfo.php">Server Info</a></p>
			
			<h2>Moderation</h2>
			<p><a href="stats/modActions.php">Mod Actions</a><a href="mod/leaderboardsBan.php">Leaderboards Ban</a><a href="mod/leaderboardsUnban.php">Leaderboards UnBan</a><a href="mod/sendBan.php">Send Ban</a><a href="mod/packCreate.php">Create Map Pack</a><a href="mod/editPack.php">Edit Map Pack</a><a href="mod/manageComments.php">Manage Comments</a><a href="mod/commentBan.php">Comment Ban</a><a href="mod/sharedcp.php">Shared CP</a></p>
			
			<h2>Administration</h2>
			<p><a href="admin/mod.php">Set Mod Status</a><a href="super/admin.php">Set Admin Status</a></p>
		</div>

	</body>
</html>
