<?php

namespace app\model;

use think\Model;

/**
 *
 */
class VerificationCodeModel extends BaseModel
{

    protected $name = 'verification_code';
    

    //验证
    public function user_check_code($mobile ,$code ,$type = 'register'){

        if(!$mobile || !$code) return false;

        $info = $this->where([
            ['mobile','=',$mobile],
            ['code','=',$code],
            ['type','=',$type]
        ])->order("id desc")->find();

        if(!$info) return false;

        if(time()>$info['expire_time']){
            return false;
        }

        $info->delete();

        return true;
    }

    //发送验证码
    public function user_send_code($mobile,$type = 'register'){

        //限制当天发送次数
        $day_s_time = strtotime(date('Y-m-d 00:00:00'));
        $day_e_time = strtotime(date('Y-m-d 23:59:59'));

        if($this->where([
            ['mobile','=',$mobile],
            ['create_time','>=',$day_s_time],
            ['create_time','<=',$day_e_time]
        ])->count()>10){
            return error('超过当天发送上限');
        }

        $code = mt_rand(999,9999);

        try {
            //发送验证码 模拟发送

            $this->save([
                'mobile'=>$mobile,
                'code'=>$code,
                'type'=>'register',
                'expire_time'=>time() + 600
            ]);

        } catch (\Throwable $th) {
            return error('发送失败:'.$th->getMessage());
        }

        return success('模拟发送成功,code:'.$code);
    }

}
