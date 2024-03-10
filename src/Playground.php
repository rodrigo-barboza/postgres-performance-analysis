<?php

namespace Src;

use Src\PostgresRepository;

class Playground
{
    public function __construct(private PostgresRepository $manager)
    {
    }

    public function runMigrations(): void
    {
        $this->manager->migrate();
    }

    public function runInsert(string $id): void
    {
        $this->manager->insert(
            'INSERT INTO testing_ads (name, email) VALUES (:name, :email)',
            [':name' => 'rodrigo', ':email' => 'rodrigo@mail.com'],
        );
    }

    public function runUpdate(string $id): void
    {
        $this->manager->update(
            'UPDATE testing_ads SET name = :name, email = :email WHERE id = :id',
            [':name' => 'rodrigo_' . $id, ':email' => 'rodrigo@mail.com', ':id' => $id],
        );
    }

    public function runSelect(string $id): void
    {
        $this->manager->select('SELECT name, email FROM testing_ads WHERE id = :id', [':id' => $id]);
    }
}
