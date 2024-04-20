<?php
 class RolesModel extends mysql{
    function __construct()
    {
      parent::__construct();
    }

    public function selectRoles()
    {
        $sql = "SELECT * FROM rol WHERE status !=0";
        $request = $this->select_all($sql);
        return $request;
    }
  
 }

?>