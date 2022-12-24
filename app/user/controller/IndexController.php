<?php

namespace app\user\controller;

use support\Request;

class IndexController
{
    public function index(Request $request)
    {

        return success('登陆成功!',['uid'=>$request->uid]);
    }

}
