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
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();
            //get above stylist FROM database
            //compare result from DB to 'Sally Style'

            $result = $test_stylist->getName();

            $this->assertEquals('Sally Style', $result);
        }

        function test_getId()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $result = $test_stylist->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_find()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $result = Stylist::find($test_stylist->getId());

            $this->assertEquals($test_stylist, $result);
        }

        function test_update()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $new_name = 'Sally Field-Style';

            $test_stylist->update($new_name);

            $this->assertEquals('Sally Field-Style', $test_stylist->getName());
        }

        function test_delete()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $name2 = 'Sam Style';
            $bio2 = 'Sam does a lot of hair.';
            $test_stylist2 = new Stylist ($name2, $bio2);
            $test_stylist2->save();

            $test_stylist2->delete();

            $this->assertEquals([$test_stylist], Stylist::getAll());
        }

        function getClients()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist($name, $bio);
            $test_stylist = save();

            $test_stylist_id = $test_stylist->getId();

            $client_name = 'Jane Doe';
            $test_client1 = new Client($name, $stylist_id);
            $test_client1->save();

            $client_name2 = 'John Doe';
            $test_client2 = new Client($name, $stylist_id);
            $test_client2 = save();

            $result = $test_stylist->getClients();

            $this->assertEquals([$test_client1, $test_client2], $result);
        }

        function test_getAll()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $name2 = 'Sam Style';
            $bio2 = 'Sam does a lot of hair.';
            $test_stylist2 = new Stylist ($name2, $bio2);
            $test_stylist2->save();

            $result = Stylist::getAll();

            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            $name = 'Sally Style';
            $bio = 'Sally does a lot of hair.';
            $test_stylist = new Stylist ($name, $bio);
            $test_stylist->save();

            $name2 = 'Sam Style';
            $bio2 = 'Sam does a lot of hair.';
            $test_stylist2 = new Stylist ($name2, $bio2);
            $test_stylist2->save();

            Stylist::deleteAll();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }
    }


?>
