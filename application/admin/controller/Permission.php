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
        $arr=Db::query("select p.id,p.name,p.description,p.path,p_c.name as p_c_name,p.category_id from permission as p join permission_category as p_c on p.category_id=p_c.id");
        $json=['code'=>'0','status'=>'ok','data'=>$arr];
        return json($json);
    }
    public function updateAction(){
        $data=Request::post();
        $validate = new \app\admin\validate\Permission;
        if (!$validate->check($data)) {
            $arr=['code'=>'1','status'=>'error','data'=>$validate->getError()];
            return json($arr);
        }
        unset($data['__token__']);
        $rbac= new Rbac();
        //$getname=$rbac->getPermission([['name', '=', $data['name']]]);
        $name=$data['name'];
        $path=$data['path'];
        $arr=Db::query("select * from permission where name='$name' or path='$path'");
        if (empty($arr)) {
            $arr=Db::table('permission')->update($data);
            $arr=['code'=>'0','status'=>'ok','data'=>'修改成功'];
            return json($arr);
        }else{
            foreach ($arr as $key => $value) {
                if ($value['id']!=$data['id']) {
                    $arr=['code'=>'2','status'=>'error','data'=>'name或者paht已经存在'];
                    return json($arr);
                }
            }
            $arr=Db::table('permission')->update($data);
            $arr=['code'=>'0','status'=>'ok','data'=>'修改成功'];
            return json($arr);
        }
    }
    public function addAction()
    {
        $data=Request::post();
        $validate = new \app\admin\validate\Permission;
        if (!$validate->check($data)) {
            $arr=['code'=>'1','status'=>'error','data'=>$validate->getError()];
            return json($arr);
        }
        $rbac= new Rbac();
        $getname=$rbac->getPermission([['name', '=', $data['name']]]);
        $getpath=$rbac->getPermission([['path', '=', $data['path']]]);
        if (empty($getname)&&empty($getpath)) {
            $arr=$rbac->createPermission([
                'name' => $data['name'],
                'description' => $data['description'],
                'status' => 1,
                'type' => 1,
                'category_id' => $data['category_id'],
                'path' => $data['path'],
            ]);
            $json=['code'=>'0','status'=>'ok','data'=>$arr];
            return json($json);       
        }else{
            $json=['code'=>'0','status'=>'ok','data'=>'名字或者路径不能重复'];
            return json($json);
        } 
    }
    function delete(){
        $data=Request::post();
        $validate = new \app\admin\validate\Delete;
        if (!$validate->check($data)) {
            $arr=['code'=>'1','status'=>'error','data'=>$validate->getError()];
            return json($arr);
        }
        $rbac= new Rbac();
        $id=$data['id'];
        $rbac->delPermission([$id]);
        $arr=['code'=>'1','status'=>'ok','data'=>'删除成功'];
        return json($arr);

    }
}