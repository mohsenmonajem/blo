<?php
namespace App\Http\Controllers;
use App\Student;
use App\User;
use App\demand;
use Illuminate\Http\Request;
use  App\Teacher;
USE App\studentclass;
use App\Dars;
use App\Teacher_dars;
use App\TeacherRequest;
use Illuminate\Support\Facades\DB;
use Verta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use App\Http\Controllers\mysql_connect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

class teacherController extends Controller {
    public function takedars() {
        $paye = Dars::all();
        for ( $i = 0; $i<count( $paye );
        $i++ ) {
            $data[$i] = $paye[$i]->payenumber;
        }
        $data = array_unique( $data );
        foreach ( $data as $variable ) {
            $u[$i] = $variable;
            $i++;
        }
        return view( 'teacher.takedars' )->with( 'data', $u );
    }

    public function getpayedars( Request $request ) {
        $msg = DB::table( 'dars' )->select( 'namelesson' )->where( 'payenumber', $request->input( 'paye' ) )->get();
        return response()->json( array( 'msg'=> $msg ), 200 );
    }
    public function savedarsteacher( Request $request ) {
        $darsdetail = DB::table( 'dars' )->where( 'namelesson', $request->input( 'dars' ) )->where( 'payenumber', $request->input( 'paye' ) )->first();
        $teacherdetail = DB::table( 'teacher' )->where( 'userid', Session::get( 'userid' ) )->first();
        $teacherselectiondars  = new  Teacher_dars;
        $teacherselectiondars->dars_id = $darsdetail->id;
        $teacherselectiondars->teacher_id = $teacherdetail->teacherkey;
        $teacherselectiondars->save();
        $msg1 = 'با موفقیت ذخیره شد';
        return response()->json( array( 'msg'=> $msg1 ), 200 );
    }

    public function requestclass() {
        $teacherdetail = DB::table( 'teacher' )->where( 'userid', Session::get( 'userid' ) )->pluck( 'teacherkey' );
        $getlessonid = DB::table( 'dars_teacher' )->where( 'teacher_id', $teacherdetail )->pluck( 'dars_id' );
        $getlessonid = $getlessonid->unique()->values()->all();
        $getlessondetail = DB::table( 'dars' )->whereIn( 'id', $getlessonid )->get();
        return view( 'teacher.getclassdata' )->with( 'lessondetail', $getlessondetail );
    }

    public function saveclass( Request $request ) {
        $startdate = explode( '/', $request->input( 'startdate' ) );
        $enddate = explode( '/', $request->input( 'enddate' ) );
        $rules = [
            'startdate'=> 'required|date',
            'enddate'=> 'required|date',
            'address'=> 'required',
            'dars'=> 'required',
            'cost'=> 'required|numeric|min:0',
            'capacity' => 'required|numeric|min:0:',

        ];
        $customMessages = [
            'capacity.required' =>'ظرفیت نمی تواند خالی باشد',
            'capacity.numeric' =>'ظرفیت نمی تواند کم تر از یک نفر باشد',
            ' cost.numeric' =>'هزینه نمی تواند 0 یا کم تر از ان باشدو',
            'startdate.required' =>' تاریخ شروع کلاس را وارد کنید',
            'enddate.required' =>'تاریخ   پایان کلاس را وارد کنید',
            'dars.required' => ' درسی برای انتخاب وارد نشده است',
            'address.required' => ' ادرس کلاس را وارد کنید',
            'cost.required' => 'هزینه کلاس را وارد نکردید',
            'start.date' =>'تاریخ  معتبر را وارد کنید ',
            'end.date' =>'تاریخ معتبر را وارد کنید',
        ];

        if ( $enddate[0]<$startdate[0] ) {

            return back()->withInput();
        }
        if ( $enddate[0] == $startdate[0] ) {
            if ( $enddate[1]<$startdate[1] ) {
                return back()->withInput();

            }
            if ( $enddate[2]<$startdate[2] ) {
                return back()->withInput();
            }
        }
        $this->validate( $request, $rules, $customMessages );
        $classdata = new TeacherRequest();
        $idteacher = Teacher::whereuserid( Session::get( 'userid' ) )->pluck( 'teacherkey' );
        $classdata->teacher_id = $idteacher[0];
        $classdata->dars_id = $request->input( 'dars' );
        $classdata->address = $request->input( 'address' );
        $classdata->capacity = $request->input( 'capacity' );
        $classdata->cost = $request->input( 'cost' );
        $classdata->start_date = $request->input( 'startdate' );
        $classdata->end_date = $request->input( 'enddate' );
        $classdata->save();
        return view( 'teacher.home' );
    }

