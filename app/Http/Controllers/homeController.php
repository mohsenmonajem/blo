<?php
namespace App\Http\Controllers;

use App\User;
use App\Student;
use App\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cookie;
use Prettus\Repository\Criteria\RequestCriteria;
class homeController extends Controller
{
    public function update()
    {
           return view ("update");
    }
    public function updatedata(Request $request)
    {
        $usernumber=Session::get('userid');
        $userdetail=User::whereuserid($usernumber)->first();
        if($userdetail->password==$request->input('passwordold'))
        {
              if($request->input('newpassword')!=null)
                {

                   User::whereuserid($usernumber)->update(
                     [
                            'email' => $request->input('email'),
                            'password' => $request->input('newpassword'),
                     ]
                     );
                }
                else
                  {

                     User::whereuserid($usernumber)->update(
                        [
                               'email' => $request->input('email'),
                        ]
                        );
                  }
             if ($userdetail->role=="student")
                 return view("student.home");

              if($userdetail->role=="teacher")
               return view("teacher.home");
        }
        else
        {
            return back()->withInput();
        }
    }
    public function register()
    {
      return view("register");
    }
    public function savedata(Request $request)
    {

         $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'family' => 'required|min:3',
            'password' => 'required',
            'role'  =>'required',
            'username'=> 'required|unique:users',
        ];
        $customMessages = [
             'name.required' => 'وارد کردن نام اجباری است',
             'name.min' =>'طول حداقل کاراکتر 3 باید باشد ',
             'family.required' =>' نام خانوادگی را وارد کنید',
             'email.required' =>'وارد کردن ایمیل اجباری است',
             'email' =>'ایمیل معتبر وارد کنید',
             'password.required' => 'وارد کردن پسورد الزامی است',
             'email.unique' =>"ایمیل تکراری ",
             'family.min' =>'طول فامیل باید بیش از 3 باشد',
             'role.required'  =>'عنوان خود را وارد نکردید',
             'username.required'=> 'نام کاربری خود را واردد کنید',
            ];
            $this->validate($request, $rules, $customMessages);
             $token=str::random(15);
              $userdata= new  User ([
              'name' => $request["name"],
              'family' =>$request["family"],
              'username' => $request["username"],
              'password' => $request["password"],
              'email' => $request["email"],
              'role' => $request["role"],
              ]);
              $userdata->remember_token=$token;
              $userdata->save();
               if($request["role"]=="student")
               {
                   $studentdata=new Student ([
                                   'userid'=>$userdata->id,
                    ]);
                    $studentdata->save();
               }
               else
                 {
                   $teacherdata=new Teacher ([
                    'userid'=>$userdata->id,
                                        ]);
                   $teacherdata->save();
                 }
                  session(['userid' => $userdata->id]);
                   Cookie::queue('userid', $userdata->id, 10000000);
                  if($request["role"]=="student")
                    return view("student.home");
                  else
                    return view("teacher.home");
                }
    public function login()
    {

       return view('logingetdata');
    }

     public function checklogin(Request $request)
     {

         $value = Session::get('userid');
         if ($request->input('username') == null && isset($value)) {

             $role = User::whereuserid($value)->pluck('role')->first();
             if ($role == "student")
                 return view("student.home");
             else
                 return view("teacher.home");

         }
         $rules = [
             'username' => 'required',
             'password' => 'required'
         ];
         $customMessages = [
             'username.required' => 'نام کاربری را وارد کنید',
             'password.required' => 'رمز عبور را وارد کنید',

         ];
         $this->validate($request, $rules, $customMessages);
         $userpassword = User::whereusername($request->input('username'))->pluck('password')->first();
         if ($userpassword == $request->input('password')) {
             $userdetail = User::whereusername($request->input('username'))->first();
             $request->session()->put('userid', $userdetail->userid);
             Cookie::queue('userid', $userdetail->userid, 10000000);
             if ($userdetail["role"] == "student")
                 return view("student.home");
             if ($userdetail["role"] == "teacher")
                 return view("teacher.home");
         }
         if ($userpassword == null)
         {
              return  view('logingetdata')->with('errorusser',1);
         }
         else
             return  view('logingetdata')->with('errorusser',2);
     }
}
