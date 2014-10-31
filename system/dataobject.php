<?php

class DataObject implements SystemComponentDataCompatible {

    private $db;

    function __construct ($data_array) {

        $this->db = Database::getInstance ();

        foreach ($data_array as $data) {

            $key = key ($data_array);
            $this->$key = $data;
            next ($data_array);

        }

    }

    public static function getInstance ($data_array) {

        return new DataObject ($data_array);

    }

}