<?php

class Obstruction extends Model
{
    private $table_name = 'tbl_obstructions';
    protected $pk = 'obstruction_id';
    public function all($with = [], $where = [])
    {
        $obstructions = $this->select(
            $this->table_name,
            '*',
            $where,
            [
                'created_at' => 'DESC',
            ],
            $with
        );
        return $obstructions;
    }

    public function countHomeData()
    {
        $total = $this->select($this->table_name);
        $completed = $this->select($this->table_name, $this->pk, ['status' => 'COMPLETED']);
        return [
            'total' => count($total),
            'current' => count($total) - count($completed),
            'completed' => count($completed)
        ];
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
    // Define relationships
    public function relationships()
    {
        return [
            'belongsTo' => [
                'user' => ['foreignKey' => 'reported_by', 'otherKey' => 'user_id', 'table' => 'tbl_users'],
                'obstruction_type' => ['foreignKey' => 'obstruction_type_id', 'otherKey' => 'obstruction_type_id', 'table' => 'tbl_obstruction_types'],
                'brgy' => ['foreignKey' => 'brgy_id', 'otherKey' => 'brgy_id', 'table' => 'tbl_barangays'],
            ],
            'hasMany' => [
                'actions' => ['foreignKey' => 'obstruction_id', 'table' => 'tbl_obstruction_actions']
            ]
        ];
    }
}
