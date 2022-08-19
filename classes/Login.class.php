<?php
declare(strict_types=1);

class Login extends Database
{
    private string $email;
    private string $password;
    private PDOStatement $sql;
    private array $row;

    public function __construct()
    {
        parent::__construct();
        if(isset($_POST['submit']))
        {
            $this->email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);   
            $this->password = strip_tags($_POST['password']);
            if(empty($this->email) || empty($this->password))
            {
                echo "Please fill the form in!";
            } else 
            {
                try
                {
                    $this->sql = $this->connection->prepare("SELECT id, email, username, password FROM users WHERE email = :email");
                    $this->sql->execute([':email' => $this->email]);
                    $this->row = $this->sql->fetch(PDO::FETCH_ASSOC);
                    if($this->sql->rowCount() > 0)
                    {
                        if(password_verify($this->password, $this->row['password']))
                        {
                            $_SESSION['user']['id'] = $this->row['id'];
                            $_SESSION['user']['email'] = $this->row['email'];
                            $_SESSION['user']['username'] = $this->row['username'];
                            header('location: ./dashboard/welcome.php');
                        }
                    }
                } catch(PDOException $error)
                {
                    echo $error;
                }
            }
        }
    }
}