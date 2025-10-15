CREATE TABLE `reuploadSongs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL,
  `hash` varchar(256) NOT NULL DEFAULT '',
  `isDisabled` int(11) NOT NULL DEFAULT 0,
  `levelsCount` int(11) NOT NULL DEFAULT 0,
  `reuploadTime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `name` (`name`),
  KEY `authorName` (`authorName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- copy data
INSERT INTO reuploadSongs (
	ID, name, authorID, authorName, size, download, hash, isDisabled, levelsCount, reuploadTime
) SELECT * FROM songs WHERE authorID=9 AND ID BETWEEN 5105655 AND 9999999;

-- copy possible colliding songs into a different range, we'll handle the difference later
INSERT INTO reuploadSongs (
	ID, name, authorID, authorName, size, download, hash, isDisabled, levelsCount, reuploadTime
) SELECT ID-4000000, name, authorID, authorName, size, download, hash, isDisabled, levelsCount, reuploadTime FROM songs WHERE authorID=9 AND ID>=10000000;

-- clear data
DELETE FROM songs WHERE authorID=9 AND ID>=5105655;

CREATE VIEW songsCombined AS
  SELECT * FROM songs
  UNION ALL
  SELECT * FROM reuploadSongs;
