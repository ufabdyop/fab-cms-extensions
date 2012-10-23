-- MySQL dump 10.13  Distrib 5.1.61, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: zenphoto
-- ------------------------------------------------------
-- Server version	5.1.61

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `_admin_to_object`
--

DROP TABLE IF EXISTS `_admin_to_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_admin_to_object` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adminid` int(11) unsigned NOT NULL,
  `objectid` int(11) unsigned NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'album',
  `edit` int(11) DEFAULT '32767',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_admin_to_object`
--

LOCK TABLES `_admin_to_object` WRITE;
/*!40000 ALTER TABLE `_admin_to_object` DISABLE KEYS */;
/*!40000 ALTER TABLE `_admin_to_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_administrators`
--

DROP TABLE IF EXISTS `_administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_administrators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pass` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `rights` int(11) DEFAULT NULL,
  `custom_data` text COLLATE utf8_unicode_ci,
  `valid` int(1) NOT NULL DEFAULT '1',
  `group` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `loggedin` datetime DEFAULT NULL,
  `lastloggedin` datetime DEFAULT NULL,
  `quota` int(11) DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prime_album` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_credentials` text COLLATE utf8_unicode_ci,
  `challenge_phrase` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`,`valid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_administrators`
--

LOCK TABLES `_administrators` WRITE;
/*!40000 ALTER TABLE `_administrators` DISABLE KEYS */;
INSERT INTO `_administrators` VALUES (1,'administrators',NULL,'group',NULL,1961345013,'Users with full privileges',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'viewers',NULL,'group',NULL,2945,'Users allowed only to view zenphoto objects',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'bozos',NULL,'group',NULL,0,'Banned users',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'album managers',NULL,'template',NULL,67386245,'Managers of one or more albums',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'default',NULL,'template',NULL,945,'Default user settings',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'newuser',NULL,'template',NULL,1,'Newly registered and verified users',0,NULL,'2012-10-23 08:59:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'admin','d9ec3f8bfe67922c033f1c71c9ebdeef78574904',NULL,NULL,1961343989,NULL,1,NULL,'2012-04-24 10:03:11','2012-10-23 09:27:31','2012-10-22 12:43:12',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `_administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_albums`
--

DROP TABLE IF EXISTS `_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_albums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` text COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci,
  `date` datetime DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `closecomments` int(1) unsigned NOT NULL DEFAULT '0',
  `commentson` int(1) unsigned NOT NULL DEFAULT '1',
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mtime` int(32) DEFAULT NULL,
  `sort_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subalbum_sort_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) unsigned DEFAULT NULL,
  `image_sortdirection` int(1) unsigned DEFAULT '0',
  `album_sortdirection` int(1) unsigned DEFAULT '0',
  `hitcounter` int(11) unsigned DEFAULT '0',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_hint` text COLLATE utf8_unicode_ci,
  `publishdate` datetime DEFAULT NULL,
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) DEFAULT '0',
  `total_votes` int(11) DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `dynamic` int(1) DEFAULT '0',
  `search_params` text COLLATE utf8_unicode_ci,
  `album_theme` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `watermark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `watermark_thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codeblock` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_albums`
--

LOCK TABLES `_albums` WRITE;
/*!40000 ALTER TABLE `_albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_captcha`
--

DROP TABLE IF EXISTS `_captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_captcha` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ptime` int(32) unsigned NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_captcha`
--

LOCK TABLES `_captcha` WRITE;
/*!40000 ALTER TABLE `_captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `_captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_comments`
--

DROP TABLE IF EXISTS `_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `inmoderation` int(1) unsigned NOT NULL DEFAULT '0',
  `type` varchar(52) COLLATE utf8_unicode_ci DEFAULT 'images',
  `IP` text COLLATE utf8_unicode_ci,
  `private` int(1) DEFAULT '0',
  `anon` int(1) DEFAULT '0',
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `ownerid` (`ownerid`),
  KEY `ownerid_2` (`ownerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_comments`
--

LOCK TABLES `_comments` WRITE;
/*!40000 ALTER TABLE `_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_images`
--

DROP TABLE IF EXISTS `_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `albumid` int(11) unsigned DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` text COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci,
  `location` text COLLATE utf8_unicode_ci,
  `city` tinytext COLLATE utf8_unicode_ci,
  `state` tinytext COLLATE utf8_unicode_ci,
  `country` tinytext COLLATE utf8_unicode_ci,
  `credit` text COLLATE utf8_unicode_ci,
  `copyright` text COLLATE utf8_unicode_ci,
  `commentson` int(1) unsigned NOT NULL DEFAULT '1',
  `show` int(1) NOT NULL DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `sort_order` int(11) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `thumbX` int(10) unsigned DEFAULT NULL,
  `thumbY` int(10) unsigned DEFAULT NULL,
  `thumbW` int(10) unsigned DEFAULT NULL,
  `thumbH` int(10) unsigned DEFAULT NULL,
  `mtime` int(32) DEFAULT NULL,
  `publishdate` datetime DEFAULT NULL,
  `expiredate` datetime DEFAULT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `hasMetadata` int(1) DEFAULT '0',
  `watermark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `watermark_use` int(1) DEFAULT '7',
  `owner` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `codeblock` text COLLATE utf8_unicode_ci,
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `EXIFMake` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFModel` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDescription` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCObjectName` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageHeadline` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageCaption` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageCaptionWriter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTime` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTimeOriginal` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTimeDigitized` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDateCreated` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCTimeCreated` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDigitizeDate` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDigitizeTime` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFArtist` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCImageCredit` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCByLine` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCByLineTitle` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCSource` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCContact` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFCopyright` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCCopyright` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFExposureTime` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFNumber` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFISOSpeedRatings` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFExposureBiasValue` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFMeteringMode` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFlash` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFImageWidth` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFImageHeight` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFOrientation` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFContrast` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSharpness` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSaturation` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFWhiteBalance` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSubjectDistance` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFocalLength` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFLensType` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFLensInfo` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFocalLengthIn35mmFilm` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCCity` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCSubLocation` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCState` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCLocationCode` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCLocationName` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCContentLocationCode` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCContentLocationName` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLatitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLatitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLongitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLongitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSAltitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSAltitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCOriginatingProgram` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCProgramVersion` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoFormat` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoSize` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoArtist` mediumtext COLLATE utf8_unicode_ci,
  `VideoTitle` mediumtext COLLATE utf8_unicode_ci,
  `VideoBitrate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoBitrate_mode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoBits_per_sample` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoCodec` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoCompression_ratio` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoDataformat` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoEncoder` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoSamplerate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoChannelmode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoChannels` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoFramerate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoResolution_x` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoResolution_y` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoAspect_ratio` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoPlaytime` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `XMPrating` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`,`albumid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_images`
--

