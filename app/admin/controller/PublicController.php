<?php

namespace app\admin\controller;

use app\admin\validate\LoginValidate;
use app\model\AdminModel;
use support\Request;
use Webman\Captcha\CaptchaBuilder;

class PublicController extends BaseController
{
    public function index(Request $request)
    {
        return response(__CLASS__);
    }

    public function captcha(Request $request){
        // 初始化验证码类
        $builder = new CaptchaBuilder();
        // 生成验证码
        $builder->build(114,42,null);
        // 将验证码的值存储到session中
        $request->session()->set('captcha', strtolower($builder->getPhrase()));
        // 获得验证码图片二进制数据
        $img_content = $builder->get();
        // 输出验证码二进制数据
        return response($img_content, 200, ['Content-Type' => 'image/jpeg']);
    }

    public function login(Request $request){

        //验证用户是否登录
        if(get_admin_id()){
            return redirect('/admin/index/index');
        }

        if(is_post()){
            //登录
            $data = $request->post();

            $validate = new LoginValidate();

            if(!$validate->check($data)){
                return error($validate->getError());
            }

            if (strtolower($data['captcha']) !== $request->session()->get('captcha')) {
                return error('验证码错误');
            }
            $adminModel = new AdminModel();
            $admin = $adminModel->where("account",$data['account'])->find();
            if(!$admin) return error('用户不存在');
            if($admin['password'] !== get_password($data['password'])) return error('密码错误');
            if(!$admin['status']) return error('用户被禁用');

            $admin->last_time = time();
            $admin->last_ip = $request->getRealIp(true);
            $admin->save();

            $request->session()->set('admin_id',$admin['id']);

            return success('登录成功');
        }

        return view('login');
    }

}
