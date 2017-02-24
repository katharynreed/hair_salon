<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Client.php';

$server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);


?>
