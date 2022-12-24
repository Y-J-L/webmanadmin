<?php

namespace app\admin\controller;

use app\admin\constants\CacheTagConstants;
use app\model\AdminMenuModel;
use Shopwwi\LaravelCache\Cache;
use support\Request;
use support\View;

class MenuController extends BaseController
{

    public function index(Request $request)
    {
        return view('menu/index');
    }

    //编辑/添加
    public function edit(Request $request){

        $id = $request->input('id',0);
        
        $menuModel = new AdminMenuModel();

        if(is_post()){

            $post = $request->post();
            $post['pid'] = $post['plist_select_nodeId'];

            if($post['id']){
                //编辑
                if($menuModel->where([
                    ['app','=',$post['app']],
                    ['controller','=',$post['controller']],
                    ['action','=',$post['action']],
                    ['id','<>',$post['id']]
                ])->count()>0){
                    return error('路由重复');
                }


                $update = $menuModel->find($post['id']);
                $update->save($post);
            }else{
                //添加

                //验证重复
                if($menuModel->where([
                    ['app','=',$post['app']],
                    ['controller','=',$post['controller']],
                    ['action','=',$post['action']],
                ])->count()>0){
                    return error('路由重复');
                }

                $menuModel->save($post);
            }

            //清除菜单缓存
            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->flush();

            return success('操作成功');
        }

        $info = [];
        if($id){
            $info = $menuModel->find($id)->toArray();
        }

        //查询树级菜单

        View::assign('info',$info);
        View::assign('id',$id);

        return view('menu/edit');
    }

    //删除菜单
    public function del(Request $request){
        $id = $request->input('id',0);

        if(!$id) return error('参数错误');

        $menuModel = new AdminMenuModel();

        //验证是否有下级菜单
        if($menuModel->where("pid",$id)->count()>0){
            return error('请先删除下级菜单');
        }

        $info = $menuModel->find($id);

        $info->delete();

        //清除菜单缓存
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->flush();

        return success('删除成功');
    }

    //获取所有菜单列表
    public function list(Request $request){

        $menuModel = new AdminMenuModel();

        $list = $menuModel->order("sort desc")->select();

        return success('ok',$list);
    }


    //获取下拉选择树级菜单
    public function sellist(Request $request){

        $menuModel = new AdminMenuModel();

        $list = $menuModel->order("sort desc")->select()->toArray();

        
        $newlist = [];
        foreach($list as $k=>$v){
            $newlist[$v['id']] = $v;
        }

        $newtree = [];
        $newtree[] = ['id'=>0,'title'=>'顶级菜单','pid'=>0];
        foreach($newlist as $k=>$v){
            if($v['pid']){
                $newlist[$v['pid']]['children'][] = &$newlist[$k];
            }else{
                $newtree[] = &$newlist[$k];
            }
        }


        return json(['status'=>['code'=>200,'message'=>'ok'],'data'=>$newtree]);
    }


    //初始化菜单
    public function initMenu(){

        //请自行备份数据库
        //执行此操作请先清除admin_menu数据表,最好设置id从1开始自增
        $menu = [
            ['id'=>1,'pid'=>0,'title'=>'系统管理','icon'=>'layui-icon-util','type'=>0,'app'=>'admin','controller'=>'system','action'=>'default','is_show'=>1,'sort'=>1000],
            ['id'=>2,'pid'=>1,'title'=>'系统设置','icon'=>'','type'=>1,'app'=>'admin','controller'=>'index','action'=>'syssetting','is_show'=>1,'sort'=>0],

            ['id'=>3,'pid'=>1,'title'=>'菜单管理','icon'=>'','type'=>1,'app'=>'admin','controller'=>'menu','action'=>'index','is_show'=>1,'sort'=>0],
            ['id'=>6,'pid'=>3,'title'=>'菜单列表','icon'=>'','type'=>1,'app'=>'admin','controller'=>'menu','action'=>'getlist','is_show'=>0,'sort'=>0],
            ['id'=>7,'pid'=>3,'title'=>'菜单添加/编辑','icon'=>'','type'=>1,'app'=>'admin','controller'=>'menu','action'=>'edit','is_show'=>0,'sort'=>0],
            ['id'=>8,'pid'=>3,'title'=>'菜单删除','icon'=>'','type'=>1,'app'=>'admin','controller'=>'menu','action'=>'del','is_show'=>0,'sort'=>0],


            ['id'=>4,'pid'=>1,'title'=>'角色管理','icon'=>'','type'=>1,'app'=>'admin','controller'=>'roles','action'=>'index','is_show'=>1,'sort'=>0],
            ['id'=>9,'pid'=>4,'title'=>'角色列表','icon'=>'','type'=>1,'app'=>'admin','controller'=>'roles','action'=>'getlist','is_show'=>0,'sort'=>0],
            ['id'=>10,'pid'=>4,'title'=>'角色添加/编辑','icon'=>'','type'=>1,'app'=>'admin','controller'=>'roles','action'=>'edit','is_show'=>0,'sort'=>0],
            ['id'=>11,'pid'=>4,'title'=>'角色删除','icon'=>'','type'=>1,'app'=>'admin','controller'=>'roles','action'=>'del','is_show'=>0,'sort'=>0],


            ['id'=>5,'pid'=>1,'title'=>'管理员管理','icon'=>'','type'=>1,'app'=>'admin','controller'=>'admin','action'=>'index','is_show'=>1,'sort'=>0],
            ['id'=>12,'pid'=>5,'title'=>'管理员列表','icon'=>'','type'=>1,'app'=>'admin','controller'=>'admin','action'=>'getlist','is_show'=>0,'sort'=>0],
            ['id'=>13,'pid'=>5,'title'=>'管理员添加/编辑','icon'=>'','type'=>1,'app'=>'admin','controller'=>'admin','action'=>'edit','is_show'=>0,'sort'=>0],
            ['id'=>14,'pid'=>5,'title'=>'管理员删除','icon'=>'','type'=>1,'app'=>'admin','controller'=>'admin','action'=>'del','is_show'=>0,'sort'=>0],
            ['id'=>15,'pid'=>5,'title'=>'修改状态','icon'=>'','type'=>1,'app'=>'admin','controller'=>'admin','action'=>'updstatus','is_show'=>0,'sort'=>0],
        ];

        foreach($menu as $v){

            AdminMenuModel::create($v);
        }

        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->flush();
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->flush();


        return json(['msg'=>'操作成功,请退出后台重新登录,防止后台tab切换错误']);
    }

}
