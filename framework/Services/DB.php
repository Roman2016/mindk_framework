<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 09.03.2016
 * Time: 13:11
 */

namespace Framework\Services;

use Framework\DI\Service;

/**
 * Class DB
 * @package Framework\Services
 */
class DB
{
    /**
     * Array of database connection parameters
     *
     * @var
     */
    private $pdo = array();

    /**
     * Get array of connection parameters for database
     *
     * DB constructor.
     */
    public function __construct()
    {
        $this->pdo = Service::get('config')->get('pdo');
    }

    /**
     * Return class of database connection
     * with required parameters
     *
     * @return \PDO
     */
    public function getDB()
    {
        $dsn = $this->pdo['dns'];
        $user = $this->pdo['user'];
        $pass = $this->pdo['password'];
        $opt = array(\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC);
        return new \PDO($dsn, $user, $pass, $opt);
    }
}
