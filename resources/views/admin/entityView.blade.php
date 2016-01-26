@extends('admin/template')

@section('header')
<script type="text/javascript">
    $(document).ready(function () {
        var hasChanged = false;
        $(document).on('click', '.btn-succedss', function () {
            if (tempValue != $(this).text()) {
                var uid = $(this).attr('uid');
                var value = $(this).text();
                value = encodeURIComponent(formatURI(value));
                var entityName = $('.Entity-name').attr('id');
                setProperty('sameas', value, 'uri');
            }
            else
                console.log('pas changé');
        });
        $(document).on('blur', '.editableProp', function () {
            if (tempValue != $(this).text()) {
                $(".btn-danger-name-" + $(this).attr('propertyName')).removeClass('disable');
            }
            else
                console.log('pas changé');
        });
        $(document).on('focus', '.editableProp', function () {
            tempValue = $(this).text();
            $('.alert-success').hide();
        });
        
        $(document).on('click', '.btn-success', function () {
            if(!$(this).hasClass('disabled')){
                var value = $('.locale-value.information-' + $(this).parent().parent().attr('name')).children('.value').text();
                console.log(value);
                if (value.length > 7 && value.substring(0, 7) == 'http://') {
                    var type = 'uri';
                    console.log('value : ' + value);
                }
                else
                    var type = 'fr';
                value = encodeURIComponent(formatURI(value));
                console.log($(this).parent().parent().attr('name'));
                console.log($('.locale-value.information-' + $(this).parent().parent().attr('name')).children(".hidden"));
                setProperty($(this).attr('name'), value, type, $(this));
            }
        });
        $(document).on('click', '.entity-delete', function () {
            $(this).parent().children('.loadingDelete').show();
            removeProperty($(this).parent().parent().attr('name'), $(this).attr('name'), $(this));
        });
        $(document).on('click', '.entity-dbpedia', function () {
            $(this).parent().children('.loadingSet').show();
            setProperty($(this).parent().attr('name'), encodeURIComponent(formatURI($(this).attr('name'))), "uri", $(this));
                      
        });
        $(document).on('mouseover', '.entity', function () {
            var color  = $(this).css("background-color");

            $(this).css("background", "grey");

            $(this).bind("mouseout", function(){
                $(this).css("background-color", color);
            }) 
        });
        $(document).on('keyup', '.locale-value', function () {
            $(".btn-danger-name-" + $(this).attr('name')).removeClass('disabled');
            $(".btn-success-name-" + $(this).attr('name')).removeClass('disabled');
            $(".btn-success-name-" + $(this).attr('name')).attr('name', $(this).text());
        });
        $(document).on('click', '.btn-danger', function () {
            if(!$(this).hasClass('disabled')){
                var item = $('.locale-value.information-' + $(this).parent().parent().attr('name'));
                item.children('.value').text(item.children('.hidden').text());
                $(this).parent().children('.btn').addClass('disabled');
                $('.alert-success').hide();
            }
        });
        $(document).on('click', '.btn-success-selected', function () {
            var value = $(this).parent().children(".value").text();
            console.log(value);
            var name = $(this).parent().attr('name');
            var item = $('.locale-value.information-' + name);
            item.children(".value").text(value);
            $('.locale-btn.information-' + name).children().children(".btn").removeClass('disabled');
            $('.alert-success').hide();
        });
        $(document).on('click', '.locale-value', function () {
            $('.alert-success').hide();
        });
       
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

        $(document).on('click', '.btn-addLOD', function () {
            $('.alert-success').hide();
            $('.new-LOD').append('<label></label>');
            $('.new-LOD label').attr('class', 'editableProp');
            $('.new-LOD label').attr('uid', 7);
            $('.new-LOD label').attr('style', "display: block; width: 100%; height: 100%; background-color: rgb(235,235,235);");
            $('.new-LOD label').attr('contenteditable', true);
            $('.new-LOD label').attr('autofocus', true);
            $('.new-LOD').removeClass();
            $(this).attr('class', 'btn btn-danger btn-block btn-delete');
            $(this).attr('uid', 7);
            $(this).text('Supprimer');
            $('.table-LOD').append("<tr><td class='new-LOD'></td><td><button class='btn btn-primary btn-addLOD'>Ajouter un lien LOD</button></td></tr>");
            $('.editableProp[uid=7]').get(0).focus();
        });
        $(document).on('click', '.nav-tabs', function () {
            $('.alert-success').hide();
        });
        $('.selected').attr('style', 'background-color: rgb(100, 255, 104);');
    });
