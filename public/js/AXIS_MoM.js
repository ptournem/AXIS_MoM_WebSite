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
	ul.addClass('list-group col-md-3');
	ul.addClass('list-group col-sm-3');
	ul.addClass('list-group col-xs-10');
	var that = this,
		currentCategory = "";
	$.each(items, function (index, item) {
	    if (item.type !== currentCategory) {
		var cat = getCatInfo(item.type);
		ul.append("<li class='list-group-item ui-autocomplete-category'><span class='glyphicon glyphicon-" + cat.class + "'></span> " + cat.text + "</li>");
		currentCategory = item.type;
	    }
	    var li = that._renderItemData(ul, $.extend({}, item, {label: item.name, value: item.name}));
	    li.addClass('list-group-item');

	});
    },
    messages: {
	noResults: '',
	results: function () {
	}
    }
});

$(document).ready(function () {
    $('#searchEntity').catcomplete({
	source: function (request, response) {
	    $.getJSON(global.searchUrl, {needle: request.term}, response);
	},
	select: function (event, ui) {
	    // on redirect vers la bonne page
	    window.location = (global.showUrl + "/" + formatURI(ui.item.URI));
	},
	delay: 600
    });
});

function formatURI(url) {
    return url.replace(/\//gi, '|');
}

function unformatURI(url) {
    return url.replace(/\|/gi, '/');
}