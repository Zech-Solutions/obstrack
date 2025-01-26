<?php

class NotificationController extends Controller
{
    private $notification;
    public function __construct()
    {
        $this->notification = $this->model("Notification");
    }
    public function index()
    {
        $notifications = $this->notification->all(['obstruction'], ['receiver' => $this->session('user_id')]);

        $this->view('notification/index', [
            'notifications' => $notifications
        ]);
    }
}
