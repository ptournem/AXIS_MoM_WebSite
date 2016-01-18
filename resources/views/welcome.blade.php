@extends('template')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
<title>AXIS-MOM</title>
<script type="text/javascript">
    function getCatInfo(cat) {
	var ret = {
	    activity: {
		class: 'wrench',
		text: 'Activité'
	    },
	    event: {
		class: 'time',
		text: 'Evènement'
	    },
	    organisation: {
		class: 'education',
		text: 'Organisation'
	    },
	    location: {
		class: 'home',
		text: 'Lieu'
	    },
	    object: {
		class: 'book',
		text: 'Objet'
	    },
	    person: {
		class: 'user',
		text: 'Personne'
	    }
	};
	if (ret.hasOwnProperty(cat)) {
	    return ret[cat];
	}

	return {class: "tag", text: "Autre"};
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
		if (item.type !== currentCategory) {
		    var cat = getCatInfo(item.type);
		    ul.append("<li class='list-group-item ui-autocomplete-category'><span class='glyphicon glyphicon-" + cat.class + "'></span> " + cat.text + "</li>");
		    currentCategory = item.type;
		}
		var li = that._renderItemData(ul, $.extend({},item,{label : item.name, id:item.URI}));
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
