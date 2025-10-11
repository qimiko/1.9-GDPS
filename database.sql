-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2025 at 04:47 AM
-- Server version: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdps`
--

-- --------------------------------------------------------

--
-- Table structure for table `acccomments`
--

CREATE TABLE IF NOT EXISTS `acccomments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL DEFAULT 'unused',
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL DEFAULT 'unused',
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `saveData` longtext NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `isHeadAdmin` int(11) NOT NULL DEFAULT 0,
  `isListMod` int(11) NOT NULL DEFAULT 0,
  `helperBanned` int(11) NOT NULL DEFAULT 0,
  `shadowBanned` int(11) NOT NULL DEFAULT 0,
  `userID` int(11) NOT NULL DEFAULT 0,
  `friends` varchar(1024) NOT NULL DEFAULT 'unused',
  `blockedBy` varchar(1024) NOT NULL DEFAULT 'unused',
  `blocked` varchar(1024) NOT NULL DEFAULT 'unused',
  `mS` int(11) NOT NULL DEFAULT 0,
  `frS` int(11) NOT NULL DEFAULT 0,
  `youtubeurl` varchar(255) NOT NULL DEFAULT '',
  `twitter` varchar(255) NOT NULL DEFAULT '',
  `twitch` varchar(255) NOT NULL DEFAULT '',
  `salt` varchar(255) NOT NULL DEFAULT '',
  `registerDate` int(11) NOT NULL DEFAULT 0,
  `friendsCount` int(11) NOT NULL DEFAULT 0,
  `saveKey` blob NOT NULL,
  `ip` text NOT NULL,
  `passwordResetKey` text NOT NULL DEFAULT '',
  `passwordResetTime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `userName` (`userName`),
  KEY `isAdmin` (`isAdmin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accSessions`
--

CREATE TABLE IF NOT EXISTS `accSessions` (
  `loginId` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `ip` text NOT NULL,
  `sessionStart` int(11) NOT NULL,
  PRIMARY KEY (`loginId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(11) NOT NULL DEFAULT 0,
  `value4` int(11) NOT NULL DEFAULT 0,
  `value5` int(11) NOT NULL DEFAULT 0,
  `value6` int(11) NOT NULL DEFAULT 0,
  `account` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `authid` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` int(11) NOT NULL,
  `authkey` text NOT NULL,
  `created` int(11) NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`authid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bannedips`
--

CREATE TABLE IF NOT EXISTS `bannedips` (
  `IP` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL DEFAULT 'none',
  `levelID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `percent` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `levelID` (`levelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cpshares`
--

CREATE TABLE IF NOT EXISTS `cpshares` (
  `shareID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`shareID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dailyfeatures`
--

CREATE TABLE IF NOT EXISTS `dailyfeatures` (
  `feaID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`feaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demonList`
--

CREATE TABLE IF NOT EXISTS `demonList` (
  `demonID` int(11) NOT NULL AUTO_INCREMENT,
  `listIndex` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Creator` text NOT NULL,
  `videoURL` text NOT NULL,
  PRIMARY KEY (`demonID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friendreqs`
--

CREATE TABLE IF NOT EXISTS `friendreqs` (
  `accountID` int(11) NOT NULL,
  `toAccountID` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `isNew` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`),
  KEY `toAccountID` (`toAccountID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE IF NOT EXISTS `friendships` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  `isNew1` int(11) NOT NULL,
  `isNew2` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `person1` (`person1`),
  KEY `person2` (`person2`),
  KEY `isNew1` (`isNew1`),
  KEY `isNew2` (`isNew2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gauntlets`
--

CREATE TABLE IF NOT EXISTS `gauntlets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `level1` int(11) NOT NULL,
  `level2` int(11) NOT NULL,
  `level3` int(11) NOT NULL,
  `level4` int(11) NOT NULL,
  `level5` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `level5` (`level5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hackDownloads`
--

CREATE TABLE IF NOT EXISTS `hackDownloads` (
  `dwID` int(11) NOT NULL AUTO_INCREMENT,
  `hackID` int(11) NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`dwID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hackList`
--

CREATE TABLE IF NOT EXISTS `hackList` (
  `hackID` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `downloadLink` text NOT NULL,
  `downloadCount` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`hackID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `gameVersion` int(11) NOT NULL,
  `binaryVersion` int(11) NOT NULL DEFAULT 0,
  `userName` mediumtext NOT NULL,
  `levelID` int(11) NOT NULL AUTO_INCREMENT,
  `levelName` varchar(255) NOT NULL,
  `levelDesc` mediumtext NOT NULL,
  `levelVersion` int(11) NOT NULL,
  `levelLength` int(11) NOT NULL DEFAULT 0,
  `audioTrack` int(11) NOT NULL,
  `auto` int(11) NOT NULL,
  `password` int(11) NOT NULL,
  `original` int(11) NOT NULL,
  `twoPlayer` int(11) NOT NULL DEFAULT 0,
  `songID` int(11) NOT NULL DEFAULT 0,
  `objects` int(11) NOT NULL DEFAULT 0,
  `coins` int(11) NOT NULL DEFAULT 0,
  `requestedStars` int(11) NOT NULL DEFAULT 0,
  `extraString` mediumtext NOT NULL,
  `levelString` longtext NOT NULL,
  `levelInfo` mediumtext NOT NULL,
  `secret` mediumtext NOT NULL,
  `starDifficulty` int(11) NOT NULL DEFAULT 0 COMMENT '0=N/A 10=EASY 20=NORMAL 30=HARD 40=HARDER 50=INSANE 50=AUTO 50=DEMON',
  `downloads` int(11) NOT NULL DEFAULT 300,
  `likes` int(11) NOT NULL DEFAULT 100,
  `starDemon` int(11) NOT NULL DEFAULT 0,
  `starAuto` varchar(11) NOT NULL DEFAULT '0',
  `starStars` int(11) NOT NULL DEFAULT 0,
  `uploadDate` varchar(1337) NOT NULL,
  `updateDate` int(11) NOT NULL,
  `starCoins` int(11) NOT NULL DEFAULT 0,
  `starFeatured` int(11) NOT NULL DEFAULT 0,
  `starHall` int(11) NOT NULL DEFAULT 0,
  `starEpic` int(11) NOT NULL DEFAULT 0,
  `starDemonDiff` int(11) NOT NULL DEFAULT 0,
  `userID` int(11) NOT NULL,
  `extID` varchar(255) NOT NULL,
  `unlisted` int(11) NOT NULL,
  `originalReup` int(11) NOT NULL DEFAULT 0 COMMENT 'used for levelReupload.php',
  `hostname` varchar(255) NOT NULL,
  `isCPShared` int(11) NOT NULL DEFAULT 0,
  `giveNoCP` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`levelID`),
  KEY `levelID` (`levelID`),
  KEY `levelName` (`levelName`),
  KEY `starDifficulty` (`starDifficulty`),
  KEY `starFeatured` (`starFeatured`),
  KEY `starEpic` (`starEpic`),
  KEY `starDemonDiff` (`starDemonDiff`),
  KEY `userID` (`userID`),
  KEY `likes` (`likes`),
  KEY `downloads` (`downloads`),
  KEY `starStars` (`starStars`),
  KEY `songID` (`songID`),
  KEY `audioTrack` (`audioTrack`),
  KEY `levelLength` (`levelLength`),
  KEY `twoPlayer` (`twoPlayer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levelscores`
--

CREATE TABLE IF NOT EXISTS `levelscores` (
  `scoreID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  PRIMARY KEY (`scoreID`),
  KEY `levelID` (`levelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `targetAccountID` int(11) NOT NULL,
  `server` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `targetUserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mappacks`
--

CREATE TABLE IF NOT EXISTS `mappacks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `levels` varchar(512) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B',
  `colors2` varchar(11) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `body` longtext NOT NULL,
  `subject` longtext NOT NULL,
  `accID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `toAccountID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `secret` varchar(25) NOT NULL DEFAULT 'unused',
  `isNew` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`messageID`),
  KEY `toAccountID` (`toAccountID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modactions`
--

CREATE TABLE IF NOT EXISTS `modactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(11) NOT NULL DEFAULT 0,
  `value4` int(11) NOT NULL DEFAULT 0,
  `value5` int(11) NOT NULL DEFAULT 0,
  `value6` int(11) NOT NULL DEFAULT 0,
  `account` int(11) NOT NULL DEFAULT 0,
  `value7` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modips`
--

CREATE TABLE IF NOT EXISTS `modips` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(69) NOT NULL,
  `isMod` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `reward` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL,
  `hash` varchar(256) NOT NULL DEFAULT '',
  `isDisabled` int(11) NOT NULL DEFAULT 0,
  `levelsCount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `isRegistered` int(11) NOT NULL,
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'undefined',
  `stars` int(11) NOT NULL DEFAULT 0,
  `demons` int(11) NOT NULL DEFAULT 0,
  `icon` int(11) NOT NULL DEFAULT 0,
  `color1` int(11) NOT NULL DEFAULT 0,
  `color2` int(11) NOT NULL DEFAULT 3,
  `iconType` int(11) NOT NULL DEFAULT 0,
  `coins` int(11) NOT NULL DEFAULT 0,
  `userCoins` int(11) NOT NULL DEFAULT 0,
  `special` int(11) NOT NULL DEFAULT 0,
  `gameVersion` int(11) NOT NULL DEFAULT 0,
  `secret` varchar(69) NOT NULL DEFAULT 'none',
  `accIcon` int(11) NOT NULL DEFAULT 0,
  `accShip` int(11) NOT NULL DEFAULT 0,
  `accBall` int(11) NOT NULL DEFAULT 0,
  `accBird` int(11) NOT NULL DEFAULT 0,
  `accDart` int(11) NOT NULL DEFAULT 0,
  `accRobot` int(11) DEFAULT 0,
  `accGlow` int(11) NOT NULL DEFAULT 0,
  `creatorPoints` double NOT NULL DEFAULT 0,
  `IP` varchar(69) NOT NULL DEFAULT '127.0.0.1',
  `lastPlayed` int(11) NOT NULL DEFAULT 0,
  `diamonds` int(11) NOT NULL DEFAULT 0,
  `orbs` int(11) NOT NULL DEFAULT 0,
  `completedLvls` int(11) NOT NULL DEFAULT 0,
  `accSpider` int(11) NOT NULL DEFAULT 0,
  `accExplosion` int(11) NOT NULL DEFAULT 0,
  `chest1time` int(11) NOT NULL DEFAULT 0,
  `chest2time` int(11) NOT NULL DEFAULT 0,
  `chest1count` int(11) NOT NULL DEFAULT 0,
  `chest2count` int(11) NOT NULL DEFAULT 0,
  `isBanned` int(11) NOT NULL DEFAULT 0,
  `isCreatorBanned` int(11) NOT NULL DEFAULT 0,
  `isCommentBanned` int(11) NOT NULL DEFAULT 0,
  `banReason` text NOT NULL DEFAULT '',
  PRIMARY KEY (`userID`),
  KEY `userID` (`userID`),
  KEY `userName` (`userName`),
  KEY `stars` (`stars`),
  KEY `demons` (`demons`),
  KEY `coins` (`coins`),
  KEY `userCoins` (`userCoins`),
  KEY `gameVersion` (`gameVersion`),
  KEY `creatorPoints` (`creatorPoints`),
  KEY `diamonds` (`diamonds`),
  KEY `orbs` (`orbs`),
  KEY `completedLvls` (`completedLvls`),
  KEY `isBanned` (`isBanned`),
  KEY `isCreatorBanned` (`isCreatorBanned`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
