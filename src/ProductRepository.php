<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/10/2017
 * Time: 14:02
 */

namespace Itb;


class ProductRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function dropTable()
    {
        $sql = "DROP TABLE IF EXISTS products";
        $this->connection->exec($sql);
    }

    public function createTable()
    {
        // drop table if it already exists
        // (removing all old data)
        $this->dropTable();

        $sql = "
            CREATE TABLE IF NOT EXISTS products (
            id integer not null primary key auto_increment,
            description text,
            price float)
        ";

        $this->connection->exec($sql);
    }

    public function insert($description, $price)
    {
        // Prepare INSERT statement to SQLite3 file db
        $sql = 'INSERT INTO products (description, price) 
			VALUES (:description, :quantity)';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $price);

        // Execute statement
        $stmt->execute();
    }

    public function update($id, $description, $price)
    {
        $sql = "UPDATE products SET description = :description, price = :price WHERE id=:id";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }

    public function deleteAll()
    {
        $sql = 'DELETE FROM products';
        $this->connection->exec($sql);
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM products';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Product');

        $products = $stmt->fetchAll();

        return $products;
    }


    public function getOne($id)
    {
        $sql = 'SELECT * FROM products WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);

        // Execute statement
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Product');

        $product = $stmt->fetch();

        return $product;


    }
}