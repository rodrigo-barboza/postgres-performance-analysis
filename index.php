<?php
// --------------------------------------------------------------------
// ANÁLISE DE DESEMPENHO DE SISTEMAS
// --------------------------------------------------------------------
//
// Descrição: Programa sintético escrito em PHP para análise de 
// desempenho do banco de dados PostgreSQL.
// Autor: Rodrigo Leandro Ramos Barboza da Silva
// Data: 9 de março de 2024
//====================================================================

require_once 'autoload.php';
require_once 'config.php';

use Src\Helpers\File;
use Src\Helpers\Time;
use Src\Playground;
use Src\PostgresRepository;

$playground = new Playground(new PostgresRepository());

echo 'Criando banco de dados e tabela...' . PHP_EOL;

$playground->runMigrations();

echo 'Banco de dados e tabela criados.' . PHP_EOL;

$report = new File();

$loop_size  = 10;
$block_size  = 30;

$pipeline = [
    'inserts' => 'runInsert',
    'updates' => 'runUpdate',
    'selects' => 'runSelect',
];

foreach($pipeline as $name => $operation) {
    $time = new Time();
    $primary_key = 1;

    echo  PHP_EOL . 'Iniciando: ' . $name .'...' . PHP_EOL;

    $report->putLine("r;$name(s)");

    $time->startTime();

    foreach(range(1, $loop_size) as $loop_index) {
        foreach(range(1, $block_size) as $block_index) {
            $playground->{$operation}($primary_key);
            $time->endTime();
            $primary_key++;
        }
        $avg = $time->blockAvg($block_size);
        $report->putLine("$loop_index;$avg");
    }

    $time->endTime();

    echo 'Finalizado(' . $name .'). Em: ' . $time->elapsedTime() . ' s' . PHP_EOL;
}

$report->save();
