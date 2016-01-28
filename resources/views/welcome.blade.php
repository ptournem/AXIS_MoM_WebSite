@extends('template/templateSimple')

@section('body')
 id="welcome"
@stop

@section('contenu')
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">	
	<div id="imaginary_container"> 
	    <div id="blocSearch">
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
    </div>
</div>
@stop

@section('footer')

@stop
