@extends('template')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
<title>AXIS-MOM</title>
<script type="text/javascript">
    function getGlyphicon(cat) {
	switch (cat) {
	    case 'Activite':
		return 'wrench';
	    case 'Evènement':
		return 'time';
	    case 'Lieu':
		return 'home';
	    case 'Organisation':
		return 'education';
	    case 'Objet':
		return 'book';
	    case 'Personne':
		return 'user';
	    default:
		return 'tag';
	}
    }

    $.widget("custom.catcomplete", $.ui.autocomplete, {
	_create: function () {
	    this._super();
	    this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
	},
	_renderMenu: function (ul, items) {
	    ul.addClass('list-group col-sm-3');
	    var that = this,
		    currentCategory = "";
	    $.each(items, function (index, item) {

		if (item.category != currentCategory) {
		    ul.append("<li class='list-group-item ui-autocomplete-category'><span class='glyphicon glyphicon-" + getGlyphicon(item.category) + "'></span> " + item.category + "</li>");
		    currentCategory = item.category;
		}
		" activite=> wrench , event=> time , lieu => home , organisation => education, objet => book, personne => user"
		var li = that._renderItemData(ul, item);
		li.addClass('list-group-item');

	    });
	},
	messages: {
	    noResults: '',
	    results: function () {
	    }
	},
    });

    $(document).ready(function () {
	$('#welcomeAutoComplete').catcomplete({
	    source: function (request, response) {
		$.getJSON("{{route('public.search')}}", {needle: request.term}, response);
	    },
	    messages: {
		noResults: '',
		results: function () {
		}
	    },
	    delay: 600
	});
    });
</script>
@stop

@section('title')
AXIS-MOM
@stop

@section('contenu')
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">	
	<div id="imaginary_container"> 
	    <div id="blocSearch">
		<div class="input-group stylish-input-group">
		    <input type="text" class="form-control" id="welcomeAutoComplete" placeholder="Rechercher une oeuvre ou un artiste" >
		    <span class="input-group-addon">
			<button type="submit">
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
