@extends('admin/template')

@section('header')
<script type="text/javascript">
    function successEntityAutocompletion(elt, ui) {
        console.log("successEntityAutocompletion");
        $('.alert-success-update').show();
        elt.text("");
        console.log(elt.parent().children(".input-group-btn"));
        elt.parent().children(".input-group-btn").children(".btn").hide();
        $("<span class='entity' name='" + ui.item.name + "' style='background-color: pink; padding: 2px; margin: 2px;'></span>").insertBefore(elt.parent().children(".value-edited"));
        elt.parent().children(".entity[name='" + ui.item.name + "']").append('<span name="' + ui.item.URI + '" class="value">' + ui.item.name + '</span>');
        elt.parent().children(".entity[name='" + ui.item.name + "']").append('<span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>');
    }
    
    function successEntityAutocompletionSameas(elt, ui) {
        console.log("successEntityAutocompletionSameas");        
        $('.alert-success-update').show();
        console.log(elt.parent().children(".input-group-btn"));
        elt.parent().children(".input-group-btn").children(".btn").hide();
        $("<span class='entity' name='" + ui.item.name + "' style='background-color: pink; padding: 2px; margin: 2px;'></span>").insertBefore(elt.parent().children(".value-edited"));
        elt.parent().children(".entity[name='" + ui.item.name + "']").append('<span name="' + ui.item.URI + '" class="value">' + ui.item.name + '</span>');
        elt.remove();
    }

    function successEntityDBpedia(elt, value) {
        console.log("successEntityDBpedia");
        elt.parent().children('.btn').addClass('disabled');
        $('.locale-value.information-' + elt.parent().parent().attr('name')).children(".hidden").text(decodeURIComponent(unformatURI(value)));
        $('.alert-success-update').show();
        var thisClone = elt.clone().css('background-color', 'pink')
            .removeClass('entity-dbpedia');
        thisClone.append('<span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>');
        elt.parent().parent().children('.locale-value')
            .prepend(thisClone); 
        elt.parent().parent().children('.locale-value').children(".input-group-btn").children(".btn").hide();
    }

    function successSameas(elt) {
        console.log("successSameas");
        $('.alert-success-update').show();
        elt.parent().parent().parent().children(".delete").children().attr("uri", elt.parent().parent().children(".value").text());
    }

    function successLiteral(elt) {
        console.log("successLiteral");
        $('.alert-success-update').show();
        elt.parent().parent().children(".hidden").text(elt.parent().parent().children(".value").text());
        elt.parent().children(".btn").addClass("disabled");
    }

    function setProperty(name, value, type, elt, successType, ui) {
        $.getJSON(top.location + '/' + name + '/' + value + '/' + type, null)
                .done(function (json) {
                    console.log(json);
                    if (json.success == true) {
                        console.log("OK");
                         switch(successType){
                            case "successLiteral" : successLiteral(elt);
                                break;
                            case "successSameas" : successSameas(elt);
                                break;
                            case "successEntityDBpedia" : successEntityDBpedia(elt, value);
                                break;
                            case "successEntityAutocompletion" : successEntityAutocompletion(elt, ui);
                                break;
                            case "successEntityAutocompletionSameas" : successEntityAutocompletionSameas(elt, ui);
                                break;
                         }
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

    function onKeyUp(elt){
        // Si la valeur initiale est différente de la valeur actuelle
        if(elt.parent().children(".value") != elt.parent().children(".hidden")){
            $(".btn-warning-name-" + elt.attr('name')).removeClass('disabled');
            $(".btn-success-name-" + elt.attr('name')).removeClass('disabled');
        }
    }

    function onClickCancel(elt, classUsed){
        if(!elt.hasClass('disabled')){
            var item = $(classUsed);
            // On remet dans 'value' sa valeur initiale (qui est dans 'hidden'
            item.children('.value').text(item.children('.hidden').text());
            elt.parent().children('.btn').addClass('disabled');
            $('.alert-success').hide();
        }
    }

    function onClickSuccess(elt, value, type, successType, name){
        if(!elt.hasClass('disabled')){
            value = encodeURIComponent(formatURI(value));
            setProperty(name, value, type, elt, successType);
        }
    }
    
    function makeSameasLigne(elt){
        // Création du content editable
        $('.new-LOD').append('<span></span>');
        $('.new-LOD span').attr('class', 'value value-edited searchSameas');
        $('.new-LOD span').attr('name', 'sameas');
        $('.new-LOD span').attr('style', "display: block; width: 100%; height: 100%;");
        $('.new-LOD span').attr('contenteditable', true);
        $('.new-LOD span').attr('autofocus', true);
        // autocomplétion
        $('.new-LOD span').catcomplete({
            source: function (request, response) {
                console.log("searchSameas");
                $.getJSON(global.searchUrlSameas, {needle: request.term}, response);
            },
            select: function (event, ui) {
                $(this).children('.value-edited').text('');
                elt = $(this);
                setProperty("sameas", encodeURIComponent(formatURI(ui.item.URI)), "uri", elt, "successEntityAutocompletionSameas", ui);

                return false;
            },
            delay: 600
        });
        // Création du bouton delete
        $('.new-LOD').append('<span class="hidden"></span>');
        $('.new-LOD .hidden').attr('style', 'display: none');
        
        // Ajout des boutons validation ou annulation
        // D'abord le div qui contient les deux boutons
        $('.new-LOD').append('<div></div>');
        $('.new-LOD div').attr('class', 'input-group-btn');
        $('.new-LOD div').attr('role', 'group');
        $('.new-LOD div').attr('style', 'position: relative; right: 0px;');
        // Le 1er bouton
        $('.new-LOD div').append('<button type="button" class="btn btn-warning btn-warning-sameas btn-warning-name-sameas disabled"></button>');
        $('.new-LOD div .btn-warning-sameas').attr('style', 'position: relative; right: 0px;');
        $('.new-LOD div .btn-warning-sameas').attr('name', 'sameas');
        $('.new-LOD div .btn-warning-sameas').append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
        // Le 2ieme bouton
        $('.new-LOD div').append('<button type="button" class="btn btn-success btn-success-sameas btn-success-name-sameas disabled"></button>');
        $('.new-LOD div .btn-success-sameas').attr('style', 'position: relative; right: 0px;');
        $('.new-LOD div .btn-success-sameas').attr('name', 'sameas');
        $('.new-LOD div .btn-success-sameas').append('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
        
        $('.new-LOD').addClass("sameasValue");
        $('.new-LOD').removeClass("new-LOD");
        
        // Remplacement du bouton ajouter par supprimer
        elt.attr('class', 'btn btn-danger btn-block btn-delete');
        elt.parent().attr("class", "delete");
        elt.text('Supprimer');
        //Ajout d'une nouvelle ligne : pour pouvoir ajouter un sameas
        $('.table-LOD').append("<tr><td class='new-LOD'></td><td><button class='btn btn-primary btn-addLOD'>Ajouter un lien LOD</button></td></tr>");
    }
    
    $(document).ready(function () {        
        // Bouton retour
        $(document).on('click', '.btn-retour', function () {
            $('.alert-success').hide();
        });
        
        /*
         * 
         * 
         * 
         * Sameas's JS
         * 
         * 
         * 
         */
        // On rend cliquable les boutons set ou cancel
        $(document).on('keyup', '.value-edited', function () {
            onKeyUp($(this));
        });
        // Pour annuler la saisie du literal
        $(document).on('click', '.btn-warning-sameas', function () {
            onClickCancel($(this), '.sameas.information-' + $(this).attr('name'));            
        });
        // Pour set un sameas
        $(document).on('click', '.btn-success-sameas', function () {
            var value = $(this).parent().parent().children('.value').text();            
            onClickSuccess($(this), value, "uri", "successSameas", $(this).attr('name'));
        });
        // Pour pouvoir rajouter une ligne sameas
        $(document).on('click', '.btn-addLOD', function () {
            $('.alert-success').hide();
            makeSameasLigne($(this));
        });
        // Supprimer un lien sameas
        $(document).on('click', '.btn-delete', function () {
            $('.alert-success').hide();
            removeProperty("sameas", encodeURIComponent(formatURI($(this).attr("uri"))), $(this));
        });
        // autocomplétion
        $('.searchSameas').catcomplete({
            source: function (request, response) {
                console.log("searchSameas");
                $.getJSON(global.searchUrlSameas, {needle: request.term}, response);
            },
            select: function (event, ui) {
                $(this).children('.value-edited').text('');
                elt = $(this);
                setProperty("sameas", encodeURIComponent(formatURI(ui.item.URI)), "uri", elt, "successEntityAutocompletionSameas", ui);

                return false;
            },
            delay: 600
        });
        
        /*
         * 
         * 
         * 
         * Property's JS
         * 
         * 
         * 
         */
        // click sur la 'croix' d'une entitÃ© -> delete de celle-ci
        $(document).on('click', '.entity-delete', function () {
            $(this).parent().children('.loadingDelete').show();
            //console.log()
            console.log($(this).parent().parent().attr('name'));
            console.log($(this).parent().children('.value').attr('name'));
            var value = encodeURIComponent(formatURI($(this).parent().children('.value').attr('name')));
            removeProperty($(this).parent().parent().attr('name'), value, $(this));
        });
        // click sur une entity DBpedia (set de celle-ci dans le local de la property)
        $(document).on('click', '.entity-dbpedia', function () {
            var parent = $(this).parent();
            parent.children('.loadingSet').show();
            setProperty(parent.attr('name'), 
                encodeURIComponent(formatURI($(this).attr('name'))), "uri", $(this), "successEntityDBpedia");
                      
        });
        // effet de style sur une entity en mouseover
        $(document).on('mouseover', '.entity', function () {
            var color  = $(this).css("background-color");
            $(this).css("background", "grey");
            $(this).bind("mouseout", function(){
                $(this).css("background-color", color);
            }) 
        });
        // Si literal on rend cliquable les boutons set ou cancel
        $(document).on('keyup', '.locale-value', function () {
            onKeyUp($(this));
        });
        // Pour annuler la saisie du literal
        $(document).on('click', '.btn-warning-locale', function () {
            onClickCancel($(this), '.locale-value.information-' + $(this).attr('name'));            
        });
        // Pour set une propriÃ©tÃ© litÃ©rale
        $(document).on('click', '.btn-success-locale', function () {
            var value = $(this).parent().parent().children('.value-edited').text();
            var successType = "successLiteral";
            var type = 'fr';
            onClickSuccess($(this), value, type, successType, $(this).attr('name'));
        }); 
        // autocomplétion
        $('.searchEntities').catcomplete({
            source: function (request, response) {
                $.getJSON(global.searchUrl, {needle: request.term}, response);
            },
            select: function (event, ui) {
                $(this).children('.value-edited').text('');
                elt = $(this);
                setProperty(elt.parent().attr('name'), encodeURIComponent(formatURI(ui.item.URI)), "uri", elt, "successEntityAutocompletion", ui);

                return false;
            },
            delay: 600
        });
        
        // Permet de reporter les valeurs de DBpedia dans local
        // TODO
        $(document).on('click', '.btn-success-selected', function () {
            var value = $(this).parent().children(".value").text();
            var name = $(this).parent().attr('name');
            var item = $('.locale-value.information-' + name);
            item.children(".value").text(value);
            $('.information-' + name + '.locale-value').children(".input-group-btn").children(".btn").removeClass('disabled');
            $('.alert-success').hide();
        });
        // Hide des alert-success
        $(document).on('click', '.locale-value', function () {
            $('.alert-success').hide();
        });
        $(document).on('click', '.nav-tabs', function () {
            $('.alert-success').hide();
        });
        
        
    });
</script>
@stop

@section('contenu')
<div class='pull-right ' id='entity-qrcode'>
    {!! QrCode::size(200)->generate(action('PublicController@anyEntity',['uid'=>Utils::formatURI($entity->URI)])) !!}
    <a href='{{action('Admin\AdminController@printQrCode',['uid'=>Utils::formatURI($entity->URI)])}}' class='btn btn-default center-block' target="_blank" >Imprimer le QRCode</a>
    <br />
    <a href="{{action('PublicController@anyEntity',['uid'=>Utils::formatURI($entity->URI)])}}" class="btn btn-default center-block" target="_blank">Voir l'oeuvre</a>
</div>
<h2 class="Entity-name" id="{{ $URIencode }}">@if($entity != null) {{ $entity->name }} @endif</h2>
<img src='{{$entity->image}}' class="center-block thumbnail entity-img" />


<div class="clearBoth">
    <ul class="nav nav-tabs nav-justified">
	<li class="active"><a data-toggle="tab" href="#informations">Informations</a></li>
	<li><a data-toggle="tab" href="#LODLink">Liens LoD</a></li>
	<li>
	    <a data-toggle="tab" href="#commentaires">
		Commentaires
		@if($nbCommentNotValidated>0)
		    ({{$nbCommentNotValidated}})
		@endif
	    </a>
	</li>
    </ul>
    <div class="tab-content">
	@include('admin.entityView.properties')
	@include('admin.entityView.LOD')
	@include('admin.entityView.comments')

    </div>
</div>
@stop
