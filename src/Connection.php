<?php

namespace App;

use PDO;

class Connection 
{
    public static function getPDO (): PDO
    {
        return new PDO('mysql:host=localhost;dbname=blog-fik6t', "root", "admin", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}