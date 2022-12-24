<?php
namespace app\user\validate;

use think\Validate;

class LoginValidate extends Validate
{


    protected $rule =   [
        'mobile'  => 'require|max:55',
        'password' => 'require|max:55',
    ];

    // protected $message  =   [
    //     'name.require' => '名称必须',
    //     'name.max'     => '名称最多不能超过25个字符',
    //     'age.number'   => '年龄必须是数字',
    //     'age.between'  => '年龄只能在1-120之间',
    //     'email'        => '邮箱格式错误',    
    // ];


}