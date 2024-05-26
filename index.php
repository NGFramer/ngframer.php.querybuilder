<?php

use NGFramer\NGFramerPHPSQLBuilder\Query;

include_once "vendor/autoload.php";

header('Content-Type: application/json');


$query = new Query();
$sqlQuery = $query->table('users')->alter()
    ->addColumn('id')->type('int')->autoIncrement()->primary()->dropPrimary()
    ->select('username')->type('varchar')->unique()->notNull()
    ->select('email')->type('varchar')->length(255)->unique()->notNull()
    ->build();

echo json_encode($sqlQuery);