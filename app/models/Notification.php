<?php

class Notification extends Model
{
    private $table_name = 'tbl_notifications';
    protected $pk = 'notification_id';
    public function all($with = [], $param = [])
    {
        $notifications = $this->select(
            $this->table_name,
            '*',
            $param,
            [
                'created_at' => 'DESC',
            ],
            $with
        );
        return $notifications;
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
                'user_sender' => ['foreignKey' => 'sender', 'otherKey' => 'user_id', 'table' => 'tbl_users'],
                'user_receiver' => ['foreignKey' => 'receiver', 'otherKey' => 'user_id', 'table' => 'tbl_users'],
                'obstruction' => ['foreignKey' => 'obstruction_id', 'otherKey' => 'obstruction_id', 'table' => 'tbl_obstructions']
            ],
            'hasMany' => [
                // 'actions' => ['foreignKey' => 'obstruction_id', 'table' => 'tbl_obstruction_actions']
            ]
        ];
    }
}
