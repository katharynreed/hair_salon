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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
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
