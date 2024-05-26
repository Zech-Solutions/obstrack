<?php

class ObstructionRequest extends Model
{
    private $table_name = 'tbl_requests';
    private $pk = 'request_id';
    public function all($with = [])
    {
        $obstructions = $this->select(
            $this->table_name,
            '*',
            [],
            [
                'created_at' => 'DESC',
            ],
            $with
        );
        return $obstructions;
    }

    public function find($id)
    {
        $data = $this->select($this->table_name, '*', [$this->pk => $id]);
        return $data[0] ?? [];
    }

    public function findByObstructionId($obstruction_id, $with = [])
    {
        $data = $this->select($this->table_name, '*', ['obstruction_id' => $obstruction_id], [], $with);
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
                'user' => ['foreignKey' => 'actioned_by', 'otherKey' => 'user_id', 'table' => 'tbl_users'],
                'obstruction' => ['foreignKey' => 'obstruction_id', 'otherKey' => 'obstruction_id', 'table' => 'tbl_obstructions'],
                'brgy' => ['foreignKey' => 'brgy_id', 'otherKey' => 'brgy_id', 'table' => 'tbl_barangays'],
            ],
            'hasMany' => [
                // 'comments' => ['foreignKey' => 'obstruction_id', 'table' => 'comments']
            ]
        ];
    }
}
