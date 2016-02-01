@extends('template/templateSimple')

@section('body')
    id="info"
@stop

@section('menu')
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('home') }}"><img src="{{ URL::asset('img/axismom.png') }}" height="20px" /></a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

	@yield('menu-before')
	 
	<div class="navbar-form navbar-left">
	    <div class="form-group">
		<div class="input-group stylish-input-group">
		    <input type="text" class="form-control" id="searchEntity" placeholder="Rechercher une oeuvre ou un artiste" >
		    <span class="input-group-addon">
			<button type="button">
			    <span class="glyphicon glyphicon-search"></span>
			</button>  
		    </span>
		</div>
	    </div>
	</div>
	
	@yield('menu-after')
      
	<div class="nav navbar-nav navbar-right">
	    @parent
	</div>
	
	
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

@endSection