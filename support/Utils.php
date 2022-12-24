<?php
function error($msg = '',$data = '', $other_result = [],$code = 0){

    $result = [
        'code' => $code,
        'msg'  => $msg,
        'data' => $data,
    ];

    $result = array_merge($result,$other_result);

    return json($result);

}

function success($msg = '',$data = '', $other_result = [],$code = 1){

    $result = [
        'code' => $code,
        'msg'  => $msg,
        'data' => $data,
    ];

    $result = array_merge($result,$other_result);

    return json($result);
}