<?php

namespace Src\Interfaces;

interface Repository
{
    public function insert(string $query, array $bidings): bool;
    public function update(string $query, array $bidings): bool;
    public function select(string $query, array $bidings): array;
}