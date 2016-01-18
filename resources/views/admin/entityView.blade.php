@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style2.css') }}">
    <script type="text/javascript">
        $(document).ready(function(){
            var hasChanged = false;
            var tempValue;
            $(document).on('blur', '.editableProp', function(){
                if(tempValue != $(this).text()){
                    var uid = $(this).attr('uid');
                    var value = $(this).text();
                    var entityName = $('.Entity-name').attr('id');
                    $.getJSON('../update/LOD/' + entityName + '/' + uid + '/' + value, null)
                        .done(function( json ) {
                            if(json[0] == true){
                                $('.alert-success-update').show();
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
                else
                    console.log('pas changÃ©');
            });
            $(document).on('focus', '.editableProp', function(){
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
<h2 class="Entity-name" id="{{ $EntityID }}">{{ $itemName }}</h2>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#informations">Informations</a></li>
    <li><a data-toggle="tab" href="#LODLink">Liens LoD</a></li>
    <li><a data-toggle="tab" href="#commentaires">Commentaires</a></li>
</ul>
<div class="tab-content">
    <div id="informations" class="tab-pane fade in active">
        <br />
        <table id="entity-information" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Informations</th>
                    <th>Local</th>
                    @foreach ($LODs as $LOD)
                        <th>{{ $LOD[0] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for ($i = 0 ; $i < count($entity) ; $i++)
                    <tr>
                        <td class="information-{{$i}}">{{ $entity[$i][0] }}</td>
                        <td @if($entity[$i][2])class="selected information-{{$i}}" @else class="information-{{$i}}" @endif >{{ $entity[$i][1] }}</td>
                        @foreach ($LODs as $LOD)
                            <td @if($LOD[3][$i])class="selected information-{{$i}}" @else class="information-{{$i}}" @endif >{{ $LOD[2][$i] }}</td>
                        @endforeach
                    </tr>
                @endfor
            </tbody>
        </table>
        <table id="entity-information" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Informations</th>
                    <th>Local</th>
                </tr>
            </thead>
            <tbody>
                @foreach($retours as $retour)
                    <tr>
                        <td class="information-{{ $retour->name }}">@if($retour->type == 'uri'){{ $retour->ent->name }} @else {{ $retour->name }} @endif</td>
                        <td class="information-{{ $retour->name }}">{{ $retour->value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="LODLink" class="tab-pane fade">
        <br />
        <div id='successMsg-update' class="alert alert-success alert-success-update" style="display: none">
            Mise Ã  jour du champ effectuÃ©.
        </div>
        <div id='successMsg-delete' class="alert alert-success alert-success-delete" style="display: none">
            LOD supprimÃ©.
        </div>
        <table id="LOD" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>LOD</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-LOD">
                @foreach ($LODs as $LOD)
                <tr>
                    <td><label class="editableProp" uid="{{$LOD[1]}}" style="display: block; width: 100%; height: 100%; background-color: rgb(235,235,235);"  contenteditable="true">{{ $LOD[0] }}</label></td>
                    <td>
                        <button class='btn btn-danger btn-block btn-delete' uid="{{$LOD[1]}}">
                            Supprimer
                        </button>
                    </td>
                </tr>
                @endforeach
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
                @foreach ($entity as $entityItem)
                <tr>
                    <td>{{ $entityItem[0] }}</td>
                    <td>{{ $entityItem[1] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('footer')

@stop
