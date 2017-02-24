<?php

    require_once __DIR__.'/../src/client.php';

    class Stylist
    {
        private $name;
        private $bio;
        private $client_id;
        private $id;

        function __construct($name, $bio, $client_id, $id = null)
        {
            $this->name = $name;
            $this->bio= $bio;
            $this->client_id = $client_id;
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

        function getClientID()
        {
            return $this->client_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name, bio, client_id) VALUES ('{$this->getName()}', '{$this->getBio()}', {$this->getClientID()});");
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


        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = [];
            foreach($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $bio = $stylist['bio'];
                $client_id = $stylist['client_id'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $bio, $client_id, $id);
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
