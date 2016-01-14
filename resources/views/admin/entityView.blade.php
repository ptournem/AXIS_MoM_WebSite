@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style2.css') }}">
    <script type="text/javascript">
        $(document).ready(function(){
            var hasChanged = false;
            var tempValue;
            $('.editableProp').blur(function(){
                console.log('tempValue : ' + tempValue);
                console.log('lastValue : ' + $(this).text());
                if(tempValue != $(this).text()){
                    console.log('changé');
                    var uid = $(this).attr('uid');
                    var value = $(this).text();
                    $.getJSON('../update/LOD/' + uid + '/' + value, null)
                        .done(function( json ) {
                            if(json[0] == true){
                                console.log( "success" );
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
                    console.log('pas changé');
            });
            $('.editableProp').focus(function(){
                tempValue = $(this).text();
                $('.alert-success').hide();
            });
            $('.editableProp').keydown(function(){
                
                console.log('keypress');
            });
        });
    </script>
@stop

@section('title')
    Administration AXIS-MOM
@stop

@section('contenu')
<h2>{{ $itemName }}</h2>
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
    <div id="LODLink" class="tab-pane fade">
        <br />
        <div id='successMsg' class="alert alert-success alert-success-update" style="display: none">
            Mise à jour du champ effectué.
        </div>
        <table id="LOD" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>LOD</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entity as $entityItem)
                <tr>
                    <td><label class="editableProp" uid="{{$entityItem[2]}}"  contenteditable="true">{{ $entityItem[0] }}</label></td>
                    <td>
                        <form method="POST" action="{{ URL::to('admin/delete/LOD/' . $entityItem[2]) }}">
                            {!! csrf_field() !!}
                            <button class='btn btn-danger btn-block' onclick="return confirm(\'Vraiment supprimer cet utilisateur ?\')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-primary">Ajouter</button></td>
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
