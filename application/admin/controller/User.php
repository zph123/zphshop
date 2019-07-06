<?php
namespace app\admin\controller;
use gmars\rbac\Rbac;

class User extends Common
{
    public function list()
    {
        return $this->fetch();
    }

}
