<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', []);
    }

    public function show($id, $old)
    {
        $this->view('home/show', [
            'id' => $id,
            'old_id' => $old
        ]);
    }
}
