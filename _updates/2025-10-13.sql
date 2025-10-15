-- custom migration to move legacy roles over to new roles

INSERT INTO `roles` (roleName, actionSuggestRating, isDefault, commentColor) VALUES (
	'base', 1, 1, '255,255,255'
);

INSERT INTO `roles` (
	priority,
	roleName,
	commandRate,
	commandFeature,
	commandEpic,
  commandUnepic,
  commandDelete,
  commandSetacc,
  commandRenameAll,
  commandPassAll,
  commandDescriptionAll,
  commandPublicAll,
  commandUnlistAll,
  commandSharecpAll,
  commandSongAll,
  actionRateDemon,
  actionRateStars,
  actionRateDifficulty,
  actionRequestMod,
  actionSuggestRating,
  actionDeleteComment,
  toolLeaderboardsban,
  toolPackcreate,
  toolModactions,
  dashboardModTools,
  modipCategory,
  commentColor,
	modBadgeLevel
) VALUES (
	10, 'mod', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '200,255,200', 1
);
SET @modId = (SELECT LAST_INSERT_ID());
INSERT INTO roleassign (roleID, accountID)
	SELECT @modId, accounts.accountID FROM accounts WHERE isAdmin=1;

INSERT INTO `roles` (
	priority,
	roleName,
	commandRate,
	commandFeature,
	commandEpic,
  commandUnepic,
  commandDelete,
  commandSetacc,
  commandRenameAll,
  commandPassAll,
  commandDescriptionAll,
  commandPublicAll,
  commandUnlistAll,
  commandSharecpAll,
  commandSongAll,
  actionRateDemon,
  actionRateStars,
  actionRateDifficulty,
  actionRequestMod,
  actionSuggestRating,
  actionDeleteComment,
  toolLeaderboardsban,
  toolPackcreate,
  toolModactions,
  dashboardModTools,
  modipCategory,
  commentColor,
	modBadgeLevel
) VALUES (
	15, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '75,255,75', 2
);
SET @adminId = (SELECT LAST_INSERT_ID());
INSERT INTO roleassign (roleID, accountID)
	SELECT @adminId, accounts.accountID FROM accounts WHERE isHeadAdmin=1;

-- we can fix this later
UPDATE accounts SET isActive=1;
