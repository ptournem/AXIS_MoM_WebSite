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
            $isMobile = (bool)preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry'.
                    '|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                    '|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
            
            if(!$isMobile) {
            ?>    
              
            <?php
            }
            ?>
            <div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Liste des utilisateurs</h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td>{!! $user->id !!}</td>
							<td class="text-primary"><strong>{!! $user->name !!}</strong></td>
							<td>{!! url('admin.users.show', 'Voir', [$user->id], ['class' => 'btn btn-success btn-block']) !!}</td>
                                                        <td>{!! url('admin.users.editPW', 'Modifier Mot de passe', [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>{!! url('admin.users.edit', 'Modifier', [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['admin.users.destroy', $user->id]]) !!}
									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer cet utilisateur ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
      
      
      <hr>

      <footer>
        <p>&copy; 2015 Company, AXIS-MOM - Titan, LookOut</p>
      </footer>
@stop

@section('footer')

@stop
