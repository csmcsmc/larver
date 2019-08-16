<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    //密码生成
    public function haxi(){
        $hashed = Hash::make("aaa");
        echo $hashed;
    }
    //商品价格
    public function Price(Request $request){
         $s_id = $request->input('s_id');
        $sel=DB::select("select price from selling  where s_id='$s_id'");

        return response()->json($sel);
    }
    //商品展示页
    public function goods_show(Request $request){
         $gid = $request->input('gid');
         $sel=DB::select("select * from selling as s join goods as g on s.goods_id=g.id where s. goods_id='$gid'");

        //var_dump($sellers);
        return response()->json($sel);
    }
    //楼层商品展示
    public function vue(){
        $arr=DB::select("select f.id as fid ,f.f_id as ff_id,f.c_name,fg.f_id ,fg.g_id,g.`name`,g.id as gid  from floor as f join f_g as fg on f.f_id=fg.f_id join goods as g on fg.g_id=g.id ");

        foreach($arr as $k=>$v) {   //对象转数组
            $sellers[$k] = (array)$v;
        }

        $arr=[];
        foreach ($sellers as $ka=>$va){
            $fid=$va['f_id'];
            $fname=$va['c_name'];
            $arr[$fid][$fname][]=$va;
        }

        return response()->json($arr);
    }


//首页分类展示
    public function fenlei(){
        $arr=DB::select("select * from fenlei where p_id>='1'");

        foreach($arr as $k=>$v) {
            $sellers[$k] = (array)$v;
        }

        // 调用
        $list=$this->t($sellers);
        return response()->json($list);
    }


    function t($arr,$pid=10,$lev=0){
        $list = array();
        foreach($arr as $v){
            if($v['p_id']==$pid){
                $v['aaa'] = $this->t($arr,$v['f_id'],$lev+1);
                $list[] = $v;
            }
        }
        return $list;
    }

//    public function index(){
//        return view('login');
//    }
//    public function login_action(Request $request){
//         $name = $request->input('name');
//         $password = $request->input('password');
//
//        $users = DB::select("select * from csuser where name='$name' and password='$password'");
//        if (empty($users)){
//            $arr=['status'=>'no','data'=>"用户名密码不正确！"];
//            $json=json_encode($arr);
//            echo $json;
//        }else{
//            $request->session()->put('name', $name); //put存session
//            $arr=['status'=>'yes'];
//            $json=json_encode($arr);
//            echo $json;
//        }
//    }
}
