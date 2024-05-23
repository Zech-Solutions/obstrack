<?php

class Obstruction extends Model
{
    private $table_name = 'tbl_obstructions';
    private $pk = 'obstruction_id';
    public function all()
    {
        $obstructions = $this->select($this->table_name);
        return $obstructions;
    }

    public function add($form)
    {
        return $this->insert($this->table_name, $form, $this->pk);
    }
}
