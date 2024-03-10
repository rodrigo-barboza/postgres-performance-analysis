<?php

const DEFAULT_CONNECTION = 'pgsql';

function config(string $key, string $connection = DEFAULT_CONNECTION): string
{
    if (!isValidKey($key, $connection)) {
        return 'Conexão ou chave inválida.';
    }

    return getKey($key, $connection);
}

function connections(): array
{
    return [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'port' => '5432',
            'database' => 'ads_pgsql_php',
            'username' => 'postgres',
            'password' => '12345',
            'dsn' => 'pgsql:host=localhost;dbname=ads_pgsql_php',
        ],
    ];
}

function isValidKey(string $key, string $connection): bool
{
    return in_array($connection, array_keys(connections()))
        && in_array($key, array_keys(connections()[$connection]));
}

function getKey(string $key, string $connection): string
{
    return connections()[$connection][$key];
}
