<?php

class BarangayController extends Controller
{
    private $brgy;
    public function __construct()
    {
        $this->brgy = $this->model("Barangay");
    }

    public function index()
    {
        $brgys = $this->brgy->all();
        $this->view('brgy/index', [
            'brgys' => $brgys
        ]);
    }

    public function create()
    {
        if ($_SESSION[SYSTEM]['role'] != 'USER') {

            $this->view('brgy/create', []);
        } else {
            $this->view('403/index', []);
        }
    }

    public function edit($brgy_id)
    {
        $barangay = $this->brgy->find($brgy_id);
        $this->view('brgy/edit', [
            'barangay' => $barangay
        ]);
    }

    public function store()
    {
        $form = [
            'name' => $this->input('name'),
        ];

        if ($this->brgy->add($form)) {
            $this->session_put('success', 'Successfully added barangay');
        } else {
            $this->session_put('error', 'Error while adding');
        }

        $this->redirect('brgys');
    }

    public function update($brgy_id)
    {
        $form = [
            'name' => $this->input('name'),
        ];

        if ($this->brgy->edit($form,$brgy_id)) {
            $this->session_put('success', 'Successfully updated barangay');
        } else {
            $this->session_put('error', 'Error while updating');
        }

        $this->redirect('brgys');
    }

    public function destroy()
    {
        $brgy_id = $this->input('brgy_id');

        if ($this->brgy->remove($brgy_id)) {
            $this->session_put('success', 'Successfully deleted barangay');
        } else {
            $this->session_put('error', 'Error while deleting');
        }
    }
}
