<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Common extends Controller
{

    public function __construct(Request $request)
    {
        //parent::__construct();
        $this->request = request();

        // 验证是否登录
        $this->middleware(function ($request, $next) {
            if (!\Session::get('name')) {
                return redirect('/login');exit();
            }

            return $next($request);
        });

    }
}
