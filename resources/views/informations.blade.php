@extends('template/templateNavbar')

@section('body')
    id="info"
@stop

@section('header')

<script type="text/javascript" src="{{ URL::asset('js/raphael.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/raphael-svg-filter-min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/semanticGraphael.js') }}"></script>
<script type="text/javascript" >
$(document).ready(function () {
    $.fn.semanticGraphael.default.ItemOptions.horizontalMargin = 0;
    $.fn.semanticGraphael.default.ItemOptions.verticalMargin = 0;
    $('#graph').semanticGraphael({
	centralItem: {!!json_encode($entity)!!},
	connections: {!! json_encode($infos->object) !!},
	onClickItem: function (item) {
	    // on navigue vers l'url de l'item 
	    window.location = ("{{route('public.show')}}/" + formatURI(item.URI));
	},
	beforeAddItem: function () {
	    //on récupère les infos qui nous intéressent 
	    this.label = this.name;
	    this.imgUrl = this.image;
	    return this;
	},
	beforeAddConnection: function () {
	    // on set le connectlabel
	    this.ent.connectLabel = this.name;
	    // et on renvoie l'entité et pas la propriété
	    return this.ent;
	},
	afterAddConnection: function (conn) {
		var item = this
		conn.item.forEach(function (elt) {
		    elt[0].classList.add(item.type);
		});
		$(conn.connection.text[0]).attr('class', this.type);
		$(conn.connection.line[0]).attr('class', this.type);
	    
	}
    });
    
    
    $('.cbfilter').click(function(){
	var selector = ('#graph .'+$(this).val());
	var elts = $(selector);
	if($(this).prop('checked')){
	    elts.show();
	}else {
	    elts.hide();
	}
    }).prop('checked',true);
});
</script>

@stop




@section('contenu')
<!-- Example row of columns -->
<div class="row">
    <div class="col-md-8">
	

    	<div><h3>{{ $entity->name }}</h3></div>
	
	@if(!BrowserDetect::isMobile())
    	<div class="hidden-phone" id="graphe">

    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="event" checked>Event</label>
    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="location" checked>Lieu</label>
    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="object" checked>Objet</label>
    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="person" checked>Personne</label>
    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="activity" checked>Activité</label>
    	    <label class="checkbox-inline"><input class="cbfilter" type="checkbox" value="organisation" checked>Organisation</label>

    	    <div id="graph" style="height:500px; width :100%"></div>
    	</div>
	@else
	    <div>
		<img src="{{$entity->image}}" style="width:100%;" class="img-thumbnail" />
	    </div>
	@endif
	
	<div id="reseauxSociaux">
	    <ul class="list-inline">
		<li>
		    <a href="https://www.facebook.com/sharer/sharer.php?u={{rawurlencode(Request::url())}}" target="_blank" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
		</li>
		<li>
		    <a href="https://plus.google.com/share?url={{rawurlencode(Request::url())}}" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-google-plus"></i></a>
		</li>
		<li>
		    <a href="https://twitter.com/intent/tweet?text=Partagez%20vos%20emotions%20&button_hashtag={{$entity->type}}&url={{rawurlencode(Request::url())}}" target="_blank" class="btn-social btn-outline" ><i class="fa fa-fw fa-twitter"></i></a>
		</li>
	    </ul>

	</div>
    </div>


    <div class="col-md-4">
	<h2>Informations</h2>
	<p>
	    @foreach($infos->literal as $info)
	    <b>{{ $info->name }}</b> : {{ $info->value }}<br />
	    @endforeach       
	</p>
	<p>
	    @foreach($infos->object as $info)
	    <b>{{ $info->name }}</b> : <a href="{{ route('public.show', ['uid'=>Utils::formatURI($info->ent->URI)]) }}">{{$info->ent->name}}</a><br />
	    @endforeach
	</p>
    </div>

    <form action="{{url('add/comment')}}" method="POST" class="form-inline">
	<div class="col-md-4">
	    <h2>Partagez vos émotions</h2>
	    @foreach($comments as $comment)
	    <p><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>{{ $comment->authorName }}</b> : {{ $comment->comment }}</p>
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