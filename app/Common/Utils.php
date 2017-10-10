<?php

namespace App\Common;

use Illuminate\Support\Facades\Log;

class Utils {

    /**
     * 记录日志信息
     */
    public static function infoLog($info, $param = [])
    {
        if ($param)
        {
            $info = $info . ' with param:' . json_encode($param);
        }
        Log::info($info);
    }

    /**
     * 记录错误日志信息
     */
    public static function errorLog($info, $param = [])
    {
        if ($param)
        {
            $info = $info . ' with param:' . json_encode($param);
        }
        Log::error($info);
    }




}