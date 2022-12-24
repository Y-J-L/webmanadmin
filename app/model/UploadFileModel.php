<?php

namespace app\model;

use think\Model;

/**
 *
 */
class UploadFileModel extends BaseModel
{
    protected $name = 'upload_file';



    static function upload($data = []){

        if(!$data['unique_id'] || !$data['size']){
            return false;
        }

        if(self::where("unique_id",$data['unique_id'])->count()>0){
            return false;
        }

        self::create($data);
        return true;
    }

}
