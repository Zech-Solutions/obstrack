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

    public function generateUUIDv4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set variant to 10xx
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Insert data into a table
    public function insert($table, $data, $pk = 'id')
    {
        $data[$pk] = $this->generateUUIDv4();
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));

        return $stmt->execute();
    }

    // Update data in a table
    public function update($table, $data, $where)
    {
        $setClause = implode(', ', array_map(fn ($key) => "$key = ?", array_keys($data)));
        $whereClause = implode(' AND ', array_map(fn ($key) => "$key = ?", array_keys($where)));
        $sql = "UPDATE $table SET $setClause WHERE $whereClause";

        $stmt = $this->prepare($sql);
        $params = array_merge(array_values($data), array_values($where));
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);

        return $stmt->execute();
    }

    // Delete data from a table
    public function delete($table, $where)
    {
        $whereClause = implode(' AND ', array_map(fn ($key) => "$key = ?", array_keys($where)));
        $sql = "DELETE FROM $table WHERE $whereClause";

        $stmt = $this->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($where)), ...array_values($where));

        return $stmt->execute();
    }

    // Select data from a table
    public function select($table, $columns = '*', $where = [])
    {
        $whereClause = $where ? 'WHERE ' . implode(' AND ', array_map(fn ($key) => "$key = ?", array_keys($where))) : '';
        $sql = "SELECT $columns FROM $table $whereClause";

        $stmt = $this->prepare($sql);
        if ($where) {
            $stmt->bind_param(str_repeat('s', count($where)), ...array_values($where));
        }
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    
    public function __destruct()
    {
        $this->db->close();
    }
}
