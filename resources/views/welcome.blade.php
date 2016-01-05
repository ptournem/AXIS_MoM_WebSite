@extends('template')

@section('header')
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>AXIS-MOM</title>
@stop

@section('title')
    AXIS-MOM
@stop

@section('contenu')
                <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form action="http://localhost/PRP/public/infos" method="GET">
                        <div id="imaginary_container"> 
                            
                            <div id="blocSearch">
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
                </div>
@stop

@section('footer')

@stop
