<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;
use App\Modir;
use App\Dars;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
class modirsaytController extends Controller
{
    public function login()
    {
        $data=null;
        return view('modir.login', ['data' => $data ]);
    }
    public function checkdata(Request $request)
    {
        $rules = [
            'password' => 'required',
        ];
        $customMessages = [
            'passwprd.required' => 'وارد کردن پسورد اجباری است',

        ];
            $this->validate($request, $rules, $customMessages);
            $password = DB::table('admin')->first();
            if($password->password==$request->input('password'))
            {
                return view('modir.home');
            }
            else
                {
                 $data="رمز عبور صحیح نیست";
                 return view('modir.login', ['data' => $data ]);
                }
    }
    public function createdars()
    {
        $data=null;
        return view('modir.sabtedars',['data'=>$data]);
    }
    public function savedatadars(Request $request)
    {

        $rules = [
            'paye' => 'required',
            'dars' => 'required',

        ];
        $customMessages = [
            'paye.required' => 'وارد کردنپایه اجباری است',
            'dars.required' =>' درس را وارد کنید',

        ];
            $this->validate($request, $rules, $customMessages);
            $valid=new Dars;
            $valid->savedata($request);
            $data=array($request->input('paye'),$request->input('dars'));
            return view('modir.sabtedars',['data'=>$data]);
    }
}
