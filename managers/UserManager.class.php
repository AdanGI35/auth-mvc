<?php 

require "AbstractManager.class.php";
require "models/User.class.php";

class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAll () : array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $users_array = [];
        
        foreach($users as $user) {
            $user1 = new User($user["email"], $user["password"]);
            $user1->setId($user["id"]);
            $this->$users_array[]=$user;
        }
        
        return $users_array;   
    }
    
    public function findOne (int $id) : ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
      
        if ($user) {
            $user1 = new User($user["email"], $user["password"]);
            $user1->setId($user["id"]);
            
            return $user1;
        }
        return null;
    }
    
    public function create (User $user) : void
    {
        $query = $this->db->prepare('INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, :created_at)');
        $parameters = [
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),

        ];
        $query->execute($parameters);
        $user->setId($this->db->lastInsertId());
    }
    
    public function update (User $user) : void
    {
        $query = $db->prepare('UPDATE users SET email = :email, password = :password');
        $parameters = [
            'email' => getEmail(),
            'password' => getPassword(),

        ];

        $query->execute($parameters);
    }
    
    public function delete (int $id) : void
    {
        $query = $db->prepare('DELETE FROM users WHERE id = :id');
        $parameters = [
            'id' => $id
        ];
        
        $query->execute($parameters);
    }
    
    public function checkLogin() {
        if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
    
            // Je vérifie dans la base de données si un utilisateur existe avec cet email    
            $query = $this->db->prepare('SELECT * FROM users WHERE email = :loginEmail');
            $parameters = [
                'loginEmail' => $_POST['loginEmail']
                ];
            $query->execute($parameters);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            }
        }
    
        
    public function checkSignin() {
        if (isset($_POST["signinEmail"]) && isset($_POST["signinPassword"])) 
        {
            if ($_POST["signinPassword"] !== $_POST["verifPassword"]) {
                header("Location: ../index.php?route=inscription");
            } 
            else 
            {
                $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
                $parameters = [
                    'email' => $_POST['signinEmail']
                    ];
                $query->execute($parameters);
                $user = $query->fetch(PDO::FETCH_ASSOC);
                
                }
            }
        }
    }