@extends('template')

@section('header')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style2.css') }}">
<title>AXIS-MOM</title>


@stop

@section('title')
AXIS-MOM
@stop

@section('top')
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
@stop


@section('contenu')
<!-- Example row of columns -->
<div class="row">
    <div class="col-md-8">
	<?php
	$isMobile = (bool) preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry' .
			'|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]' .
			'|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT']);

	if (!$isMobile) {
	    ?>    

    	<div><h3>{{ $itemName }}</h3></div>
    	<div class="hidden-phone" id="graphe">

    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Event</label>
    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Lieu</label>
    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Objet</label>
    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Personne</label>
    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Activité</label>
    	    <label class="checkbox-inline"><input type="checkbox" value="" checked>Organisation</label>

    	    <p><img src="{{ URL::asset('img/graph.gif') }}" width="400px"></img></p>
    	</div>   
	    <?php
	}
	?>

	<div id="reseauxSociaux">
	    <ul class="list-inline">
		<li>
		    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
		</li>
		<li>
		    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
		</li>
		<li>
		    <a href="https://twitter.com/intent/tweet?text=Partagez%20vos%20emotions%20&button_hashtag=MuseeDuLouvre" target="_blank" class="btn-social btn-outline" ><i class="fa fa-fw fa-twitter"></i></a>
		</li>
	    </ul>

	</div>
    </div>


    <div class="col-md-4">
	<h2>Informations</h2>
	<p>
	    @foreach($infos as $info)
	    <b>{{ $info[0] }}</b> : {{ $info[1] }}<br />
	    @endforeach            
	</p>
    </div>

    <form action="{{url('add/comment')}}" method="POST" class="form-inline">
	<div class="col-md-4">
	    <h2>Partagez vos émotions</h2>
	    @foreach($comments as $comment)
	    <p><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>{{ $comment[0] }}</b> : {{ $comment[1] }}</p>
	    <hr>
	    @endforeach

	    {!! csrf_field() !!}
	    <div class="form-group">
		<input type="text" class="form-control" name='pseudo' id="usr" placeholder="Votre nom">
		{!! $errors->first('pseudo', '<small class="help-block">:message</small>') !!}
	    </div>
	    <div class="form-group">
		<textarea class="form-control" rows="4" name='comment' id="comment" placeholder="Votre commentaire"></textarea>
		{!! $errors->first('comment', '<small class="help-block">:message</small>') !!}
	    </div>
	    <div class="form-group">
		<button type="submit" class="btn btn-primary">Connexion</button>
	    </div>
	</div>
    </form>
</div>


<hr>

<footer>
    <p>&copy; 2015 Company, AXIS-MOM - Titan, LookOut</p>
</footer>
@stop

@section('footer')

@stop
