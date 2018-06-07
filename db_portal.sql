CREATE DATABASE  IF NOT EXISTS `db_portal` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_portal`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_portal
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB

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
-- Table structure for table `campeonato`
--

DROP TABLE IF EXISTS `campeonato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campeonato` (
  `idCampeonato` int(11) NOT NULL,
  `totalGols` int(11) DEFAULT NULL,
  `totalCartoes` int(11) DEFAULT NULL,
  `totalFaltas` int(11) DEFAULT NULL,
  `logoCampeonato` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idCampeonato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campeonato`
--

LOCK TABLES `campeonato` WRITE;
/*!40000 ALTER TABLE `campeonato` DISABLE KEYS */;
INSERT INTO `campeonato` (`idCampeonato`, `totalGols`, `totalCartoes`, `totalFaltas`, `logoCampeonato`) VALUES (1,9,NULL,NULL,NULL);
/*!40000 ALTER TABLE `campeonato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogador`
--

DROP TABLE IF EXISTS `jogador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jogador` (
  `idJogador` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `rg` varchar(13) NOT NULL,
  `nFaltasCometidas` int(11) DEFAULT NULL,
  `nCartoesAmarelos` int(11) DEFAULT NULL,
  `nCartoesVemelhos` int(11) DEFAULT NULL,
  `nGolsMarcados` int(11) DEFAULT NULL,
  `fk_idTime` int(11) NOT NULL,
  `fotoJogador` varchar(20) DEFAULT NULL,
  `numero` int(11) DEFAULT '0',
  PRIMARY KEY (`idJogador`),
  KEY `fk_idTime` (`fk_idTime`),
  CONSTRAINT `jogador_ibfk_1` FOREIGN KEY (`fk_idTime`) REFERENCES `time` (`idTime`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogador`
--

LOCK TABLES `jogador` WRITE;
/*!40000 ALTER TABLE `jogador` DISABLE KEYS */;
INSERT INTO `jogador` (`idJogador`, `nome`, `rg`, `nFaltasCometidas`, `nCartoesAmarelos`, `nCartoesVemelhos`, `nGolsMarcados`, `fk_idTime`, `fotoJogador`, `numero`) VALUES (1,'Álvaro Leandro Vieira Amparo','MG-12.882.302',NULL,NULL,NULL,0,1,NULL,1),(2,'Epifânio Pierre Melo Pereira','MG-14.218.214',NULL,NULL,NULL,0,1,NULL,23),(3,'Eudes Bastos de Aguiar','MG-9.149.814',NULL,NULL,NULL,0,1,NULL,3),(4,'Anderson Silva ','MG-10.895.221',NULL,NULL,NULL,0,1,NULL,5),(5,'Brian Alves Lisboa','MG-16.041.124',NULL,NULL,NULL,0,1,NULL,10),(6,'Breno Araújo ','MG-6.361.700',NULL,NULL,NULL,0,1,NULL,11),(7,'Jean Castro de Souza','MG-10.168.013',NULL,NULL,NULL,0,1,NULL,2),(8,'Walerson Antônio Alexandre','MG-14.529.017',NULL,NULL,NULL,0,1,NULL,3),(9,'Luciano Brayan Braz Lima','MG-17.700.474',NULL,NULL,NULL,1,5,NULL,8),(10,'Raphael Athos','MG-12.406.944',NULL,NULL,NULL,0,5,NULL,9),(11,'Ricardo Lucas Pereira Rosa','MG-14.185.362',NULL,NULL,NULL,0,5,NULL,24),(12,'Tiago Luiz de Melo','MG-12.034.204',NULL,NULL,NULL,0,5,NULL,12),(13,'Bruno Henrique','MG-10.674.313',NULL,NULL,NULL,0,5,NULL,13),(14,'Fernando Júnior','MG-5.678.134',NULL,NULL,NULL,0,5,NULL,45),(15,'Maurício Gonzaga','',NULL,NULL,NULL,0,5,NULL,52),(16,'Rafael Ocelli','MG-10.386.493',NULL,NULL,NULL,1,6,NULL,32),(17,'Edine Alves','MG-18.885.296',NULL,NULL,NULL,2,6,NULL,30),(18,'Gabriel Amaral','MG-15.282.071',NULL,NULL,NULL,0,6,NULL,26),(19,'Guilherme Freitas','MG-14.783.209',NULL,NULL,NULL,1,6,NULL,29),(20,'Pedro Afonso','',NULL,NULL,NULL,0,6,NULL,4),(21,'Raoni Barros Nascimento','MG-12.226.008',NULL,NULL,NULL,1,6,NULL,3),(22,'Thiago Rabelo Faria','MG-17.697.185',NULL,NULL,NULL,0,8,NULL,6),(23,'Daniel Teles Gonçalves Rosa','',NULL,NULL,NULL,1,8,NULL,2),(24,'Lauro César Coto','MG-15.309.223',NULL,NULL,NULL,0,8,NULL,5),(25,'Gustavo dos Anjos Corrêa','MG-10.989.658',NULL,NULL,NULL,0,8,NULL,8),(26,'Renan Romerson Bottaro Dutra de Morais','MG-10.024.128',NULL,NULL,NULL,0,8,NULL,4),(27,'Kleber Reinaldo Mateus','MG-15.055.926',NULL,NULL,NULL,0,8,NULL,6),(28,'Enrico Cloves Araújo','M-8.771.977',NULL,NULL,NULL,0,8,NULL,1),(29,'Felipe Fraga Magalhães','MG-15.361.550',NULL,NULL,NULL,0,8,NULL,11),(30,'Euler','',NULL,NULL,NULL,1,8,NULL,12),(31,'Bruno Nonato Gomes','MG-14.734.931',NULL,NULL,NULL,3,3,NULL,15),(32,'Lucas Maia','',NULL,NULL,NULL,2,3,NULL,16),(33,'Tiago Pereira da Silva','',NULL,NULL,NULL,1,3,NULL,18),(34,'Mateus Nascimento','MG-12.797.326',NULL,NULL,NULL,2,3,NULL,22),(35,'Renato Miranda','',NULL,NULL,NULL,0,3,NULL,22),(36,'Erick Fonseca Boaventura','MG-15.509.053',NULL,NULL,NULL,0,3,NULL,23),(37,'Danilo','MG-9.335.724',NULL,NULL,NULL,0,3,NULL,26),(38,'Diego Lima','',NULL,NULL,NULL,0,3,NULL,28),(39,'Matheus Saliba','MG-15.466.234',NULL,NULL,NULL,1,2,NULL,29),(40,'Mateus Maia','MG-17.129.238',NULL,NULL,NULL,1,2,NULL,10),(41,'Rian Fortunato','MG-15.213.173',NULL,NULL,NULL,3,2,NULL,5),(42,'Matheus Felipe Martins','MG-19.108.830',NULL,NULL,NULL,4,2,NULL,1),(43,'Lucas Vieira dos Santos','MG-17.900.883',NULL,NULL,NULL,0,2,NULL,13),(44,'Wellingson Tobias','MG-16.720.048',NULL,NULL,NULL,1,2,NULL,16),(45,'Matheus Menezes de Freitas Castro','MG-16.981.556',NULL,NULL,NULL,0,4,NULL,4),(46,'Guilherme da Silva Justino','MG-19.242.766',NULL,NULL,NULL,0,4,NULL,14),(47,'Miquéias Custódio de Azevedo','MG-16.744.328',NULL,NULL,NULL,0,4,NULL,19),(48,'Gustavo Yallen de Souza Azevedo','MG-15.684.971',NULL,NULL,NULL,0,4,NULL,28),(49,'Victor Hugo Monteiro de Almeida','MG-13.388.269',NULL,NULL,NULL,0,4,NULL,33),(50,'Mateus Tadeu Souza de Castro','MG-12.209.265',NULL,NULL,NULL,0,4,NULL,34),(51,'Hudson Ferreira Lopes','MG-10.831.676',NULL,NULL,NULL,0,4,NULL,28),(52,'Leandro Oliveira Pereira','MG-17.268.812',NULL,NULL,NULL,0,4,NULL,55),(53,'Lucas Rezende','MG-13.994.821',NULL,NULL,NULL,0,4,NULL,50),(54,'Bruno Siqueira Santos','MG-16.841.643',NULL,NULL,NULL,1,7,NULL,46),(55,'William Henrique dos Santos','MG-17.051.187',NULL,NULL,NULL,1,7,NULL,42),(56,'Márcio Rogério da Silva','MG-13.539.500',NULL,NULL,NULL,1,7,NULL,38),(57,'Jefferson Menezes','MG-12.196.505',NULL,NULL,NULL,2,7,NULL,49),(58,'Guilherme Batista dos Santos','MG-15.630.512',NULL,NULL,NULL,0,7,NULL,12),(59,'Felipe Arcângelo da Silva','MG-12.110.251',NULL,NULL,NULL,0,7,NULL,10),(60,'Daniel Henrique Oliveira Batista Silva','MG-14.223.585',NULL,NULL,NULL,1,7,NULL,22),(61,'André Luiz Galdino dos Santos','MG-10.025.287',NULL,NULL,NULL,0,7,NULL,23),(62,'Rodrigo Leandro da Silva','MG-11.906.763',NULL,NULL,NULL,0,7,NULL,24);
/*!40000 ALTER TABLE `jogador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogo`
--

DROP TABLE IF EXISTS `jogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jogo` (
  `idJogo` int(11) NOT NULL,
  `data` datetime DEFAULT NULL,
  `local` varchar(45) DEFAULT NULL,
  `placarCasa` int(11) NOT NULL,
  `placarVisitante` int(11) NOT NULL,
  `fk_idCampeonato` int(11) NOT NULL,
  `fk_idJuiz` int(11) NOT NULL,
  PRIMARY KEY (`idJogo`),
  KEY `fk_idCampeonato` (`fk_idCampeonato`),
  KEY `fk_idJuiz` (`fk_idJuiz`),
  CONSTRAINT `jogo_ibfk_1` FOREIGN KEY (`fk_idCampeonato`) REFERENCES `campeonato` (`idCampeonato`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_ibfk_2` FOREIGN KEY (`fk_idJuiz`) REFERENCES `juiz` (`idJuiz`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogo`
--

LOCK TABLES `jogo` WRITE;
/*!40000 ALTER TABLE `jogo` DISABLE KEYS */;
INSERT INTO `jogo` (`idJogo`, `data`, `local`, `placarCasa`, `placarVisitante`, `fk_idCampeonato`, `fk_idJuiz`) VALUES (1,'2016-06-11 08:00:00',NULL,0,3,1,1),(2,'2016-06-11 08:25:00',NULL,3,0,1,1),(3,'2016-06-11 08:50:00',NULL,0,2,1,1),(4,'2016-06-11 09:15:00',NULL,1,0,1,1),(5,'2016-06-11 09:40:00',NULL,6,0,1,1),(6,'2016-06-11 10:05:00',NULL,5,0,1,1),(7,'2016-06-11 10:30:00',NULL,0,1,1,1),(8,'2016-06-11 10:55:00',NULL,1,0,1,1),(9,'2016-06-11 11:20:00',NULL,3,0,1,1),(10,'2016-06-11 11:45:00',NULL,0,1,1,1),(11,'2016-06-11 12:10:00',NULL,1,1,1,1),(12,'2016-06-11 12:35:00',NULL,1,1,1,1),(13,'2016-06-18 08:00:00',NULL,2,0,1,1),(14,'2016-06-18 08:25:00',NULL,1,0,1,1),(15,'2016-06-18 00:00:00',NULL,0,3,1,1),(16,'2016-06-12 08:50:00',NULL,1,1,1,1),(17,'2016-06-18 09:15:00',NULL,1,1,1,1),(18,'2016-06-18 09:40:00',NULL,0,1,1,1),(19,'2016-06-18 10:30:00',NULL,0,5,1,1),(20,'2016-06-18 10:55:00',NULL,1,0,1,1);
/*!40000 ALTER TABLE `jogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogo_tem_times`
--

DROP TABLE IF EXISTS `jogo_tem_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jogo_tem_times` (
  `fk_idJogo` int(11) NOT NULL,
  `fk_idTime` int(11) NOT NULL,
  `idVisitante` int(11) DEFAULT NULL,
  `escalacaoCasa` mediumblob,
  `escalacaoVisitante` mediumblob,
  PRIMARY KEY (`fk_idTime`,`fk_idJogo`),
  KEY `fk_idJogo` (`fk_idJogo`),
  KEY `idVisitante` (`idVisitante`),
  CONSTRAINT `jogo_tem_times_ibfk_1` FOREIGN KEY (`fk_idJogo`) REFERENCES `jogo` (`idJogo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_tem_times_ibfk_2` FOREIGN KEY (`fk_idTime`) REFERENCES `time` (`idTime`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_tem_times_ibfk_3` FOREIGN KEY (`idVisitante`) REFERENCES `time` (`idTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogo_tem_times`
--

LOCK TABLES `jogo_tem_times` WRITE;
/*!40000 ALTER TABLE `jogo_tem_times` DISABLE KEYS */;
INSERT INTO `jogo_tem_times` (`fk_idJogo`, `fk_idTime`, `idVisitante`, `escalacaoCasa`, `escalacaoVisitante`) VALUES (1,1,2,NULL,NULL),(5,1,3,NULL,NULL),(9,1,4,NULL,NULL),(16,1,6,NULL,NULL),(6,2,4,NULL,NULL),(13,2,5,NULL,NULL),(17,2,7,NULL,NULL),(20,2,6,NULL,NULL),(2,3,4,NULL,NULL),(10,3,2,NULL,NULL),(18,3,6,NULL,NULL),(3,5,6,NULL,NULL),(7,5,7,NULL,NULL),(11,5,8,NULL,NULL),(8,6,8,NULL,NULL),(4,7,8,NULL,NULL),(12,7,6,NULL,NULL),(14,7,4,NULL,NULL),(19,7,3,NULL,NULL),(15,8,3,NULL,NULL);
/*!40000 ALTER TABLE `jogo_tem_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `juiz`
--

DROP TABLE IF EXISTS `juiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `juiz` (
  `idJuiz` int(11) NOT NULL,
  `nomeJuiz` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idJuiz`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `juiz`
--

LOCK TABLES `juiz` WRITE;
/*!40000 ALTER TABLE `juiz` DISABLE KEYS */;
INSERT INTO `juiz` (`idJuiz`, `nomeJuiz`) VALUES (1,NULL);
/*!40000 ALTER TABLE `juiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time`
--

DROP TABLE IF EXISTS `time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time` (
  `idTime` int(11) NOT NULL,
  `nomeTime` varchar(60) NOT NULL,
  `escudo` varchar(255) DEFAULT NULL,
  `nJogadores` int(11) DEFAULT NULL,
  `nomeTecnico` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time`
--

LOCK TABLES `time` WRITE;
/*!40000 ALTER TABLE `time` DISABLE KEYS */;
INSERT INTO `time` (`idTime`, `nomeTime`, `escudo`, `nJogadores`, `nomeTecnico`) VALUES (1,'Logistica','/FutIFMG/wp-includes/images/escudos/logistica.png',8,'Pierre'),(2,'Horriver','/FutIFMG/wp-includes/images/escudos/horriver.png',6,'Matheus Saliba'),(3,'CQC 2','/FutIFMG/wp-includes/images/escudos/CQC-2.png',8,'Bruno Nonato'),(4,'Realgoritmos','/FutIFMG/wp-includes/images/escudos/realgoritmos.png',9,'Victor Hugo Monteiro'),(5,'TPGalacticos','/FutIFMG/wp-includes/images/escudos/tpgalacticos.png',7,'Luciano Lima'),(6,'Insanos','/FutIFMG/wp-includes/images/escudos/insanos.png',6,'Rafael Ocelli'),(7,'Uns e Outros','/FutIFMG/wp-includes/images/escudos/uns-e-outros.png',9,'Felipe A. Silva'),(8,'TPG2014','/FutIFMG/wp-includes/images/escudos/tpg2014.png',8,'Daniel Teles');
/*!40000 ALTER TABLE `time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_tem_campeonato`
--

DROP TABLE IF EXISTS `time_tem_campeonato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_tem_campeonato` (
  `fk_idCampeonato` int(11) NOT NULL,
  `fk_idTime` int(11) NOT NULL,
  `grupo` varchar(2) NOT NULL,
  `nVitorias` int(11) DEFAULT NULL,
  `nEmpates` int(11) DEFAULT NULL,
  `nDerrotas` int(11) DEFAULT NULL,
  `nGolsFeitos` int(11) DEFAULT NULL,
  `nGolsSofridos` int(11) DEFAULT NULL,
  PRIMARY KEY (`fk_idTime`,`fk_idCampeonato`),
  KEY `fk_idCampeonato` (`fk_idCampeonato`),
  CONSTRAINT `time_tem_campeonato_ibfk_1` FOREIGN KEY (`fk_idCampeonato`) REFERENCES `campeonato` (`idCampeonato`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `time_tem_campeonato_ibfk_2` FOREIGN KEY (`fk_idTime`) REFERENCES `time` (`idTime`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_tem_campeonato`
--

LOCK TABLES `time_tem_campeonato` WRITE;
/*!40000 ALTER TABLE `time_tem_campeonato` DISABLE KEYS */;
INSERT INTO `time_tem_campeonato` (`fk_idCampeonato`, `fk_idTime`, `grupo`, `nVitorias`, `nEmpates`, `nDerrotas`, `nGolsFeitos`, `nGolsSofridos`) VALUES (1,1,'A',2,0,1,9,3),(1,2,'A',3,0,0,9,0),(1,3,'A',1,0,2,3,6),(1,4,'A',0,0,3,0,11),(1,5,'B',0,1,2,1,4),(1,6,'B',2,1,0,4,1),(1,7,'B',2,1,0,3,1),(1,8,'B',0,1,2,1,3);
/*!40000 ALTER TABLE `time_tem_campeonato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'db_portal'
--

--
-- Dumping routines for database 'db_portal'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-07  0:42:15
