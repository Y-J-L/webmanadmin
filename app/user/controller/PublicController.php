<?php

namespace app\user\controller;

use app\admin\constants\CacheTagConstants;
use app\model\UserModel;
use app\model\VerificationCodeModel;
use app\user\validate\LoginValidate;
use app\user\validate\RegisterValidate;
use support\Request;

class PublicController
{
    //用户登陆
    public function login(Request $request){

        $data = $request->post();

        $validate = new LoginValidate();
        if(!$validate->check($data)){
            return error($validate->getError());
        }

        if(!check_mobile($data['mobile'])){
            return error('手机号格式错误!');
        }

        $userModel = new UserModel();

        $user = $userModel->where("mobile",$data['mobile'])->find();
        if(!$user) return error('用户不存在');
        if(get_password($data['password']) !== $user['password']) return error('密码错误!');
        if($user['status'] != 1) return error('用户被禁用');

        //登陆成功
        

        $user->last_login_time = time();
        $user->last_login_ip = $request->getRealIp();
        $user->save();

        //获取登陆token
        $token = $userModel->getToken($user->id);
        
        return success('登陆成功',$token);
    }

    //用户注册
    public function register(Request $request){
        $post = $request->post();

        $validate = new RegisterValidate();
        if(!$validate->check($post)){
            return error($validate->getError());
        }

        if(!check_mobile($post['mobile'])){
            return error('手机号格式错误');
        }

        //验证码
        $codeModel = new VerificationCodeModel();
        if(!$codeModel->user_check_code($post['mobile'],$post['verification_code'],'register')){
            return error('验证码错误');
        }

        $userModel = new UserModel();
        if($userModel->where("mobile",$post['mobile'])->find()){
            return error('用户已存在');
        }

        $userModel->save([
            'mobile'=>$post['mobile'],
            'password'=>get_password($post['password']),
            'status'=>1,
            'last_login_time'=>time(),
            'last_login_ip'=>$request->getRealIp()
        ]);

        $uid = $userModel->id;

        //获取登陆token
        $token = $userModel->getToken($uid);

        return success('注册成功',$token);
    }

    //发送注册手机号验证码
    public function sendRegisterCode(Request $request){

        $post = $request->post();

        if(!$post['mobile']) return error('请输入手机号');

        if(!check_mobile($post['mobile'])) return error('手机号格式错误');


        $codeModel = new VerificationCodeModel();
        return $codeModel->user_send_code($post['mobile'],'register');

    }


}