</script>
@stop

@section('contenu')
<h2 class="Entity-name" id="{{ $URIencode }}">{{ $entity->name }}</h2>
{!! QrCode::size(100)->generate(URL::to('public/entity/' . $URIencode)); !!}
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#informations">Informations</a></li>
    <li><a data-toggle="tab" href="#LODLink">Liens LoD</a></li>
    <li><a data-toggle="tab" href="#commentaires">Commentaires</a></li>
</ul>
<div class="tab-content">
    <div id="informations" class="tab-pane fade in active">
        <br />
        <div id='successMsg-update' class="alert alert-success alert-success-update" style="display: none">
            Mise à  jour du champ effectué.
        </div>
        <table id="entity-information" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Informations</th>
                    <th width="35%">Local</th>
                    @if($dbpediaInfo)
                    <th>DBPedia</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($retours as $retour)
                    @if($retour->name != 'sameas')
                        <tr>
                        <td class="information-{{ $retour->name }}">{{ $retour->name }}</td>
                        @if($retour->type == 'uri')
                            <td name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                                @if(is_array($retour->entity_locale))
                                    @foreach($retour->entity_locale as $entity)
                                    <span class="entity" style="background-color: pink; padding: 2px; margin: 2px;">
                                        <span class="value">{{ $entity->URI }}</span>
                                        <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                                    </span>
                                    @endforeach
                                @else
                                    <span class="entity" style="background-color: pink; padding: 2px; margin: 2px;">
                                        <span name="{{ $retour->entity_locale->URI }}" class="value">{{ $retour->entity_locale->name }}</span>
                                        <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                                    </span>
                                @endif
                                <img class="loadingDelete" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                            </td>
                            @if($dbpediaInfo)
                                <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                                    <button type="button" name="{{ $entity->name }}" 
                                            class="btn btn-success-selected btn-success-selected-{{ $retour->name }}">
                                        <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                                    </button>
                                    @if(is_array($retour->entity_dbpedia))
                                        @foreach($retour->entity_dbpedia as $entity)
                                        <span class="entity entity-dbpedia" name="{{ $entity->URI }}" style="background-color: pink; padding: 2px; margin: 2px;">
                                            <span name="{{ $entity->URI }}" class="value">{{ $entity->name }}</span>
                                        </span>
                                        @endforeach    
                                    @else
                                        <span class="entity entity-dbpedia" style="background-color: pink; padding: 2px; margin: 2px;">
                                            <span name="{{ $retour->entity_dbpedia->URI }}" class="value">{{ $retour->entity_dbpedia->name }}</span>
                                        </span>
                                    @endif
                                    <img class="loadingSet" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                                </td>
                            @endif                                
                        @else
                            <td contenteditable="true" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                                <span class="value">{{ $retour->value_locale }}</span>
                                <span class="hidden" style="display: none">{{ $retour->value_locale }}</span>
                                <div class="input-group-btn" role="group">
                                    <button type="button" name="{{ $retour->value_locale }}" class="btn btn-danger btn-danger-name-{{ $retour->name }} disabled">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" name="{{ $retour->value_locale }}" class="btn btn-success btn-success-name-{{ $retour->name }}  disabled">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </td>
                            @if($dbpediaInfo)
                                <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                                    <button type="button" name="{{ $retour->value_locale }}" class="btn btn-success-selected btn-success-selected-{{ $retour->name }}">
                                        <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                                    </button>
                                    <span class="value">{{ $retour->value_dbpedia }}</span>
                                </td>
                            @endif
                        @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="LODLink" class="tab-pane fade">
        <br />
        <div id='successMsg-update' class="alert alert-success alert-success-update" style="display: none">
            Mise à  jour du champ effectué.
        </div>
        <div id='successMsg-delete' class="alert alert-success alert-success-delete" style="display: none">
            LOD supprimé.
        </div>
        <table id="LOD" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>LOD</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-LOD">
                <tr>
                    <td>
                        @foreach($dbpedia as $retour)
                        <label class="editableProp" uid="3" style="display: block; width: 100%; height: 100%; background-color: rgb(180,180,180);"  contenteditable="true">$retour-></label>
                        @endforeach
                    </td>
                    <td>
                        <button class='btn btn-danger btn-block btn-delete' uid="3">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="new-LOD"></td>
                    <td><button class="btn btn-primary btn-addLOD">Ajouter un lien LOD</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="commentaires" class="tab-pane fade">
        <br />
        <table id="comments" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>lala</td>
                    <td>blabla</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
