<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <script type="text/javascript">
        $(document).ready(function() {
         $("#getnewpassword").click(function(){

            if($(this).prop("checked") == true)
            {
                  var text1='<span class="newpassword"> رمز جدید</span><input type="text" name="newpassword" required>';
                  var radioBtn = $(text1);
                  radioBtn.appendTo('#password');
            }
             if($(this).prop("checked") == false)
             {

                    var element=document.getElementsByClassName("newpassword");
                      element[1].remove();
                      element[0].remove();
             }
         });
        });
    </script>
       <body>
               <?php
               use Illuminate\Support\Facades\Cookie;
               use Illuminate\Http\Request;
               use App\User;
               use Illuminate\Http\Response;
               use Illuminate\Support\Facades\DB;
                         $value=Session::get('userid');
                        $username=User::whereuserid($value)->first();
                ?>
               <span> {{ $username->username }}</span>
               <br>
               <form action="updatedata" method="POST">
               <div id="password">
                {{ csrf_field() }}

              <span> رمز قدیمی</span><input type="text"  name="passwordold" value="{{ old("passwordold") }}"  required>
              <br>
               </div>
                <span>ایمیل</span><input type="text" name="email"  value="{{ $username->email }}" required>
                <br>
               <span>  رمز جدید</span> <input type="checkbox" id="getnewpassword"><br>
                <input type="submit" value="ارسال">
            </form>
            </body>
</html>
