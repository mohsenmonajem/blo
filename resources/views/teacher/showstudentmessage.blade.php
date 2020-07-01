<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Laravel</title>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
   <script>
             var count=0;
             var value=1;
   </script>
     <script>
               $(document).ready(function() {
                 $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
            });
          $(".message").click(function() {
             $("#reply").empty();
             var textid =$(this).attr("value");
              var text1='<div>'+$(this).text()+'</div><br><input type="text" id="messages" ><input type="button" value="ارسال">';
              var divBtn = $(text1);
              divBtn.appendTo('#reply');
             $("input:button").click(function() {
               $.ajax({
                 url: '/replyteacher',
                 type: 'POST',
                 data: { _token: '{{ csrf_token() }}',textid:textid,replytext:$("#messages").val()},
                 success:function(data){
                                       if(data["msg"]==0)
                                        {
                                          $("#reply").empty();
                                          var text1='<div>قبلا به این پیام پاسخ داده شده است </div>';
                                          var divBtn = $(text1);
                                          divBtn.appendTo('#reply');
                                        }
                                        else
                                        {
                                          var text1='<div>  پاسخ ثبت شد</div>';
                                          var divBtn = $(text1);
                                          divBtn.appendTo('#reply');
                                        }
                                       },
                 error: function ()
                 {
                     alert('error');
                 },
               });
              });
           });
    });
</script>
<body>
           @foreach($message  as $element)
           <p class="message" id="message{{$element->textid}}" value="{{$element->textid}}">{{$element->messagestudent}}</p>
              <div style="border:1 px  solid black;">
                <p>{{$element->datestudent}}</p>
                <p>{{$element->timestudent}}</p>
              </div>
           @endforeach
           <div id="reply"> </div>
</body>
</html>
