<?php

class ObstructionController extends Controller
{
    private $obstructionType;
    private $obstructionAction;
    private $obstructionRequest;
    private $obstruction;
    private $brgy;
    private $notification;
    private $user;
    public function __construct()
    {
        $this->obstructionType = $this->model("ObstructionType");
        $this->obstructionAction = $this->model("ObstructionAction");
        $this->obstructionRequest = $this->model("ObstructionRequest");
        $this->obstruction = $this->model("Obstruction");
        $this->brgy = $this->model("Barangay");
        $this->notification = $this->model("Notification");
        $this->user = $this->model("User");
    }

    public function index()
    {
        $where = [];
        if ($_SESSION[SYSTEM]['role'] == 'ADMIN') {
            $where = ['brgy_id' => $this->session('brgy_id')];
        }
        $obstructions = $this->obstruction->all(['user', 'actions', 'obstruction_type', 'brgy'], $where);
        // echo json_encode($this->session('user_id'));
        // echo json_encode($obstructions);
        // die;
        $this->view('obstruction/index', [
            'obstructions' => $obstructions
        ]);
    }

    public function show()
    {
        $filter = $_REQUEST['filter'] ?? "";
        $where = [];
        if (in_array($filter, ['PENDING', 'VERIFIED', 'REJECTED', 'WIP', 'COMPLETED'])) {
            $where = ['status' => $filter];
        }

        $user_role = $_SESSION['obstrack']['role'] ?? "";
        if ($user_role === 'ADMIN') {
            $where['brgy_id'] = $_SESSION['obstrack']['brgy_id'];
        }

        $obstructions = $this->obstruction->all(['user', 'actions', 'obstruction_type', 'brgy'], $where);
        $this->view('obstruction/show', [
            'obstructions' => $obstructions,
            'filter' => $filter
        ]);
    }

    public function indexRequest()
    {
        $where = [];
        $requests = $this->obstructionRequest->all(['brgy']);
        // echo json_encode($this->session('user_id'));
        // echo json_encode($obstructions);
        // die;
        $this->view('obstruction/index-request', [
            'requests' => $requests
        ]);
    }


    public function create()
    {
        if ($_SESSION[SYSTEM]['role'] == 'USER') {
            $obstruction_types = $this->obstructionType->all();
            $brgys = $this->brgy->all();

            $this->view('obstruction/create', [
                'obstruction_types' => $obstruction_types,
                'brgys' => $brgys
            ]);
        } else {
            $this->view('403/index', []);
        }
    }

    public function detail($obstruction_id)
    {
        $notif_id = $_REQUEST['notif_id'] ?? "";
        if ($notif_id != '') {
            $this->notification->edit([
                'is_seen' => 1
            ], $notif_id);
        }

        $obstruction = $this->obstruction->find($obstruction_id, ['brgy', 'actions', 'user']);
        if ($obstruction) {
            $this->view('obstruction/detail', [
                'obstruction' => $obstruction
            ]);
        } else {
            $this->view('404/index', []);
        }
    }

    public function toVerify($obstruction_id)
    {
        if ($_SESSION[SYSTEM]['role'] != 'USER') {
            $obstruction = $this->obstruction->find($obstruction_id, ['brgy']);
            if ($obstruction) {
                $this->view('obstruction/to-verify', [
                    'obstruction' => $obstruction
                ]);
            } else {
                $this->view('404/index', []);
            }
        } else {
            $this->view('403/index', []);
        }
    }


    public function action($obstruction_id)
    {
        if ($_SESSION[SYSTEM]['role'] != 'USER') {
            $obstruction = $this->obstruction->find($obstruction_id);
            if ($obstruction) {
                $this->view('obstruction/action', [
                    'obstruction' => $obstruction
                ]);
            } else {
                $this->view('404/index', []);
            }
        } else {
            $this->view('403/index', []);
        }
    }

    public function request($obstruction_id)
    {
        if ($_SESSION[SYSTEM]['role'] != 'USER') {
            $obstruction = $this->obstruction->find($obstruction_id, ['user']);
            $request = $this->obstructionRequest->findByObstructionId($obstruction_id);
            if ($obstruction) {
                $this->view('obstruction/request', [
                    'obstruction' => $obstruction,
                    'request' => $request
                ]);
            } else {
                $this->view('404/index', []);
            }
        } else {
            $this->view('403/index', []);
        }
    }

    public function store()
    {
        $images = $this->processReportImages();
        $form = [
            'obstruction_type_id' => '8b350acd-faf3-4e7a-a8fe-5bc8db50c1bf',
            'brgy_id' => $this->input('brgy_id'),
            'reported_by' => $this->session('user_id'),
            'images' => json_encode($images),
            'detail' => $this->input('detail'),
            'landmarks' => $this->input('landmarks'),
            'street' => $this->input('street'),
            'location' => $this->input('location') ?? "[]",
            'is_anonymous' => $this->input('is_anonymous') == 'on' ? 1 : 0
        ];

        if ($this->obstruction->add($form)) {
            $this->session_put('success', 'Successfully reported');
        } else {
            $this->session_put('error', 'Error while reporting');
        }

        $this->redirect('obstructions');
    }

