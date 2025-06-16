/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: siscap
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la respuesta',
  `question_id` int(11) NOT NULL COMMENT 'Referencia al código de la pregunta',
  `student_id` int(11) NOT NULL COMMENT 'Referencia al código del estudiante',
  `qualification` decimal(4,2) NOT NULL DEFAULT 0.00 COMMENT 'Calificación de la respuesta',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de la respuesta',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del curso',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del curso',
  `description` text DEFAULT NULL COMMENT 'Descripción del curso',
  `place` varchar(150) DEFAULT NULL COMMENT 'Lugar donde se desarrollara el curso',
  `destined` varchar(150) DEFAULT NULL COMMENT 'Especificación para quienes esta destinado el curso',
  `type` int(11) NOT NULL DEFAULT 2 COMMENT 'Tipo del curso: Presencial(1), Virtual(2) o Ambos(3)',
  `quota` smallint(6) NOT NULL DEFAULT 50 COMMENT 'Cupos límite para el curso',
  `state_id` int(11) NOT NULL COMMENT 'Referencia al código de estado del curso',
  `start` date DEFAULT NULL COMMENT 'Fecha de inicio del curso',
  `finish` date DEFAULT NULL COMMENT 'Fecha de finalización del curso',
  `banner` varchar(250) DEFAULT NULL COMMENT 'Pancarta del curso',
  `visible` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de visibilidad para el curso',
  `user_id` int(11) NOT NULL COMMENT 'Referecnia al código del usuario responsable de crear el curso',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación del curso',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima actualización al curso',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criterions`
--

DROP TABLE IF EXISTS `criterions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `criterions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del criterio de la pregunta',
  `poll_id` int(11) NOT NULL COMMENT 'Referencia al código de la Encuesta',
  `criterion` text NOT NULL COMMENT 'Descripción del criterio de la pregunta',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de la pregunta',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima edición',
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`),
  CONSTRAINT `criterions_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criterions`
--

