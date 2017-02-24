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
            $GLOBALS['DB']->exec("INSERT INTO stylists (name, bio, client_id) VALUES ('{$this->getName()}', {$this->getClientId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM stylists');
        }
    }

?>
