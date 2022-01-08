<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Demo Task</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/all.css">

        <script type="text/javascript">
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>
    </head>
    <body>
        <body>
         <div id="app">
             @if(Auth::check())
                <mainapp :user="{{Auth::user()}}"></mainapp>
            @else
                <mainapp :user="false"></mainapp>
            @endif
         </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>
