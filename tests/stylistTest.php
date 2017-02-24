<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/stylist.php';

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client ($client_name);
            $test_Client->save();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $client_id = $test_Client->getId();
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $result = $test_stylist->getName();

            $this->assertEquals('Sally Style', $result);
        }
    }


?>
