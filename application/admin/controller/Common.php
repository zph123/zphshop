<?php
namespace app\admin\controller;
use think\Controller;
use Session;

class Common extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $uname=Session::get('uname');
        if (empty($uname)) {
        	return $this->redirect('login/login');
        }else{
        	$this->assign('uname',$uname);
        }
    }
    public function commonToken()
    {
        $token = $this->request->token('__token__', 'sha1');
        $arr=['token'=>$token];
        echo json_encode($arr);
        // $this->assign('token', $token);
        // return $this->fetch();
    }
}
