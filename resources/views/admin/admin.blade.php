@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style2.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/Admin/Admin.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function(){
            $('#button-filter-show-all').click(function(){
                $('#entities tbody tr').show();;
            });
            
            $('.button-filter-type').click(function(){
                var c = $(this).attr('data-class');
                $('#entities tbody tr').show();
                $('#entities tbody tr:not(.type-'+c+')').hide();
            }); 
        });
    </script>
@stop

@section('title')
    Administration AXIS-MOM
@stop

@section('contenu')
Bienvenue sur la page d'administration

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#membres">Gestion des membres</a></li>
    <li><a data-toggle="tab" href="#entites">Gestion des entités</a></li>
    <li><a data-toggle="tab" href="#commentaires">Gestion des commentaires</a></li>
    <li><a data-toggle="tab" href="#logs">Logs</a></li>
</ul>
<br />
<div class="tab-content">
    <div id="membres" class="tab-pane fade in active">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterMembre">
          Ajouter un membre
        </button>
        <br /><br />
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Liste des utilisateurs</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="text-primary"><strong>{!! $user->name !!}</strong></td>
                                <td>
                                    <a href="{{ URL::to('admin/users') }}" class="btn btn-mini btn-primary">Voir</a>
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/users') }}" class="btn btn-mini btn-primary">Modifier Mot de passe</a>
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/users') }}" class="btn btn-mini btn-primary">Modifier</a>
                                </td>
                                <td>
                                    <form action="{{ URL::to('admin/users') }}" method="POST">
                                        <button type="submit" class='btn btn-danger btn-block' onclick="return confirm(\'Vraiment supprimer cet utilisateur ?\')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
    </div>
    <div id="entites" class="tab-pane fade">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterEntite">
          Ajouter une entité
        </button>
        <a id="button-filter-show-all">Tout</a> | 
        <a data-class='Event' class='button-filter-type'>Event</a> | 
        <a data-class='Lieu' class='button-filter-type'>Lieu</a> | 
        <a data-class='Objet' class='button-filter-type' >Objet</a> | 
        <a data-class='Personne' class='button-filter-type'>Personne</a> | 
        <a data-class='Activite' class='button-filter-type'>Activité</a> | 
        <a data-class='Organisation' class='button-filter-type'>Organisation</a>
        <br /><br />
            <table id="entities" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entities as $entity)
                <tr class="type-{{ $entity['type']}}">
                    <td><a href="{{ URL::to('admin/view/' . $entity['id']) }}" style="display: block;width: 100%; height: 100%;">{{ $entity['name']}}</a></td>
                    <td>{{ $entity['type']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="commentaires" class="tab-pane fade">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Commentaire</th>
                    <th>Commentaire</th>
                    <th>Commentaire</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="logs" class="tab-pane fade">

            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Logs</th>
                    <th>Logs</th>
                    <th>Logs</th>
                    <th>Logs</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
                <tr>
                    <td>Roberts</td>
                    <td>Roger</td>
                    <td>roger.roberts904@gmail.com</td>
                    <td>Administrateur</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



nom
description
image (lien, input texte)
type


<!-- Modal membre -->
<div class="modal fade" id="ajouterMembre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Création utilisateur</h4>
      </div>
      <div class="modal-body">
          ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal entite -->
<div class="modal fade" id="ajouterEntite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{url('admin/addEntity')}}" method="POST">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Création entitées</h4>
            </div>
            <div class="modal-body">
                  {!! csrf_field() !!}
                  <select id="entity-type" name="entity-type" size="1">
                      <option value="Activite">Activité</option>
                      <option value="Event">Evénement</option>
                      <option value="Lieu">Lieu</option>
                      <option value="Organisation">Organisation</option>
                      <option value="Objet">Objet</option>
                      <option value="Personne">Personne</option>
                  </select><br/>
                  <label for="entity-name">Nom</label> : 
                  <input type="text" id="entity-name" name="entity-name" required="true"/><br/>
                  <label for="entity-description">Description</label> : 
                  <input type="text" id="entity-description" name="entity-description" required="true"/><br/>
                  <label for="entity-image">Lien vers images</label> : 
                  <input type="text" id="entity-image" name="entity-image"/>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
  </div>
</div>

@stop

@section('footer')

@stop
