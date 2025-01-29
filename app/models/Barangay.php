<?php

class Barangay extends Model
{
    private $table_name = 'tbl_barangays';
    protected $pk = 'brgy_id';
    public function all($with = [])
    {
        $obstructions = $this->select(
            $this->table_name,
            '*',
            [],
            [
                'name' => 'ASC',
            ],
            $with
        );
        return $obstructions;
    }

    public function find($id, $with = [])
    {
        $data = $this->select($this->table_name, '*', [$this->pk => $id], [], $with);
        return $data[0] ?? [];
    }

    public function add($form)
    {
        return $this->insert($this->table_name, $form, $this->pk);
    }

    public function edit($form, $id)
    {
        return $this->update($this->table_name, $form, [$this->pk => $id]);
    }

    public function remove($id)
    {
        return $this->delete($this->table_name, [$this->pk => $id]);
    }

    // Define relationships
    public function relationships()
    {
        return [
            'belongsTo' => [
                // 'user' => ['foreignKey' => 'reported_by', 'otherKey' => 'user_id', 'table' => 'tbl_users'],
                // 'obstruction_type' => ['foreignKey' => 'obstruction_type_id', 'otherKey' => 'obstruction_type_id', 'table' => 'tbl_obstruction_types']
            ],
            'hasMany' => [
                // 'actions' => ['foreignKey' => 'obstruction_id', 'table' => 'tbl_obstruction_actions']
            ]
        ];
    }
}
