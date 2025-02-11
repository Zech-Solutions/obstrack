<?php

class ApiController extends Controller
{
    private $user;
    private $obstruction;
    private $obstructionAction;
    private $notification;
    private $barangay;

    public function __construct()
    {
        $this->user = $this->model("User");
        $this->obstruction = $this->model("Obstruction");
        $this->notification = $this->model("Notification");
        $this->barangay = $this->model("Barangay");
        $this->obstructionAction = $this->model("ObstructionAction");
    }

    public function getData()
    {
        $db = $this->model('Database');
        $data = $db->getSomething();
        $this->response($data);
    }

    public function getAllBrgys()
    {
        return $this->barangay->all();
    }

    public function getNotifications()
    {
        $input = $this->inputs()['input'];

        $obstructions = $this->notification->all(['user_sender', 'user_receiver', 'obstruction'], [
            'receiver' => $input['receiver_id']
        ]);
        return $obstructions;
    }

    public function updateNotification()
    {
        $input = $this->inputs()['input'];

        $obstruction = $this->notification->edit([
            'is_seen' => 1
        ], $input['notification_id']);
        return $obstruction;
    }

    public function getUser()
    {
        $input = $this->inputs()['input'];
        $user_id = $input['user_id'];
        $user = $this->user->find($user_id);
        return $user;
    }


    public function getAllObstructions()
    {
        $obstructions = $this->obstruction->all(['user', 'actions', 'obstruction_type', 'brgy']);
        return $obstructions;
    }

    public function getObstruction()
    {
        $input = $this->inputs()['input'];
        $obstruction_id = $input['obstruction_id'];
        $obstruction = $this->obstruction->find($obstruction_id, ['user', 'actions', 'obstruction_type', 'brgy']);
        $obstruction['actions'] = $this->fixObstructionData($obstruction);
        $obstruction['images'] = json_decode($obstruction["images"]);
        return $obstruction;
    }

    public function fixObstructionData($obstruction)
    {
        $actions = [];
        $actions[] = array(
            'created_at' => $obstruction['created_at'],
            'status' => "PENDING",
            'detail' => '',
            'images' => json_decode($obstruction["images"]),
            'description' => 'Citizen reported an obstruction.'
        );
        if ($obstruction['actions'] > 0) {
            foreach ($obstruction['actions'] as $action) {
                $data = array(
                    'created_at' => $action['created_at'],
                    'status' => $action['status'],
                    'detail' => $action['detail'],
                    'images' => json_decode($action["images"]),
                    'description' => $action['detail']
                );
                if ($action['status'] === 'VERIFIED') {
                    $data['description'] = "Reported obstruction was verified upon inspection. And given a notice for compliance until " . date("F d, Y", strtotime($action['notice_at']));
                }
                if ($action['status'] === 'REJECTED') {
                    $data['description'] = "Upon verification, the reported obstruction was not found to be non-legitimate and does not constitiute a violation. no further actions are required at this time";
                }
                $actions[] = $data;
            }
        }

        usort($actions, function ($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });
        return $actions;
    }

    public function login()
    {
        $input = $this->inputs()['input'];
        $form = [
            'username' => $input['username'],
            'password' => $input['password'],
        ];
        return $this->user->login($form, true);
    }

    public function register()
    {
        $input = $this->inputs()['input'];

        if ($this->user->usernameExists($input['username'])) {
            return ['status' => 'exist'];
        }

        $form = [
            'username' => $input['username'],
            'password' => $input['password'],
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'dob' => $input['dob'],
            'gender' => $input['gender'],
            'address' => $input['address'],
            'email' => $input['email'],
        ];

        if ($this->user->register($form)) {
            return [
                'status' => 'success'
            ];
        } else {
            return [
                'status' => 'errror'
            ];
        }
    }

    public function updateProfile()
    {
        $image = $this->processProfileImage();
        $form = [
            'user_id' => $this->input('user_id'),
            'first_name' => $this->input('first_name'),
            'middle_name' => $this->input('middle_name'),
            'last_name' => $this->input('last_name'),
            'dob' => $this->input('dob'),
            'gender' => $this->input('gender'),
            'address' => $this->input('address'),
            'email' => $this->input('email')
        ];

        if (!empty($image)) {
            $form['image'] = $image;
        }

        if ($this->user->edit($form, $this->input('user_id'))) {
            return [
                'status' => 'success'
            ];
        } else {
            return [
                'status' => 'errror'
            ];
        }
    }

