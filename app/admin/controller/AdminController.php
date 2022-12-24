<?php

namespace app\admin\controller;

use app\admin\constants\CacheTagConstants;
use app\model\AdminModel;
use app\model\AdminRolesModel;
use Exception;
use Shopwwi\LaravelCache\Cache;
use support\Request;
use support\View;

class AdminController extends BaseController
{
    public function index(Request $request)
    {
        return view('admin/index');
    }

    //添加/编辑管理员
    public function edit(Request $request)
    {

        $id = $request->input('id', 0);

        if ($id == 1) {
            return error('无法编辑admin用户');
        }

        $adminModel = new AdminModel();

        if (is_post()) {

            $post = $request->post();
            //处理密码
            if (!empty($post['password'])) {
                $post['password'] = get_password($post['password']);
            } else {
                unset($post['password']);
            }

            if ($post['roles']) {
                $post['roles'] = trim(implode(",", $post['roles']), ",");
            }

            if ($id) {

                if ($adminModel->where("id", '<>', $id)->where("account", $post['account'])->count() > 0) {
                    return error('账号重复!');
                }

                //编辑
                $info = $adminModel->find($id);
                $info->save($post);
            } else {

                if ($adminModel->where("account", $post['account'])->count() > 0) {
                    return error('账号重复!');
                }


                if (!$post['password']) {
                    return error('请输入管理员密码!');
                }

                //添加
                $adminModel->save($post);
            }

            //清除管理员缓存
            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_INFO)->flush();
            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->flush();
            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->flush();

            return success('操作成功');
        }

        $info = [];
        if ($id) {
            $info = $adminModel->find($id);
        }

        //查询角色
        $rolesModel = new AdminRolesModel();
        $roleslist = $rolesModel->select()->toArray();

        if ($info['roles']) {
            //处理选中
            $user_roles = array_unique(explode(",", $info['roles']));

            foreach ($roleslist as $k => $v) {
                if (in_array($v['id'], $user_roles)) {
                    $roleslist[$k]['ischeck'] = 'checked';
                }
            }
        }

        View::assign('roleslist', $roleslist);

        View::assign('info', $info);
        View::assign('id', $id);

        return view('admin/edit');
    }

    //删除管理员
    public function del(Request $request)
    {

        $id = $request->input('id', 0);

        if (!$id) return error('参数错误');
        if ($id == 1) return error('请勿删除admin用户');

        $adminModel = new AdminModel();

        $info = $adminModel->find($id);

        if(!$info) return error('数据不存在');

        $info->delete();

        //清除管理员相关缓存
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->flush();
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->flush();
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_INFO)->flush();

        return success('操作成功');
    }

    //修改状态
    public function updstatus(Request $request){

        $id = $request->input('id',0);
        $checked = $request->input('checked');

        if(!$id || !$checked){
            return error('参数错误');
        }

        if($id == 1) return error('无法修改admin');

        if($checked == 'true'){
            AdminModel::where('id',$id)->update(['status'=>1]);
        }else{
            AdminModel::where('id',$id)->update(['status'=>0]);
        }

        return success('操作成功');
    }

    public function getlist(Request $request)
    {

        $params = $request->all();

        $adminModel = new AdminModel();

        $limit = $request->input('limit', $this->limit);

        $list = $adminModel->where(function ($query) use ($params) {
            if ($params['name']) {
                $query->where("name", 'like', "{$params['name']}%");
            }
        })->order("id asc")->paginate($limit);

        $count = $list->total();

        return success('ok',$list->toArray()['data'], ['count' => $count]);
    }
}
