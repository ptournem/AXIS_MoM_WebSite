<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <script src="js/jquery-1.11.3.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        
        <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
        <script type="text/javascript" src="js/currency-autocomplete.js"></script>
    
        @yield('header')
        
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome-min.css">
        
    </head>
    
    <body>
        
        
        @yield('top')
        

            
        <div class="container">
            
            @yield('contenu')
        </div>

        
        
        
        
        @yield('footer')
    </body>
</html>