LOCK TABLES `_images` WRITE;
/*!40000 ALTER TABLE `_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_menu`
--

DROP TABLE IF EXISTS `_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `include_li` int(1) unsigned DEFAULT '1',
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `menuset` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `span_class` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `span_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_menu`
--

LOCK TABLES `_menu` WRITE;
/*!40000 ALTER TABLE `_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_news`
--

DROP TABLE IF EXISTS `_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `extracontent` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentson` int(1) unsigned DEFAULT '0',
  `codeblock` text COLLATE utf8_unicode_ci,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastchange` datetime DEFAULT NULL,
  `lastchangeauthor` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) unsigned NOT NULL DEFAULT '0',
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `sticky` int(1) DEFAULT '0',
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_news`
--

LOCK TABLES `_news` WRITE;
/*!40000 ALTER TABLE `_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_news2cat`
--

DROP TABLE IF EXISTS `_news2cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_news2cat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) unsigned NOT NULL,
  `news_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_news2cat`
--

LOCK TABLES `_news2cat` WRITE;
/*!40000 ALTER TABLE `_news2cat` DISABLE KEYS */;
/*!40000 ALTER TABLE `_news2cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_news_categories`
--

DROP TABLE IF EXISTS `_news_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_news_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci,
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `hitcounter` int(11) unsigned DEFAULT '0',
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `parentid` int(11) DEFAULT NULL,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_news_categories`
--

LOCK TABLES `_news_categories` WRITE;
/*!40000 ALTER TABLE `_news_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `_news_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_obj_to_tag`
--

DROP TABLE IF EXISTS `_obj_to_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_obj_to_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` int(11) unsigned NOT NULL,
  `type` tinytext COLLATE utf8_unicode_ci,
  `objectid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagid` (`tagid`),
  KEY `objectid` (`objectid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_obj_to_tag`
--

LOCK TABLES `_obj_to_tag` WRITE;
/*!40000 ALTER TABLE `_obj_to_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `_obj_to_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_options`
--

DROP TABLE IF EXISTS `_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `theme` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `creator` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_option` (`name`,`ownerid`,`theme`)
) ENGINE=MyISAM AUTO_INCREMENT=403 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_options`
--

LOCK TABLES `_options` WRITE;
/*!40000 ALTER TABLE `_options` DISABLE KEYS */;
INSERT INTO `_options` VALUES (1,0,'zenphoto_version','1.4.3.3 [10902]','',NULL),(2,0,'zenphoto_install','a:5:{s:13:\"functions.php\";i:81992;s:15:\"SERVER_SOFTWARE\";s:22:\"Apache/2.2.15 (CentOS)\";s:8:\"ZENPHOTO\";s:14:\"1.4.3.3[10902]\";s:6:\"FOLDER\";s:22:\"/var/www/html/zenphoto\";s:8:\"DATABASE\";s:12:\"MySql 5.1.61\";}','',NULL),(6,0,'extra_auth_hash_text','P#w{MX1uAK(q%_D9nr}J2LU6a^!]eR','','zp-core/setup/setup-option-defaults.php'),(4,0,'libauth_version','3','',NULL),(5,0,'strong_hash','1','','zp-core/lib-auth.php'),(7,0,'password_strength','10','','zp-core/setup/setup-option-defaults.php'),(8,0,'min_password_lenght','6','','zp-core/setup/setup-option-defaults.php'),(9,0,'user_album_edit_default','1','','zp-core/setup/setup-option-defaults.php'),(10,0,'time_offset','0','','zp-core/setup/setup-option-defaults.php'),(11,0,'mod_rewrite_image_suffix','.php','','zp-core/setup/setup-option-defaults.php'),(12,0,'server_protocol','http','','zp-core/setup/setup-option-defaults.php'),(13,0,'charset','UTF-8','','zp-core/setup/setup-option-defaults.php'),(14,0,'image_quality','85','','zp-core/setup/setup-option-defaults.php'),(15,0,'thumb_quality','75','','zp-core/setup/setup-option-defaults.php'),(16,0,'search_password','','','zp-core/setup/setup-option-defaults.php'),(17,0,'search_hint',NULL,'','zp-core/setup/setup-option-defaults.php'),(18,0,'watermark_h_offset','90','','zp-core/setup/setup-option-defaults.php'),(19,0,'watermark_w_offset','90','','zp-core/setup/setup-option-defaults.php'),(20,0,'watermark_scale','5','','zp-core/setup/setup-option-defaults.php'),(21,0,'watermark_allow_upscale','1','','zp-core/setup/setup-option-defaults.php'),(22,0,'perform_video_watermark','0','','zp-core/setup/setup-option-defaults.php'),(23,0,'spam_filter','none','','zp-core/setup/setup-option-defaults.php'),(24,0,'email_new_comments','1','','zp-core/setup/setup-option-defaults.php'),(25,0,'image_sorttype','Filename','','zp-core/setup/setup-option-defaults.php'),(26,0,'image_sortdirection','0','','zp-core/setup/setup-option-defaults.php'),(27,0,'hotlink_protection','1','','zp-core/setup/setup-option-defaults.php'),(28,0,'feed_items','10','','zp-core/setup/setup-option-defaults.php'),(29,0,'feed_imagesize','240','','zp-core/setup/setup-option-defaults.php'),(30,0,'feed_sortorder','latest','','zp-core/setup/setup-option-defaults.php'),(31,0,'feed_items_albums','10','','zp-core/setup/setup-option-defaults.php'),(32,0,'feed_imagesize_albums','240','','zp-core/setup/setup-option-defaults.php'),(33,0,'feed_sortorder_albums','latest','','zp-core/setup/setup-option-defaults.php'),(34,0,'feed_enclosure','0','','zp-core/setup/setup-option-defaults.php'),(35,0,'feed_mediarss','0','','zp-core/setup/setup-option-defaults.php'),(36,0,'feed_cache','1','','zp-core/setup/setup-option-defaults.php'),(37,0,'feed_cache_expire','86400','','zp-core/setup/setup-option-defaults.php'),(38,0,'feed_hitcounter','1','','zp-core/setup/setup-option-defaults.php'),(39,0,'feed_title','both','','zp-core/setup/setup-option-defaults.php'),(40,0,'search_fields','title,desc,tags,file,location,city,state,country,content,author','','zp-core/setup/setup-option-defaults.php'),(41,0,'allowed_tags_default','a => (href =>() title =>() target=>() class=>() id=>())\nabbr =>(class=>() id=>() title =>())\nacronym =>(class=>() id=>() title =>())\nb => (class=>() id=>() )\nblockquote =>(class=>() id=>() cite =>())\nbr => (class=>() id=>() )\ncode => (class=>() id=>() )\nem => (class=>() id=>() )\ni => (class=>() id=>() ) \nstrike => (class=>() id=>() )\nstrong => (class=>() id=>() )\nul => (class=>() id=>())\nol => (class=>() id=>())\nli => (class=>() id=>())\np => (class=>() id=>() style=>())\nh1=>(class=>() id=>() style=>())\nh2=>(class=>() id=>() style=>())\nh3=>(class=>() id=>() style=>())\nh4=>(class=>() id=>() style=>())\nh5=>(class=>() id=>() style=>())\nh6=>(class=>() id=>() style=>())\npre=>(class=>() id=>() style=>())\naddress=>(class=>() id=>() style=>())\nspan=>(class=>() id=>() style=>())\ndiv=>(class=>() id=>() style=>())\nimg=>(class=>() id=>() style=>() src=>() title=>() alt=>() width=>() height=>())\n','',NULL),(42,0,'allowed_tags','a => (href =>() title =>() target=>() class=>() id=>())\nabbr =>(class=>() id=>() title =>())\nacronym =>(class=>() id=>() title =>())\nb => (class=>() id=>() )\nblockquote =>(class=>() id=>() cite =>())\nbr => (class=>() id=>() )\ncode => (class=>() id=>() )\nem => (class=>() id=>() )\ni => (class=>() id=>() ) \nstrike => (class=>() id=>() )\nstrong => (class=>() id=>() )\nul => (class=>() id=>())\nol => (class=>() id=>())\nli => (class=>() id=>())\np => (class=>() id=>() style=>())\nh1=>(class=>() id=>() style=>())\nh2=>(class=>() id=>() style=>())\nh3=>(class=>() id=>() style=>())\nh4=>(class=>() id=>() style=>())\nh5=>(class=>() id=>() style=>())\nh6=>(class=>() id=>() style=>())\npre=>(class=>() id=>() style=>())\naddress=>(class=>() id=>() style=>())\nspan=>(class=>() id=>() style=>())\ndiv=>(class=>() id=>() style=>())\nimg=>(class=>() id=>() style=>() src=>() title=>() alt=>() width=>() height=>())\n','','zp-core/setup/setup-option-defaults.php'),(43,0,'style_tags','abbr => (title => ())\nacronym => (title => ())\nb => ()\nem => ()\ni => () \nstrike => ()\nstrong => ()\n','','zp-core/setup/setup-option-defaults.php'),(44,0,'comment_name_required','1','','zp-core/setup/setup-option-defaults.php'),(45,0,'comment_email_required','1','','zp-core/setup/setup-option-defaults.php'),(46,0,'comment_web_required','show','','zp-core/setup/setup-option-defaults.php'),(47,0,'Use_Captcha','','','zp-core/setup/setup-option-defaults.php'),(48,0,'full_image_quality','75','','zp-core/setup/setup-option-defaults.php'),(49,0,'protect_full_image','Protected view','','zp-core/setup/setup-option-defaults.php'),(50,0,'locale','','','zp-core/setup/setup-option-defaults.php'),(51,0,'date_format','%x','','zp-core/setup/setup-option-defaults.php'),(52,0,'zp_plugin_colorbox_js','137','','zp-core/setup/setup-option-defaults.php'),(53,0,'zp_plugin_class-video','4105','','zp-core/setup/setup-option-defaults.php'),(54,0,'use_lock_image','1','','zp-core/setup/setup-option-defaults.php'),(55,0,'search_user','','','zp-core/setup/setup-option-defaults.php'),(56,0,'multi_lingual','0','','zp-core/setup/setup-option-defaults.php'),(57,0,'tagsort','0','','zp-core/setup/setup-option-defaults.php'),(58,0,'albumimagesort','ID','','zp-core/setup/setup-option-defaults.php'),(59,0,'albumimagedirection','DESC','','zp-core/setup/setup-option-defaults.php'),(60,0,'cache_full_image','0','','zp-core/setup/setup-option-defaults.php'),(61,0,'custom_index_page','','','zp-core/setup/setup-option-defaults.php'),(62,0,'picture_of_the_day','a:3:{s:3:\"day\";N;s:6:\"folder\";N;s:8:\"filename\";N;}','','zp-core/setup/setup-option-defaults.php'),(63,0,'exact_tag_match','0','','zp-core/setup/setup-option-defaults.php'),(64,0,'EXIFMake','1','','zp-core/setup/setup-option-defaults.php'),(65,0,'EXIFModel','1','','zp-core/setup/setup-option-defaults.php'),(66,0,'EXIFExposureTime','1','','zp-core/setup/setup-option-defaults.php'),(67,0,'EXIFFNumber','1','','zp-core/setup/setup-option-defaults.php'),(68,0,'EXIFFocalLength','1','','zp-core/setup/setup-option-defaults.php'),(69,0,'EXIFISOSpeedRatings','1','','zp-core/setup/setup-option-defaults.php'),(70,0,'EXIFDateTimeOriginal','1','','zp-core/setup/setup-option-defaults.php'),(71,0,'EXIFExposureBiasValue','1','','zp-core/setup/setup-option-defaults.php'),(72,0,'EXIFMeteringMode','1','','zp-core/setup/setup-option-defaults.php'),(73,0,'EXIFFlash','1','','zp-core/setup/setup-option-defaults.php'),(74,0,'EXIFDescription','0','','zp-core/setup/setup-option-defaults.php'),(75,0,'IPTCObjectName','0','','zp-core/setup/setup-option-defaults.php'),(76,0,'IPTCImageHeadline','0','','zp-core/setup/setup-option-defaults.php'),(77,0,'IPTCImageCaption','0','','zp-core/setup/setup-option-defaults.php'),(78,0,'IPTCImageCaptionWriter','0','','zp-core/setup/setup-option-defaults.php'),(79,0,'EXIFDateTime','0','','zp-core/setup/setup-option-defaults.php'),(80,0,'EXIFDateTimeDigitized','0','','zp-core/setup/setup-option-defaults.php'),(81,0,'IPTCDateCreated','0','','zp-core/setup/setup-option-defaults.php'),(82,0,'IPTCTimeCreated','0','','zp-core/setup/setup-option-defaults.php'),(83,0,'IPTCDigitizeDate','0','','zp-core/setup/setup-option-defaults.php'),(84,0,'IPTCDigitizeTime','0','','zp-core/setup/setup-option-defaults.php'),(85,0,'EXIFArtist','0','','zp-core/setup/setup-option-defaults.php'),(86,0,'IPTCImageCredit','0','','zp-core/setup/setup-option-defaults.php'),(87,0,'IPTCByLine','0','','zp-core/setup/setup-option-defaults.php'),(88,0,'IPTCByLineTitle','0','','zp-core/setup/setup-option-defaults.php'),(89,0,'IPTCSource','0','','zp-core/setup/setup-option-defaults.php'),(90,0,'IPTCContact','0','','zp-core/setup/setup-option-defaults.php'),(91,0,'EXIFCopyright','0','','zp-core/setup/setup-option-defaults.php'),(92,0,'IPTCCopyright','0','','zp-core/setup/setup-option-defaults.php'),(93,0,'IPTCKeywords','0','','zp-core/setup/setup-option-defaults.php'),(94,0,'EXIFImageWidth','0','','zp-core/setup/setup-option-defaults.php'),(95,0,'EXIFImageHeight','0','','zp-core/setup/setup-option-defaults.php'),(96,0,'EXIFOrientation','0','','zp-core/setup/setup-option-defaults.php'),(97,0,'EXIFContrast','0','','zp-core/setup/setup-option-defaults.php'),(98,0,'EXIFSharpness','0','','zp-core/setup/setup-option-defaults.php'),(99,0,'EXIFSaturation','0','','zp-core/setup/setup-option-defaults.php'),(100,0,'EXIFWhiteBalance','0','','zp-core/setup/setup-option-defaults.php'),(101,0,'EXIFSubjectDistance','0','','zp-core/setup/setup-option-defaults.php'),(102,0,'EXIFLensType','0','','zp-core/setup/setup-option-defaults.php'),(103,0,'EXIFLensInfo','0','','zp-core/setup/setup-option-defaults.php'),(104,0,'EXIFFocalLengthIn35mmFilm','0','','zp-core/setup/setup-option-defaults.php'),(105,0,'IPTCCity','0','','zp-core/setup/setup-option-defaults.php'),(106,0,'IPTCSubLocation','0','','zp-core/setup/setup-option-defaults.php'),(107,0,'IPTCState','0','','zp-core/setup/setup-option-defaults.php'),(108,0,'IPTCLocationCode','0','','zp-core/setup/setup-option-defaults.php'),(109,0,'IPTCLocationName','0','','zp-core/setup/setup-option-defaults.php'),(110,0,'IPTCContentLocationCode','0','','zp-core/setup/setup-option-defaults.php'),(111,0,'IPTCContentLocationName','0','','zp-core/setup/setup-option-defaults.php'),(112,0,'EXIFGPSLatitude','0','','zp-core/setup/setup-option-defaults.php'),(113,0,'EXIFGPSLatitudeRef','0','','zp-core/setup/setup-option-defaults.php'),(114,0,'EXIFGPSLongitude','0','','zp-core/setup/setup-option-defaults.php'),(115,0,'EXIFGPSLongitudeRef','0','','zp-core/setup/setup-option-defaults.php'),(116,0,'EXIFGPSAltitude','0','','zp-core/setup/setup-option-defaults.php'),(117,0,'EXIFGPSAltitudeRef','0','','zp-core/setup/setup-option-defaults.php'),(118,0,'IPTCOriginatingProgram','0','','zp-core/setup/setup-option-defaults.php'),(119,0,'IPTCProgramVersion','0','','zp-core/setup/setup-option-defaults.php'),(120,0,'VideoFormat','0','','zp-core/setup/setup-option-defaults.php'),(121,0,'VideoSize','0','','zp-core/setup/setup-option-defaults.php'),(122,0,'VideoArtist','0','','zp-core/setup/setup-option-defaults.php'),(123,0,'VideoTitle','0','','zp-core/setup/setup-option-defaults.php'),(124,0,'VideoBitrate','0','','zp-core/setup/setup-option-defaults.php'),(125,0,'VideoBitrate_mode','0','','zp-core/setup/setup-option-defaults.php'),(126,0,'VideoBits_per_sample','0','','zp-core/setup/setup-option-defaults.php'),(127,0,'VideoCodec','0','','zp-core/setup/setup-option-defaults.php'),(128,0,'VideoCompression_ratio','0','','zp-core/setup/setup-option-defaults.php'),(129,0,'VideoDataformat','0','','zp-core/setup/setup-option-defaults.php'),(130,0,'VideoEncoder','0','','zp-core/setup/setup-option-defaults.php'),(131,0,'VideoSamplerate','0','','zp-core/setup/setup-option-defaults.php'),(132,0,'VideoChannelmode','0','','zp-core/setup/setup-option-defaults.php'),(133,0,'VideoChannels','0','','zp-core/setup/setup-option-defaults.php'),(134,0,'VideoFramerate','0','','zp-core/setup/setup-option-defaults.php'),(135,0,'VideoResolution_x','0','','zp-core/setup/setup-option-defaults.php'),(136,0,'VideoResolution_y','0','','zp-core/setup/setup-option-defaults.php'),(137,0,'VideoAspect_ratio','0','','zp-core/setup/setup-option-defaults.php'),(138,0,'VideoPlaytime','0','','zp-core/setup/setup-option-defaults.php'),(139,0,'XMPrating','0','','zp-core/setup/setup-option-defaults.php'),(140,0,'IPTC_encoding','ISO-8859-1','','zp-core/setup/setup-option-defaults.php'),(141,0,'UTF8_image_URI','0','','zp-core/setup/setup-option-defaults.php'),(142,0,'captcha','zenphoto','','zp-core/setup/setup-option-defaults.php'),(143,0,'sharpen_amount','40','','zp-core/setup/setup-option-defaults.php'),(144,0,'sharpen_radius','0.5','','zp-core/setup/setup-option-defaults.php'),(145,0,'sharpen_threshold','3','','zp-core/setup/setup-option-defaults.php'),(164,0,'zp_plugin_seo_zenphoto','2053','','zp-core/setup/setup-option-defaults.php'),(147,0,'search_no_albums','0','','zp-core/setup/setup-option-defaults.php'),(148,0,'defined_groups','a:6:{i:0;s:14:\"administrators\";i:1;s:7:\"viewers\";i:2;s:5:\"bozos\";i:3;s:14:\"album managers\";i:4;s:7:\"default\";i:5;s:7:\"newuser\";}','',NULL),(149,0,'comment_body_requiired','1','','zp-core/setup/setup-option-defaults.php'),(150,0,'zp_plugin_zenphoto_sendmail','4101','','zp-core/setup/setup-option-defaults.php'),(151,0,'RSS_album_image','1','','zp-core/setup/setup-option-defaults.php'),(152,0,'RSS_comments','1','','zp-core/setup/setup-option-defaults.php'),(153,0,'RSS_articles','1','','zp-core/setup/setup-option-defaults.php'),(154,0,'RSS_article_comments','1','','zp-core/setup/setup-option-defaults.php'),(155,0,'AlbumThumbSelect','1','','zp-core/setup/setup-option-defaults.php'),(156,0,'site_email','zenphoto@localhost','','zp-core/setup/setup-option-defaults.php'),(157,0,'site_email_name','Zenphoto','','zp-core/setup/setup-option-defaults.php'),(158,0,'Zenphoto_theme_list','a:6:{i:0;s:7:\"default\";i:27;s:18:\"effervescence_plus\";i:91;s:7:\"garland\";i:142;s:10:\"stopdesign\";i:214;s:7:\"zenpage\";i:251;s:8:\"zpmobile\";}','',NULL),(159,0,'zp_plugin_deprecated-functions','4105','',NULL),(160,0,'zp_plugin_zenphoto_news','2055','','zp-core/setup/setup-option-defaults.php'),(161,0,'zp_plugin_hitcounter','2181','','zp-core/setup/setup-option-defaults.php'),(162,0,'zp_plugin_tiny_mce','2053','','zp-core/setup/setup-option-defaults.php'),(163,0,'zp_plugin_security-logger','4106','','zp-core/setup/setup-option-defaults.php'),(165,0,'default_copyright','Copyright 2012: localhost:8080','','zp-core/setup/setup-option-defaults.php'),(166,0,'fullsizeimage_watermark',NULL,'','zp-core/setup/setup-option-defaults.php'),(167,0,'gallery_page_unprotected_register','1','','zp-core/setup/setup-option-defaults.php'),(168,0,'gallery_page_unprotected_contact','1','','zp-core/setup/setup-option-defaults.php'),(169,0,'gallery_data','a:18:{s:21:\"gallery_sortdirection\";i:0;s:16:\"gallery_sorttype\";s:2:\"ID\";s:13:\"gallery_title\";s:388:\"a:14:{s:5:\"en_US\";s:7:\"Gallery\";s:5:\"zh_CN\";s:6:\"相馆\";s:5:\"zh_TW\";s:6:\"相館\";s:5:\"nl_NL\";s:7:\"Galerij\";s:5:\"fr_FR\";s:7:\"Galerie\";s:5:\"gl_ES\";s:8:\"Galería\";s:5:\"de_DE\";s:7:\"Galerie\";s:5:\"he_IL\";s:12:\"גלרייה\";s:5:\"it_IT\";s:8:\"Galleria\";s:5:\"ja_JP\";s:15:\"ギャラリー\";s:5:\"pl_PL\";s:7:\"Galeria\";s:5:\"sk_SK\";s:8:\"Galéria\";s:5:\"es_ES\";s:8:\"Galería\";s:5:\"sv_SE\";s:7:\"Galleri\";}\";s:19:\"Gallery_description\";s:955:\"a:9:{s:5:\"en_US\";s:73:\"You can insert your Gallery description on the Admin Options Gallery tab.\";s:5:\"zh_TW\";s:72:\"可在管理區設定頁的「相館」分頁輸入您的相館描述。\";s:5:\"nl_NL\";s:53:\"Hier kun je een beschrijving van de galerij invoeren.\";s:5:\"fr_FR\";s:102:\"Vous pouvez saisir la description de votre galerie dans l’onglet « Options d’administration ».\";s:5:\"gl_ES\";s:105:\"Podes inserir a descrición da túa Galería usando a pestana de Opcións de Administración da Galería.\";s:5:\"de_DE\";s:68:\"Sie können Ihre Galeriebeschreibung bei den Einstellungen eingeben.\";s:5:\"it_IT\";s:107:\"È possibile inserire la descrizione della galleria usando la scheda Opzioni galleria nell\'amministrazione.\";s:5:\"ja_JP\";s:108:\"管理オプションのギャラリータブを使用してギャラリーの説明を挿入できます。\";s:5:\"sk_SK\";s:77:\"Popis galérie môžete upraviť v záložke administrátorských nastavení.\";}\";s:16:\"gallery_password\";N;s:12:\"gallery_user\";N;s:12:\"gallery_hint\";N;s:10:\"hitcounter\";N;s:13:\"current_theme\";s:7:\"default\";s:13:\"website_title\";N;s:11:\"website_url\";N;s:16:\"gallery_security\";s:6:\"public\";s:16:\"login_user_field\";N;s:24:\"album_use_new_image_date\";N;s:19:\"thumb_select_images\";N;s:17:\"unprotected_pages\";s:43:\"a:2:{i:0;s:8:\"register\";i:1;s:7:\"contact\";}\";s:13:\"album_publish\";i:1;s:13:\"image_publish\";i:1;}','',NULL),(170,0,'search_cache_duration','30','','zp-core/setup/setup-option-defaults.php'),(171,0,'search_within','1','','zp-core/setup/setup-option-defaults.php'),(172,0,'last_update_check','30','',NULL),(173,0,'zp_plugin_zenphotoDonate','2057','','zp-core/setup/setup-option-defaults.php'),(174,0,'zp_plugin_uploader_http','2053','','zp-core/setup/setup-option-defaults.php'),(175,0,'zp_plugin_uploader_flash','2053','','zp-core/setup/setup-option-defaults.php'),(176,0,'zp_plugin_uploader_jQuery','2053','','zp-core/setup/setup-option-defaults.php'),(177,0,'zp_plugin_ipBlocker',NULL,'','zp-core/setup/setup-option-defaults.php'),(178,0,'spamFilter_none_action',NULL,'',NULL),(179,0,'zp_plugin_class-video_mov_w','520','','zp-core/zp-extensions/class-video.php'),(180,0,'zp_plugin_class-video_mov_h','390','','zp-core/zp-extensions/class-video.php'),(181,0,'zp_plugin_class-video_3gp_w','520','','zp-core/zp-extensions/class-video.php'),(182,0,'zp_plugin_class-video_3gp_h','390','','zp-core/zp-extensions/class-video.php'),(183,0,'zp_plugin_class-video_videoalt','ogg, avi, wmv','','zp-core/zp-extensions/class-video.php'),(184,0,'deprecated_getZenpageHitcounter','1','','zp-core/zp-extensions/deprecated-functions.php'),(185,0,'deprecated_printImageRating','1','','zp-core/zp-extensions/deprecated-functions.php'),(186,0,'deprecated_printAlbumRating','1','','zp-core/zp-extensions/deprecated-functions.php'),(187,0,'deprecated_printImageEXIFData','1','','zp-core/zp-extensions/deprecated-functions.php'),(188,0,'deprecated_printCustomSizedImageMaxHeight','1','','zp-core/zp-extensions/deprecated-functions.php'),(189,0,'deprecated_getCommentDate','1','','zp-core/zp-extensions/deprecated-functions.php'),(190,0,'deprecated_getCommentTime','1','','zp-core/zp-extensions/deprecated-functions.php'),(191,0,'deprecated_hitcounter','1','','zp-core/zp-extensions/deprecated-functions.php'),(192,0,'deprecated_my_truncate_string','1','','zp-core/zp-extensions/deprecated-functions.php'),(193,0,'deprecated_getImageEXIFData','1','','zp-core/zp-extensions/deprecated-functions.php'),(194,0,'deprecated_zenpageHitcounter','1','','zp-core/zp-extensions/deprecated-functions.php'),(195,0,'deprecated_getAlbumPlace','1','','zp-core/zp-extensions/deprecated-functions.php'),(196,0,'deprecated_printAlbumPlace','1','','zp-core/zp-extensions/deprecated-functions.php'),(197,0,'deprecated_printEditable','1','','zp-core/zp-extensions/deprecated-functions.php'),(198,0,'deprecated_rewrite_path_zenpage','1','','zp-core/zp-extensions/deprecated-functions.php'),(199,0,'deprecated_getNewsImageTags','1','','zp-core/zp-extensions/deprecated-functions.php'),(200,0,'deprecated_printNewsImageTags','1','','zp-core/zp-extensions/deprecated-functions.php'),(201,0,'deprecated_getNumSubalbums','1','','zp-core/zp-extensions/deprecated-functions.php'),(202,0,'deprecated_getAllSubalbums','1','','zp-core/zp-extensions/deprecated-functions.php'),(203,0,'deprecated_addPluginScript','1','','zp-core/zp-extensions/deprecated-functions.php'),(204,0,'deprecated_zenJavascript','1','','zp-core/zp-extensions/deprecated-functions.php'),(205,0,'deprecated_normalizeColumns','1','','zp-core/zp-extensions/deprecated-functions.php'),(206,0,'deprecated_printParentPagesBreadcrumb','1','','zp-core/zp-extensions/deprecated-functions.php'),(207,0,'deprecated_isMyAlbum','1','','zp-core/zp-extensions/deprecated-functions.php'),(208,0,'deprecated_getSubCategories','1','','zp-core/zp-extensions/deprecated-functions.php'),(209,0,'deprecated_inProtectedNewsCategory','1','','zp-core/zp-extensions/deprecated-functions.php'),(210,0,'deprecated_isProtectedNewsCategory','1','','zp-core/zp-extensions/deprecated-functions.php'),(211,0,'deprecated_getParentNewsCategories','1','','zp-core/zp-extensions/deprecated-functions.php'),(212,0,'deprecated_getCategoryTitle','1','','zp-core/zp-extensions/deprecated-functions.php'),(213,0,'deprecated_getCategoryID','1','','zp-core/zp-extensions/deprecated-functions.php'),(214,0,'deprecated_getCategoryParentID','1','','zp-core/zp-extensions/deprecated-functions.php'),(215,0,'deprecated_getCategorySortOrder','1','','zp-core/zp-extensions/deprecated-functions.php'),(216,0,'deprecated_getParentPages','1','','zp-core/zp-extensions/deprecated-functions.php'),(217,0,'deprecated_isProtectedPage','1','','zp-core/zp-extensions/deprecated-functions.php'),(218,0,'deprecated_isMyPage','1','','zp-core/zp-extensions/deprecated-functions.php'),(219,0,'deprecated_checkPagePassword','1','','zp-core/zp-extensions/deprecated-functions.php'),(220,0,'deprecated_isMyNews','1','','zp-core/zp-extensions/deprecated-functions.php'),(221,0,'deprecated_checkNewsAccess','1','','zp-core/zp-extensions/deprecated-functions.php'),(222,0,'deprecated_checkNewsCategoryPassword','1','','zp-core/zp-extensions/deprecated-functions.php'),(223,0,'deprecated_getCurrentNewsCategory','1','','zp-core/zp-extensions/deprecated-functions.php'),(224,0,'deprecated_getCurrentNewsCategoryID','1','','zp-core/zp-extensions/deprecated-functions.php'),(225,0,'deprecated_getCurrentNewsCategoryParentID','1','','zp-core/zp-extensions/deprecated-functions.php'),(226,0,'deprecated_inNewsCategory','1','','zp-core/zp-extensions/deprecated-functions.php'),(227,0,'deprecated_inSubNewsCategoryOf','1','','zp-core/zp-extensions/deprecated-functions.php'),(228,0,'deprecated_isSubNewsCategoryOf','1','','zp-core/zp-extensions/deprecated-functions.php'),(229,0,'deprecated_printNewsReadMoreLink','1','','zp-core/zp-extensions/deprecated-functions.php'),(230,0,'deprecated_getNewsContentShorten','1','','zp-core/zp-extensions/deprecated-functions.php'),(231,0,'deprecated_checkForPassword','1','','zp-core/zp-extensions/deprecated-functions.php'),(232,0,'deprecated_printAlbumMap','1','','zp-core/zp-extensions/deprecated-functions.php'),(233,0,'deprecated_printImageMap','1','','zp-core/zp-extensions/deprecated-functions.php'),(234,0,'deprecated_setupAllowedMaps','1','','zp-core/zp-extensions/deprecated-functions.php'),(235,0,'deprecated_printPreloadScript','1','','zp-core/zp-extensions/deprecated-functions.php'),(236,0,'deprecated_processExpired','1','','zp-core/zp-extensions/deprecated-functions.php'),(237,0,'deprecated_getParentItems','1','','zp-core/zp-extensions/deprecated-functions.php'),(238,0,'deprecated_getPages','1','','zp-core/zp-extensions/deprecated-functions.php'),(239,0,'deprecated_getArticles','1','','zp-core/zp-extensions/deprecated-functions.php'),(240,0,'deprecated_countArticles','1','','zp-core/zp-extensions/deprecated-functions.php'),(241,0,'deprecated_getTotalArticles','1','','zp-core/zp-extensions/deprecated-functions.php'),(242,0,'deprecated_getAllArticleDates','1','','zp-core/zp-extensions/deprecated-functions.php'),(243,0,'deprecated_getCurrentNewsPage','1','','zp-core/zp-extensions/deprecated-functions.php'),(244,0,'deprecated_getCombiNews','1','','zp-core/zp-extensions/deprecated-functions.php'),(245,0,'deprecated_countCombiNews','1','','zp-core/zp-extensions/deprecated-functions.php'),(246,0,'deprecated_getCategoryLink','1','','zp-core/zp-extensions/deprecated-functions.php'),(247,0,'deprecated_getCategory','1','','zp-core/zp-extensions/deprecated-functions.php'),(248,0,'deprecated_getAllCategories','1','','zp-core/zp-extensions/deprecated-functions.php'),(249,0,'deprecated_isProtectedAlbum','1','','zp-core/zp-extensions/deprecated-functions.php'),(250,0,'deprecated_getRSSHeaderLink','1','','zp-core/zp-extensions/deprecated-functions.php'),(251,0,'deprecated_getZenpageRSSHeaderLink','1','','zp-core/zp-extensions/deprecated-functions.php'),(252,0,'deprecated_generateCaptcha','1','','zp-core/zp-extensions/deprecated-functions.php'),(253,0,'deprecated_printAlbumZip','1','','zp-core/zp-extensions/deprecated-functions.php'),(254,0,'deprecated_printImageDiv','1','','zp-core/zp-extensions/deprecated-functions.php'),(255,0,'deprecated_getImageID','1','','zp-core/zp-extensions/deprecated-functions.php'),(256,0,'deprecated_printImageID','1','','zp-core/zp-extensions/deprecated-functions.php'),(257,0,'deprecated_getAlbumId','1','','zp-core/zp-extensions/deprecated-functions.php'),(258,0,'deprecated_resetCurrentAlbum','1','','zp-core/zp-extensions/deprecated-functions.php'),(259,0,'deprecated_setAlbumCustomData','1','','zp-core/zp-extensions/deprecated-functions.php'),(260,0,'deprecated_setImageCustomData','1','','zp-core/zp-extensions/deprecated-functions.php'),(261,0,'deprecated_getImageSortOrder','1','','zp-core/zp-extensions/deprecated-functions.php'),(262,0,'deprecated_printImageSortOrder','1','','zp-core/zp-extensions/deprecated-functions.php'),(263,0,'deprecated_getFirstImageURL','1','','zp-core/zp-extensions/deprecated-functions.php'),(264,0,'deprecated_getLastImageURL','1','','zp-core/zp-extensions/deprecated-functions.php'),(265,0,'deprecated_getSearchURL','1','','zp-core/zp-extensions/deprecated-functions.php'),(266,0,'deprecated_printPasswordForm','1','','zp-core/zp-extensions/deprecated-functions.php'),(267,0,'logger_log_guests','1','','zp-core/zp-extensions/security-logger.php'),(268,0,'logger_log_admin','1','','zp-core/zp-extensions/security-logger.php'),(269,0,'logger_log_type','all','','zp-core/zp-extensions/security-logger.php'),(270,0,'zenphoto_news_length','0','','zp-core/zp-extensions/zenphoto_news.php'),(271,0,'tinymce_zenphoto','zenphoto-default.js.php','','zp-core/zp-extensions/tiny_mce.php'),(272,0,'tinymce_zenpage','zenpage-default-full.js.php','','zp-core/zp-extensions/tiny_mce.php'),(273,0,'tinymce_tinyzenpage_customimagesize','400','','zp-core/zp-extensions/tiny_mce.php'),(274,0,'tinymce_tinyzenpage_customthumb_size','120','','zp-core/zp-extensions/tiny_mce.php'),(275,0,'tinymce_tinyzenpage_customthumb_cropwidth','120','','zp-core/zp-extensions/tiny_mce.php'),(276,0,'tinymce_tinyzenpage_customthumb_cropheight','120','','zp-core/zp-extensions/tiny_mce.php'),(277,0,'tinymce_tinyzenpage_flowplayer_width','320','','zp-core/zp-extensions/tiny_mce.php'),(278,0,'tinymce_tinyzenpage_flowplayer_height','240','','zp-core/zp-extensions/tiny_mce.php'),(279,0,'tinymce_tinyzenpage_flowplayer_mp3_height','26','','zp-core/zp-extensions/tiny_mce.php'),(280,0,'zenphoto_seo_lowercase','1','','zp-core/zp-extensions/seo_zenphoto.php'),(281,0,'colorbox_theme','example1','','zp-core/zp-extensions/colorbox_js.php'),(282,0,'hitcounter_ignoreIPList_enable','0','','zp-core/zp-extensions/hitcounter.php'),(283,0,'hitcounter_ignoreSearchCrawlers_enable','0','','zp-core/zp-extensions/hitcounter.php'),(284,0,'hitcounter_ignoreIPList','','','zp-core/zp-extensions/hitcounter.php'),(285,0,'hitcounter_searchCrawlerList','Teoma,alexa, froogle, Gigabot,inktomi, looksmart, URL_Spider_SQL,Firefly, NationalDirectory, Ask Jeeves,TECNOSEEK, InfoSeek, WebFindBot, girafabot, crawler,www.galaxy.com, Googlebot, Scooter, Slurp, msnbot, appie, FAST, WebBug, Spade, ZyBorg, rabaz ,Baiduspider, Feedfetcher-Google, TechnoratiSnoop, Rankivabot, Mediapartners-Google, Sogou web spider, WebAlta Crawler','','zp-core/zp-extensions/hitcounter.php'),(286,0,'zenphoto_captcha_length','5','','zp-core/zp-extensions/captcha/zenphoto.php'),(287,0,'zenphoto_captcha_key','740ced61b8e73f2d88634fed5baaadc2dac28c92','','zp-core/zp-extensions/captcha/zenphoto.php'),(288,0,'zenphoto_captcha_string','abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ','','zp-core/zp-extensions/captcha/zenphoto.php'),(289,0,'Theme_logo','','effervescence_plus','themes/effervescence_plus'),(290,0,'Allow_search','1','effervescence_plus','themes/effervescence_plus'),(291,0,'Slideshow','1','effervescence_plus','themes/effervescence_plus'),(292,0,'Graphic_logo','*','effervescence_plus','themes/effervescence_plus'),(293,0,'Watermark_head_image','1','effervescence_plus','themes/effervescence_plus'),(294,0,'Theme_personality','image_page','effervescence_plus','themes/effervescence_plus'),(295,0,'effervescence_transition','slide-hori','effervescence_plus','themes/effervescence_plus'),(296,0,'effervescence_caption_location','image','effervescence_plus','themes/effervescence_plus'),(297,0,'Theme_colors','kish-my father','effervescence_plus','themes/effervescence_plus'),(298,0,'effervescence_menu','','effervescence_plus','themes/effervescence_plus'),(299,0,'albums_per_page','9','effervescence_plus','themes/effervescence_plus'),(300,0,'albums_per_row','3','effervescence_plus','themes/effervescence_plus'),(301,0,'images_per_page','20','effervescence_plus','themes/effervescence_plus'),(302,0,'images_per_row','5','effervescence_plus','themes/effervescence_plus'),(303,0,'image_size','595','effervescence_plus','themes/effervescence_plus'),(304,0,'image_use_side','longest','effervescence_plus','themes/effervescence_plus'),(305,0,'thumb_transition','1','effervescence_plus','themes/effervescence_plus'),(306,0,'thumb_size','100','effervescence_plus','themes/effervescence_plus'),(307,0,'thumb_crop_width','100','effervescence_plus','themes/effervescence_plus'),(308,0,'thumb_crop_height','100','effervescence_plus','themes/effervescence_plus'),(309,0,'thumb_crop','1','effervescence_plus','themes/effervescence_plus'),(310,0,'effervescence_daily_album_image','1','effervescence_plus','themes/effervescence_plus'),(311,0,'effervescence_daily_album_image_effect','','effervescence_plus','themes/effervescence_plus'),(312,0,'colorbox_effervescence_plus_album','1','','themes/effervescence_plus/themeoptions.php'),(313,0,'colorbox_effervescence_plus_image','1','','themes/effervescence_plus/themeoptions.php'),(314,0,'colorbox_effervescence_plus_search','1','','themes/effervescence_plus/themeoptions.php'),(315,0,'Allow_search','1','zpmobile','themes/zpmobile'),(316,0,'Allow_search','1','stopdesign','themes/stopdesign'),(317,0,'Mini_slide_selector','Recent images','stopdesign','themes/stopdesign'),(318,0,'albums_per_page','9','stopdesign','themes/stopdesign'),(319,0,'albums_per_row','3','stopdesign','themes/stopdesign'),(320,0,'images_per_page','24','stopdesign','themes/stopdesign'),(321,0,'Allow_search','1','garland','themes/garland'),(322,0,'zenpage_zp_index_news','','zenpage','themes/zenpage'),(323,0,'Allow_search','1','zenpage','themes/zenpage'),(324,0,'Use_thickbox','1','zenpage','themes/zenpage'),(325,0,'zenpage_homepage','none','zenpage','themes/zenpage'),(326,0,'thumb_transition','1','zpmobile','themes/zpmobile'),(327,0,'colorbox_default_album','1','','themes/zpmobile/themeoptions.php'),(328,0,'colorbox_default_image','1','','themes/zpmobile/themeoptions.php'),(329,0,'colorbox_default_search','1','','themes/zpmobile/themeoptions.php'),(330,0,'thumb_size','79','zpmobile','themes/zpmobile'),(331,0,'thumb_crop_width','79','zpmobile','themes/zpmobile'),(332,0,'thumb_crop_height','79','zpmobile','themes/zpmobile'),(333,0,'thumb_crop','1','zpmobile','themes/zpmobile'),(334,0,'custom_index_page','gallery','zpmobile','themes/zpmobile'),(335,0,'images_per_row','6','stopdesign','themes/stopdesign'),(336,0,'image_size','480','stopdesign','themes/stopdesign'),(337,0,'image_use_side','longest','stopdesign','themes/stopdesign'),(338,0,'thumb_size','89','stopdesign','themes/stopdesign'),(339,0,'thumb_crop_width','89','stopdesign','themes/stopdesign'),(340,0,'thumb_crop_height','89','stopdesign','themes/stopdesign'),(341,0,'thumb_crop','1','stopdesign','themes/stopdesign'),(342,0,'thumb_transition','1','stopdesign','themes/stopdesign'),(343,0,'Allow_search','1','default','themes/default'),(344,0,'Theme_colors','light','default','themes/default'),(345,0,'albums_per_page','6','default','themes/default'),(346,0,'albums_per_row','3','default','themes/default'),(347,0,'images_per_page','20','default','themes/default'),(348,0,'images_per_row','5','default','themes/default'),(349,0,'image_size','595','default','themes/default'),(350,0,'image_use_side','longest','default','themes/default'),(351,0,'Allow_cloud','1','garland','themes/garland'),(352,0,'albums_per_page','6','garland','themes/garland'),(353,0,'albums_per_row','2','garland','themes/garland'),(354,0,'images_per_page','20','garland','themes/garland'),(355,0,'images_per_row','5','garland','themes/garland'),(356,0,'image_size','520','garland','themes/garland'),(357,0,'image_use_side','longest','garland','themes/garland'),(358,0,'zenpage_contactpage','1','zenpage','themes/zenpage'),(359,0,'zenpage_custommenu','','zenpage','themes/zenpage'),(360,0,'albums_per_page','6','zenpage','themes/zenpage'),(361,0,'albums_per_row','2','zenpage','themes/zenpage'),(362,0,'images_per_page','20','zenpage','themes/zenpage'),(363,0,'images_per_row','5','zenpage','themes/zenpage'),(364,0,'image_size','580','zenpage','themes/zenpage'),(365,0,'image_use_side','longest','zenpage','themes/zenpage'),(366,0,'albums_per_page','6','zpmobile','themes/zpmobile'),(367,0,'albums_per_row','1','zpmobile','themes/zpmobile'),(368,0,'images_per_page','24','zpmobile','themes/zpmobile'),(369,0,'images_per_row','6','zpmobile','themes/zpmobile'),(370,0,'colorbox_stopdesign_album','1','','themes/stopdesign/themeoptions.php'),(371,0,'colorbox_stopdesign_image','1','','themes/stopdesign/themeoptions.php'),(372,0,'colorbox_stopdesign_search','1','','themes/stopdesign/themeoptions.php'),(373,0,'thumb_size','100','default','themes/default'),(374,0,'thumb_crop_width','100','default','themes/default'),(375,0,'thumb_crop_height','100','default','themes/default'),(376,0,'thumb_crop','1','default','themes/default'),(377,0,'thumb_transition','1','default','themes/default'),(378,0,'thumb_transition','1','garland','themes/garland'),(379,0,'thumb_size','85','garland','themes/garland'),(380,0,'thumb_crop_width','85','garland','themes/garland'),(381,0,'thumb_crop_height','85','garland','themes/garland'),(382,0,'thumb_crop','1','garland','themes/garland'),(383,0,'garland_personality','image_page','garland','themes/garland'),(384,0,'garland_transition','slide-hori','garland','themes/garland'),(385,0,'thumb_size','95','zenpage','themes/zenpage'),(386,0,'thumb_crop_width','95','zenpage','themes/zenpage'),(387,0,'thumb_crop_height','95','zenpage','themes/zenpage'),(388,0,'thumb_crop','1','zenpage','themes/zenpage'),(389,0,'thumb_transition','1','zenpage','themes/zenpage'),(390,0,'colorbox_zenpage_album','1','','themes/zenpage/themeoptions.php'),(391,0,'colorbox_zenpage_image','1','','themes/zenpage/themeoptions.php'),(392,0,'image_size','595','zpmobile','themes/zpmobile'),(393,0,'image_use_side','longest','zpmobile','themes/zpmobile'),(394,0,'garland_caption_location','image','garland','themes/garland'),(395,0,'colorbox_garland_image','1','','themes/garland/themeoptions.php'),(396,0,'colorbox_garland_album','1','','themes/garland/themeoptions.php'),(397,0,'colorbox_garland_search','1','','themes/garland/themeoptions.php'),(398,0,'garland_menu','','garland','themes/garland'),(399,0,'custom_index_page','','garland','themes/garland'),(400,0,'colorbox_zenpage_search','1','','themes/zenpage/themeoptions.php'),(401,0,'custom_index_page','','zenpage','themes/zenpage'),(402,0,'password_pattern','A-Za-z0-9   |   ~!@#$%&*_+`-(),.\\^\'\"/[]{}=:;?\\|','','zp-core/lib-auth.php');
/*!40000 ALTER TABLE `_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_pages`
--

DROP TABLE IF EXISTS `_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `extracontent` text COLLATE utf8_unicode_ci,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentson` int(1) unsigned DEFAULT '0',
  `codeblock` text COLLATE utf8_unicode_ci,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `lastchange` datetime DEFAULT NULL,
  `lastchangeauthor` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) unsigned NOT NULL DEFAULT '0',
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_pages`
--

LOCK TABLES `_pages` WRITE;
/*!40000 ALTER TABLE `_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_plugin_storage`
--

DROP TABLE IF EXISTS `_plugin_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_plugin_storage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `aux` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `aux` (`aux`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_plugin_storage`
--

LOCK TABLES `_plugin_storage` WRITE;
/*!40000 ALTER TABLE `_plugin_storage` DISABLE KEYS */;
INSERT INTO `_plugin_storage` VALUES (1,'cacheManager','effervescence_plus','a:13:{s:5:\"theme\";s:18:\"effervescence_plus\";s:5:\"apply\";b:0;s:10:\"image_size\";i:595;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:0;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(2,'cacheManager','effervescence_plus','a:13:{s:5:\"theme\";s:18:\"effervescence_plus\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(3,'cacheManager','effervescence_plus','a:13:{s:5:\"theme\";s:18:\"effervescence_plus\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";i:180;s:12:\"image_height\";i:80;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(4,'cacheManager','zpmobile','a:13:{s:5:\"theme\";s:8:\"zpmobile\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";i:79;s:12:\"image_height\";i:79;s:10:\"crop_width\";i:79;s:11:\"crop_height\";i:79;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(5,'cacheManager','stopdesign','a:13:{s:5:\"theme\";s:10:\"stopdesign\";s:5:\"apply\";b:0;s:10:\"image_size\";i:480;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:0;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(6,'cacheManager','stopdesign','a:13:{s:5:\"theme\";s:10:\"stopdesign\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";N;s:12:\"image_height\";i:89;s:10:\"crop_width\";i:67;s:11:\"crop_height\";i:89;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(7,'cacheManager','stopdesign','a:13:{s:5:\"theme\";s:10:\"stopdesign\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";i:89;s:12:\"image_height\";N;s:10:\"crop_width\";i:89;s:11:\"crop_height\";i:67;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(8,'cacheManager','stopdesign','a:13:{s:5:\"theme\";s:10:\"stopdesign\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";i:210;s:12:\"image_height\";i:59;s:10:\"crop_width\";i:310;s:11:\"crop_height\";i:59;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(9,'cacheManager','default','a:13:{s:5:\"theme\";s:7:\"default\";s:5:\"apply\";b:0;s:10:\"image_size\";s:3:\"595\";s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:0;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(10,'cacheManager','garland','a:13:{s:5:\"theme\";s:7:\"garland\";s:5:\"apply\";b:0;s:10:\"image_size\";i:520;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:0;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(11,'cacheManager','zenpage','a:13:{s:5:\"theme\";s:7:\"zenpage\";s:5:\"apply\";b:0;s:10:\"image_size\";N;s:11:\"image_width\";i:580;s:12:\"image_height\";i:580;s:10:\"crop_width\";N;s:11:\"crop_height\";N;s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";N;s:3:\"wmk\";b:0;s:4:\"gray\";N;s:8:\"maxspace\";b:1;}'),(12,'cacheManager','zenpage','a:13:{s:5:\"theme\";s:7:\"zenpage\";s:5:\"apply\";b:0;s:10:\"image_size\";i:95;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";s:3:\"100\";s:11:\"crop_height\";s:3:\"100\";s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(13,'cacheManager','default','a:13:{s:5:\"theme\";s:7:\"default\";s:5:\"apply\";b:0;s:10:\"image_size\";s:3:\"100\";s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";s:3:\"100\";s:11:\"crop_height\";s:3:\"100\";s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}'),(14,'cacheManager','garland','a:13:{s:5:\"theme\";s:7:\"garland\";s:5:\"apply\";b:0;s:10:\"image_size\";i:85;s:11:\"image_width\";N;s:12:\"image_height\";N;s:10:\"crop_width\";s:3:\"100\";s:11:\"crop_height\";s:3:\"100\";s:6:\"crop_x\";N;s:6:\"crop_y\";N;s:5:\"thumb\";b:1;s:3:\"wmk\";N;s:4:\"gray\";N;s:8:\"maxspace\";N;}');
/*!40000 ALTER TABLE `_plugin_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_search_cache`
--

DROP TABLE IF EXISTS `_search_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_search_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criteria` text COLLATE utf8_unicode_ci,
  `date` datetime DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `criteria` (`criteria`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_search_cache`
--

LOCK TABLES `_search_cache` WRITE;
/*!40000 ALTER TABLE `_search_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `_search_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_tags`
--

DROP TABLE IF EXISTS `_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_tags`
--

LOCK TABLES `_tags` WRITE;
/*!40000 ALTER TABLE `_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-23 17:28:45
