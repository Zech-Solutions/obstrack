<?php

class Obstruction extends Model
{
    private $table_name = 'tbl_obstructions';
    private $pk = 'obstruction_id';
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

    public function add($form)
    {
        return $this->insert($this->table_name, $form, $this->pk);
    }

    // Define relationships
    public function relationships()
    {
        return [
            'belongsTo' => [
                'user' => ['foreignKey' => 'reported_by', 'otherKey' => 'user_id', 'table' => 'tbl_users']
            ],
            'hasMany' => [
                // 'comments' => ['foreignKey' => 'obstruction_id', 'table' => 'comments']
            ]
        ];
    }
}
