<?php

class HomeController extends Controller
{
    private $obstruction;
    public function __construct()
    {
        $this->obstruction = $this->model("Obstruction");
    }
    public function index()
    {
        $report_data = $this->obstruction->countHomeData();
        $obstructions = $this->obstruction->all(['obstruction_type']);
        $this->view('home/index', [
            'report_data' => $report_data,
            'obstructions' => $obstructions
        ]);
    }
}
