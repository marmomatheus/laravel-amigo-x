<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-path" content="/">        
        <title>Amigo X</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
        <link href='{{ mix('css/app.css') }}' rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>