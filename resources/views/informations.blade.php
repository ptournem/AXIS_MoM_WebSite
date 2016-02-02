@extends('template/templateNavbar')

@section('body')
id="info"
@stop

@section('header')

<!--FACEBOOK-->
<meta property="og:title" content="{{$entity->name}}" >
<meta property="og:site_name" content="AXIS-MoM">
    <meta property="og:url" content="{{Request::url()}}" >
<meta property="og:description" content="AXIS_MoM est un POC réalisé par une équipe d'étudiant de l'IG2I pour l'ASBL Titan et la société Tite Maison Production qui a pour but de prouver que l'ontologie AXIS-CSRM développée par Titan est utilisable." >
<meta property="og:image" content="{{$entity->image}}" >
<meta property="og:type" content="website" >
<meta property="og:locale" content="fr_FR" >
<!--TWITTER-->
<meta property="twitter:card" content="summary" >
<meta property="twitter:title" content="{{$entity->name}}" >
<meta property="twitter:description" content="AXIS_MoM est un POC réalisé par une équipe d'étudiant de l'IG2I pour l'ASBL Titan et la société Tite Maison Production qui a pour but de prouver que l'ontologie AXIS-CSRM développée par Titan est utilisable." >
<meta property="twitter:url" content="{{Request::url()}}" >
<meta property="twitter:image" content="{{$entity->image}}" >
<!--GOOGLE-->
<meta itemprop="name" content="{{$entity->name}}">
<meta itemprop="description" content="AXIS_MoM est un POC réalisé par une équipe d'étudiant de l'IG2I pour l'ASBL Titan et la société Tite Maison Production qui a pour but de prouver que l'ontologie AXIS-CSRM développée par Titan est utilisable.">
<meta itemprop="image" content="{{$entity->image}}">


<script type="text/javascript" src="{{ URL::asset('js/raphael.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/raphael-svg-filter-min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/semanticGraphael.js') }}"></script>
<script type="text/javascript" >
$(document).ready(function () {
    
    // init du graphe 
    $.fn.semanticGraphael.default.ItemOptions.horizontalMargin = 0;
    $.fn.semanticGraphael.default.ItemOptions.verticalMargin = 0;
    $('#graph').semanticGraphael({
	centralItem: {!!json_encode($entity)!!},
	connections: {!! json_encode($infos->connection) !!},
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
    
    // filtres
    $('.cbfilter').click(function(){
	var selector = ('#graph .'+$(this).val());
	var elts = $(selector);
	if($(this).prop('checked')){
	    elts.show();
	}else {
	    elts.hide();
	}
    }).prop('checked',true);
    
    // envoie du commentaire 
    $('#addCommentModal #btnComment').click(function(){
	var data = $('#addCommentModal form').serialize();
	$.post("{{route('comment.add')}}",data,function(data){
	    if(data.result){
		resetForm();
		$('#addCommentModal .alert').removeClass('alert-danger').addClass('alert-success').text('Commentaire ajouté ! Il sera affiché après modération.').show('fade').delay(1500).hide(function(){
		    $('#addCommentModal').modal('hide')
		});
		
	    }else {
		resetForm();
		$('#addCommentModal form p').hide();
		$.each(data.require,function(key,msg){
		    $('#addCommentModalError-'+key).parent().addClass('has-error');
		    $('#addCommentModalError-'+key).text(msg).show('fade');
		})
		
	    }
	});
    })
    
    function resetForm(){
	$('#addCommentModal form>div').removeClass('has-error');
	$('#addCommentModal form p').hide();
    }
    
    // reset des champs lors de la fermeture de la modal 
    $('#addCommentModal').on('hide.bs.modal', function (event) {
	$('#addCommentModal form').get(0).reset()
	resetForm();
    });
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
    <div class="panel-group col-md-4 accordionInfo" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
	    <div class="panel-heading" role="tab" id="headingOne">
		<h4 class="panel-title">
		    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			Informations
		    </a>
		</h4>
	    </div>
	    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
		<div class="panel-body">
		    @foreach($infos->literal as $info)
			<p>
			    <b>{{ $info->name }}</b> : {{ $info->value }}
			</p>
		    @endforeach   
		    @foreach($infos->object as $info)
			<p>
			    <b>{{ $info->name }}</b> :
			    @if(is_array($info->ent))
				<ul>
				    @foreach($info->ent as $ent)
					<li><a href="{{ route('public.show', ['uid'=>Utils::formatURI($ent->URI)]) }}">{{$ent->name}}</a></li>
				    @endforeach
				</ul>
			    @else 
				 <a href="{{ route('public.show', ['uid'=>Utils::formatURI($info->ent->URI)]) }}">{{$info->ent->name}}</a>
			    @endif
			    
			</p>
		    @endforeach
		    
		</div>
	    </div>
	</div>
	<div class="panel panel-default">
	    <div class="panel-heading" role="tab" id="headingTwo">
		<h4 class="panel-title pull-left headingButton">
		   <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			Commentaires ({{count($comments)}})
		    </a>
		</h4>

		<button class="btn btn-default pull-right"  data-toggle="modal" data-target="#addCommentModal">Commenter</button>
		<div class="clearfix"></div>
	    </div>
	    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
		 <ul class="list-group">
		    @foreach($comments as $comment)
		    <li class="list-group-item"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <b>{{ $comment->authorName }}</b> : {{ $comment->comment }}</li>
		    @endforeach
		  </ul>
	    </div>
	</div>
    </div>

</div>


<hr>

<footer>
    <p>&copy; 2015 Company, AXIS-MOM - Titan, LookOut</p>
</footer>

<div class="modal fade" tabindex="-1" id="addCommentModal" role="dialog">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Commenter cette oeuvre</h4>
	    </div>
	    <div class="modal-body">
		<div class="alert" role="alert" style="display:none;"></div>
		<form>
		    {!! csrf_field() !!}  
		    <input type="hidden" name="entity" value="{{$entity->URI}}" />
		    <div class="form-group">
			<label class="control-label" for="commentName">Nom et prénom :</label>
			<input type="text" class="form-control" name="Nom" id="commentName" placeholder="Nom">
			<p id="addCommentModalError-Nom" class="text-danger" style="display:none;"></p>
			
		    </div>
		    <div class="form-group">
			<label class="control-label" for="commentEmail">Mail :</label>
			<input type="email" class="form-control" name="Mail" id="commentEmail" placeholder="Email">
			<p id="addCommentModalError-Mail" class="text-danger" style="display:none;"></p>
		    </div>
		    <div class="form-group">
			<label class="control-label" for="commentComment">Commentaire :</label>
			<textarea class="form-control" name="Commentaire" id="commentComment"></textarea>
			<p id="addCommentModalError-Commentaire" class="text-danger" style="display:none;"></p>
		    </div>
		</form>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		<button type="button" class="btn btn-primary" id="btnComment">Commenter</button>
	    </div>
	</div>
    </div>
</div>
@stop