<?php

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function prepare($sql)
    {
        return $this->db->prepare($sql);
    }
}
