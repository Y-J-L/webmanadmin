<?php

namespace app\model;

use think\Model;

/**
 *
 */
class OptionModel extends BaseModel
{
    protected $name = 'option';


    //自动写入时间戳
    protected $autoWriteTimestamp = false;

    // 设置json类型字段
	protected $json = ['option_value'];
    
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;
    
}
