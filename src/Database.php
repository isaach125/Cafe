<?php
namespace Itb;


class Database
{
    const DB_NAME = 'test';
    const DB_USER = 'root';
    const DB_PASS = 'pass';
    const DB_HOST = 'localhost:3306';

    // the private connection property
    private $connection;

    /*w
     * create and store SQLIte / MySQL db connection ...
     */
    public function __construct()
    {
        try{
            $this->connection = $this->createMysqlConnection();
        } catch(\Exception $e){
            print $e;
        }
    }

    /*
     * create a new MySQL db connection
     */
    private function createMysqlConnection()
    {
        $dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST;
        return new \PDO($dsn, self::DB_USER, self::DB_PASS);
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

}
