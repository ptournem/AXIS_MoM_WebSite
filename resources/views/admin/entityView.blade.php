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
                var value = $(this).attr('name');
                console.log(value);
                if (value.length > 7 && value.substring(0, 7) == 'http://') {
                    var type = 'uri';
                    console.log('value : ' + value);
                }
                else
                    var type = 'fr';
                value = encodeURIComponent(formatURI(value));
                setProperty($(this).attr('name'), value, type, $(this));
            }
        });
        $(document).on('keyup', '.locale-value', function () {
            $(".btn-danger-name-" + $(this).attr('name')).removeClass('disabled');
            $(".btn-success-name-" + $(this).attr('name')).removeClass('disabled');
            $(".btn-success-name-" + $(this).attr('name')).attr('name', $(this).text());
        });
        $(document).on('click', '.btn-danger', function () {
            if(!$(this).hasClass('disabled')){
                $('.locale-value.information-' + $(this).parent().parent().attr('name')).text($(this).attr('name'));
                $(this).parent().children('.btn').addClass('disabled');
                $('.alert-success').hide();
            }
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
                    <th colspan="2">Local</th>
                    @if($dbpediaInfo)
                    <th>DBPedia</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($retours as $retour)
                    @if($retour->name != 'sameas')
                        <tr>
                        <td class="information-{{ $retour->name }}">{{ $retour->name }}  </td>
                        @if($retour->type == 'uri')
                            <td contenteditable="true" style="background-color: rgb(103, 145, 252)" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                                {{ $retour->entity_locale->name }}
                            </td>
                            <td style="background-color: rgb(103, 145, 252)" name="{{ $retour->name }}" class="information-{{ $retour->name }}">
                                <div class="input-group-btn" role="group">
                                    <button type="button" name="{{ $retour->entity_locale->name }}" class="btn btn-danger btn-danger-name-{{ $retour->name }} disabled">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" name="{{ $retour->entity_locale->name }}" class="btn btn-success btn-success-name-{{ $retour->name }}  disabled">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </td>
                            @if($dbpediaInfo)
                                <td class="information-{{ $retour->name }}" style="background-color: rgb(103, 145, 252)">{{ $retour->entity_dbpedia->name }}</td>
                            @endif                                
                        @else
                            <td contenteditable="true" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                                {{ $retour->value_locale }}
                            </td>
                            <td name="{{ $retour->name }}" class="information-{{ $retour->name }}">
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
                                <td class="information-{{ $retour->name }}">{{ $retour->value_dbpedia }}</td>
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
