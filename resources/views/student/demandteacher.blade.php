<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script src="{{ asset('js-persian-cal.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('js-persian-cal.css') }}">
        <meta charset="utf-8">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Laravel</title>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
         <script>
            var count=0;
            var value=1;
         </script>
        <script>
            $(document).ready(function () {
                $(".getclick").change(function() {
                    if(count!=0)
                        $("#container").empty();
                });
            });
        </script>
        <script type="text/javascript">
            var  payedars;
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(".getclick").click(function() {
                    if(this.value!=value)
                    {
                        payedars=$(this).val();
                        value=this.value;
                        $.ajax({
                            url: '/getpayedars',
                            type: 'POST',
                            data: { _token: '{{ csrf_token() }}',paye:$(this).val()},
                            success:function(data){
                                for(var i=0;i<data["msg"].length ;i++)
                                {
                                    var poem = data["msg"][i].namelesson;
                                    var text1='<input type="radio"  class="darse"  name="dars" value='+poem+'><spand>'+poem+'</spand><br/>';
                                    var radioBtn = $(text1);
                                    radioBtn.appendTo("#container");
                                    count++;
                                }
                                var text2='<input type="button"  id="rr" value="انتخاب" onclick="msg()" >';
                                var radioBtn2 = $(text2);
                                radioBtn2.appendTo('#container');

                            },
                            error: function ()
                            {
                                alert('error');
                            },
                        });
                    }
                });

             });
        </script>
        <script type="text/javascript">
            function msg()
            {
              $("#teacherdata").empty();
              var paye=$('input[name="paye"]:checked').val();
              var dars= $('input[name="dars"]:checked').val();
              $.ajax({
                  url: '/getteacherdetail',
                  type: 'POST',
                  data: { _token: '{{ csrf_token() }}',dars:dars,paye:paye },
                  success:function(data){
                    console.log(data);
                    for(var i=0;i<data["msg"].length ;i++)
                    {

                      var start='<div style="border:2px solid black">';
                      var name='<div><p><span>:نام</span><span>'+data["msg"][i].name+'</span></p></div>';
                      var family='<p><span>:نام خانوادگی</span><span>'+data["msg"][i].family+'</span></p>';
                      var email='<p><span>:ایمیل</span><span>'+data["msg"][i].email+'</span></p>'
                      var text='<input type="text"><br>';
                      var iddars=data["dars"].id;

                      var input1 ='<button class="data" onclick="darkhast(this,'+iddars+')" value="'+data["msg"][i].userid+'">ارسال درخواست</button>';
                      var end='</div>';
                      var text = $(start+name+family+email+text+input1+end);
                      text.appendTo('#teacherdata');
                    count++;
                  }
                 },
                  error: function ()
                  {
                      alert('error');
                  },
              });
            }
            function  darkhast(data,darsid)
            {

            if($('input:text').val().length>1)
            {
              $.ajax({
                  url: '/savestudentdemand',
                  type: 'POST',
                  dataType: "json",
                  data: { _token: '{{ csrf_token() }}',teacheruserid:$(data).val(),darsid:darsid,text:$('input:text').val()},
                  success:function(value){
                             console.log(value);
                  },
                  error: function ()
                  {
                      alert('error');
                  },
              });
            }
            else
            {
                      var text='<div style="border:2px solid black">شرح در خواست را کامل کنید</div>';
                      var text1 = $(text);
                      text1.appendTo('#teacherdata');

            }
          }
        </script>
    </head>
    <body>
    <div id ='msg'>This message will be replaced using Ajax.
        Click the button to replace the message.</div>
    {{ csrf_field() }}
    @foreach($data as $variable)
        <div>
            <input type="radio" name="paye" class="getclick" value="{{ $variable }}">
            <span>{{ $variable }} </span>
        </div>
    @endforeach
    <br>
    <br>
    <div id="container"></div>
    <div id="teacherdata"></div>
    </body>
</html>
