<?php
namespace app\exception;

use Throwable;
use Webman\Exception\ExceptionHandlerInterface;
use Webman\Http\Request;
use Webman\Http\Response;

class ExceptionHandler implements ExceptionHandlerInterface {

    private $_debug;

    public function __construct()
    {
        $this->_debug = config('app.debug');
    }

    //日志记录
    public function report(Throwable $exception)
    {
        //TODO 记录日志
    }

    public function render(Request $request, Throwable $exception): Response
    {
        $code = $exception->getCode();

        $json = ['code' => $code ? $code : 0, 'msg' => $exception->getMessage(),'data'=>[]];
        $this->_debug && $json['traces'] = (string)$exception;
        return new Response(200, ['Content-Type' => 'application/json'],
            \json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    }

}