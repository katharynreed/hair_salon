<?php

    class Client
    {
        private $name;

        function __construct($name, $id = null)
        {
            $this->name = $name;
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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function find($search_id)
        {
            $found_client = null;
            $clients = self::getAll();
            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query('SELECT * FROM clients');
            $clients = [];
            foreach($returned_clients as $client) {
                $name = $client['name'];
                $id = $client['id'];
                $new_client = new Client($name, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM clients');
        }






    }

?>
