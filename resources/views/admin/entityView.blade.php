@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style2.css') }}">
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
        <div id="entites">
            <br /><br />
                <table id="entities" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
    <div id="LODLink" class="tab-pane fade">
        lod link
    </div>
    <div id="commentaires" class="tab-pane fade">
        commentaires
    </div>
</div>
@stop

@section('footer')

@stop
