<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <script src="{{ URL::asset('js/jquery-1.11.3.min.js') }}"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon.png') }}" />
        
        <script type="text/javascript" src="{{ URL::asset('js/jquery.autocomplete.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/currency-autocomplete.js') }}"></script>
    
        @yield('header')
        
        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}">
        
    </head>
    
    <body>
        @if(Session::get('isConnected') != 'true')
            <div id="connexion">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalConnexion">
                    <span class="fa fa-user" aria-hidden="true"></span>
                </button>
            </div>
        @else
            <div id="connexion">
                <form action="{{url('auth/deconnexion')}}" method="POST" class="form-inline">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-default">
                        <span aria-hidden="true"> déconnexion</span>
                    </button>
                </form>
                <form action="{{url('admin/users')}}" method="POST" class="form-inline">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-default">
                        <span aria-hidden="true">Admin</span>
                    </button>
                </form>
            </div>
        @endif
        
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="col-xs-4">
            <div class="navbar-header">
              <a class="navbar-brand" href="{{ url('home') }}"><img src="{{ URL::asset('img/axismom.png') }}" width="120px" /></a>
            </div>
        </div>
        <form action="{{url('infos')}}" method="GET">
            <div class="col-xs-8">
                <div id="navbar" class="navbar-collapse collapse"> 
                    <div class="input-group stylish-input-group">
                        <input type="text" class="form-control" id="autocomplete" placeholder="Rechercher une oeuvre ou un artiste" >
                        <span class="input-group-addon">
                            <button type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>  
                        </span>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </nav>

        
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
        @if (session('status'))
                <div class="alert alert-success">
                        {{ session('status') }}
                </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                            @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                            @endforeach
                    </ul>
            </div>
        @endif
      <div class="modal-body">
          
          <form action="{{url('auth/connexion')}}" method="POST" class="form-inline">
              {!! csrf_field() !!}
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom d'utilisateur">
              </div>
                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
            </div>
            <br /><br />  
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
              </div>
                {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>  
          </form>
          
      </div>
      
    </div>
  </div>
</div>
        
        
        @yield('footer')
    </body>
</html>
