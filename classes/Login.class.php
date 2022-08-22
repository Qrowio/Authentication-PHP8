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
                    $this->row = $this->select('id, email, username, password', 'users', ['email' => $this->email]);  
                    if(!empty($this->row))
                    {
                        if(password_verify($this->password, $this->row[0]['password']))
                        {
                            $_SESSION['user']['id'] = $this->row[0]['id'];
                            $_SESSION['user']['email'] = $this->row[0]['email'];
                            $_SESSION['user']['username'] = $this->row[0]['username'];
                            header('location: ./dashboard/welcome.php');
                        } else {
                            echo "Wrong credentials!";
                        }
                    } else {
                        echo "Wrong credentials!";
                    }
                } catch(PDOException $error)
                {
                    echo $error;
                }
            }
        }
    }
}