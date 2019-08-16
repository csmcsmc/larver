<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
        public function index(Request $request){
            $pid=$request->input('pid');
            $sel=DB::select("select * from area where parent_id='$pid'");
            return response()->json($sel);
        }
        public function add(Request $request){
            $address=$request->input('address');
            $ads_name=$request->input('ads_name');
            $xix=$request->input('xix');
            $phone=$request->input('phone');
            $users=auth()->user();
            $id=$users->id;

            $flag = DB::table('ads')->insert([
                'u_id' => $id,
                'address' => $address,
                'phone' => $phone,
                'u_id'=>$id,
                'ads_name'=>$ads_name,
                'xix'=>$xix,
                'default'=>'0'
            ]);
            if ($flag==true){
                $arr=['status'=>'ok'];
                return response()->json($arr);
            }

        }
        public function show(){
            $users=auth()->user();
            $id=$users->id;
            $sel=DB::select("select * from ads where u_id='$id'");
            return response()->json($sel);
        }
        public function default(Request $request){
            $id=$request->input('id');
            $sel=DB::select("select ads_id from ads where `default`='1'");
            if (!empty($sel)){
                foreach($sel as $k=>$v) {   //对象转数组
                    $sel[$k] = (array)$v;
                }
                $aid='';
                foreach ($sel as $k=>$v){
                    $aid=$v['ads_id'];
                }
              DB::update("update ads set `default`='0' where ads_id ='$aid'");
            }
            $up=DB::update("update ads set `default`='1' where ads_id ='$id'");
            if ($up==true){
                $arr=['status'=>'ok'];
                return response()->json($arr);
            }
        }
}
