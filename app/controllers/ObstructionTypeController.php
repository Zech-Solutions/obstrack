<?php

class ObstructionTypeController extends Controller
{
    private $obstructionType;
    public function __construct()
    {
        $this->obstructionType = $this->model("ObstructionType");
    }
    public function index()
    {
        $obstruction_types = $this->obstructionType->all();
        $this->view('obstruction-type/index', [
            'obstruction_types' => $obstruction_types
        ]);
    }

    public function create()
    {
        if ($_SESSION[SYSTEM]['role'] != 'USER') {
            $this->view('obstruction-type/create', []);
        } else {
            $this->view('403/index', []);
        }
    }

    public function edit($obstruction_type_id)
    {
        $obstruction_type = $this->obstructionType->find($obstruction_type_id);

        // echo json_encode($obstruction_type);
        // die;

        $this->view('obstruction-type/edit', [
            'obstruction_type' => $obstruction_type
        ]);
    }

    public function store()
    {
        $form = [
            'name' => $this->input('name'),
        ];
        if ($this->obstructionType->add($form)) {
            $this->session_put('success', 'Successfully added');
        } else {
            $this->session_put('error', 'Adding failed');
        }
        $this->redirect('obstruction-types');
    }

    public function destroy()
    {
        $obstruction_type_id = $this->input('obstruction_type_id');

        if ($this->obstructionType->remove($obstruction_type_id)) {
            $this->session_put('success', 'Successfully deleted Obstruction Type');
        } else {
            $this->session_put('error', 'Error while deleting');
        }
    }

    public function update($obstruction_type_id)
    {
        $form = [
            'name' => $this->input('name'),
        ];
        if ($this->obstructionType->edit($form, $obstruction_type_id)) {
            $this->session_put('success', 'Successfully updated');
        } else {
            $this->session_put('error', 'Updating failed');
        }
        $this->redirect('obstruction-types');
    }
}
