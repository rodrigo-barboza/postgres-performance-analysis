<?php

namespace Src;

use PDOException;
use RuntimeException;

abstract class PostgresManager extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createDefaultTable(string $table_name): void
    {
        $schema = "
            CREATE TABLE IF NOT EXISTS $table_name (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100),
                email VARCHAR(100)
            )
        ";

        try {
            $this->connection->exec($schema);
        } catch (PDOException $error) {
            throw new RuntimeException('Erro ao criar a tabela');
        }
    }

    public function dropTabeIfExists(string $table_name): void
    {
        $query = "SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_name = :table)";

        $builder = $this->connection->prepare($query);
        $builder->execute([':table' => $table_name]);

        $exists_table = $builder->fetchColumn();

        if ($exists_table) {
            $query = "DROP TABLE $table_name";
            $this->connection->exec($query);
        }
    }

    public function migrate(): void
    {
        $this->dropTabeIfExists('testing_ads');
        $this->createDefaultTable('testing_ads');
    }
}
