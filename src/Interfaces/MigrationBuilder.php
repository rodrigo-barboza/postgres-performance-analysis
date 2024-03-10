<?php

namespace Src\Interfaces;

interface MigrationBuilder
{
    public function dropTabeIfExists(string $table_name): void;
    public function createDefaultTable(string $table_name): void;
    public function migrate(): void;
}
