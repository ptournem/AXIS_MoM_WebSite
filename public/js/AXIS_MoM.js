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
	    li.prepend('<img width="20" height="20" class="img-rounded" src="' + item.image + '"  style="margin-right : 10px;"/>');
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

function setProperty(name, value, type, elt) {
    $.getJSON(top.location + '/' + name + '/' + value + '/' + type, null)
	    .done(function (json) {
		console.log(json);
		if (json.success == true) {
		    console.log("OK");
                    elt.parent().children('.btn').addClass('disabled');
                    $('.locale-value.information-' + elt.parent().parent().attr('name')).children(".hidden").text(decodeURIComponent(unformatURI(value)));
		    $('.alert-success-update').show();
                    var thisClone = elt.clone().css('background-color', 'pink')
                        .removeClass('entity-dbpedia');
                        thisClone.append('<span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>');
                        elt.parent().parent().children('.locale-value')
                                    .append(thisClone);  
		}
		else {
		    console.log("fail");
		}
                elt.parent().children('.loadingSet').hide();
	    })
	    .fail(function (jqxhr, textStatus, error) {
		var err = textStatus + ", " + error;
		console.log("Request Failed: " + err);
                elt.parent().children('.loadingSet').hide();
	    });
}

function removeProperty(name, uriB, elt) {
    $.getJSON(top.location + '/' + name + '/' + uriB, null)
	    .done(function (json) {
		console.log(json);
		if (json.success == true) {
		    console.log("OK");
                    elt.parent().remove();
		}
		else {
		    console.log("fail");
		}
                elt.parent().children('.loadingDelete').hide();
	    })
	    .fail(function (jqxhr, textStatus, error) {
		var err = textStatus + ", " + error;
		console.log("Request Failed: " + err);
                elt.parent().children('.loadingDelete').hide();
	    });
}

function addEntity(type, name, description, image) {
    $.getJSON(top.location + '/addEntity/' + type + '/' + name + '/' + description + '/' + encodeURIComponent(formatURI(image)), null)
	    .done(function (json) {
		if (json.success === true) {
		    $('.alert-success-new-entity').show();
		    $('.btn-close-add-entity').trigger('click');
		    $('.tbody-entities').append("<tr class='type-" + json.type + "'><td><a href='" + top.location + "/view/" + encodeURIComponent(formatURI(json.URI)) + "' style='display: block;width: 100%; height: 100%;'>" + json.name + "</a></td><td>" + json.type + "</td></tr>");
		    $('.entity-name').val(null);
		    $('.entity-description').val(null);
		    $('.entity-image').val(null);
		}
		else {
		    console.log("fail");
		}
	    })
	    .fail(function (jqxhr, textStatus, error) {
		var err = textStatus + ", " + error;
		console.log("Request Failed: " + err);
	    });
}
