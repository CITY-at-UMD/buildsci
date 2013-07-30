-- MySQL dump 10.13  Distrib 5.5.21, for linux2.6 (i686)
--
-- Host: localhost    Database: virtualpulse
-- ------------------------------------------------------
-- Server version	5.5.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `in_buildings`
--

DROP TABLE IF EXISTS `in_buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `in_buildings` (
  `SubmissionID` int(11) NOT NULL,
  `City` varchar(45) NOT NULL,
  `State` varchar(2) NOT NULL,
  `BuildingName` varchar(45) DEFAULT NULL,
  `SpaceType` varchar(45) DEFAULT NULL,
  `NumFloors` tinyint(4) DEFAULT NULL,
  `TotalFloorArea` double DEFAULT NULL,
  `WindowWallRatio` double DEFAULT NULL,
  `RoofMaterialName` varchar(45) DEFAULT NULL,
  `PrincipleHeating` varchar(45) DEFAULT NULL,
  `WallMaterialName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`SubmissionID`),
  KEY `fk_City` (`City`),
  KEY `fk_State` (`State`),
  KEY `fk_SpaceType` (`SpaceType`),
  CONSTRAINT `fk_SubmissionID` FOREIGN KEY (`SubmissionID`) REFERENCES `submissions` (`SubmissionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_City` FOREIGN KEY (`City`) REFERENCES `ref_locations` (`City`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_State` FOREIGN KEY (`State`) REFERENCES `ref_locations` (`State`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_SpaceType` FOREIGN KEY (`SpaceType`) REFERENCES `ref_spacetypes` (`SpaceType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `in_buildings`
--

LOCK TABLES `in_buildings` WRITE;
/*!40000 ALTER TABLE `in_buildings` DISABLE KEYS */;
INSERT INTO `in_buildings` VALUES (2,'San Francisco','CA','Bank of America Center','SmallOffice',3,100,0.4,'Metal','NaturalGas','Concrete Mass'),(3,'San Francisco','CA','Bank of America Center','SmallOffice',3,100,0.4,'Metal','NaturalGas','Concrete Mass');
/*!40000 ALTER TABLE `in_buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `out_annualenergyuses`
--

DROP TABLE IF EXISTS `out_annualenergyuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `out_annualenergyuses` (
  `SubmissionID` int(11) NOT NULL,
  `TotalSiteEnergy` double DEFAULT NULL,
  `TotalSourceEnergy` double DEFAULT NULL,
  `Heating` double DEFAULT NULL,
  `Cooling` double DEFAULT NULL,
  `FanPump` double DEFAULT NULL,
  `ServiceHotWater` double DEFAULT NULL,
  `ExteriorLighting` double DEFAULT NULL,
  `InteriorLighting` double DEFAULT NULL,
  `Process` double DEFAULT NULL,
  PRIMARY KEY (`SubmissionID`),
  CONSTRAINT `fk_Out_OtherFuelEndUses_Submissions1` FOREIGN KEY (`SubmissionID`) REFERENCES `submissions` (`SubmissionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `out_annualenergyuses`
--

LOCK TABLES `out_annualenergyuses` WRITE;
/*!40000 ALTER TABLE `out_annualenergyuses` DISABLE KEYS */;
INSERT INTO `out_annualenergyuses` VALUES (3,946.53,1779.6,584.76,3.65,12.05,0,0,137.11,208.97);
/*!40000 ALTER TABLE `out_annualenergyuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `out_electricityuses`
--

DROP TABLE IF EXISTS `out_electricityuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `out_electricityuses` (
  `SubmissionID` int(11) NOT NULL,
  `TotalSiteEnergy` double DEFAULT NULL,
  `TotalSourceEnergy` double DEFAULT NULL,
  `Heating` double DEFAULT NULL,
  `Cooling` double DEFAULT NULL,
  `FanPump` double DEFAULT NULL,
  `ServiceHotWater` double DEFAULT NULL,
  `ExteriorLighting` double DEFAULT NULL,
  `InteriorLighting` double DEFAULT NULL,
  `Process` double DEFAULT NULL,
  PRIMARY KEY (`SubmissionID`),
  CONSTRAINT `fk_Out_ElectricityUses` FOREIGN KEY (`SubmissionID`) REFERENCES `submissions` (`SubmissionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `out_electricityuses`
--

LOCK TABLES `out_electricityuses` WRITE;
/*!40000 ALTER TABLE `out_electricityuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `out_electricityuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `out_naturalgasuses`
--

DROP TABLE IF EXISTS `out_naturalgasuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `out_naturalgasuses` (
  `SubmissionID` int(11) NOT NULL,
  `TotalSiteEnergy` double DEFAULT NULL,
  `TotalSourceEnergy` double DEFAULT NULL,
  `Heating` double DEFAULT NULL,
  `Cooling` double DEFAULT NULL,
  `FanPump` double DEFAULT NULL,
  `ServiceHotWater` double DEFAULT NULL,
  `ExteriorLighting` double DEFAULT NULL,
  `InteriorLighting` double DEFAULT NULL,
  `Process` double DEFAULT NULL,
  PRIMARY KEY (`SubmissionID`),
  CONSTRAINT `fk_Out_NaturalGasUses` FOREIGN KEY (`SubmissionID`) REFERENCES `submissions` (`SubmissionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `out_naturalgasuses`
--

LOCK TABLES `out_naturalgasuses` WRITE;
/*!40000 ALTER TABLE `out_naturalgasuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `out_naturalgasuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_locations`
--

DROP TABLE IF EXISTS `ref_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_locations` (
  `City` varchar(45) NOT NULL,
  `State` varchar(2) NOT NULL,
  `ClimateZone` varchar(2) DEFAULT NULL,
  `WeatherFileName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`City`,`State`),
  KEY `pk_City` (`City`),
  KEY `pk_State` (`State`),
  KEY `ClimateZone` (`ClimateZone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_locations`
--

LOCK TABLES `ref_locations` WRITE;
/*!40000 ALTER TABLE `ref_locations` DISABLE KEYS */;
INSERT INTO `ref_locations` VALUES ('Albuquerque','NM','4B','USA_NM_Albuquerque.Intl.AP.723650_TMY3'),('Atlanta','GA','3A','USA_GA_Atlanta-Hartsfield-Jackson.Intl.AP.722190_TMY3'),('Baltimore','MD','4A','USA_MD_Baltimore-Washington.Intl.AP.724060_TMY3'),('Chicago','IL','5A','USA_IL_Chicago-OHare.Intl.AP.725300_TMY3'),('Denver','CO','5B','USA_CO_Denver.Intl.AP.725650_TMY3'),('Duluth','MN','7','USA_MN_Duluth.Intl.AP.727450_TMY3'),('Fairbanks','AK','8','USA_AK_Fairbanks.Intl.AP.702610_TMY3'),('Helena','MT','6B','USA_MT_Helena.Rgnl.AP.727720_TMY3'),('Houston','TX','2A','USA_TX_Houston-Bush.Intercontinental.AP.722430_TMY3'),('Las Vegas','NV','3B','USA_NV_Las.Vegas-McCarran.Intl.AP.723860_TMY3'),('Los Angeles','CA','3B','USA_CA_Los.Angeles.Intl.AP.722950_TMY3'),('Miami','FL','1A','USA_FL_Miami.Intl.AP.722020_TMY3'),('Minneapolis','MN','6A','USA_MN_Minneapolis-St.Paul.Intl.AP.726580_TMY3'),('Phoenix','AZ','2B','USA_AZ_Phoenix-Sky.Harbor.Intl.AP.722780_TMY3'),('San Francisco','CA','3C','USA_CA_San.Francisco.Intl.AP.724940_TMY3'),('Seattle','WA','4C','USA_WA_Seattle-Tacoma.Intl.AP.727930_TMY3');
/*!40000 ALTER TABLE `ref_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_spacetypes`
--

DROP TABLE IF EXISTS `ref_spacetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_spacetypes` (
  `SpaceTypeID` int(11) NOT NULL,
  `SpaceType` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`SpaceTypeID`),
  KEY `SpaceType` (`SpaceType`),
  KEY `pk_SpaceTypeID` (`SpaceTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_spacetypes`
--

LOCK TABLES `ref_spacetypes` WRITE;
/*!40000 ALTER TABLE `ref_spacetypes` DISABLE KEYS */;
INSERT INTO `ref_spacetypes` VALUES (3,'LargeOffice'),(2,'MediumOffice'),(1,'SmallOffice');
/*!40000 ALTER TABLE `ref_spacetypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submissions` (
  `SubmissionID` int(11) NOT NULL AUTO_INCREMENT,
  `SubmissionTimeStamp` timestamp NULL DEFAULT NULL,
  `UserName` varchar(20) NOT NULL,
  PRIMARY KEY (`SubmissionID`),
  KEY `fk_UserName` (`UserName`),
  CONSTRAINT `fk_UserName` FOREIGN KEY (`UserName`) REFERENCES `users` (`UserName`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submissions`
--

LOCK TABLES `submissions` WRITE;
/*!40000 ALTER TABLE `submissions` DISABLE KEYS */;
INSERT INTO `submissions` VALUES (2,'2013-07-02 19:38:26','Mujing'),(3,'2013-07-02 19:51:47','Mujing');
/*!40000 ALTER TABLE `submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `UserName` varchar(20) NOT NULL,
  `Email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`UserName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('Mujing','mqw5130@psu.edu');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-08 18:23:46
