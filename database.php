<?php

class Connection
{

    //function to connect user_accounts database
    public static function connectToDB()
    {
        try {
            return new PDO ("mysql:host=127.0.0.1; dbname=udhs_db", "root", "");
        } catch
        (PDOException $e) {
            die ($e->getMessage());
        }
    }
}

//connection to database
$pdo = Connection::connectToDB();
?>