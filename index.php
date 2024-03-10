<?php

require_once 'autoload.php';
require_once 'config.php';

use Src\Helpers\File;
use Src\Helpers\Time;
use Src\Playground;
use Src\PostgresRepository;

$ln = '';
$R  = 10;
$B  = 30;

$playground = new Playground(new PostgresRepository());

echo 'Criando banco de dados e tabela...' . PHP_EOL;

$playground->runMigrations();

echo 'Banco de dados e tabela criados.' . PHP_EOL;

$report = new File();

$pipeline = [
    'inserts' => 'runInsert',
    'updates' => 'runUpdate',
    'selects' => 'runSelect',
];

foreach($pipeline as $name => $operation) {
    $time = new Time();
    $pk = 1;

    echo  PHP_EOL . 'Iniciando: ' . $name .'...' . PHP_EOL;

    $report->putLine("r;$name(s)");

    $time->startTime();

    foreach(range(1, $R) as $it_r) {
        foreach(range(1, $B) as $it_b) {
            $playground->{$operation}($pk);
            $time->endTime();
            $m = $time->elapsedTime()/1e9/$B;
            $report->putLine("$it_r;$m");
            $pk++;
        }
    }

    $time->endTime();

    echo 'Finalizado:  ' . $name .'. Em: ' . $time->elapsedTime() . ' s' . PHP_EOL;
}

$report->save();
