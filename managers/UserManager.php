<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class UserManager extends AbstractManager
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return PDO
     */
    public function getDb() : PDO
    {
        return $this->db;
    }

    /**
     * @param string $email
     * @return User
     */
    public function findOne(string $email) : User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $parameters = [
            "email" => $email,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if($user !== null)
        {
            $item = new User($user["username"], $user["email"], $user["password"], $user["role"], DateTime::createFromFormat('Y-m-d H:i:s', $user["created_at"]));
            $item->setId($user["id"]);
        }
        else
        {
            $item = new User("", "", "", "", new DateTime());
        }

        return $item;
    }

    /**
     * @param User $user
     * @return void
     */
    public function create(User $user) : void
    {
        $currentDateTime = date('Y-m-d H:i:s');

        $query = $this->db->prepare('INSERT INTO users (id, username, email, password, role, created_at) VALUES (NULL, :username, :email, :password, :role, :created_at)');
        $parameters = [
            "username" => $user->getUsername(),
            "password" => $user->getPassword(),
            "email" => $user->getEmail(),
            "role" => $user->getRole(),
            "created_at" => $currentDateTime,
        ];

        $query->execute($parameters);

        $user->setId($this->db->lastInsertId());
    }
}