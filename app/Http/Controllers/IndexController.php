<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class IndexController extends Common
{

    public function index(){
        $pdo=DB::connection()->getPdo();
        dd($pdo);
    }
    public function show(Request $request){
        //$neme= $request->session()->get('name');  //get 取session
        return view('show');
    }
    public function showa(){
        $sel = DB::select("select * from csuser");

        $arr=['status'=>$sel];
        $json=json_encode($arr);
        echo $json;
    }
    public function add(Request $request){

        $name = $request->input('name');
        $password = $request->input('password');

        $flag = DB::table('csuser')->insert([
            'name' => $name,
            'password' => $password,
        ]);
        if ($flag==true){
            $arr=['status'=>'ok','data'=>"添加成功！"];
            return response()->json($arr);
        }else{
            $arr=['status'=>'no','data'=>"添加失败！"];
            return response()->json($arr);
        }
    }
    //删除
    public function delete(Request $request){
        $id = $request->input('id');

        $del = DB::table('csuser')->where('id', '=', $id)->delete();
        if ($del==true){
            $arr=['status'=>'ok'];
            $json=json_encode($arr);
            echo $json;
        }else{
            $arr=['status'=>'no'];
            $json=json_encode($arr);
            echo $json;
        }
    }
    //修改
    public function update(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $password = $request->input('password');

        $up = DB::table('csuser')->where('id', '=', $id)->update(['name' =>$name,'password'=>$password ]);
        if ($up==true){
            $arr=['status'=>'ok'];
            $json=json_encode($arr);
            echo $json;
        }else{
            $arr=['status'=>'no'];
            $json=json_encode($arr);
            echo $json;
        }
    }
    //退出登录
    public function tui(Request $request){
        $request->session()->pull('name');
    }
}
