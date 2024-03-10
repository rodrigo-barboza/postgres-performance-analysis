<?php

namespace Src;

use PDO;
use Src\Interfaces\Repository;

class PostgresRepository extends PostgresManager implements Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(string $query, array $bindings): bool
    {
        $builder = $this->connection->prepare($query);

        return $builder->execute($bindings);
    }

    public function update(string $query, array $bindings): bool
    {
        $builder = $this->connection->prepare($query);

        return $builder->execute($bindings);
    }

    public function select(string $query, array $bindings): array
    {
        $builder = $this->connection->prepare($query);
        $builder->execute($bindings);

        return $builder->fetchAll(PDO::FETCH_ASSOC);
    }
}
