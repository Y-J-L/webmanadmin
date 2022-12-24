<?php

namespace app\admin\controller;

use app\admin\constants\CacheKeyConstants;
use app\admin\constants\CacheTagConstants;
use app\model\AdminMenuModel;
use app\model\AdminModel;
use app\model\AdminRolesModel;
use app\model\OptionModel;
use app\model\RequestLogModel;
use app\model\UploadFileModel;
use app\service\excel\ExcelService;
use Shopwwi\LaravelCache\Cache;
use support\Redis;
use support\Request;
use support\View;
use think\facade\Db;

class IndexController
{
    public function index(Request $request)
    {

        return view('index/index');
    }

    //控制台首页
    public function main(Request $request){


        //获取最近七天的请求量
        $date_arr = [];
        $pv_arr = [];

        
        for($i = 6;$i>=0;$i--){
            $a = strtotime(date("Y-m-d 00:00:00",strtotime("- $i day")));
            
            $date_arr[] = date('Y-m-d',$a);
            $pv_arr[] = Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->get('request_pv_'.$a) ?? 0;
        }

        //echo json_encode($date_arr);
        //echo json_encode($pv_arr);
        View::assign('date_arr',json_encode($date_arr));
        View::assign('pv_arr',json_encode($pv_arr));


        //var_dump($pv_arr);
        //var_dump($date_arr);


        //今日请求量
        $day_pv = Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->get('request_pv_'.strtotime(date('Y-m-d 00:00:00')));

        //cpu核心数量
        $cpu_count = cpu_count();

        //启用进程数量
        $start_server = config('server.count');

        //站点总请求量
        $total_pv = Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->get(CacheKeyConstants::CACHE_KEY_REQUEST_PV_TOTAL);

        //上传附件配置
        $upload = bcdiv(config('server.max_package_size') / 1024,1024,0);

        //获取已上传附件总量
        $uploadsize = UploadFileModel::sum('size') ?? 0;
        $uploadsize = sprintf("%.3f",$uploadsize / 1024 / 1024).'M';

        //$os
        $os = PHP_OS;

        $mysql = \think\facade\Db::query('SELECT VERSION() as mysql_version')[0]['mysql_version'];

        //返回redis信息
        $handler = Redis::connection('default');
        $redis = $handler->info();

        //获取当前db的key总量
        $dbinfo = $redis['db'.getenv('RDS_DATABASE')];
        $keys = end(explode("=",explode(",",$dbinfo)[0]));

        $redis['keycount'] = $keys;


        View::assign('redis',$redis);

        View::assign('os',$os);
        View::assign('mysql',$mysql);

        View::assign('upload',$upload);
        View::assign('uploadsize',$uploadsize);
        View::assign('php_version',PHP_VERSION);

        View::assign('day_pv',$day_pv);
        View::assign('cpu_count',$cpu_count);
        View::assign('start_server',$start_server);
        View::assign('total_pv',$total_pv);

        return view('index/main');
    }

    //系统设置
    public function sysSetting(Request $request){

        if(is_post()){

            $post = $request->post();

            foreach($post as $k=>$v){
               
                $info = OptionModel::where("option_name",$k)->find();
                if($info){
                    //修改
                    OptionModel::where("id",$info['id'])->update(['option_value'=>$v]);
                }else{
                    //新增
                    OptionModel::create(['option_name'=>$k,'option_value'=>$v]);
                }

            }
            //清理缓存
            Cache::tags(CacheTagConstants::CACHE_TAG_OPTION)->flush();

            return success('操作成功');
        }

        //获取配置
        $site_info = get_option('site_info');
        $upload_info = get_option('upload_info');

        View::assign('site_info',$site_info);
        View::assign('upload_info',$upload_info);


        return view('index/setting');
    }

