@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/AXIS_MOM.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var hasChanged = false;
            var tempValue;
            $(document).on('blur', '.editableProp', function(){
                if(tempValue != $(this).text()){
                    var uid = $(this).attr('uid');
                    var value = $(this).text();
                    value = encodeURIComponent(formatURI(value));
                    var entityName = $('.Entity-name').attr('id');
                    setProperty('sameas', value, 'uri');
                }
                else
                    console.log('pas changé');
            });
            $(document).on('focus', '.editableProp', function(){
                tempValue = $(this).text();
                $('.alert-success').hide();
            });
            $(document).on('blur', '.locale-value', function(){
                if(tempValue != $(this).text()){
                    var value = $(this).text();
                    if(value.substring(0, 7) == 'http://'){
                        var type = 'uri';
                        console.log('value : ' + value);
                    }
                    else
                        var type = 'fr';
                    value = encodeURIComponent(formatURI(value));
                    setProperty($(this).attr('name'), value, type);
                }
                else
                    console.log('pas changé');
            });
            $(document).on('focus', '.locale-value', function(){
                tempValue = $(this).text();
                $('.alert-success').hide();
            });            
            $(document).on('click', '.btn-delete', function(){
                $('.alert-success').hide();
                if(confirm('Vraiment supprimer ce lien LOD ?')){
                    var uid = $(this).attr('uid');
                    var entityName = $('.Entity-name').attr('id');
                    $.getJSON('../delete/LOD/' + entityName + '/' + uid, null)
                        .done(function( json ) {
                            if(json[0] == true){
                                $('.alert-success-delete').show();
                            }
                            else{
                                console.log( "fail" );
                            }
                        })
                        .fail(function( jqxhr, textStatus, error ) {
                            var err = textStatus + ", " + error;
                            console.log( "Request Failed: " + err );
                        });
                }
            });
            
            $(document).on('click', '.btn-addLOD', function(){
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
            $(document).on('click', '.nav-tabs', function(){
                $('.alert-success').hide();
            });
            $('.selected').attr('style', 'background-color: rgb(100, 255, 104);');
        });
    </script>
@stop

@section('title')
    Administration AXIS-MOM
@stop

@section('contenu')
<h2 class="Entity-name" id="{{ $entity->URI }}">{{ $entity->name }}</h2>
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
                    <th>Local</th>
                    @foreach($retours as $retour)
                        @if($retour->value_dbpedia != null || $retour->entity_dbpedia != null)
                            <th>DBPedia</th>
                             @break; 
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($retours as $retour)
                    @if($retour->name != 'sameas')
                        <tr>
                            <td class="information-{{ $retour->name }}">{{ $retour->name }}  </td>
                            @if($retour->type == 'uri')
                            <td contenteditable="true" style="background-color: rgb(103, 145, 252)" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">{{ $retour->entity_locale->name }}</td>
                                @if($retour->entity_dbpedia != null)
                                    <td class="information-{{ $retour->name }}">{{ $retour->entity_dbpedia->name }}</td>
                                @endif
                            @else
                                <td contenteditable="true" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">{{ $retour->value_locale }}</td>
                                @if($retour->value_dbpedia != null)
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

@section('footer')

@stop
