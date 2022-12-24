<?php
namespace app\user\validate;

use think\Validate;

class RegisterValidate extends Validate
{


    protected $rule =   [
        'mobile'  => 'require|max:30',
        'password' => 'require|length:6,30',
        'verification_code'=>'require|length:3,10'
    ];

    protected $message = [
        'password.length' => '密码长度在6-30之间',
        'verification_code.length' => '验证码格式错误'
    ];

    // protected $message  =   [
    //     'name.require' => '名称必须',
    //     'name.max'     => '名称最多不能超过25个字符',
    //     'age.number'   => '年龄必须是数字',
    //     'age.between'  => '年龄只能在1-120之间',
    //     'email'        => '邮箱格式错误',    
    // ];



}