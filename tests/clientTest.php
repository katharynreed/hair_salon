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
            Stylist::deleteAll();
        }

        function test_getName()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $result = $test_Client->getName();

            $this->assertEquals('Jane Doe', $result);
        }

        function test_getId()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $result = $test_Client->getId();

            $this->assertEquals(true, is_numeric($result));

        }

        function test_find()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();
            print_r("STEP 1 CLIENT: \n");
            print_r($test_Client);

            $result = Client::find($test_Client->getId());

            $this->assertEquals($test_Client, $result);
        }

        function test_update()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $new_name = 'Robin Sparkles';

            $test_Client->update($new_name);

            $this->assertEquals('Robin Sparkles', $test_Client->getName());
        }

        function test_delete()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $client_name2 = 'John Doe';
            $test_Client2 = new Client ($client_name2, $stylist_id);
            $test_Client2->save();

            $test_Client->delete();

            $this->assertEquals([$test_Client2], Client::getAll());
        }

        function test_getAll()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $client_name2 = 'John Doe';
            $test_Client2 = new Client ($client_name2, $stylist_id);
            $test_Client2->save();

            $result = Client::getAll();

            $this->assertEquals([$test_Client, $test_Client2], $result);
        }

        function test_deleteAll()
        {
            $stylist_name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($stylist_name, $bio);
            $test_stylist->save();

            $client_name = 'Jane Doe';
            $stylist_id = $test_stylist->getId();
            $test_Client = new Client($client_name, $stylist_id);
            $test_Client->save();

            $client_name2 = 'John Doe';
            $test_Client2 = new Client ($client_name2, $stylist_id);
            $test_Client2->save();

            Client::deleteAll();
            $result = Client::getAll();

            $this->assertEquals([], $result);
    }
}

?>
