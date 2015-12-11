@extends('template')

@section('header')
    <link rel="stylesheet" type="text/css" href="css/style2.css">
@stop

@section('titre')
    AXIS-MOM
@stop

@section('top')
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">AXIS-MOM</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
            <div class="input-group stylish-input-group">
                <input type="text" class="form-control"  placeholder="Search" >
                <span class="input-group-addon">
                    <button type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
            
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
@stop


@section('contenu')
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-8">
          <h2>Graphe</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>

        <div class="col-md-4">
          <h2>Lache ton com</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>
      
      
      <hr>

      <footer>
        <p>&copy; 2015 Company, Inc.</p>
      </footer>
@stop

@section('footer')

@stop
