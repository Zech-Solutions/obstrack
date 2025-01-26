<?php

class User extends Model
{
    private $table_name = 'tbl_users';
    private $pk = 'user_id';

    public function all()
    {
        $users = $this->select($this->table_name);
        return $users;
    }

    public function filter($where = [])
    {
        $users = $this->select($this->table_name, '*', $where);
        return $users;
    }

    public function usernameExists($username)
    {
        $data = $this->select($this->table_name, '*', ['username' => $username]);
        return $data;
    }

    public function register($form)
    {
        $form['password'] = password_hash($form['password'], PASSWORD_BCRYPT);
        return $this->insert($this->table_name, $form, $this->pk);
    }

    public function login($form, $isApi = false)
    {
        $param = ['username' => $form['username']];
        if($isApi){
            $param['role'] = "USER";
        }
        $user = $this->select($this->table_name, '*', $param);

        if ($user && password_verify($form['password'], $user[0]['password'])) {
            if ($isApi) {
                return [
                    'token' => md5(rand(1, 1000)),
                    'login' => true,
                    'user_id' => $user[0]['user_id'],
                    'fullname' => $user[0]['first_name'] . " " . $user[0]['last_name']
                ];
            }
            if($user[0]['role'] === 'USER')
                return false;
            $_SESSION[SYSTEM] = $user[0];
            return true;
        } else {
            if ($isApi) {
                return [
                    'login' => false,
                    'token' => '',
                    'data' => []
                ];
            }
            return false;
        }
    }

    public function find($id, $with = [])
    {
        $data = $this->select($this->table_name, '*', [$this->pk => $id], [], $with);
        return $data[0] ?? [];
    }
    
    public function edit($form, $id)
    {
        return $this->update($this->table_name, $form, [$this->pk => $id]);
    }
}
