<?php

require_once __DIR__ . "/../PHPMailer/src/Exception.php";
require_once __DIR__ . "/../PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        // header("Content-Type: application/json");
        // http_response_code($status);
        echo json_encode($data);
    }

    public function redirect($url)
    {
        header("Location: " . URL_PUBLIC . "/$url");
        exit;
    }

    public function redirectLogin()
    {
        header("Location: " . URL);
        exit;
    }

    public function inputs()
    {
        $inputs = json_decode(file_get_contents('php://input'), TRUE);
        return $inputs ?? [];
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

    public function sendEmail($name, $from, $to, $subject = "Obstruction", $message = "")
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                           // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';    // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                  // Enable SMTP authentication
            $mail->Username   = 'obstrack123@gmail.com'; // SMTP username
            $mail->Password   = 'uyvq syvw qpgz soas';
            $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                   // TCP port to connect to

            // Recipients
            $mail->setFrom($from, $name);
            $mail->addAddress($to);
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('eduard16carton@gmail.com');
            // $mail->addBCC('bcc@example.com');

            // Attachments (optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();
            $this->redirect('home');
        } catch (Exception $e) {
            $this->redirect('home');
        }
    }
}
