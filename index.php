<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

require_once 'vendor/autoload.php';

header('Content-Type: application/json');


$query = new Query();
$queryLog =  $query
    ->view('master')->select('id', 'name', 'email')
    ->buildLog();

echo json_encode($queryLog);