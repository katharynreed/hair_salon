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
            //get above stylist FROM database
            //compare result from DB to 'Sally Style'

            $result = $test_stylist->getName();

            $this->assertEquals('Sally Style', $result);
        }

        function test_getId()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client ($client_name);
            $test_Client->save();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $client_id = $test_Client->getId();
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $result = $test_stylist->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_find()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client ($client_name);
            $test_Client->save();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $client_id = $test_Client->getId();
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $result = Stylist::find($test_stylist->getId());

            $this->assertEquals($test_stylist, $result);
        }

        function test_update()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client ($client_name);
            $test_Client->save();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $client_id = $test_Client->getId();
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $new_name = 'Sally Field-Style';

            $test_stylist->update($new_name);

            $this->assertEquals('Sally Field-Style', $test_stylist->getName());
        }

        function test_delete()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client ($client_name);
            $test_Client->save();
            $client_id = $test_Client->getId();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $name2 = 'Sam Style';
            $bio2 = 'Sam does a lot of hair.';
            $test_stylist2 = new Stylist ($name2, $bio2, $client_id);
            $test_stylist2->save();

            $test_stylist2->delete();

            $this->assertEquals([$test_stylist], Stylist::getAll());
        }

        function test_getAll()
        {
            $client_name = 'Jane Doe';
            $test_Client = new Client($client_name);
            $test_Client->save();
            $client_id = $test_Client->getId();

            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio, $client_id);
            $test_stylist->save();

            $name2 = 'Sam Style';
            $bio2 = 'Sam does a lot of hair.';
            $test_stylist2 = new Stylist ($name2, $bio2, $client_id);
            $test_stylist2->save();

            $result = Stylist::getAll();
            // print_r("Here is the result!!\n\n");
            // print_r($result);

            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }
    }


?>
