<?php
declare(strict_types=1);

class Register extends Database
{
    private string $email;
    private string $username;
    private string $password;
    private string $confirm;
    private string $hashed;
    private PDOStatement $sql;
    private bool|array $row;

    public function __construct()
    {
        parent::__construct();
        if(isset($_POST['submit']))
        {
            $this->email = filter_var(strtolower($_POST['email']),FILTER_SANITIZE_EMAIL);   
            $this->username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);   
            $this->password = strip_tags($_POST['password']);   
            $this->confirm = strip_tags($_POST['confirm']);

            if(empty($this->email) || empty($this->username) || empty($this->password) || empty($this->confirm) || $this->password != $this->confirm)
            {
                echo "Please ensure the entire form is correct and submitted.";
            } else
            {
                try
                {
                    $this->hashed = password_hash($this->password,PASSWORD_DEFAULT);
                    $this->row = $this->select('email', 'users', ['email' => "$this->email"]);
                    if(!empty($this->row))
                    {
                        echo "The user already exists!";
                    } else 
                    {   
                        $this->sql = $this->connection->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
                        $this->sql->execute([
                            ':email' => $this->email,
                            ':username' => $this->username,
                            ':password' => $this->hashed
                        ]);
                        header('location: index.php');
                    }
                } catch(PDOException $error)
                {
                    echo $error;
                }
            }
        }
    }
}