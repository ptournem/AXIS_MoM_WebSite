@extends('template')

@section('header')
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    
    
    
@stop

@section('title')
    AXIS-MOM
@stop

@section('top')
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="col-xs-4">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><img src="img/axismom.png" width="120px" /></a>
            </div>
        </div>
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

            </div><!--/.navbar-collapse -->
        </div>
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
            
                
                <div class="hidden-phone" id="graphe">
                    
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Event</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Lieu</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Objet</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Personne</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Activité</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" checked>Organisation</label>
                    
                    <p><img src="img/graph.gif" width="400px"></img></p>
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
            <p><b>Artiste</b> : Jacques Louis David<br />
                <b>Période</b> : Néo-Classicisme<br />
                <b>Support</b> : Peinture à l'huile<br />
                <b>Lieu</b> : Musée du Louvre</p>
        </div>
          
        <div class="col-md-4">
            <h2>Partagez vos émotions</h2>
            <p><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>Robin</b> : très belle oeuvre</p>
            <hr>
            <p><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>Riad</b> : wallah elle chill cette tableau</p>
            <hr>
            <p><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>Corentin</b> : moi j'aime pas trop</p>
            
            <hr>
            <div class="form-group">
                <input type="text" class="form-control" id="usr" placeholder="Votre nom">
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="4" id="comment" placeholder="Votre commentaire"></textarea>
            </div>
        </div>
      </div>
      
      
      <hr>

      <footer>
        <p>&copy; 2015 Company, AXIS-MOM - Titan, LookOut</p>
      </footer>
@stop

@section('footer')

@stop
