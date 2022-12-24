<?php

namespace app\admin\controller;

use app\admin\constants\CacheTagConstants;
use app\model\AdminMenuModel;
use app\model\AdminRolesModel;
use Shopwwi\LaravelCache\Cache;
use support\Request;
use support\View;

/**
 * 角色管理
 */
class RolesController extends BaseController
{
    public function index(Request $request)
    {
        return view('roles/index');
    }

    //添加/编辑角色
    public function edit(Request $request){

        $id = $request->input('id',0);

        if($id == 1){
            return error('无法编辑超级管理员');
        }

        $rolesModel = new AdminRolesModel();
        
        if(is_post()){

            $post = $request->post();
            $rules = "";
            if($post['rules']){
                foreach($post['rules'] as $k=>$v){
                    if($v['nodeId'] && $v['checked'] == "1"){
                        $rules .= $v['nodeId'].",";
                    }
                }
            }

            $post['rules'] = trim($rules,",");

            if($id){
                //编辑
                $info = $rolesModel->find($id);
                $info->save($post);
            }else{
                //添加
                $rolesModel->save($post);
            }

            //清除管理员角色
            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->flush();

            return success('操作成功');
        }

        $info = [];
        if($id){
            $info = $rolesModel->find($id);
        }

        View::assign('info',$info);
        View::assign('id',$id);

        return view('roles/edit');
    }

    //删除角色
    public function del(Request $request){

        $id = $request->input('id',0);

        if(!$id) return error('参数错误');

        if($id == 1){
            return error('无法删除超级管理员');
        }

        $rolesModel = new AdminRolesModel();

        $info = $rolesModel->find($id);

        if(!$info) return error('数据不存在');

        $info->delete();

        //清理缓存
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->flush();

        return success('操作成功');
    }


    //获取数据列表
    public function getlist(Request $request){

        $params = $request->all();

        $rolesModel = new AdminRolesModel();

        $limit = $request->input('limit',$this->limit);

        $list = $rolesModel->where(function($query) use ($params){
            if($params['name']){
                $query->where("name",'like',"%{$params['name']}%");
            }
        })->order("id asc")->paginate($limit);

        $count = $list->total();

        return success('ok',$list->toArray()['data'],['count'=>$count]);
    }

    //获取菜单复选框
    public function getmenu(Request $request){

        $rolesModel = new AdminRolesModel();
        $id = $request->input('id',0);

        $check_ids = [];
        if($id){
            //获取选中内容
            $info = $rolesModel->where("id",$id)->value("rules");
            if($info){
                $check_ids = explode(",",$info);
            }
        }

        //获取所有菜单
        $menuModel = new AdminMenuModel();
        $list = $menuModel->order("sort desc")->select()->toArray();
        
        $newlist = [];
        foreach($list as $k=>$v){
            if(in_array($v['id'],$check_ids)){
                $v['checkArr'] = ['checked'=>1];
            }else{
                $v['checkArr'] = ['checked'=>0];
            }
            $newlist[$v['id']] = $v;
        }

        $newtree = [];
        foreach($newlist as $k=>$v){
            if($v['pid']){
                $newlist[$v['pid']]['children'][] = &$newlist[$k];
            }else{
                $newtree[] = &$newlist[$k];
            }
        }


        return json(['status'=>['code'=>200,'message'=>'ok'],'data'=>$newtree]);
    }
}
