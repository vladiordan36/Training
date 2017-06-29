<?php
require_once('config.php');

$link = mysqli_connect(DBSERVER, DBUSER, DBPASS, DBNAME);

if (!$link) {
    echo "Connection failed" . PHP_EOL . "<br />";
    echo "Error number: " . mysqli_connect_errno() . PHP_EOL . "<br />";
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}