<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
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
    </head>
    <body>
            <form action="/home/savedata" method="post">
                {{ csrf_field() }}
              <div><span>name</span> <input type="text" name="name" for="name"> </div>
                <small class="text-danger">{{ $errors->first('name') }}</small>
                 <div> <span>family</span> <input type="text" name="family" for="family"></div>
                             <small class="text-danger">{{ $errors->first('family') }}</small>
               <div>  <span>email</span>  <input type="text" name="email" for="email"> </div>
                             <small class="text-danger">{{ $errors->first('email') }}</small>
                    <div>  <span>password</span>  <input type="text" name="password" for="password"> </div>
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                 <span>معلم</span><input type="radio" name="role" value="teacher"><br>
                <span>   دانش اموز</span><input type="radio" name="role" value="student"><br>
              <span>  نام کاربری </span><input type="text" name="username">
                <br>
               <input type="submit" value="submit">
        </form>
    </body>
</html>
