<?php
/**
 * Class for creation database and tables
 */

namespace Vav\Core\SQL;

use Vav\Core\Connector\PdoConnector;

class Install
{
    /**
     * @var \PDO
     */
    private static $PDO;

    private $createGoal = "
        DROP TABLE IF EXISTS `goal`;
        /*!40101 SET @saved_cs_client     = @@character_set_client */;
        /*!40101 SET character_set_client = utf8 */;
        CREATE TABLE `goal` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) unsigned DEFAULT NULL,
          `name` varchar(255) NOT NULL,
          `price` decimal(10,2) NOT NULL,
          `priority` int(11) DEFAULT NULL,
          `fsum` decimal(10,2) DEFAULT NULL,
          `fperiod` varchar(10) DEFAULT NULL,
          `deadline` varchar(36) DEFAULT NULL,
          `auto` int(1) DEFAULT '0',
          `paid_sum` decimal(10,2) NOT NULL DEFAULT '0.00',
          `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `fk_user_id` (`user_id`),
          CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
        /*!40101 SET character_set_client = @saved_cs_client */;
    ";

    private $createUser = "
        DROP TABLE IF EXISTS `user`;
        /*!40101 SET @saved_cs_client     = @@character_set_client */;
        /*!40101 SET character_set_client = utf8 */;
        CREATE TABLE `user` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) DEFAULT NULL,
          `email` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `uk_email` (`email`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
        /*!40101 SET character_set_client = @saved_cs_client */;

        LOCK TABLES `user` WRITE;
        /*!40000 ALTER TABLE `user` DISABLE KEYS */;
        INSERT INTO `user` VALUES (1,'Alexey','l.e.h.a.vav@gmail.com','test');
        /*!40000 ALTER TABLE `user` ENABLE KEYS */;
        UNLOCK TABLES;
        /*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
    ";

    /**
     * Instantiate PDO
     */
    public function __construct()
    {
        if (!isset(self::$PDO)) {
            self::$PDO = PdoConnector::getConnector();
        }
    }

    public function prepareFoundation($event)
    {
        echo PHP_EOL;
        print_r($event);
        echo PHP_EOL;
        die();
        self::$PDO->query('CREATE DATABASE IF NOT EXISTS ' . DB_NAME);
        self::$PDO->query('USE ' . DB_NAME);
        $this->createTables();
    }

    public function createTables()
    {
        self::$PDO->exec($this->createUser);
        self::$PDO->exec($this->createGoal);
    }
} 