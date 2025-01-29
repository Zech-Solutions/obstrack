<?php
require_once '../app/globals.php';

require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/controllers/ApiController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

date_default_timezone_set("Asia/Manila");

$controller = new ApiController();

$response = array();
if (isset($_GET['action'])) {
    $action = str_replace('/', '', $_GET['action']);

    if ($action == 'login') {
        $response['data'] = $controller->login();
    }else if ($action == 'register') {
        $response['data'] = $controller->register();
    } else if ($action == 'update_profile') {
        $response['data'] = $controller->updateProfile();
    } else if ($action == 'add_obstruction') {
        $response['data'] = $controller->addObstruction();
    } else if ($action == 'get_brgys') {
        $response['data'] = $controller->getAllBrgys();
    } else if ($action == 'get_obstructions') {
        $response['data'] = $controller->getAllObstructions();
    } else if ($action == 'get_obstruction') {
        $response['data'] = $controller->getObstruction();
    } else if ($action == 'get_notifications') {
        $response['data'] = $controller->getNotifications();
    } else if ($action == 'update_notification') {
        $response['data'] = $controller->updateNotification();
    } else if ($action == 'get_user') {
        $response['data'] = $controller->getUser();
    } else {
        $response['status'] = "error";
        $response['message'] = 404;
    }
} else {
    $response['status'] = "error";
    $response['message'] = 403;
}


function sql_update($table_name, $form_data, $where_clause = '')
{
	$whereSQL = '';
	if (!empty($where_clause)) {
		if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
			$whereSQL = " WHERE " . $where_clause;
		} else {
			$whereSQL = " " . trim($where_clause);
		}
	}
	$sql = "UPDATE " . $table_name . " SET ";
	$sets = array();
	foreach ($form_data as $column => $value) {
		$sets[] = "`" . $column . "` = '" . $value . "'";
	}
	$sql .= implode(', ', $sets);
	$sql .= $whereSQL;

	return $sql;
}

function sql_insert($table_name, $form_data)
{
	$fields = array_keys($form_data);

	$sql = "INSERT INTO " . $table_name . "
	    (`" . implode('`,`', $fields) . "`)
	    VALUES('" . implode("','", $form_data) . "')";

	return $sql;
}

function generateUUIDv4()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set variant to 10xx
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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
            $image = getVidOrImg($file_type). "-".uniqid() . "." . $ext[count($ext) - 1];

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

function isFileAcceptable($fileType){
    if(strpos($fileType, 'image') !== false || strpos($fileType, 'video') !== false)
        return true;
    return false;
}

function getVidOrImg($fileType){
    if(strpos($fileType, 'image') !== false)
        return 'img';
    if(strpos($fileType, 'video') !== false)
        return 'vid';
}

echo json_encode($response);
