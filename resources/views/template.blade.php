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
        
        
        @yield('header')
        
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome-min.css">
        
    </head>
    
    <body>
        
        <div id="connexion">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalConnexion">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Se connecter
            </button>
        </div>
        
        @yield('top')
        
        <div class="container">
            
            @yield('contenu')
        </div>
        
        
        <!-- Modal -->
<div class="modal fade" id="modalConnexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Se connecter</h4>
      </div>
      <div class="modal-body">
          
          <form class="form-inline">
              
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Login">
              </div>
            </div>
            <br /><br />  
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Mot de passe">
              </div>
            </div>
              
          </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary">Connexion</button>
      </div>
    </div>
  </div>
</div>
        
        
        @yield('footer')
    </body>
</html>
