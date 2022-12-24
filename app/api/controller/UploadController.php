<?php

namespace app\api\controller;

use app\model\UploadFileModel;
use support\Request;
use Tinywan\Storage\Storage;

class UploadController
{

    //单图/多图上传
    public function upload(Request $request){

        $upload_info = get_option('upload_info');

        $type = $upload_info['type'] ?? 0;

        //允许的文件扩展名
        $upload_info_extensions = explode(",",trim($upload_info['extensions'],","));

        //最大上传大小
        $maxsize = bcmul($upload_info['maxsize'],(1024*1024),0);

        //验证文件类型 、 文件大小等
        

        foreach ($request->file() as $key => $spl_file) {

            //字节/1024/1024 = Mb

            if(!$spl_file->isValid()){
                return error($spl_file->getUploadName().'已失效');
            }

            if(!in_array($spl_file->getUploadExtension(),$upload_info_extensions)){
                return error($spl_file->getUploadExtension().'文件不允许上传');
            }

            if($spl_file->getSize() > $maxsize){
                return error($spl_file->getUploadName().'大小超出上传限制');
            }

            // var_export($spl_file->isValid()); // 文件是否有效，例如ture|false
            // var_export($spl_file->getUploadExtension()); // 上传文件后缀名，例如'jpg'
            // var_export($spl_file->getUploadMineType()); // 上传文件mine类型，例如 'image/jpeg'
            // var_export($spl_file->getUploadErrorCode()); // 获取上传错误码，例如 UPLOAD_ERR_NO_TMP_DIR UPLOAD_ERR_NO_FILE UPLOAD_ERR_CANT_WRITE
            // var_export($spl_file->getUploadName()); // 上传文件名，例如 'my-test.jpg'
            // var_export($spl_file->getSize()); // 获得文件大小，例如 13364，单位字节
            // var_export($spl_file->getPath()); // 获得上传的目录，例如 '/tmp'
            // var_export($spl_file->getRealPath()); // 获得临时文件路径，例如 `/tmp/workerman.upload.SRliMu`        
        }

        if($type == 0){
            //本地上传
            try{
                Storage::config('local');
                $res = Storage::uploadFile();
            }catch(\Throwable $e){

                return error('上传失败'.$e->getMessage());
            }
            
            //var_dump($res);


        }else if($type == 1){
            //阿里云上传
            // if(!$upload_info['oss_endpoint'] || !$upload_info['oss_bucket'] || !$upload_info['oss_accessKeySecret'] || !$upload_info['oss_accessKeyId'] ){

            //     return json(['code'=>0,'msg'=>'请检查上传配置!']);
            // }

            try{

                Storage::config('oss');
                $res = Storage::uploadFile();

            }catch(\Throwable $e){

                return error('上传失败'.$e->getMessage());
            }
            


        }else if($type == 2){
            //七牛云上传
            // if(!$upload_info['qiniu_bucketUrl'] || !$upload_info['qiniu_bucket'] || !$upload_info['qiniu_accessKey'] || !$upload_info['qiniu_secretKey'] ){

            //     return json(['code'=>0,'msg'=>'请检查上传配置!']);
            // }
            try{

                Storage::config('qiniu');
                $res = Storage::uploadFile();

            }catch(\Throwable $e){

                return error('上传失败'.$e->getMessage());
            }

        }

        //添加文件上传记录
        foreach($res as $k=>$v){
            UploadFileModel::upload($v);

            //隐藏完整路径
            unset($res[$k]['save_path']);
        }

        return success('ok',$res);
    }

}
