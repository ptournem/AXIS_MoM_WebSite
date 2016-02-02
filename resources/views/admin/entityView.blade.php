@extends('admin/template')

@section('header')
<script type="text/javascript">
    function successEntityAutocompletion(elt, ui) {
        console.log("successEntityAutocompletion");
        $('.alert-success-update').show();
        $("<span class='entity' name='" + ui.item.name + "' style='background-color: pink; padding: 2px; margin: 2px;'></span>").insertBefore(elt.children(".value-edited"));
        elt.children(".entity[name='" + ui.item.name + "']").append('<span name="' + ui.item.URI + '" class="value">' + ui.item.name + '</span>');
        elt.children(".entity[name='" + ui.item.name + "']")
                .append('<span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>');
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
            .append(thisClone); 
    }

    function successSameas(elt) {
        console.log("successSameas");
        //TODO
    }

    function successLiteral(elt) {
        console.log("successLiteral");
        //TODO
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

    function onKeyUp(name){
        var parent = $(".information-" + name + ".sameasValue");
        // Si la valeur initiale est diffÃ©rente de la valeur actuelle
        if(parent.children(".value") != parent.children(".hidden")){
            $(".btn-danger-name-" + name).removeClass('disabled');
            $(".btn-success-name-" + name).removeClass('disabled');
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
    
    function makeSameasLigne(){
        $('.alert-success').hide();
        // Création du content editable
        $('.new-LOD').append('<span></span>');
        $('.new-LOD label').attr('class', 'value value-edited');
        $('.new-LOD label').attr('style', "display: block; width: 100%; height: 100%;");
        $('.new-LOD label').attr('contenteditable', true);
        $('.new-LOD label').attr('autofocus', true);
        // Création du bouton delete
        $('.new-LOD').append('<span class="hidden"></span>');
        $('.new-LOD .hidden').attr('style', 'display: none');
        
        $('.new-LOD').addClass("sameasValue");
        $('.new-LOD').removeClass("new-LOD");
        
        // Remplacement du bouton ajouter par supprimer
        $(this).attr('class', 'btn btn-danger btn-block btn-delete');
        $(this).text('Supprimer');
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
        $(document).on('keyup', '.sameasValue', function () {
            onKeyup($(this).attr('name'));
        });
        // Pour annuler la saisie du literal
        $(document).on('click', '.btn-warning-sameas', function () {
            onClickCancel($(this), '.sameas.information-' + $(this).attr('name'));            
        });
        // Pour set une sameas
        $(document).on('click', '.btn-success-sameas', function () {
            var value = $(this).parent().parent().children('.value').text();            
            onClickSuccess($(this), value, "uri", "successSameas", $(this).attr('name'));
        });
        // Pour pouvoir rajouter une ligne sameas
        $(document).on('click', '.btn-addLOD', function () {
            $('.alert-success').hide();
            makeSameasLigne();
        });
        // Supprimer un lien sameas
        $(document).on('click', '.btn-delete', function () {
            $('.alert-success').hide();
            if (confirm('Vraiment supprimer ce lien LOD ?')) {
                var uid = $(this).attr('uid');
                var entityName = $('.Entity-name').attr('id');
                $.getJSON('../delete/LOD/' + entityName + '/' + uid, null)
                        .done(function (json) {
                            if (json[0] == true) {
                                $('.alert-success-delete').show();
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
            removeProperty($(this).parent().parent().attr('name'), $(this).attr('name'), $(this));
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
            onKeyup($(this).attr('name'));
        });
        // Pour annuler la saisie du literal
        $(document).on('click', '.btn-warning-locale', function () {
            onClickCancel($(this), '.locale-value.information-' + $(this).attr('name'));            
        });
        // Pour set une propriÃ©tÃ© litÃ©rale
        $(document).on('click', '.btn-success-locale', function () {
            var value = $(this).parent().parent().children('.value').text();
            if (value.length > 7 && value.substring(0, 7) == 'http://') {
                var successType = "successEntityAutocompletion";
                var type = 'uri';
            }
            else{
                var successType = "successLiteral";
                var type = 'fr';
            }
            
            onClickSuccess($(this), value, type, successType, $(this).attr('name'));
        }); 
        
        // Permet de reporter les valeurs de DBpedia dans local
        // TODO
        $(document).on('click', '.btn-success-selected', function () {
            var value = $(this).parent().children(".value").text();
            console.log(value);
            var name = $(this).parent().attr('name');
            var item = $('.locale-value.information-' + name);
            item.children(".value").text(value);
            $('.locale-btn.information-' + name).children().children(".btn").removeClass('disabled');
            $('.alert-success').hide();
        });
        // Hide des alert-success
        $(document).on('click', '.locale-value', function () {
            $('.alert-success').hide();
        });
        $(document).on('click', '.nav-tabs', function () {
            $('.alert-success').hide();
        });
        
        $('#searchEntities').catcomplete({
            source: function (request, response) {
                $.getJSON(global.searchUrl, {needle: request.term}, response);
            },
            select: function (event, ui) {
                $(this).children('.value-edited').text('');
                elt = $(this);
                console.log(formatURI($(".Entity-name").attr('id')));
                $.getJSON(top.location + '/' + $(this).attr('name') + '/' + encodeURIComponent(formatURI($(".Entity-name").attr('id'))) + '/' + "uri", null)
                .done(function (json) {
                    console.log(json);
                    if (json.success == true) {
                        console.log("OK");

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

                return false;
            },
            delay: 600
        });
    });
</script>
@stop

@section('contenu')
<h2 class="Entity-name" id="{{ $URIencode }}">@if($entity != null) {{ $entity->name }} @endif</h2>
<button class='btn btn-default btn-retour'>
    <a href="{{url('admin')}}">Retour</a>
</button>

{!! QrCode::size(100)->generate(URL::to('public/entity/' . $URIencode)); !!}
<ul class="nav nav-tabs">
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
@stop
