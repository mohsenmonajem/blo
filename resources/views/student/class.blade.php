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

   <script>
             var count=0;
             var value=1;
   </script>

     <script type="text/javascript">
     var  payedars;
               $(document).ready(function() {
                $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });
          $("input:radio").click(function() {
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
                                         var text1='<input type="radio" name="dars"'+'value='+poem+' />'+'<spand>'+poem+'</spand><br/>'
                                         var radioBtn = $(text1);
                                         radioBtn.appendTo('#container');
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
        <script>
            $(document).ready(function () {
                    $(".getclick").change(function() {
                    if(count!=0)
                      $("#container").empty();
                 });

                    });
         </script>
         <script>
                   function msg()
                   {
                      var getradio=document.getElementsByName('dars');
                      var checking=false;
                      var  text;
                      for(var i=0;i<getradio.length;i++)
                      {
                             if(getradio[i].checked==true)
                               {
                                 checking=true;
                                 text=getradio[i].value;
                               }
                      }
                       var checkdate=$("input:text");
                       if(checkdate[0].value.length==0)
                          checking=false;
                      if(checking==true)
                      {
                            $.ajaxSetup({

                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                 });
                  $.ajax({
                   url: '/getstudentclass',
                   type: 'POST',
                   data: { _token: '{{ csrf_token() }}',dars:text,startclass:checkdate[0].value,paye:payedars},
                                            success:function(data)
                                            {
                                                if(data["msg"]==0)
                                                   alert('درسی موجود نیست');
                                                   for(var i=0;i<data["msg"].length ;i++)
                                                   {
                                                      var name='<div><p><span>:نام</span><span>'+data["teacherdetail"][i].name+'</span></p>';
                                                      var family='<p><span>:نام خانوادگی</span><span>'+data["teacherdetail"][i].family+'</span></p>';
                                                      var capacity='<p><span>:تعداد کلاس</span><span>'+data["msg"][i].capacity+'</span></p>';
                                                      var cost='<p><span>  تومان قیمت:</span><span>'+data["msg"][i].cost+'</span></p>';
                                                      var startdate='<p><span>تاریخ شروع</span><span>'+data["msg"][i].start_date+'</span></p>';
                                                      var enddate='<p><span>تاریخ پایان</span><span>'+data["msg"][i].end_date+'</span></p>';
                                                      var address='<p><span>ادرس</span><span>'+data["msg"][i].address+'</span></p></div><br><br>';
                                                      var input1 ='<button class="data" onclick="sabtenam(this)" value="'+data["msg"][i].code_class+'">ثبت نام</button>';
                                                      var text = $(name+family+capacity+cost+startdate+enddate+address+input1);
                                                     text.appendTo('#information');
                                                   }
                                            },
                    error: function ()
                    {
                      alert('error');
                    },
                     });
                   }
                 else
                      {
                              alert(' لطفا درسی را انتخاب کنید یا  روز شروع کلاس خالی است  ');
                      }
             }
         </script>
         <script>
                function sabtenam(id)
                {

                    $.ajax({
                        url: '/sabtenam',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}',code_class:$(id).val()},

                        success:function(data){

                                                   console.log(data);
                                               },
                        error: function ()
                        {
                            alert('error');
                        },
                    });
                }

         </script>


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
    </head>
    <body>
         <?php
         ?>
        <div id ='msg'>This message will be replaced using Ajax.
         Click the button to replace the message.</div>
            {{ csrf_field() }}
            @foreach($data as $variable)
          <div>
             <input type="radio" name="paye" class="getclick" value="{{ $variable }}">
             <span>{{ $variable }} </span>
           </div>
          @endforeach
          <br/>
          <br/>
          <input type="text" id="pcal1" class="pdate" name="startdate" {{ old('startdate') }}>
         <small class="text-danger">{{ $errors->first('startdate') }}</small>
          <div id="container"> </div>
          <div id="information"></div>
          <script>
            var objCal1 = new AMIB.persianCalendar( 'pcal1',
            { extraInputID: "extra", extraInputFormat: "YYYYMMDD" }
            );
          </script>
    </body>
</html>
