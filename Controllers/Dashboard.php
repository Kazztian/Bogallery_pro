<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
    }

    public function dashboard()
    {
        $data['page_id'] = 2;
        $data['page_tag'] = "Dashboard - Bogallery";
        $data['page_title'] = "Dashboard - Bogallery";
        $data['page_name'] = "dashboard";
        $this->views->getView($this, "dashboard", $data);
    }
}


?>