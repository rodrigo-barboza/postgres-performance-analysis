<?php

require_once 'autoload.php';
require_once 'config.php';

use Src\Helpers\Time;
use Src\Playground;
use Src\PostgresRepository;

$ln = '';
$R  = 100;
$B  = 300;

$playground = new Playground(new PostgresRepository());

echo 'Criando banco de dados e tabela...' . PHP_EOL;

$playground->runMigrations();

echo 'Banco de dados e tabela criados.' . PHP_EOL;

foreach(['runInsert', 'runUpdate', 'runSelect'] as $operation) {
    $time = new Time();
    $pk = 1;

    echo  PHP_EOL . 'Iniciando ' . $operation .'...' . PHP_EOL;

    $time->startTime();
    foreach(range(1, $R) as $it_r) {
        foreach(range(1, $B) as $it_b) {
            $playground->{$operation}($pk);
            $pk++;
        }
    }
    $time->endTime();

    echo 'Finalizado:  ' . $operation .'. Em: ' . $time->elapsedTime() . ' s' . PHP_EOL;
}
