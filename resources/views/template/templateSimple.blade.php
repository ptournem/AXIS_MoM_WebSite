<!DOCTYPE html>
<html>
    <head>
        <title>@section('title') AXIS_MoM @show</title>
        <meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<link rel="canonical" href="{{url('/')}}">
	<meta name="keywords" content="AXIS-MoM,Titan.be,LookOut,IG2I,Tite Maison Production" >
	<meta name="description" content="AXIS_MoM est un POC réalisé par une équipe d'étudiant de l'IG2I pour l'ASBL Titan et la société Tite Maison Production qui a pour but de prouver que l'ontologie AXIS-CSRM développée par Titan est utilisable.">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
	<script type="text/javascript">
	    var global = {
		showUrl: "{{route('public.show') }}",
		searchUrl: "{{route('public.search')}}",
                searchUrlSameas: "{{route('public.searchSameas')}}"
	    };
	</script>

        <script src="{{ URL::asset('js/jquery-1.11.3.min.js') }}"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon.png') }}" />

        <script type="text/javascript" src="{{ URL::asset('js/jquery.autocomplete.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/AXIS_MoM.js') }}"></script>

	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
        @yield('header')


        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}">
	
	<script type="text/javascript">
	    $(document).ready(function () {
		$('body').addClass('{{BrowserDetect::isMobile()== true ? "mobile":"desktop"}}');
	    })
	</script>

    </head>
    
    <body @yield('body')>
	@section('menu')
	    @if(Session::get('isConnected') != 'true')
		<div id="connexion">
		    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalConnexion">
			<span class="fa fa-user" aria-hidden="true"></span>
		    </button>
		</div>
	    @else
	    <div id="connexion">
		<form action="{{url('auth/deconnexion')}}" method="POST" class="form-inline pull-right">
		    {!! csrf_field() !!}
		    <button type="submit" class="btn btn-default">
			<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Déconnexion
		    </button>
		</form>
		<a id='admin-bt' href="{{url('admin')}}" class="form-inline pull-right">
		    <button type="submit" class="btn btn-default">
			<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Administration
			
		    </button>
		</a>
	    </div>
	    @endif
	@show

        @yield('top')
	<div class='container'>
	    <div class='row'>
		@if(session('messages'))
		@foreach(Session::get('messages') as $msg)
		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2 alert alert-danger alert-dismissible message-error" role="alert">
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <strong>Attention : </strong> {{$msg}}
		</div>
		@endforeach
		@endif
	    </div>
	</div>
	
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
			    <br /><br />
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
