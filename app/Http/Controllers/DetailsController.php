<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class DetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    public function index(Request $request){
         $s_id=$request->input('s_id');
         $sid=substr($s_id,0,strlen($s_id)-1);
        $users=auth()->user();
        $id=$users->id;
        $sel=DB::select("select coll.sell_id,coll.sum,coll.u_id,se.goods_id,se.ganame,se.price,g.`name` from collection as coll join selling as se on coll.sell_id=s_id join goods as g on se.goods_id=g.id where coll.sell_id in ($sid) and u_id='$id'");
        return response()->json($sel);
    }

    public function deta_adshow(Request $request){
        $users=auth()->user();
        $id=$users->id;
        $sel=DB::select("select * from ads where u_id='$id' and `default`='1'");
        return response()->json($sel);
    }
    public function deta_adadd(Request $request){
        $arr=$request->input('arr');
        $adsarr=$request->input('adsarr');
        $price=$request->input('price');

        $users=auth()->user();
        $id=$users->id;
        $tim=strtotime(date("Y/m/d H:i:s"));

        $ads_name='';
        $address='';
        $xix='';
        $phone='';
        foreach ($adsarr as $k=>$v){
            $ads_name=$v['ads_name'];
            $address=$v['address'];
            $xix=$v['xix'];
            $phone=$v['phone'];
        }

        $order_id = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

        foreach ($arr as $k=>$v){
            $flag = DB::table('datails')->insert([
                'price'=>$v['price'],
                'h_id'=>$v['sell_id'],
                'sum'=>$v['sum'],
                'order_id'=>$order_id,
                'h_type'=>$v['ganame'],
                'h_goods'=>$v['name'],
            ]);
            $affectedRows =  DB::table('collection')->where('sell_id', '=', $v['sell_id'])->delete();

        }

        $flag = DB::table('order')->insert([
            'h_address' => $address,
            'h_xix' => $xix,
            'h_phone' => $phone,
            'h_name'=>$ads_name,
            'order_id' => $order_id,
            'time' => $tim,
            'status' => '0',
            'u_id'=>$id,
            'price'=>$price,
        ]);

        return response()->json($order_id);
    }
}
