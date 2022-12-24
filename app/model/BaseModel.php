<?php

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 *基础模型类
 */
class BaseModel extends Model
{
   
    protected $pk = 'id';

    protected $strice = false;

    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    //启用软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;


    // 设置json类型字段
	//protected $json = ['info'];

    
}
