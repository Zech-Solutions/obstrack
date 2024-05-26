<?php

class ObstructionAction extends Model
{
    private $table_name = 'tbl_obstruction_actions';
    private $pk = 'obstruction_action_id';
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

    public function add($form)
    {
        return $this->insert($this->table_name, $form, $this->pk);
    }

    // Define relationships
    public function relationships()
    {
        return [
            'belongsTo' => [
                'user' => ['foreignKey' => 'actioned_by', 'otherKey' => 'user_id', 'table' => 'tbl_users']
            ],
            'hasMany' => [
                // 'comments' => ['foreignKey' => 'obstruction_id', 'table' => 'comments']
            ]
        ];
    }
}
