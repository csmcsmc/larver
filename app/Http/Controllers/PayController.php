<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['notify','return']]);
    }

    protected $config = [
        'alipay' => [
            'app_id' => '2016101000650491',
            'notify_url' => 'http://www.laravel.com/public/api/notify',
            'return_url' => 'http://www.laravel.com/public/api/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzRBz7cMBMP1DuRpFd3AwUSXyvqgbOG2P5rRWVc2JeA5FvVngZQat7cdH6mq5vjf193Dm+2k4jHh7h10I8a92+MSLr6BiVJjTLtTf23HYf+SlylQEQBh9CFttvbQP9ElO5Y9GGdOM+CQ7jSsP0156gZ9bHnAhR0TDPa7WMrEw6PmNyh6hdqadGcAfFQgrA21CFKiItMUFPIXLWEQdLJ6afkgCF5k9j4Srqpibyvs5vX6E7dApzNrNx0sZg08V0z4bxJmtgBdPsLokQlmxB27FKTzH1zPWlsxjICcrakG1dyC/xlqdrNPgp/YQzBErru49+P+zXytIarITbw3/OEZP+QIDAQAB',
            'private_key' => 'MIIEowIBAAKCAQEA1vik8w6i9GMrdRpucvpltrNmvq6WVN6HyiuX3PVlH8/xHJybgcU5HsY6ZVKTx8WLFLZDJc813r5QmLBCOaA+HqslHmYd6wg8T6BHnK2f7Tnu2/MuEoFPt3sv++9HSXa5VtV7dt0G1RFdn3fQdSufKUUx5Pz+cNC+deelukkZKX0qcC85oBL0cL9JCPgGq7eKYe1HiWqev7O3MoN3jT3pHNpO/vWIdbiSAcCn21PSHu5c4CZCL5lP7IsoSL0exoaUZ7FJ2e98e3cp1iw4MpQwgyDx7drU1lW11L7hqSqKrceSk1WQ5G/eNdxO2IVhAAtQTVmKZOw/PRmD+sTVSHh0BQIDAQABAoIBADqx7SfIKUodAbKZouqV38vAtB8AQF+v2teii3ZzMkc7WZP8VqFaHjx+11bu8xaqo0zmbvMV3pmQ0SS/i3V8gTmSdTIVo7mWqBD9rE/lQDNfjA5WGZBH6mIoqnNZY9d1KSnCZFGSC9mFQlDWP/6eCHkWQYdKZJadCEPdGe0BJHOlDxC+2QM3rgFXEhbKWTw2dDFbvCFCEt+qvz9FFXzXT/7qKF1ifAPxDUVpNMxOWfQjj3EBrabBdmmI1hQYMUR9yXh/N1DBH0fpfFMY9FwXQynwW+zaVXcWF/HlA/6b/6lVLg0cCUaJMPm1zPa9Xdz8OPDyk8MToh+5f6C+8VJ448kCgYEA8tVqfbMpNiBaGwkrO1zwKmCPOop72+a106bZUPt5rs0NVkRCDJsD1NfJJfYYRlGRkpdawJb5L2tjbCT5OOvQ1jYlkQc5oDtsW2+PNrTG68+rwjGqD11tpLibIf8YlolICLmpbuOtFUOMFr3tTu9WQUkHpBaTA87x2nxIxq7vdt8CgYEA4qB+CPNXUEELFfAOfTcI1ewF7iMKDlUQGircwZEY0wQICf1MxZzFt7iJzWl3Ff7l/sfvUfphRreWePjI4rnKOvh0ASgzGURLaTBCT4EDCvFiC92ipXZzvY9vob2VkcCR3A0WrpH3ArQDClgUGVtFeB/EQWLQwoVsMwhysxqa5ZsCgYBKg25P7///WeIMVb3sU1JmzoZkwkXLbnnw3kvk66WlG8qx4/QYhiCg2S4h9efw++qdftAcNLd184/oiVfoPYQxlx/j5sGqB1HypMLfWI2Joonj5vV2DYctenAv+GUFHE78TmxNWJOt6LI98D23cP2Yvt4XXc3y5zeTgXuba+aTJQKBgQCj/RyWX3ecBCUAb+AcLXnASnUUF9jL/DOVq9RoYRVEhJNInzkxebr8sZVNxXY9vWAyV/zOJk7DvE8vJF9A6M30lBplR/CJ5QhoilpBa4qHHZokGfH6p1cjISrXL/eOK3mgcPwrwEWseBQHJSsOGiSPwvThl56WU7OyzfcpsSPK5wKBgC/5pqoQBhIFsveRXnPBAiHUbV4cxvBtBvP471joV2RSq2FPn4P4ZEtUKYcRK5DYKR0iOqiWjs3PJo4CVsdO+1lUin7CbphoD2/lunew15NDD8oYZ6kXPGHibGXpuNoJqw3sRvCEB8IlxsKJrpg/OSbZIQtjY5S77dty+Bt1raA3',
        ],
    ];

    public function index(Request $request)
    {
        $order_id=$request->input("order_id");

        $sel=DB::select("select * from `order`  where order_id='$order_id'");

        foreach($sel as $k=>$v) {   //对象转数组
            $sellers[$k] = (array)$v;
        }

        $price='';
        foreach ($sellers as $k=>$v){
            $price=$v['price'];
        }
        $config_biz = [
            'out_trade_no' =>$order_id ,
            'total_amount' => $price,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);
        $arr=$pay->driver('alipay')->gateway()->verify($request->all());
        $order_id=$arr['out_trade_no'];
        $total_price=$arr['total_amount'];
        $order_time=$arr['timestamp'];
        header("location:http://localhost:8080/#/Buycar?o_id=$order_id&total_price=$total_price&order_time=$order_time");



    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        $verify = $pay->driver('wechat')->gateway('mp')->verify($request->getContent());

        $up = DB::update('update `order` set `status` = ? where `order_id` = ?', ['1', $verify['out_trade_no']]);

        if ($verify) {
            file_put_contents('notify.txt', "收到来自微信的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $verify['out_trade_no'] . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $verify['total_fee'] . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}