<?php

class Lugares extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(5);
    }

    public function Lugares()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Lugares";
        $data['page_title'] = "LUGARES <small>BoGallery</small>";
        $data['page_name'] = "lugares";
        $data['page_functions_js'] = "functions_lugares.js";
        $this->views->getView($this, "lugares", $data);
    }
}
