<?php

class ObstructionType extends Model
{
    private $table_name = 'tbl_obstruction_types';
    private $pk = 'obstruction_type_id';

    public function all()
    {
        $obstruction_types = $this->select($this->table_name);
        return $obstruction_types;
    }

    public function find($id)
    {
        $obstruction_type = $this->select($this->table_name, '*', [$this->pk => $id]);
        return $obstruction_type[0] ?? [];
    }

    public function remove($id)
    {
        return $this->delete($this->table_name, [$this->pk => $id]);
    }

    public function add($form)
    {
        return $this->insert($this->table_name, $form, $this->pk);
    }

    public function edit($form, $id)
    {
        return $this->update($this->table_name, $form, [$this->pk => $id]);
    }
}
