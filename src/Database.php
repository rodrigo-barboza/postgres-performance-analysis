<?php

namespace Src;

use PDO;
use PDOException;

abstract class Database
{
    protected PDO $connection;

    public function __construct()
    {
        try {
            $this->connection = $this->createPdoConnection();
        } catch (PDOException $error) {
            throw new PDOException('Erro ao conectar-se ao banco de dados');
        }
    }

    private function createPdoConnection(): PDO
    {
        return new PDO(config('dsn'), config('username'), config('password'));
    }

    public abstract function createDefaultTable(string $table_name): void;

    public abstract function dropTabeIfExists(string $table_name): void;

    public abstract function migrate(): void;
}
