<?php
declare(strict_types=1);

class Session {
    
    public function user()
    {
        if(isset($_SESSION['user']))
        {
            header("location: ./dashboard/welcome.php");
        }
    }

    public function dashboard()
    {
        if(!isset($_SESSION['user']))
        {
            header("location: ../index.php");
        }
    }
}