<?php
namespace App\Http\Controllers;
use App\Dars;
use App\Teacher;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;
use App\TeacherRequest;
use App\studentclass;
use Carbon\Carbon;
use Verta;
use App\User;
use App\demand;
use Illuminate\Support\Str;
use Illuminate\Routing\ResponseFactory;
class studentController extends Controller {
    public function showclassview() {
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
        return view( 'student.class' )->with( 'data', $u );
    }

    public function getclassinformation( Request $request ) {
        //this function getpaye and return the lesson for this paye
        $darsdetail = DB::table( 'dars' )->where( 'namelesson', $request->input( 'dars' ) )->where( 'payenumber', $request->input( 'paye' ) )->first();
        $getclass = TeacherRequest::wheredars_id( $darsdetail->id )->get();
        $count = 0;
        for ( $i = 0; $i<count( $getclass );
        $i++ ) {
            $startdate = explode( '/', $request->input( 'startclass' ) );
            $enddate = explode( '-', $getclass[$i]->start_date );
            if ( $enddate[0]<$startdate[0] ) {
                continue;
            }
            if ( $enddate[0] == $startdate[0] ) {
                if ( $enddate[1]<$startdate[1] ) {

                    continue;
                }
                if ( $enddate[2]<$startdate[2] ) {
                    continue;
                }
            }
            $useridteacher = Teacher::whereteacherkey( $getclass[$i]->teacher_id )->first();
            $teacherdetail = User::whereuserid( $useridteacher->userid )->first();
            $detailteacher[$count] = $teacherdetail;
            $msg[$count] = $getclass[$i];
            $count++;
        }
        if ( $count == 0 ) {
            $msg = 0;
            $detailteacher = 0;

        }
        return response()->json( array( 'msg'=> $msg, 'teacherdetail'=>$detailteacher ), 200 );
    }

    public function sabtenam( Request $request ) {
        $studentdetail = Student::whereuserid ( Session::get( 'userid' ) )->first();
        $sabteclass = new studentclass;
        $sabteclass->code_class = $request->input( 'code_class' );
        $sabteclass->studentkey = $studentdetail->studnetkey;
        $sabteclass->save();
        $msg = $request->input( 'code_class' );
        return response()->json( array( 'msg'=> $msg, ), 200 );
    }

    public function demandteacher() {
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
        return view( 'student.demandteacher' )->with( 'data', $u );
    }
    public function savestudentdemand(Request $request)
    {
      $savedemand = new demand;
      $savedemand->teacheruserid=$request->input('teacheruserid');
      $savedemand->studentuserid=Session::get('userid');
      $savedemand->messagestudent=$request->input('text');
      $ldate[0] = date('Y');
      $ldate[1] = date('m');
      $ldate[2] = date('d');
      $shamsi=Verta::getJalali($ldate[0],$ldate[1],$ldate[2]);
      $ldate =new verta();
      $ldate->addHours(5);
      $savedemand->datestudent=collect($shamsi)->implode('-');
      $savedemand->timestudent=$ldate->formatTime();
      $savedemand->isread=false;
      $savedemand->studentread=false;
      $savedemand->darsid=$request->input("darsid");
      $savedemand->save();
      return response()->json( array( 'msg'=> 1 ), 200 );
    }
    public function showmessageforstudent()
    {
       $getdarsid=demand::wherestudentuserid(Session::get('userid'))->pluck('darsid');

      $getdarsid=$getdarsid->unique();
       $count=0;
       foreach(  $getdarsid as $element)
       {
          $dars[$count]=Dars::whereid($element)->first();
          $count++;
       }
      if($count==0)
      {
        $dars=null;
         return view('student.showmessage')->with('dars',$dars);
      }
       return view('student.showmessage')->with('dars',$dars);
    }
    public function studentallmessage(Request $request)
    {
      $teacherid=demand::wheredarsid($request->input('darsid'))->wherestudentuserid(Session::get('userid'))->pluck('teacheruserid');
      $teacherid=$teacherid->unique();
       if($teacherid==null)
        return response()->json( array( 'numbermessage'=> -1 ), 200 );
      $count=0;
      foreach ($teacherid as $element)
      {
          $teacherdetail[$count]=User::whereuserid($element )->first();
          $numbernotreadmessage=demand::wherestudentuserid(Session::get('userid'))->where('teacheruserid',$element)->where('darsid',$request->input('darsid'))->where('studentread',0)->where('replyteacher','notnull')->get();
          $notreadmessage[$count]=count($numbernotreadmessage);
          $count++;
      }
      return response()->json( array( 'numbermessage'=> $notreadmessage,'teacherdetail' => $teacherdetail ), 200 );
    }
}
?>
