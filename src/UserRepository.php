<?php

namespace Itb;

class UserRepository
{
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function dropTable()
    {
        $sql = "DROP TABLE IF EXISTS users";
        $this->connection->exec($sql);
    }

    public function createTable()
    {
        $this->dropTable();

        $sql = "CREATE TABLE IF NOT EXISTS users (
            id integer not null primary key auto_increment,
            username text, password text)";

        $this->connection->exec($sql);
    }

    public function insert($username, $password)
    {
        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare INSERT statement to SQLite3 file db
        $sql = 'INSERT INTO users (username, password) 
			VALUES (:username, :password)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }


    public function getAll()
    {
        $sql = 'SELECT * FROM users';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\User');

        $user = $stmt->fetchAll();
        return $user;
    }

    public function getOne($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);

        // Execute statement
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\User');

        $user = $stmt->fetch();
        return $user;
    }

    public function deleteAll()
    {
        $sql = 'DELETE FROM users';
        $stmt = $this->connection->exec($sql);
        return $stmt;
    }
}