<?php

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = 'Shubh1905s';
$DATABASE='signupforms';

$con = mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if (!$con) {
    echo "Connection unsuccessful";
}
?>