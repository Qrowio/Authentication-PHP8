<?php
declare(strict_types=1);

class Database
{
    protected PDO $connection;
    const host = 'localhost';
    const name = 'strictauth';
    const username = 'root';
    const password = '';

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=".self::host.";dbname=".self::name."", self::username, self::password);
        } catch (PDOException $error) {
            echo $error;
        }
    }
}