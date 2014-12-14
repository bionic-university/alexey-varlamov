<?php
/**
 * Create PDO object
 */

namespace Vav\Core\Connector;

use Vav\CashTarget\Vav;

class PdoConnector
{
    /**
     * @return \PDO
     */
    public static function getConnector()
    {
        try {
            $PDO = new \PDO(DSN, USER, PWD);
            $PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $PDO->exec('SET NAMES utf8');
        } catch (\PDOException $e) {
            Vav::log('Error: ' . $e->getMessage());
        }

        return $PDO;
    }
} 