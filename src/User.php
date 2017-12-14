<?php
namespace Itb;

class User
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    private $id;
    private $username;
    private $password;
    private $role;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRoleAsString()
    {
        switch($this->role){
            case self::ROLE_ADMIN:
                return 'ROLE_ADMIN';
                break;

            case self::ROLE_USER:
                return 'ROLE_USER';
                break;

            default:
                return 'error - unknown user role!';
        }
    }

    public static function verifyAction($username, $password)
    {
        $user = User::getOneByUsername($username);

        if(null == $user){
            return false;
        }

        $passss = $user->getPassword();

        if ($password == $passss) {
            return true;
        }
        //return password_verify($password, $passss);
    }

    public static function getOneByUsername($username)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\User');

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }


    public function update($id, $username, $password)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "UPDATE users SET username = :username, password = :password WHERE id=:id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
}