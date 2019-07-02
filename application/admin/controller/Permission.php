<?php
namespace app\admin\controller;
use gmars\rbac\Rbac;
use Request;
use Db;
class Permission extends Common
{
	public function list()
    {
    	//存一个串
        return $this->fetch();
    }
    public function show()
    {
    	$rbac= new Rbac();
        $arr=$rbac->getPermission([['status', '=', 1]]);
        echo json_encode($arr);
    }
    public function delete()
    {
    	//先验证串
    	$id=Request::post('id');
    	$rbac= new Rbac();
        $rbac->delPermissionCategory([$id]);
        $arr=['code'=>'0','status'=>'ok','data'=>'删除成功'];
    	echo json_encode($arr);
    }


    // public function addAction()
    // {
    // 	$data=Request::post();
    // 	$validate = new \app\admin\validate\Permission;
    // 	if(!$validate->check($data)){
    // 		$arr=['code'=>'1','status'=>'error','data'=>$validate->getError()];
    // 		echo json_encode($arr);
    // 		die;
    // 	}    	
    // 	$rbac= new Rbac();
    // 	$getarr=$rbac->getPermissionCategory([['name', '=', $data['name']]]);
    // 	if (empty($getarr)) {
    // 		// $rbac->savePermissionCategory([
    // 		//     'name' => $data['name'],
    // 		//     'description' => $data['description'],
    // 		//     'status' => 1
    // 		// ]);
    // 		$rbac->createPermission([
    // 		    'name' => '文章列表查询',
    // 		    'description' => '文章列表查询',
    // 		    'status' => 1,
    // 		    'type' => 1,
    // 		    'category_id' => 1,
    // 		    'path' => 'article/content/list',
    // 		]);
    // 		$arr=['code'=>'0','status'=>'ok','data'=>'添加成功'];
    // 		echo json_encode($arr);
    // 	}else{
    // 		$arr=['code'=>'1','status'=>'error','data'=>'分类已经存在'];
    // 		echo json_encode($arr);
    // 		die;
    // 	}    
    // }
}