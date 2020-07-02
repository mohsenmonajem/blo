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
                        window.stop();
                        $("#userdata").empty();
                        var dars=$(this).val();
                        console.log(dars);
                        $.ajax({
                            url: '/getallstudentmessage',
                            type: 'POST',
                            data: { _token: '{{ csrf_token() }}',darsid:dars},
                            success:function(data){
                              if (data["numbermessage"]==-1)
                              {
                                var name='<div>اطلاعاتی موجود نیست</div>';
                                var text = $(name);
                                text.appendTo('#userdata');
                              }
                              else
                             {
                                for(var i=0;i<data["teacherdetail"].length ;i++)
                                {
                                    var name='<span style="border:2px solid black;">'+'<span><a href="/student/show/{'+data["teacherdetail"][i].userid+'}/{'+dars+'}">'+data["teacherdetail"][i].name+data["teacherdetail"][i].family+'</a></span>'+data["numbermessage"][i]+'</span>';
                                    var text = $(name);
                                    text.appendTo('#userdata');
                                 }
                             }
                           },
                            error: function ()
                            {
                                alert('error');
                            },
                        });
                      });
                });
        </script>
    </head>
    <body>
      @if ($dars===null)
       <p>  درسی موجود نیست</p>
      @else
           @foreach($dars as $element)
            <input  class="getclick" type="radio" name="dars" value="{{$element->id}}"<span>{{$element->payenumber}} {{$element->namelesson}} </span><br>
           @endforeach
      @endif
          <div id="userdata"></div>
    </body>
</html>
