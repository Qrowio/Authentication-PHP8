<?php
declare(strict_types=1);

class Database
{
    protected PDO $connection;
    const host = 'localhost';
    const name = 'strictauth';
    const username = 'root';
    const password = '';
    private PDOStatement $statement;
    private array $row;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=".self::host.";dbname=".self::name."", self::username, self::password);
        } catch (PDOException $error) {
            echo $error;
        }
    }

    public function select(string $column, string $table, array $where = []) : array
    {
        try 
        {
            if(empty($column) || empty($table))
            {
                return array();
            } else
            {   
                if(!empty($where))
                {
                    $string;
                    foreach($where as $key => $val)
                    {
                        $string = $key . ' = :' . $key;
                    }
    
                    $this->statement = $this->connection->prepare("SELECT $column FROM $table WHERE $string");
    
                    foreach($where as $key => $val)
                    {
                        $this->statement->bindValue(":" . $key, $val);
                    }
                }

                if(empty($where))
                {
                    $this->statement = $this->connection->prepare("SELECT $column FROM $table");
                }
                $this->statement->execute();
                return $this->statement->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $error) {
            echo $error;
        }
    }

    public function delete(string $table, array $where = [])
    {
        if(empty($table))
        {
            return $where;
        } 

        if(!empty($where))
        {
            foreach($where as $key => $val)
            {
                $string = $key . "= :" . $key;
            }
            
            $this->statement = $this->connection->prepare("DELETE FROM $table WHERE $string");

            foreach($where as $key => $val)
            {
                $this->statement->bindValue(':' . $key, $val);
            }   
            return $this->statement->execute();
        }
        
        if(empty($where))
        {
            echo $table;
            $this->statement = $this->connection->prepare("DELETE FROM $table");
            $this->statement->execute();
            return 'Table deleted';
        }
    }

    // public function insert(string $table, array $columns = [], array $values = [])
    // {
    //     if(empty($table) || empty($columns) || empty($values))
    //     {
    //         return "Please insert correctly";
    //     } else
    //     {
    //         // INSERT INTO table (columns) VALUES (:values)
    //         return;
    //     }
    // }
}