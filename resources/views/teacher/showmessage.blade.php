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
                        $("#userdata").empty();
                        payedars=$(this).val();
                        value=this.value;
                        $.ajax({
                            url: '/getnamestudent',
                            type: 'POST',
                            data: { _token: '{{ csrf_token() }}',darsid:$(this).val()},
                            success:function(data){
                              if(data["msg"]==0)
                              {
                                 var name='<div>اطلاعاتی موجود نیست</div>';
                                 var text = $(name);
                                 text.appendTo('#userdata');

                              }
                              else
                              {
                                for(var i=0;i<data["userdetail"].length ;i++)
                                {
                                  console.log('"/teacher/showusermessage/{'+data["userdetail"][i].userid+'}/{'+data["darsid"][i]+'}">');
                                  var name='<span style="border:2px solid black;">'+'<span><a href="/teacher/showusermessage/{'+data["userdetail"][i].userid+'}/{'+data["darsid"][i]+'}">'+data["userdetail"][i].name+data["userdetail"][i].family+'</a></span>'+data["numbermessage"][i]+'</span>';
                                  var text = $(name);
                                  text.appendTo('#userdata');
                                  count++;
                                }
                              }
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
                    for(var i=0;i<data["msg"].length ;i++)
                    {
                      var start='<div style="border:2px solid black">';
                      var name='<div><p><span>:نام</span><span>'+data["msg"][i].name+'</span></p></div>';
                      var family='<p><span>:نام خانوادگی</span><span>'+data["msg"][i].family+'</span></p>';
                      var email='<p><span>:ایمیل</span><span>'+data["msg"][i].email+'</span></p>'
                      var text='<input type="text"><br>';
                      var input1 ='<button class="data" onclick="darkhast(this)" value="'+data["msg"][i].userid+'">ارسال درخواست</button>';
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
            function  darkhast(data)
            {

            if($('input:text').val().length>1)
            {
              $.ajax({
                  url: '/savestudentdemand',
                  type: 'POST',
                  dataType: "json",
                  data: { _token: '{{ csrf_token() }}',teacheruserid:$(data).val(),text:$('input:text').val()},
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
      @if ($darsdetail===0)
       <p>  درسی موجود نیست</p>
      @else
           @foreach($darsdetail as $element)
            <input  class="getclick" type="radio" name="dars" value="{{$element->id}}"<span>{{$element->payenumber}} {{$element->namelesson}} </span><br>
           @endforeach
      @endif
          <div id="userdata"></div>
    </body>
</html>
