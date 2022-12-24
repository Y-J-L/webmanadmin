<?php

namespace app\admin\controller;

use app\model\UserModel;
use support\Request;

class UserController extends BaseController
{

    public function index(Request $request)
    {
        
        return view('user/index');
    }

    public function getlist(Request $request){

        $params = $request->all();

        $adminModel = new UserModel();

        $limit = $request->input('limit', $this->limit);

        $list = $adminModel->where(function ($query) use ($params) {
            if ($params['mobile']) {
                $query->where("mobile", 'like', "{$params['mobile']}%");
            }
        })->order("id asc")->paginate($limit);

        $count = $list->total();

        return success('ok',$list->toArray()['data'], ['count' => $count]);
    }

    //更新用户状态
    public function updstatus(Request $request){

        $id = $request->input('id',0);
        $checked = $request->input('checked');

        if(!$id || !$checked){
            return error('参数错误');
        }

        if($checked == 'true'){
            UserModel::where('id',$id)->update(['status'=>1]);
        }else{
            UserModel::where('id',$id)->update(['status'=>0]);
        }

        //更新用户缓存
        get_userinfo($id,true);

        return success('操作成功');
    }

}
