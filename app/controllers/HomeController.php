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
        $user_role = $_SESSION['obstrack']['role'] ?? "";
        $where = [];

        if($user_role === 'ADMIN'){
            $where['brgy_id'] = $_SESSION['obstrack']['brgy_id'];
        }

        $report_data = $this->obstruction->countHomeData();
        $obstructions = $this->obstruction->all(['obstruction_type'], $where);
        $this->view('home/index', [
            'report_data' => $report_data,
            'obstructions' => $obstructions
        ]);
    }
}
