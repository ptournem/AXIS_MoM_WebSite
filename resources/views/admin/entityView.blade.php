@extends('admin/template')

@section('header')
<link rel="stylesheet" href="{{ URL::asset('css/datepicker.css') }}">
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/locales/bootstrap-datepicker.fr.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery-dateFormat.min.js') }}"></script>
<script type="text/javascript">
    
    
    $(document).ready(function () {  
        var adminDeleteLiteral = "{{route('admin.deleteLiteral')}}";
        var adminDeleteEntityProperty = "{{route('admin.deleteEntityProperty')}}";
        var adminDeleteEntity = "{{route('admin.deleteEntity')}}";
        var adminSetProperty = "{{route('admin.setProperty')}}";
        var adminGetIndex = "{{route('admin.getIndex')}}";
        var token = "{{csrf_token()}}";
        var EntityUri = "{{$entity->URI}}";
        
        function successEntityAutocompletion(elt, ui, name) {
            console.log("successEntityAutocompletion");
            $('.alert-success-update').show();
            elt.text("");
            elt.parent().children(".input-group-btn").children(".btn").hide();
            var inputGroup = $("<div class='input-group'></div>");
            inputGroup.insertBefore(elt.parent().children(".value-edited"));
            inputGroup.append($('<span name="' + ui.item.URI + '" class="entity btn btn-default form-control disabled value">' + ui.item.name + '</span>').insertBefore(elt.parent().children(".value-edited")));
            
            var inputGroupBtn = $("<div class='input-group-btn'></div>");
            inputGroup.append(inputGroupBtn);
            
            var entityDelete = $('<span name="' + name + '" class="btn btn-danger entity-delete"></span>');
            inputGroupBtn.append(entityDelete);
            
            entityDelete.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
        }

        function successEntityAutocompletionSameas(elt, ui) {
            console.log("successEntityAutocompletionSameas");        
            $('.alert-success-update').show();
            console.log(elt.parent().children(".input-group-btn"));
            elt.parent().children(".input-group-btn").children(".btn").hide();
            $("<span class='entity btn btn-default center-block' target='_blank' style='background-color: rgb(34, 238, 70);'>"
                    + "<span name='" + ui.item.URI + "' class='value'>" + ui.item.name + "</span></span>").insertBefore(elt.parent().children(".value-edited"));
            elt.parent().children(".entity[name='" + ui.item.name + "']").append('<span name="' + ui.item.URI + '" class="value">' + ui.item.name + '</span>');
            elt.remove();
                                
                            
        }

        function successEntityDBpedia(elt, value) {
            console.log("successEntityDBpedia");
            $('.locale-value.information-' + elt.parent().parent().attr('name')).children(".hidden").text(decodeURIComponent(unformatURI(value)));
            $('.alert-success-update').show();
            var thisClone = elt.clone().css('background-color', 'rgb( 34, 238, 70)')
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
            elt.parent().parent().parent().children(".hidden").text(elt.parent().parent().children(".value").text());
            elt.parent().children(".btn").addClass("disabled");
        }

        function successDate(elt) {
            console.log("successDate");
            $('.alert-success-update').show();
        }

        function setProperty(name, value, type, elt, successType, ui) {
            $.post(adminSetProperty, {uri: EntityUri, name: name, value: value, type: type, _token: token}, function (data) {
                    if (data.success) {
                        console.log("OK");
                        switch(successType){
                           case "successLiteral" : successLiteral(elt);
                               break;
                           case "successSameas" : successSameas(elt);
                               break;
                           case "successEntityDBpedia" : successEntityDBpedia(elt, value);
                               break;
                           case "successEntityAutocompletion" : successEntityAutocompletion(elt, ui, name);
                               break;
                           case "successEntityAutocompletionSameas" : successEntityAutocompletionSameas(elt, ui);
                               break;
                           case "successDate" : successDate(elt);
                               break;
                        }
                    }
                    elt.parent().children('.loadingSet').hide();
                }, 'json');
        }

        function removeEntityProperty(name, uriB, elt) {
            console.log("adminDeleteEntityProperty : " + adminDeleteEntityProperty);
            $.post(adminDeleteEntityProperty, {uri: EntityUri, name: name, uriB: uriB, _token: token}, function (data) {
                    if (data.success) {
                        elt.parent().parent().remove();
                    }
                }, 'json');
        }
        
        function removeLiteralProperty(name, value, type, elt, successType) {
            $.post(adminDeleteLiteral, {uri: EntityUri, name: name, _token: token}, function (data) {
                    if (data.success) {
                        // changement des classes
                        console.log("removeL OK");
                        setProperty(name, value, type, elt, successType);
                    }
                }, 'json');
        }
        
        function removeEntity(name, value, type, elt, successType) {
            $.post(adminDeleteLiteral, {uri: EntityUri, name: name, _token: token}, function (data) {
                    if (data.success) {
                        // changement des classes
                        console.log("removeL OK");
                        setProperty(name, value, type, elt, successType);
                    }
                }, 'json');
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
                // On remet dans 'value' sa valeur initiale (qui est dans 'hidden')
                item.children('.input-group').children('.value').text(item.children('.hidden').text());
                elt.parent().children('.btn').addClass('disabled');
                $('.alert-success').hide();
            }
        }

        function onClickSuccess(elt, value, type, successType, name){
            if(!elt.hasClass('disabled')){
                removeLiteralProperty(name, value, type, elt, successType);
            }
        }

        function makeSameasLigne(elt){
            // Création du content editable
	    var $newLod = $('.new-LOD');
	    
	    var $div =  $('<div></div>');
	    $newLod.append($div);
	    $div.addClass('input-group');
            var $span = $('<span></span>');
	    $div.append($span);
            $span.attr('class', 'value value-edited searchSameas form-control');
            $span.attr('name', 'sameas');
            $span.attr('contenteditable', true);
            // autocomplétion
            $span.catcomplete({
                source: function (request, response) {
                    console.log("searchSameas");
                    $.getJSON(global.searchUrlSameas, {needle: request.term}, response);
                },
                select: function (event, ui) {
                    $(this).children('.value-edited').text('');
                    elt = $(this);
                    setProperty("sameas", ui.item.URI, "uri", elt, "successEntityAutocompletionSameas", ui);

                    return false;
                },
                delay: 600
            });
            // Création du bouton delete
            var $hidden = $('<span class="hidden"></span>');
	    $div.append($hidden);
            $hidden.attr('style', 'display: none');

            // Ajout des boutons validation ou annulation
            // D'abord le div qui contient les deux boutons
            var $inputBtn = $('<div></div>');
	    $div.append($inputBtn);
            $inputBtn.attr('class', 'input-group-btn');
            $inputBtn.attr('role', 'group');
            $inputBtn.attr('style', 'position: relative; right: 0px;');
            // Le 1er bouton :	Annuler
            var $annulerBtn = $('<button type="button" class="btn btn-warning btn-warning-sameas btn-warning-name-sameas disabled"></button>');
	    $inputBtn.append($annulerBtn);
            $annulerBtn.attr('style', 'position: relative; right: 0px;');
            $annulerBtn.attr('name', 'sameas');
            $annulerBtn.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
	    
            // Le 2ieme bouton : Valider 
            var $validerBtn = $('<button type="button" class="btn btn-success btn-success-sameas btn-success-name-sameas disabled"></button>');
	    $inputBtn.append($validerBtn);
            $validerBtn.attr('style', 'position: relative; right: 0px;');
            $validerBtn.attr('name', 'sameas');
            $validerBtn.append('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');

            $newLod.addClass("sameasValue");
            $newLod.removeClass("new-LOD");

            // Remplacement du bouton ajouter par supprimer
            elt.attr('class', 'btn btn-danger btn-block btn-delete');
            elt.parent().attr("class", "delete");
            elt.text('Supprimer');
            //Ajout d'une nouvelle ligne : pour pouvoir ajouter un sameas
            $('.table-LOD').append("<tr><td class='new-LOD'></td><td><button class='btn btn-primary btn-addLOD'>Ajouter un lien LOD</button></td></tr>");
        }
            
    
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
            removeEntityProperty("sameas", $(this).attr("uri"), $(this).parent());
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
                setProperty("sameas", ui.item.URI, "uri", elt, "successEntityAutocompletionSameas", ui);

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
            var value = $(this).parent().parent().children('.value').attr('name');
            removeEntityProperty($(this).attr('name'), value, $(this));
        });
        // click sur une entity DBpedia (set de celle-ci dans le local de la property)
        $(document).on('click', '.entity-dbpedia', function () {
            var parent = $(this).parent();
            parent.children('.loadingSet').show();
            setProperty(parent.attr('name'), 
                $(this).attr('name'), "uri", $(this), "successEntityDBpedia");
                      
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
                var elt = $(this);
                setProperty(elt.attr('name'), ui.item.URI, "uri", elt, "successEntityAutocompletion", ui);

                return false;
            },
            delay: 600
        });
        // Supprime l'entity
        $(document).on('click', '.btn-delete-entity', function () {
            $.post(adminDeleteEntity, {uri: EntityUri, _token: token}, function (data) {
                    if (data.success) {
                        // changement des classes
                        console.log("remove Entity OK");
                        window.location = adminGetIndex;
                    }
                    else{
                        
                    }
                        
                }, 'json');
        });
        // Permet de reporter les valeurs de DBpedia dans local
        $(document).on('click', '.btn-success-selected', function () {
            var value = $(this).parent().children(".value").text();
            var name = $(this).parent().attr('name');
            var item = $('.locale-value.information-' + name);
            console.log(item);
            console.log(value);
            console.log(name);
            console.log(item.children().children(".form-control"));
            if($(this).hasClass("typeDate")){
                item.children().children(".form-control").val(value);
                onClickSuccess($(this), value, 'fr', "successDate", name);
            }
            else{
                item.children(".value").text(value);
                $('.information-' + name + '.locale-value').children(".input-group-btn").children(".btn").removeClass('disabled');
                $('.alert-success').hide();
            }
        });
        // Hide des alert-success
        $(document).on('click', '.locale-value', function () {
            $('.alert-success').hide();
        });
        $(document).on('click', '.nav-tabs', function () {
            $('.alert-success').hide();
        });
        
        $('.date').datepicker({
            autoclose: true,
            dateFormat: 'yyyy-mm-dd',
            language: 'fr'
        });
        $('.date').datepicker()
            .on("changeDate", function(e) {
            onClickSuccess($(this), $.format.date(e.date, "yyyy-MM-dd"), 'fr', "successDate", $(this).attr("name"));
        });
    });
</script>
@stop

@section('contenu')
<div class='pull-right ' id='entity-qrcode'>
    {!! QrCode::size(200)->generate(action('PublicController@anyEntity',['uid'=>Utils::formatURI($entity->URI)])) !!}
    <a href='{{action('Admin\AdminController@getPrintQrCode',['uid'=>Utils::formatURI($entity->URI)])}}' class='btn btn-default center-block' target="_blank" >Imprimer le QRCode</a>
    <br />
    <a href="{{action('PublicController@anyEntity',['uid'=>Utils::formatURI($entity->URI)])}}" class="btn btn-default center-block" target="_blank">Voir l'oeuvre</a>
    <br />
    <span name="{{action('Admin\AdminController@postDeleteEntity',['uri'=>$entity->URI])}}" class="btn btn-danger btn-delete-entity center-block" target="_blank">Supprimer l'oeuvre</span>
</div>
<h2 class="Entity-name" id="{{ $URIencode }}">@if($entity != null) {{ $entity->name }} @endif</h2>
<img src='{{$entity->image}}' class="center-block thumbnail entity-img" />


<div class="clearBoth">
    <ul id='admin-nav-tabs' class="nav nav-tabs nav-justified">
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