    public function  showclass() {

        $teacherid = Teacher::whereuserid( Session::get( 'userid' ) )->pluck( 'teacherkey' )->first();
        $classteacher = TeacherRequest::whereteacher_id( $teacherid )->get();
        return view( 'teacher.classdetail' )->with( 'classteacher', $classteacher );
    }
    public  function  studentmember( Request $request ) {
        $studentdetail = studentclass::wherecode_class( $request->input( 'code_class' ) )->get();
        if ( $studentdetail == null )
        return response()->json( array( 'msg'=> 0 ), 200 );
        $count = 0;
        foreach ( $studentdetail as $value ) {
            $userdetail = Student::wherestudnetkey( $value->studentkey )->first();
            $user[$count] = User::whereuserid( $userdetail->userid )->first();
            $count++;
        }
        $user = array_unique( $user );
        return response()->json( array( 'msg'=> $user ), 200 );
    }
    public function teacherdetail(Request $request)
    {
      $dars=DB::table('dars')->where('payenumber',$request->input('paye'))->where('namelesson',$request->input('dars'))->first();
      $teacherids=Teacher_dars::wheredars_id($dars->id)->get();
       $count=0;
       if(count($teacherids)==0)
          return response()->json( array( 'msg'=> 0 ), 200 );
      foreach($teacherids as $variable)
      {
         $userid[$count]=Teacher::whereteacherkey($variable->teacher_id)->pluck('userid')->first();
         $count++;
      }
      $userid= array_unique($userid);
      $count=0;
      foreach($userid as $variable)
      {
         $userdetail[$count]=User::whereuserid($userid)->first();
         $count++;
      }
      return response()->json( array( 'msg'=> $userdetail,'dars'=> $dars), 200 );
    }
    public function showmessagegetdars()
    {
             $teacherid = Teacher::whereuserid( Session::get( 'userid' ) )->pluck( 'teacherkey' )->first();
             $getlessonid=DB::table( 'dars_teacher' )->where( 'teacher_id', $teacherid )->pluck( 'dars_id' );
              if(count($getlessonid)==0)
                 return view('teacher.showmessage')->with('darsdetail',0);
             $count=0;
             $getlessonid = $getlessonid->unique();
             foreach( $getlessonid  as $element)
             {

                  $darsdetail[$count]=Dars::whereid($element)->first();
                  $count++;
             }
             return view('teacher.showmessage')->with('darsdetail',$darsdetail);
    }
    public function getnamestudent(Request $request)
    {
         $userid=demand::whereteacheruserid(Session::get('userid'))->where('darsid',$request->input('darsid'))->pluck('studentuserid');
         $userid = $userid->unique();
         $count=0;
         if(count($userid)==0)
           return response()->json( array( 'msg'=> 0), 200 );
         foreach( $userid  as $element)
         {
              $userdetail[$count]=User::whereuserid($element)->first();
              $notreadmessage=$userid=demand::whereteacheruserid(Session::get('userid'))->where('darsid',$request->input('darsid'))->where('isread',0)->where('studentuserid',$element)->get();
              $numbernotreadmessage[$count]=count($notreadmessage);
              $count++;
         }
         return response()->json( array('userdetail'=> $userdetail,'numbermessage'=>$numbernotreadmessage,'darsid'=>$request->input('darsid')), 200 );
    }
    public function getmessage($userid,$darsid)
    {
          $studentuserid=str_replace('{', ' ', $userid);
          $studentuserid=str_replace('}', ' ', $studentuserid);
          $darsid=str_replace('{', ' ', $darsid);
          $darsid=str_replace('}', ' ', $darsid);
          $message=demand::whereteacheruserid(Session::get('userid'))->where('darsid',$darsid)->where('studentuserid',$studentuserid)->where('replyteacher',null)->get();
          return view('teacher.showstudentmessage')->with('message',$message);
    }
    public function replyteacher(Request $request)
    {
           $textid=$request->input('textid');
           $replyteacher=$request->input('replytext');
           $text=demand::wheretextid($textid)->first();
           $text->replyteacher=$replyteacher;
           $ldate[0] = date('Y');
           $ldate[1] = date('m');
           $ldate[2] = date('d');
           $shamsi=Verta::getJalali($ldate[0],$ldate[1],$ldate[2]);
           $ldate =new verta();
           $ldate->addHours(5);
           $text->dateteacher=collect($shamsi)->implode('-');;
           $text->timeteacher=$ldate->formatTime();
           $text->save();
     }
}
