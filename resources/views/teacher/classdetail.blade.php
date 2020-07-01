<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
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
        <script type="text/javascript">

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        <script type="text/javascript">
              function sendidclass(id)
              {
                  console.log(id.value);
                  $.ajax({
                      url: '/getclassmember',
                      type: 'POST',
                      data: { _token: '{{ csrf_token() }}',code_class:id.value},
                      success:function(data)
                      {
                        console.log(data);

                      },
                      error: function ()
                      {
                          alert('error');
                      },
                  });
              }
        </script>
    </head>
    <body>
                    <?php $count=1; ?>
                @foreach($classteacher as $variable)

                    <button style="background: darkgreen" onclick="sendidclass(this)" value="{{$variable->code_class}}">کلاس{{$count}}</button>
                    <?php $count++; ?>
                @endforeach
    </body>
</html>
