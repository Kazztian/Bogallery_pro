<?php
 class rolesModel extends mysql{
    function __construct()
    {
      parent::__construct();
    }

    public function selecRoles()
    {
        $sql = "SELECT * FROM rol WHERE status !=0";
        $request = $this->select_all($sql);
        return $request;
    }
  
 }

?>