    public function storeAction()
    {
        $images = $this->processReportImages();
        $form = [
            'obstruction_id' => $this->input('obstruction_id'),
            'actioned_by' => $this->session('user_id'),
            'images' => json_encode($images),
            'detail' => $this->input('detail'),
            'status' => $this->input('status'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        if (!empty($this->input('notice_at'))) {
            $form['notice_at'] = $this->input('notice_at');
        }

        if ($this->obstructionAction->add($form)) {
            $this->session_put('success', 'Successfully taken action');
            $form = [
                'status' => $this->input('status')
            ];
            $this->obstruction->edit($form, $this->input('obstruction_id'));
            $this->prepareNotif();
        } else {
            $this->session_put('error', 'Error while reporting');
        }

        $this->redirect('obstructions');
    }

    public function prepareNotif()
    {
        $obstruction_id = $this->input('obstruction_id');
        $reported_by = $this->input('reported_by');
        $users = $this->user->all();

        foreach ($users as $user) {
            if ($user['role'] == 'USER' && $reported_by != $user['user_id'])
                continue;
            if ($user['user_id'] == $this->session('user_id'))
                continue;
            $this->addNotifAfterActionTaken($user['user_id'], $user['email'], $obstruction_id, $this->getNotifDesc());
        }
    }

    public function getNotifDesc()
    {
        $status = $this->input('status');
        if ($status === 'VERIFIED')
            return "Reported obstruction was verified upon inspection. And given a notice for compliance until " . date('F j, Y', strtotime($this->input('notice_at'))) . ".";
        if ($status === 'REJECTED')
            return "Upon verification, the reported obstruction was found to be non-legitimate and does not constitute a violation. No further actions are required at this time.";
        if ($status === 'WIP')
            return "Reported obstruction status is currently working in progress.";
        if ($status === 'COMPLETED')
            return "Reported obstruction successfully resolved.";
        return '';
    }

    public function addNotifAfterActionTaken($user_id, $to, $obstruction_id, $description = "")
    {
        $form = [
            'sender' => $this->session('user_id'),
            'receiver' => $user_id,
            'obstruction_id' => $obstruction_id,
            'description' => $description,
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $this->notification->add($form);

        $name = $this->session('first_name') . " " . $this->session('last_name');
        $from = $this->session('email');
        if ($to != "" && $from != "") {
            $this->sendEmail($name, $from, $to, "Action Taken", $description);
        }
    }


    public function storeRequest()
    {
        $images = $this->processReportImages();
        $form = [
            'obstruction_id' => $this->input('obstruction_id'),
            'request_by' => $this->session('user_id'),
            'brgy_id' => $this->session('brgy_id'),
            'files' => json_encode($images),
            'message' => $this->input('message')
        ];

        if ($this->obstructionRequest->add($form)) {
            $this->session_put('success', 'Successfully requested permission');
        } else {
            $this->session_put('error', 'Error while reporting');
        }

        $this->redirect('obstructions');
    }

    public function updateRequest()
    {
        $request_id = $this->input('request_id');
        $obstruction_id = $this->input('obstruction_id');
        $status = $this->input('status');
        $form = [
            'status' => $status,
            'approved_by' => $this->session('user_id'),
        ];

        if ($this->obstructionRequest->edit($form, $request_id)) {
            $this->session_put('success', 'Successfully requested permission');
            $form = [
                'approval_status' => $status
            ];
            if ($status == 'REJECTED') {
                $form['status'] = 'REJECTED';
            }
            $this->obstruction->edit($form, $obstruction_id);
        } else {
            $this->session_put('error', 'Error while reporting');
        }

        // $this->redirect('obstructions');
    }

    public function processReportImages()
    {
        $uploadDir = "../public/images/obstructions";
        $uploadedImages = [];
        $file_images = $this->files("images");

        if (empty($file_images['tmp_name'][0]))
            return [];
        try {

            foreach ($file_images["tmp_name"] as $key => $tmp_name) {
                $file_name = $file_images["name"][$key];
                $file_tmp = $file_images["tmp_name"][$key];
                $file_type = $file_images["type"][$key];

                // Check if file is an image
                if (exif_imagetype($file_tmp) === false) {
                    // Handle error for non-image files
                    continue;
                }

                $ext = explode(".", basename($file_name));
                $image = uniqid() . "." . $ext[count($ext) - 1];

                // Generate a unique filename
                $target_file = $uploadDir . "/" . $image;

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($file_tmp, $target_file)) {
                    $uploadedImages[] = $image;
                } else {
                    // Handle upload failure
                }
            }
            return $uploadedImages;
        } catch (Exception $e) {
            return $e;
        }
    }
}
