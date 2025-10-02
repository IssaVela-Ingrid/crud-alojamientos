-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_alojamientos_crud
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alojamientos`
--

DROP TABLE IF EXISTS `alojamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alojamientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_por_admin_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creado_por_admin_id` (`creado_por_admin_id`),
  CONSTRAINT `alojamientos_ibfk_1` FOREIGN KEY (`creado_por_admin_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alojamientos`
--

LOCK TABLES `alojamientos` WRITE;
/*!40000 ALTER TABLE `alojamientos` DISABLE KEYS */;
INSERT INTO `alojamientos` VALUES (1,'Acogedor Estudio en el Centro','Estudio moderno, cerca de todo. Ideal para viajes cortos.',50.00,'2025-09-29 22:19:47',NULL),(2,'Villa con Piscina y Vistas al Mar','Lujo y confort. Perfecto para familias y grupos grandes.',350.50,'2025-09-29 22:19:47',NULL),(3,'Apartamento Vintage','Decoración única con encanto clásico. Barrio tranquilo.',75.99,'2025-09-29 22:19:47',NULL),(4,'Apartamento Moderno en el Centro','Luminoso apartamento recién reformado con todas las comodidades, perfecto para estancias cortas o largas. Cerca de transporte público.',95.00,'2025-10-01 20:24:27',1),(5,'Acogedora Casa Rural con Vistas a la Montaña','Escapada tranquila. Disfruta de la naturaleza y de un amplio jardín. Ideal para familias o grupos de amigos.',120.50,'2025-10-01 20:24:31',1),(6,'Estudio Básico y Funcional cerca de la Universidad','Opción económica y práctica para estudiantes o viajeros con presupuesto limitado. Pequeño pero bien ubicado.',45.99,'2025-10-01 20:24:34',1),(7,'Espectacular Loft de Diseño Industrial','Techos altos, grandes ventanales y decoración minimalista. Una experiencia de lujo en el corazón de la ciudad.',180.00,'2025-10-01 20:24:40',1),(8,'Chalet de Lujo con Piscina Privada','Villa espaciosa con 4 habitaciones, barbacoa y piscina. Ideal para unas vacaciones inolvidables.',299.99,'2025-10-01 20:24:43',1),(9,'Habitación Privada en Piso Compartido','Una habitación cómoda con baño compartido en un ambiente amigable. Wifi incluido.',35.00,'2025-10-01 20:24:47',1),(10,'Bungalow Pequeño a 50 metros de la Playa','Despierta con el sonido del mar. Perfecto para parejas que buscan relajación y sol.',110.00,'2025-10-01 20:24:50',1),(11,'Increíble Ático con Terraza Panorámica','Vistas de 360 grados de la ciudad, ideal para cenas al aire libre. Muy bien comunicado.',150.00,'2025-10-01 20:24:53',1),(12,'Cabaña Ecológica Autosuficiente en el Bosque','Una experiencia de desconexión total. Energía solar y ambiente rústico.',85.00,'2025-10-01 20:24:56',1),(13,'Piso Grande Ideal para Familias','Tres dormitorios, cocina totalmente equipada y zona de juegos cercana. Tranquilidad y confort garantizados.',135.75,'2025-10-01 20:24:59',1);
/*!40000 ALTER TABLE `alojamientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alojamientos_usuario`
--

DROP TABLE IF EXISTS `alojamientos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alojamientos_usuario` (
  `usuario_id` int NOT NULL,
  `alojamiento_id` int NOT NULL,
  PRIMARY KEY (`usuario_id`,`alojamiento_id`),
  KEY `alojamiento_id` (`alojamiento_id`),
  CONSTRAINT `alojamientos_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alojamientos_usuario_ibfk_2` FOREIGN KEY (`alojamiento_id`) REFERENCES `alojamientos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alojamientos_usuario`
--

LOCK TABLES `alojamientos_usuario` WRITE;
/*!40000 ALTER TABLE `alojamientos_usuario` DISABLE KEYS */;
INSERT INTO `alojamientos_usuario` VALUES (2,2),(2,3),(2,11);
/*!40000 ALTER TABLE `alojamientos_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('usuario','administrador') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador Principal','admin@example.com','$2y$10$IghoGA0nwAoc1ENssy2aDOn.wpvm0F44bc1GuilnOXRuH1VAoWMTa','administrador','2025-09-29 22:19:40'),(2,'Luis','luis@gmail.com','$2y$10$IghoGA0nwAoc1ENssy2aDOn.wpvm0F44bc1GuilnOXRuH1VAoWMTa','usuario','2025-10-01 17:22:37');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_alojamientos_crud'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-01 15:28:48
