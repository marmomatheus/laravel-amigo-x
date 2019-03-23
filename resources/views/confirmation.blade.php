<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>confirmação - Amigo X</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
</head>

<body>
    <div class="jumbotron text-xs-center">
        <h1 class="display-3">Sucesso!</h1>
        <p class="lead">{{ $confirmationText }}</p>
        <hr>        
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{ url('login')}}" role="button">Login</a>
        </p>
    </div>
</body>

</html>