    public function addObstruction()
    {
        $images = $this->processReportImages();
        $sender = $this->user->find($this->input('reported_by'));
        if (count($images) < 1)
            return [
                'status' => 'no-media',
                'obstruction_id' => 0
            ];
        $form = [
            'obstruction_type_id' => '8b350acd-faf3-4e7a-a8fe-5bc8db50c1bf',
            'brgy_id' => $this->input('brgy_id'),
            'reported_by' => $this->input('reported_by'),
            'images' => json_encode($images),
            'detail' => $this->input('detail'),
            'landmarks' => $this->input('landmarks'),
            'street' => $this->input('street'),
            'location' => $this->input('location') ?? "[]",
            'is_anonymous' => $this->input('is_anonymous'),
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $obstruction_id = $this->obstruction->add($form);
        if ($obstruction_id != '') {

            $brgys = $this->user->filter(['brgy_id' => $this->input('brgy_id')]);
            foreach ($brgys as $row) {
                $this->addNotifAfterObstructionCreated($row, $sender, $obstruction_id);
            }

            $roots = $this->user->filter(['role' => 'ROOT']);
            foreach ($roots as $row) {
                $this->addNotifAfterObstructionCreated($row, $sender, $obstruction_id);
            }
        }
        return [
            'status' => $obstruction_id != '' ? 'success' : 'errror',
            'obstruction_id' => $obstruction_id
        ];
    }

    public function addNotifAfterObstructionCreated($receiver, $sender, $obstruction_id)
    {

        $name = $sender['first_name'] . " " . $sender['last_name'];
        $from = $sender['email'];
        $user_id = $receiver['user_id'];
        $to = $receiver['email'];

        $form = [
            'sender' => $this->input('reported_by'),
            'receiver' => $user_id,
            'obstruction_id' => $obstruction_id,
            'description' => "New obstruction was reported by citizen.",
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $this->notification->add($form);
        if ($to != "" && $from != "") {
            $this->sendEmail($name, $from, $to, "New Obstruction", "New obstruction was reported by citizen.");
        }
    }

    function processReportImages()
    {
        $uploadDir = "../public/images/obstructions";
        $uploadedImages = [];
        $file_images = $_FILES['media'];
        try {

            foreach ($file_images["tmp_name"] as $key => $tmp_name) {
                $file_name = $file_images["name"][$key];
                $file_tmp = $file_images["tmp_name"][$key];
                $file_type = $file_images["type"][$key];

                // Check if file is an image
                if (!isFileAcceptable($file_type)) {
                    // Handle error for non-image files
                    continue;
                }

                $ext = explode(".", basename($file_name));
                $image = getVidOrImg($file_type) . "-" . uniqid() . "." . $ext[count($ext) - 1];

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

    function isFileAcceptable($fileType)
    {
        if (strpos($fileType, 'image') !== false || strpos($fileType, 'video') !== false)
            return true;
        return false;
    }

    function getVidOrImg($fileType)
    {
        if (strpos($fileType, 'image') !== false)
            return 'img';
        if (strpos($fileType, 'video') !== false)
            return 'vid';
    }

    public function processProfileImage()
    {
        $uploadDir = "../public/images/users"; // Target directory for uploads
        $file_image = $this->files("image"); // Retrieve the single file input

        try {
            // Check if the uploaded file exists and has no errors
            if (isset($file_image) && $file_image["error"] === UPLOAD_ERR_OK) {
                $file_tmp = $file_image["tmp_name"];
                $file_name = $file_image["name"];
                $file_type = $file_image["type"];

                // Check if the uploaded file is an image
                if (exif_imagetype($file_tmp) === false) {
                    throw new Exception("Uploaded file is not a valid image.");
                }

                // Extract the file extension
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                // Generate a unique filename
                $image = uniqid() . "." . $ext;

                // Full path to save the file
                $target_file = $uploadDir . "/" . $image;

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($file_tmp, $target_file)) {
                    return $image; // Return the filename of the uploaded image
                } else {
                    throw new Exception("Failed to move the uploaded file.");
                }
            } else {
                throw new Exception("No file uploaded or an error occurred during upload.");
            }
        } catch (Exception $e) {
            // Return error message
            return '';
        }
    }
}
