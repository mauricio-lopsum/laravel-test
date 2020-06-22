<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Please login to continue</title>

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
                font-size: 30px;
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

            form{
                width: 300px;
            }
            input{
                width: 200px;
                border: 1px solid #ccc;
                display: block;
                padding: 0.5rem;
                margin: 0 auto;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Please sign in
                </div>

                @if (isset($_GET['error']))
                    <ul style="color:red">
                        User/password don't match our records.
                    </ul>
                @endif

                {{Form::open (array ('url' => 'logincheck'))}}
                    <p> {{Form::text ('username', "", array ('placeholder'=>'Username','maxlength'=>30))}} </p>
                    <p> {{Form::password ('password', array('placeholder'=>'Password','maxlength'=>30)) }} </p>
                    <p> {{Form::submit ('Submit')}} </p>
                {{Form::close ()}}


            </div>
        </div>
    </body>
</html>
