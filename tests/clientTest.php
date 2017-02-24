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

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Client::deleteAll();
    }

    function test_getName()
    {
        $client_name = 'Jane Doe';
        $test_Client = new Client ($client_name);
        $test_Client->save();

        $result = $test_Client->getName();

        $this->assertEquals('Jane Doe', $result);
    }

    function test_getId()
    {
        $client_name = 'Jane Doe';
        $test_Client = new Client ($client_name);
        $test_Client->save();

        $result = $test_Client->getId();

        $this->assertEquals(true, is_numeric($result));

    }

    function test_deleteAll()
    {
        $client_name = 'Jane Doe';
        $test_Client = new Client ($client_name);
        $test_Client->save();

        $client_name2 = 'John Doe';
        $test_Client2 = new Client ($client_name2);
        $test_Client2->save();

        Client::deleteAll();
        $result = Client::getAll();

        $this->assertEquals([], $result);
    }
}

?>
