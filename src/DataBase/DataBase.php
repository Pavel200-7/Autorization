<?php

namespace App\DataBase;

use PDO;

class DataBase
{
    protected $pdo;
    private string $pathToDB;

    public function __construct() {
        $this->pathToDB = dirname(__DIR__, 2) . '/data/data.db';
        $dsn = "sqlite:$this->pathToDB";

        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $initQuery = <<<initQuery
            CREATE TABLE IF NOT EXISTS users (
                                    id INTEGER PRIMARY KEY,
                                    name TEXT, 
                                    phone TEXT,
                                    email TEXT,
                                    password TEXT
                                             )
        initQuery;

        $this->pdo->exec($initQuery);
    }
}

