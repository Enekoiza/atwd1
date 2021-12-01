<?php


//!                          DATABASE CONNECTION VARIABLES                       //

$host = 'localhost';
$dbname = 'Currencies';
$username = 'root';
$pass = '';

$dbOptions = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, //Get an error on a query
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Fetch associative array
    \PDO::ATTR_EMULATE_PREPARES   => false,
];

$dbroute = "mysql:host=localhost;dbname=Currencies";

$dbValues = array(
    'host' => 'localhost',
    'dbname' => 'Currencies',
    'username' => 'root',
    'pass' => '',
    'dbOptions' => [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, //Get an error on a query
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // Fetch associative array
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ]

);

//!                          --------------------------                          //


$currencies = array('AUD', 'BRL', 'CAD', 'CHF', 'CNY', 'DKK', 'EUR', 'HKD', 'HUF', 'INR', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'USD', 'ZAR');


?>
