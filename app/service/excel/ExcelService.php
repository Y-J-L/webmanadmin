<?php

namespace app\service\excel;

class ExcelService
{

    /**
     * TODO 导出操作
     * @param $id
     * @param $path
     * @param $header
     * @param $title
     * @param array $export
     * @param string $filename
     * @param array $end
     * @param string $suffix
     */
    public function export($path, $header, $title, $export = [], $filename = '',$end = [],$suffix = 'xlsx')
    {

        try{
            $_path = SpreadsheetExcelService::instance()
                ->createOrActive()
                ->setExcelHeader($header,count($title['mark']) + 2)
                ->setExcelTile($title)
                ->setExcelContent($export)
                ->setExcelEnd($end)
                ->excelSave($filename, $suffix, $path);

        }catch (\Throwable $exception){

            return '导出失败'.$exception->getMessage();
        }

        //TODO 添加导出记录表，可以方便后期维护及定期删除

        return $_path;
    }

    //请求记录导出
    public function requestLogExport($list = []){

        $header = ['Id','ip','请求方式', '路由', '耗时ms','异常信息','请求时间'];

        $title = [
            'title' => '请求记录 导出数据',
            'sheets' => 'sheets1',
            'mark' => ['生成时间:' . date('Y-m-d H:i:s', time())],
        ];

        foreach ($list as $k=>$v){
            $searchLog[]=[
                $v['id'],
                $v['ip'],
                $v['method'],
                $v['route'],
                $v['times'].' ',
                $v['exception'],
                $v['create_time'],
            ];
        }

        $filename = 'requestlog_' . date('YmdHis');
        $end = [];
        return $this->export('exp', $header, $title, $searchLog, $filename, $end);
    }

}
