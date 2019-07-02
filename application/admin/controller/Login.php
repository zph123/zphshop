<?php
namespace app\admin\controller;
use Session;
use Request;
use think\Controller;
use think\captcha\Captcha;
use app\admin\model\User;
class Login extends Controller
{
    public function login()
    {
        return $this->fetch();
    }
    public function loginAction()
    {
    	$verify=Request::post('verify');
    	$name=Request::post('name');
    	$password=Request::post('password');
    	$verify_session=Session::get('verify');
    	if ($verify!=$verify_session) {
    		$arr=['code'=>'0','status'=>'error','data'=>'验证码错误'];
    		echo json_encode($arr);
    		die;
    	}else{
    		$data=['user_name'=>$name,'password'=>md5($password)];
    		$arr=User::where($data)->find();
    		if (empty($arr)) {
    			$arr=['code'=>'1','status'=>'error','data'=>'用户名或者密码错误'];
    			echo json_encode($arr);
    			 die;
    		}else{
    			Session::set('uid',$arr['id']);
    			Session::set('uname',$arr['user_name']);
    			$arr=['code'=>'2','status'=>'ok','data'=>'正确'];
    			echo json_encode($arr);
    			die;

    		}
    	}
    }

    //生成验证码，生成一张图
    public function verify()
    {
    	header("Content-type: image/png");
    	$string = mt_rand(999, 9999);
    	Session::set('verify',$string);
    	$im     = imagecreatefrompng("static/images/button1.png");
    	$orange = imagecolorallocate($im, 0, 0, 0);
    	$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
    	imagestring($im, 3, $px, 9, $string, $orange);
    	imagepng($im);
    	imagedestroy($im);

    	exit(0);

        //$captcha = new Captcha();
        //return $captcha->entry();    
    }

}
