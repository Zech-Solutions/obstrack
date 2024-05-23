<?php

class Controller
{
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        extract($data);
        require_once '../app/views/' . $view . '.php';
    }

    public function response($data, $status = 200)
    {
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data);
    }

    public function redirect($url)
    {
        header("Location: " . URL_PUBLIC . "/$url");
        exit;
    }

    public function input($key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    public function files($key, $default = null)
    {
        return $_FILES[$key] ?? $default;
    }

    public function session($key, $default = null)
    {
        return $_SESSION[SYSTEM][$key] ?? $default;
    }

    public function session_put($key, $default = null)
    {
        $_SESSION[SYSTEM][$key] = $default;
    }
}
