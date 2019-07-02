<?php
namespace app\admin\controller;
use gmars\rbac\Rbac;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }

}
