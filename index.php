<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

require_once 'vendor/autoload.php';

header('Content-Type: application/json');


$query = new Query();
$queryLog =  $query
    ->table('master')
    ->select('id', 'name', 'email')
    ->where([
        'column' => 'id',
        'value' => 1,
        'operator' => '>'
    ],
    [
        'column' => 'name',
        'value' => 'John Doe',
        'operator' => '='
    ],
    [
        'elements' => [
            [
                'column' => 'email',
                'value' => 'heyneupkishor@gmail.com'
            ]
        ]
    ])
    ->whereOr([
        'column' => 'id',
        'value' => 1,
        'operator' => '>'
    ],
    [
        'column' => 'name',
        'value' => 'John Doe',
        'operator' => '='
    ])
    ->limit(10)
    ->groupBy('name')
    ->sortBy('id', 'ASC')
    ->build();

echo json_encode($queryLog);