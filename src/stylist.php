<?php

    require_once __DIR__.'/../src/client.php';

    class Stylist
    {
        private $name;
        private $bio;
        private $id;

        function __construct($name, $bio, $id = null)
        {
            $this->name = $name;
            $this->bio= $bio;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getBio()
        {
            return $this->bio;
        }

        function setBio()
        {
            $this->bio = $new_bio;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name, bio) VALUES ('{$this->getName()}', '{$this->getBio()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function find($search_id)
        {
            $found_stylist = null;
            $stylists = self::getAll();
            foreach($stylists as $stylist) {
                $stylist_id = $stylist->getId();
                if ($stylist_id == $search_id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
        }

        function getClients()
        {
            $clients = Array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE client_id = {$this->getId()};");
            foreach($returned_clients as $client) {
                $name = $client['name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new Client($name, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }


        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = [];
            foreach($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $bio = $stylist['bio'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $bio, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM stylists');
        }

    }

?>
