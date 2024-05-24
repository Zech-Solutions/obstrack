<?php

class ObstructionController extends Controller
{
    private $obstructionType;
    private $obstruction;
    public function __construct()
    {
        $this->obstructionType = $this->model("ObstructionType");
        $this->obstruction = $this->model("Obstruction");
    }

    public function index()
    {
        $obstructions = $this->obstruction->all(['user']);
        // echo json_encode($this->session('user_id'));
        // echo json_encode($obstructions);
        // die;
        $this->view('obstruction/index', [
            'obstructions' => $obstructions
        ]);
    }

    public function create()
    {
        if ($_SESSION[SYSTEM]['role'] == 'USER') {
            $obstruction_types = $this->obstructionType->all();

            $this->view('obstruction/create', [
                'obstruction_types' => $obstruction_types
            ]);
        } else {
            $this->view('obstruction/index', []);
        }
    }

    public function store()
    {
        $images = $this->processReportImages();
        $form = [
            'obstruction_type_id' => $this->input('obstruction_type_id'),
            'reported_by' => $this->session('user_id'),
            'images' => json_encode($images),
            'detail' => $this->input('detail'),
            'is_anonymous' => $this->input('is_anonymous') == 'on' ? 1 : 0
        ];

        if ($this->obstruction->add($form)) {
            $this->session_put('success', 'Successfully reported');
        } else {
            $this->session_put('error', 'Error while reporting');
        }

        $this->redirect('obstructions');
    }

    public function processReportImages()
    {
        $uploadDir = "../public/images/obstructions";
        $uploadedImages = [];
        $file_images = $this->files("images");
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