    //上传附件列表
    public function uploadlist(Request $request){

        
        return view('index/uploadlist');
    }
    public function getUploadList(Request $request){
        $params = $request->all();

        $uploadModel = new UploadFileModel();

        $limit = $request->input('limit',$this->limit);

        $list = $uploadModel->where(function($query) use ($params){
            if($params['name']){
                $query->where("origin_name",'like',"%{$params['name']}%");
            }
        })->order("id desc")->paginate($limit)->each(function($item,$key){

            $item->size = sprintf("%.3f",$item->size / 1024 / 1024).'M';
            
        });

        $count = $list->total();

        return success('ok',$list->toArray()['data'],['count'=>$count]);
    }

    //请求记录
    public function requestlog(Request $request){

        return view('index/requestlog');
    }
    public function getRequestLog(Request $request){

        $params = $request->all();

        $requestlogModel = new RequestLogModel();

        $limit = $request->input('limit',$this->limit);

        $list = $requestlogModel->field("id,ip,method,action,route,times,exception,create_time")->where(function($query) use ($params){
            if($params['route']){
                $query->where("route",'like',"{$params['route']}%");
            }
        })->order("id desc")->paginate($limit)->each(function($item,$key){

            $item->times = $item->times.'ms';
            
        });

        $count = $list->total();

        return success('ok',$list->toArray()['data'],['count'=>$count]);
    }
    //删除请求记录
    public function requestlogDel(Request $request){
        $type = $request->input('type');

        if($type == "1"){
            //删除全部
            Db::name('request_log')->delete(true);

            return success('操作成功');
        }else if($type == "2"){
            //扩展其他日期
        }

    }
    //导出请求记录
    public function exportRequestLog(Request $request){

        $list = RequestLogModel::field('id,ip,method,route,times,exception,create_time')->order("id desc")->limit(0,100000)->select();

        $excelService = new ExcelService();

        $res = $excelService->requestLogExport($list);
        

        return response()->download(runtime_path().'/'.$res,end(explode("/",$res)));
    }

    //获取菜单
    public function menu(Request $request){

        $admin_id = get_admin_id();

        //增加缓存 获取角色,查询角色下的菜单列表
        $list = Cache::tags(CacheTagConstants::CACHE_TAG_OPTION)->get('admin_menu_'.$admin_id);

        if(!$list){

            // $adminModel = new AdminModel;
            // $admin = $adminModel->find($admin_id);

            // $rolesModel = new AdminRolesModel;
            // $roles = $rolesModel->where("id",'in',$admin['roles'])->select();

            // if(!$roles){
            //     return json([]);
            // }

            // $rules = [];

            // foreach($roles as $k=>$v){
            //     $rules = array_merge($rules,explode(",",$v['rules']));
            // }

            $rules = get_admin_rules();

            
            $menuModel = new AdminMenuModel();

            if(in_array("*",$rules)){
                //超级管理员
                $list =  $menuModel->where("is_show",1)->order("sort desc")->column("*",'id');
            }else{
                $list =  $menuModel->where("is_show",1)->where("id",'in',$rules)->order("sort desc")->column("*",'id');
            }

            //处理上下级层级
            foreach($list as $k=>$v){
                $list[$k]['icon'] = 'layui-icon '.$v['icon'];
                $list[$k]['openType'] = '_iframe';
                $list[$k]['href'] = '/'.$v['app'].'/'.$v['controller'].'/'.$v['action'];
                if($v['pid'] && isset($list[$v['pid']])){
                    $list[$v['pid']]['children'][] = &$list[$k];
                }
            }

            //将最顶层的id下表去除,放到最外面一层
            $rtnlist = [];
            foreach($list as $k=>$v){
                if(!$v['pid']){
                    $rtnlist[] = $v;
                }
            }

            Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->set('admin_menu_'.$admin_id,$rtnlist);
            $list = Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_MENU)->get('admin_menu_'.$admin_id);
        }

        
        return json($list);
    }

    //退出登陆
    public function logout(Request $request){

        
        $request->session()->set('admin_id',0);
        

        return success('退出成功');
    }
}
