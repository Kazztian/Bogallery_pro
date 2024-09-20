<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        //sessionStart();
        parent::__construct();
       // session_Start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(1);
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
