<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

     public function index(Request $request){
         $users=auth()->user();
         $id=$users->id;
          $s_id = $request->input('s_id');
          $name = $request->input('name');
          $sum = $request->input('sum');

         $flag = DB::table('collection')->insert([
             'u_name' => $name,
             'sell_id' => $s_id,
             'sum' => $sum,
             'u_id'=>$id
         ]);
         if ($flag==true){
             $arr=['status'=>'ok'];
             $json=json_encode($arr);
             echo $json;
         }else{
             $arr=['status'=>'no'];
             $json=json_encode($arr);
             echo $json;
         }
     }
     public function show(){
         $users=auth()->user();
         $id=$users->id;
         $sel=DB::select("select coll.sell_id,coll.sum,coll.u_id,se.goods_id,se.ganame,se.price,g.`name` from collection as coll join selling as se on coll.sell_id=s_id join goods as g on se.goods_id=g.id where u_id='$id'");
         return response()->json($sel);
     }

     public function Plus(Request $request){
         $sell_id=$request->input('sell_id');
        DB::table('collection')->where('sell_id',$sell_id)->increment('sum');

     }

     public function Reduce(Request $request){
         $sell_id=$request->input('sell_id');
         DB::table('collection')->where('sell_id',$sell_id)->decrement('sum');
     }
}
