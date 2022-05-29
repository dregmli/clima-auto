<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Principal\SMNClient;

echo "Iniciadno Programa: \n";

date_default_timezone_set('America/Mexico_City');

$program = new SMNClient();

while(true){

    $program->start();
    sleep(5*60);

}