LOCK TABLES `criterions` WRITE;
/*!40000 ALTER TABLE `criterions` DISABLE KEYS */;
/*!40000 ALTER TABLE `criterions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la evaluación',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso',
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `title` varchar(150) NOT NULL COMMENT 'Título de la evaluación',
  `time_limit` tinyint(4) NOT NULL DEFAULT 30,
  `description` text DEFAULT NULL COMMENT 'Descripción de la evaluación',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación de la evaluación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima modificación de la evaluación',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo de la evaluación',
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluations`
--

LOCK TABLES `evaluations` WRITE;
/*!40000 ALTER TABLE `evaluations` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del archivo',
  `title` varchar(150) DEFAULT NULL COMMENT 'Título del archivo',
  `description` text DEFAULT NULL COMMENT 'Descripción del archivo',
  `src` varchar(250) NOT NULL COMMENT 'Ruta del archivo',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado del archivo',
  `user_id` int(11) NOT NULL COMMENT 'Referecnia al código del usuario que publica el archivo',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso que pertenece el archivo',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación del archivo',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la última actualización del archivo',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `files_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `instructors` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del instructor',
  `teacher_id` int(11) NOT NULL COMMENT 'Referencia al código  del profesor que va instruir el curso',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo del ingreso. ''0'' para Inactivo y ''1'' para Activo. Por defecto es Activo',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima actualización',
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `instructors_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructors`
--

LOCK TABLES `instructors` WRITE;
/*!40000 ALTER TABLE `instructors` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del mensaje',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código del usuario que envía el mensaje',
  `subject` varchar(50) NOT NULL COMMENT 'Asunto del mensaje',
  `body` text DEFAULT NULL COMMENT 'Cuerpo del mensaje',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación del mensaje',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la opción',
  `question_id` int(11) NOT NULL COMMENT 'Referencia al código de la pregunta',
  `choise` text NOT NULL COMMENT 'Opción de la pregunta',
  `correct` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Estado de opción considerado como verdadera',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la última modificación',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado activo de la opción',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `options_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del participante',
  `student_id` int(11) NOT NULL COMMENT 'Referencia al código del estudiante que participa en el curso',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al Código del curso al que participa',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo del ingreso. ''0'' para Inactivo y ''1'' para Activo. Por defecto es Activo',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación del participante',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima actualización',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phrases`
--

DROP TABLE IF EXISTS `phrases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `phrases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL COMMENT 'Detalle de la Frase. No es necesario incluir comillas.',
  `author` varchar(50) DEFAULT NULL COMMENT 'Nombre del autor',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de la frase',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código del usuario que crea la frase',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación de la frase',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la última actualización a la frase',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `phrases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phrases`
--

LOCK TABLES `phrases` WRITE;
/*!40000 ALTER TABLE `phrases` DISABLE KEYS */;
INSERT INTO `phrases` VALUES (1,'No hay nada tan agotador como la eterna presencia de una tarea sin completar','William James ',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(2,'Una persona no puede directamente escoger sus circunstancias, pero si puede escoger sus pensamientos e indirectamente -y con seguridad- darle forma a sus circunstancias','James Allen',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(3,'Únicamente aquellos que se atreven a tener grandes fracasos, terminan consiguiendo grandes éxitos','Robert F. Kennedy',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(4,'No te des por vencido, aún y cuando estuvieras vencido','Anonimo',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(5,'La idea no es vivir para siempre, la idea es crear algo que sí lo haga','Andy Warhol',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(6,'Un hombre sin una sonrisa en la cara, no debería de abrir una tienda','Proverbio Chino',1,1,'2017-07-27 13:55:35','2017-07-27 13:55:35'),(7,'Una mala actitud es como una llanta ponchada, no llegarás a ningún lado hasta que la cambies','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(8,'Si supiera que el mundo se acaba mañana, yo, hoy todavía, plantaría un árbol','Martin Luther King ',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(9,'Solamente aquellas personas que poseen un espíritu perdedor consideran la posibilidad de una derrota antes de intentarlo','Sergio Delgado.',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(10,'La gente no tiene que creer en ti, tú mismo tienes que creer en ti','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(11,' Normalmente, lo que nos da más miedo hacer es lo que más necesitamos hacer','Timothy Ferriss',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(12,'Pensar es gratis, no hacerlo sale carísimo','Anonimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(13,'Un fracasado es un hombre que ha cometido un error, pero que no es capaz de convertirlo en experiencia','Thomas Edison',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(14,'Las oportunidades se le escapan a la gente porque están vestidas en overol y parecen trabajo','Thomas Edison',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(15,'Cuida los pequeños gastos, un pequeño agujero hunde un barco','Benjamín Franklin',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(16,'La escalera del éxito nunca está llena en la cima','Napoleón Hill',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(17,'Siempre supe que iba a ser rico. No creo que alguna vez lo dudé ni por un minuto','Warren Buffett',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(18,'Fija tus ojos hacia adelante en lo que puedes hacer, no hacia atrás en lo que no puedes cambiar\" ','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(19,'Uno de los secretos del éxito, es el no permitir que los contratiempos pasajeros nos derroten','Mary Kay',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(20,'Los pasos que no te atreves a dar, también dejan huella','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(21,'Cuando un niño aprende a caminar y se cae 50 veces, nunca se dice a sí mismo: Esto no es para mí','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(22,'Lo más importante que se aprende cuando se gana, es que se puede ganar','Dave Weinbaum',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(23,'El éxito es ese viejo trío: habilidad, oportunidad y valentía','Charles Luckman',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(24,'Tu mayor competidor es lo que quieres llegar a ser','Jim Taylor',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(25,'Me siento más orgulloso de la forma en que manejaste el éxito que por tu éxito','Kirk Douglas',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(26,'Vender no es hacer que otra persona compre tu producto, vender es ayudar a otras personas a resolver sus problemas','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(27,'Sólo hay algo peor que formar a tus empleados y que se vayan: no formarlos, y que se queden','Henry Ford',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(28,'No subas la voz, mejora tu argumento','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(29,'Si el plan ‘A’ no funciona, recuerda que el alfabeto tiene otras 25 letras','Anónimo',1,1,'2017-07-27 13:55:36','2017-07-27 13:55:36'),(30,'Fallar no es lo contrario del éxito, es parte de él','Arianna Huffington',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(31,'La necesidad es la madre de la invención','Platón',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(32,'Tus clientes más insatisfechos son tu principal fuente de aprendizaje','Bill Gates',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(33,'Siento una enorme gratitud hacia todos los que me dijeron ‘no’, gracias a ellos, lo hice yo mismo','Albert Einstein',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(34,' Cree que puedes y estás a la mitad del camino','Theodore Roosevelt',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(35,' Si no te gusta el sitio en donde estás, muévete, no eres un árbol','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(36,' Enfrentar los miedos es difícil, pero es mucho más difícil vivir con ellos toda la vida','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(37,'El dolor de la disciplina , no se compara con el de la decepción','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(38,'Dime y lo olvido, enséñame y lo recuerdo, involúcrame y lo aprendo','Benjamín Franklin',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(39,'Un ingrediente básico para el éxito, es tener el entusiasmo a la alza','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(40,'Todos quieren estar en la cima, pero la mayoría no quiere escalar','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(41,'Si te rindes hoy, de nada habrá servido el esfuerzo de ayer','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(42,'Es difícil derrotar a una persona que nunca se rinde','Babe Ruth',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(43,'Mucha gente se queda tan enganchada con lo que no puede tener, que no piensan por un segundo si realmente lo quiere','Lionel Shriver',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(44,'Hay quien cruza el bosque y sólo ve leña para el fuego','Lev Nikolaievich',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(45,'Para ser un ganador, debes planear ganar, prepararte para ganar y confiar que ganarás','Zig Ziglar',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(46,'No sólo se trata de trabajar mucho, sino de ser más productivo','Steve Jobs',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(47,'Valen más 5,000 personas a las que les interese escuchar tu mensaje, que 5 millones a las que no les interese','Seth Godin',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(48,'Muchos de los fracasos de la vida son de gente que no se dio cuenta lo cerca que estaban el éxito cuando se rindieron','Thomas Edison',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(49,'Si compras cosas que no necesitas, pronto trendrás que vender las que sí necesitas','Warren Buffet',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(50,'La mayoría de las personas gastan más tiempo hablando de los problemas que en afrontarlos','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(51,'Si lo intentas puedes perder, si no lo intentas, ya perdiste','Anónimo',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(52,'Cuando confíes en ti sabras vivir','ARISTÓTELES.',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(53,'El placer en el trabajo pone la perfección en el trabajo','ARISTÓTELES',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(54,'En la vida no obtienes lo que quieres sino lo que negocias','Donald Trump',1,1,'2017-07-27 13:55:37','2017-07-27 13:55:37'),(55,'El liderazgo es la capacidad de transformar la visión en realidad','Warren Bennis',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(56,'Cuando el amor y la habilidad trabajan juntos, espera una obra maestra','John Ruskin',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(57,'La diferencia entre una persona exitosa y los demás, no es la falta de fortaleza, ni la falta de conocimiento, sino la falta de voluntad','Vince Lomabardi',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(58,'Haz tu trabajo de todo corazón y tendrás éxito – hay muy poca competencia','Elbert Hubbard',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(59,'Sólo los que se arriesgan a ir demasiado lejos, son los que descubren hasta dónde pueden llegar','T.S. Eliot',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(60,'Si realmente quiero mejorar la situación, puedo trabajar en lo único sobre lo que tengo control: yo mismo','Stephen Covey',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(61,'Un hombre con una idea es un loco, hasta que triunfa','Mark Twain',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(62,'Sólo existe un jefe: el cliente, y puede despedir a cualquiera en la empresa, empezando por su presidente, simplemente gastando su dinero en otro lado','Sam Walton, fundador de Wal Mart',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(63,'Ten la expectativa que se cumpla cada necesidad. Ten la expectativa de tener la respuesta a cada problema. Ten la expectativa de tener la abundancia en cada nivel','Elleen Caddy',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(64,'El cambio está en tu mente, pero los resultados se encuentran en tus acciones','Eric Franicevich',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(65,'Para la gente próspera, no se trata de obtener más cosas, se trata de tener la libertad de tomar casi la decisión que quieras','Harv Eker',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(66,'Es un gran error no hacer nada por creer que se hace poco','Sydney Smith',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(67,'Si abandonas tu apego a lo conocido estarás entrando al campo de todas las posibilidades','Deepak Chopra',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(68,'Nunca llegarás a tu destino si te detienes a arrojar piedras a cada perro que te ladre','Winston Churchill',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(69,'Un negocio que no hace otra cosa más que dinero, es un negocio pobre','Henry Ford',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(70,'La lógica te lleva del punto A al punto B. La imaginación te llevará a donde sea','Albert Einstein',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(71,'La confianza en uno mismo es el primer secreto del éxito','Emerson',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(72,'La fórmula para el desastre: podría + debería = no lo haré','Jim Rohn',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(73,'La confianza en uno mismo es el primer secreto del éxito','Anónimo',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(74,'El fracaso es la oportunidad de empezar de nuevo con más inteligencia','Henry Ford',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(75,'Siempre he estado en el lugar correcto en el tiempo correcto. Por supuesto que yo mismo me conduje ahí','Bob Hope',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(76,'El Éxito consiste en confiar en ti, en no depender de nadie, y en tener en mente que no hay nada imposible','Donald Trump',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(77,'La inspiración existe, pero tiene que encontrarte trabajando.','Pablo Picasso',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(78,'Aún el viaje más largo, comienza con el primer paso','Proverbio Chino',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(79,'Mientras dices que es imposible, alguien más ya lo está haciendo','Anónimo',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(80,'Piensa en ti como un recurso adicional para tus clientes: un consultor, un consejero, un mentor y un amigo y no sólo como un simple vendedor','Anónimo',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(81,'La mejor publicidad es la que hacen los clientes satisfechos','Philip Kotler',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(82,'El pesimista se queja del viento; el optimista espera a que cambie; el realista ajusta las velas.','George Ward',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(83,'La mejor manera de vengarte de un enemigo, es ser feliz y tener éxito.','Anónimo',1,1,'2017-07-27 13:55:38','2017-07-27 13:55:38'),(84,'El mayor error que puedes cometer en la vida, es constantemente tener miedo a cometer uno','Elbert Hubbard',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(85,'Ya sea que tú diriges tu día, o el día te dirige a ti','Anónimo',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(86,'El objetivo del marketing es hacer innecesaria la venta','Anónimo',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(87,'Dejar de hacer publicidad para ahorrar dinero, es como parar tu reloj para ahorrar tiempo','Henry Ford',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(88,'Siempre parece imposible hasta que está hecho','Nelson Mandela',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(89,'Para tener éxito, tu deseo por el éxito, debe ser mayor que tu miedo al fracaso','Bill Cosby',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(90,'No estaba lloviendo cuando Noé construyó el arca','Howard Ruff',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(91,'Un emprendedor ve oportunidades, donde otros sólo ven problemas','Michel Gerber',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(92,'Nadie puede volver a atrás y hacer un gran comienzo, sin embargo, cualquiera puede empezar desde ahora y realizar un gran final','Carl Brand',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(93,'Lo que logras por conseguir tus metas, no es tan importante como en lo que te conviertes cuando las alcanzas','Goethe',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(94,'Deberíamos usar el pasado como trampolín y no como sofá','Harold McMillan',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(95,'Si no te ves a ti mismo como un ganador no puedes actuar como un ganador','Zig Ziglar',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(96,'La clave del éxito depende sólo de lo que podamos hacer de la mejor manera posible','Henry W. Longfellow',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(97,'Mientras no abras tus alas, no tendrás idea de qué tan lejos puedes volar','Anónimo',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(98,'La mayoría de la gente gasta más tiempo y energías en esquivar los problemas que en resolverlos','Henry Ford',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(99,'Yo sabía que de lo único que podía arrepentirme, era de no intentarlo','Jeff Bezos, creador de Amazon',1,1,'2017-07-27 13:55:39','2017-07-27 13:55:39'),(100,'Nadie puede hacerte sentir inferior sin tu consentimiento','Eleanor Roosevelt',1,1,'2017-07-27 14:00:31','2017-07-27 14:00:31'),(101,'No desperdicies un buen error, aprende de él','Robert Kiyosaki',1,1,'2017-07-27 14:00:31','2017-07-27 14:00:31'),(102,'Por lo general cambiamos por una de las siguientes razones desesperación o inspiración','Jim Rohn',1,1,'2017-07-27 14:00:31','2017-07-27 14:00:31'),(103,'Las metas son sueños con fecha límite','Anónimo',1,1,'2017-07-27 14:00:31','2017-07-27 14:00:31');
/*!40000 ALTER TABLE `phrases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la encuesta',
  `title` varchar(50) NOT NULL COMMENT 'Título de la de la Encuesta',
  `description` text DEFAULT NULL COMMENT 'Descripción de la encuesta',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de la encuesta',
  `user_id` int(11) NOT NULL COMMENT 'Código del usuario que crea la encuesta',
  `course_id` int(11) NOT NULL COMMENT 'Código del curso donde se realiza la encuesta',
  `created` datetime NOT NULL COMMENT 'Fecha de creación',
  `modified` datetime NOT NULL COMMENT 'Fecha de actualización',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `polls_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `polls_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls`
--

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentations`
--

DROP TABLE IF EXISTS `presentations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `presentations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la presentación',
  `task_id` int(11) NOT NULL COMMENT 'Referencia al código de la tarea',
  `student_id` int(11) NOT NULL COMMENT 'Referencia al código del estudiante',
  `file` varchar(250) DEFAULT NULL COMMENT 'Archivo entregable para la tarea',
  `qualification` tinyint(4) DEFAULT NULL COMMENT 'Calificación de la tarea',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación de la presentación',
  `modified` datetime DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de activo de la presentación',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `presentations_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `presentations_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentations`
--

LOCK TABLES `presentations` WRITE;
/*!40000 ALTER TABLE `presentations` DISABLE KEYS */;
/*!40000 ALTER TABLE `presentations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la pregunta',
  `evaluation_id` int(11) NOT NULL COMMENT 'Referencia al código de la evaluación',
  `title` varchar(150) NOT NULL COMMENT 'Título de la pregunta',
  `description` text DEFAULT NULL COMMENT 'Descripción de la pregunta',
  `state` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación de la pregunta',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la útima modificación de la pregunta',
  PRIMARY KEY (`id`),
  KEY `evaluation_id` (`evaluation_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipients`
--

DROP TABLE IF EXISTS `recipients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipients` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del envió de un mensaje',
  `message_id` int(11) NOT NULL COMMENT 'Código del mensaje que se envía',
  `user_id` int(11) NOT NULL COMMENT 'Código de un usuario destinatario',
  `reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Estado Revisado/NoRevisado del mensaje, ''1'' para  Revisado y ''0'' para No revisado. Por defecto es No Revisado',
  `favourite` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Estado Favorito/NoFavorito del mensaje, ''0'' para No favorito y ''1'' para Favorito. Por defecto No es favorito',
  `trash` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Estado Basurero/NoBasurero, ''0'' para No esta en basurero y ''1'' para Enviar al basurero. Los mensajes del basurero son para eliminar definitivamente',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación de envío',
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `recipients_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipients`
--

LOCK TABLES `recipients` WRITE;
/*!40000 ALTER TABLE `recipients` DISABLE KEYS */;
/*!40000 ALTER TABLE `recipients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la respuesta',
  `question_id` int(11) NOT NULL COMMENT 'Referencia a código de la pregunta',
  `value` tinyint(4) NOT NULL COMMENT 'Valor de la respuesta',
  `participant_id` int(11) NOT NULL COMMENT 'Referencia al código del participante',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación de la respuesta',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `participant_id` (`participant_id`),
  CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `criterions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del rol',
  `name` varchar(50) NOT NULL COMMENT 'Nombre del rol',
  `description` varchar(150) DEFAULT NULL COMMENT 'Descripción del rol',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo del rol, ''1'' para Activo y ''0'' para Inactivo',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación del rol',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima actualización al rol',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator',NULL,1,'2017-05-13 22:21:01','2017-05-13 22:21:01'),(2,'programmer',NULL,0,'2017-05-13 22:21:56','2017-05-13 22:21:56'),(3,'teacher',NULL,1,'2017-05-13 22:21:56','2017-05-13 22:21:56'),(4,'student',NULL,1,'2017-05-13 22:22:25','2017-05-13 22:22:25');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso al cual pertenece el horario',
  `hour` float(10,2) DEFAULT NULL COMMENT 'Hora para el horario',
  `day` smallint(2) DEFAULT NULL COMMENT 'Día para el horario',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de propiedades',
  `sendEmail` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos?',
  `sendEmailUserAdd` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al agregar usuario?',
  `sendEmailUserEdit` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al editar usuario?',
  `sendEmailUserDisabled` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al desativar usuario?',
  `sendEmailCourseAdd` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al agregar curso?',
  `sendEmailInstructorAdd` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al agregar instructor?',
  `sendEmailParticipantAdd` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos al agregar participantes a un curso?',
  `sendEmailParticipantsComunicate` tinyint(1) NOT NULL DEFAULT 1 COMMENT '¿Enviar correos electrónicos a participantes?',
  `folder` varchar(250) NOT NULL DEFAULT '/home/siscap/dlince_siscap_folder/' COMMENT 'Dirección al directorio de los archivos subidos',
  `typeFiles` varchar(250) NOT NULL DEFAULT '''txt'', ''pdf'', ''zip'', ''rar'', ''7zip'', ''jpg'', ''gif'', ''jpeg'', ''png'', ''doc'', ''docx'', ''xls'', ''xlsx'', ''ppt'', ''pptx'', ''odt'', ''ods'', ''odp''' COMMENT 'Tipos de archivos aprobados en las subídas',
  `typeBanners` varchar(250) NOT NULL DEFAULT '''jpg'', ''gif'', ''jpeg'', ''png''' COMMENT 'Tipos de archivos para pancartas aprobados en las subídas',
  `limitsTime` varchar(50) NOT NULL DEFAULT '0,30,45,60,900,120' COMMENT 'Tiempos límites disponibles para rendir evaluaciones',
  `maxSizeFiles` varchar(20) NOT NULL DEFAULT '5242880' COMMENT 'Máximo tamaño para subida de archivos en Kilobytes',
  `maxSizeBanners` varchar(20) NOT NULL DEFAULT '150000' COMMENT 'Máximo tamaño para subida de pancartas en Kilobytes',
  `emailFrom` varchar(50) NOT NULL DEFAULT 'info@dlince.com' COMMENT 'Correo electrónico que envía los mensajes',
  `nameEmailFrom` varchar(50) NOT NULL DEFAULT 'DLince - Info' COMMENT 'Nombre del correo electrónico que envía los mensajes',
  `created` datetime NOT NULL COMMENT 'Fecha de creación de las configuraciones',
  `modified` datetime NOT NULL COMMENT 'Fecha de modificación de las configuraciones',
  `user_id` int(11) NOT NULL COMMENT 'Último usuario que edito las configuraciones',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,0,0,0,0,0,0,0,0,'/webapps/siscap/folder/','txt,pdf,zip,rar,7zip,jpg,gif,jpeg,png,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,pps','jpg','0,30,45,60,900,120','5202880','150600','info@dlince.com','DLince - Info','2017-10-15 12:45:29','2025-06-15 12:45:45',1);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de estado de curso',
  `description` varchar(15) NOT NULL COMMENT 'Descripción de estado de curso',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de curso',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código de usuario que crea el curso',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de ultima actualización',
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `states_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Activo',1,1,'2017-07-18 05:57:40','2017-07-18 05:57:40'),(2,'Inactivo',1,1,'2017-07-18 05:57:40','2017-07-18 05:57:40');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del estudiante',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código del usuario que es estudiante.',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo  del estudiante. ''0'' para Inactivo y ''1'' para Activo. Por defecto es Activo',
  `creator` int(11) NOT NULL COMMENT 'Referencia al código del usuario que crea el estudiante',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación del estudiante',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la ultima edición al estudiante',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `creator` (`creator`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `students_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (33,45,1,1,'2018-01-23 10:08:19','2018-01-23 10:08:19');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de la tarea',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso',
  `start` datetime NOT NULL COMMENT 'Fecha y hora de inicio de la tarea',
  `finish` datetime NOT NULL COMMENT 'Fecha y hora final para entrega de la tarea',
  `title` varchar(150) DEFAULT NULL COMMENT 'Título de la tarea',
  `description` text DEFAULT NULL COMMENT 'Descripción de la tarea',
  `filename` varchar(250) DEFAULT NULL COMMENT 'Archivo para considerar en la tarea',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código del usuario que crea la tarea',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de la creación de la tarea',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de la última modificación de la tarea',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado activo de la tarea',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del profesor',
  `resume` text DEFAULT NULL COMMENT 'Resumen de la hoja de vida del profesor',
  `web_page` varchar(256) DEFAULT NULL COMMENT 'URL de la página Web del profesor',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código de usuario que es profesor',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo del profesor, ''1'' para Activo y ''0'' para Inactivo',
  `creator` int(11) NOT NULL COMMENT 'Referencia al código de usuario creador del profesor',
  `created` datetime NOT NULL COMMENT 'Fecha de creación del profesor',
  `modified` datetime NOT NULL COMMENT 'Fecha de ultima actualización al profesor',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `creator` (`creator`),
  CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,NULL,NULL,46,1,1,'2025-06-15 12:42:40','2025-06-15 12:42:40');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código único de usuario',
  `dni` varchar(8) DEFAULT NULL COMMENT 'Número de DNI del usuario',
  `names` varchar(50) NOT NULL COMMENT 'Nombres del usuario',
  `father_surname` varchar(50) NOT NULL COMMENT 'Apellido paterno del usuario',
  `mother_surname` varchar(50) NOT NULL COMMENT 'Apellido materno del usuario',
  `role_id` int(11) NOT NULL COMMENT 'Código del rol del usuario',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado Activo/Inactivo del usuario, ''1'' para Activo y ''0'' para Inactivo',
  `email` varchar(50) NOT NULL COMMENT 'Correo electrónico de usuario',
  `password` varchar(255) NOT NULL COMMENT 'Contraseña del usuario',
  `changed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Estado Si-cambio/No-Cambio su contraseña, ''0'' para indicar que nunca se cambio y ''1'' para indicar que si se cambio',
  `last_login` datetime DEFAULT NULL,
  `when_changed` datetime DEFAULT NULL COMMENT 'Fecha y hora de la ultima vez que cambio su contraseña',
  `firm` text DEFAULT NULL COMMENT 'Firma del usuario',
  `created` datetime NOT NULL COMMENT 'Fecha de creación del usuario',
  `modified` datetime NOT NULL COMMENT 'Fecha de ultima actualización al usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `dni` (`dni`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'12345670','Lincoln','Hawk','Hawk',1,1,'admin@siscap.com','$2y$10$O6d7V7dhwE26I9H/yfLIh.NyYKV4RAPe78JTqN7p4w42eqQ1jeHZi',1,'2025-06-15 19:30:33','2025-06-15 11:49:28',NULL,'2017-07-17 22:34:49','2025-06-15 12:41:01'),(45,'12345678','Michael','Hawk','Hawk',4,1,'student@siscap.com','$2y$10$L16ETxZ70QQjWj6QbHgKUu82q.FSizzHv4/Gopi4XENKJ/XbpvXHi',1,'2018-01-23 12:45:10','2025-06-15 11:49:39',NULL,'2018-01-23 10:08:19','2025-06-15 12:41:29'),(46,'12345679','Bob','Hurley','Hurley',3,1,'teacher@siscap.com','$2y$10$4VKWW4Ko.XCvfnePCKXyJe1E/O65uTu7M6H5gvWW637rYLqH6dMtW',0,NULL,NULL,NULL,'2025-06-15 12:42:40','2025-06-15 12:42:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código del video',
  `title` varchar(150) DEFAULT NULL COMMENT 'Título del video',
  `description` text DEFAULT NULL COMMENT 'Descripción del video',
  `url` varchar(250) NOT NULL COMMENT 'URL del video en youtube, vimeo, etc...',
  `width` smallint(6) NOT NULL DEFAULT 640 COMMENT 'Ancho en pixeles del IFRAME del video',
  `height` smallint(6) NOT NULL DEFAULT 360 COMMENT 'Alto en pixeles del IFRAME del video',
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado del video',
  `user_id` int(11) NOT NULL COMMENT 'Referencia al código del usuario que publica',
  `course_id` int(11) NOT NULL COMMENT 'Referencia al código del curso',
  `created` datetime NOT NULL COMMENT 'Fecha y hora de creación',
  `modified` datetime NOT NULL COMMENT 'Fecha y hora de ultima actualización',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-16  0:44:27
