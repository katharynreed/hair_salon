<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/client.php';

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
            $test_Client = new Client($client_name);
            $test_Client->save();

            $result = $test_Client->getName();

            $this->assertEquals('Jane Doe', $result);
        }

        function test_getId()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();

            $result = $test_Client->getId();

            $this->assertEquals(true, is_numeric($result));

        }

        function test_find()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();

            $result = Client::find($test_Client->getId());

            $this->assertEquals($test_Client, $result);
        }

        function test_update()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();

            $new_name = 'Robin Sparkles';

            $test_Client->update($new_name);

            $this->assertEquals('Robin Sparkles', $test_Client->getName());
        }

        function test_delete()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();

            $client_name2 = 'John Doe';
            $test_Client2 = new Client ($client_name2);
            $test_Client2->save();

            $test_Client->delete();

            $this->assertEquals([$test_Client2], Client::getAll());
        }

        function test_getAll()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();

            $client_name2 = 'John Doe';
            $test_Client2 = new Client ($client_name2);
            $test_Client2->save();

            $result = Client::getAll();

            $this->assertEquals([$test_Client, $test_Client2], $result);
        }

        function test_deleteAll()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
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
