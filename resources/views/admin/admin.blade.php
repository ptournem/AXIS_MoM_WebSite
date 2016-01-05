@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="css/style3.css">
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
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Rôle</th>
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
    <div id="entites" class="tab-pane fade">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterEntite">
          Ajouter une entité
        </button>
        <br /><br />
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Entite</th>
                    <th>Entite</th>
                    <th>Entite</th>
                    <th>Entite</th>
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






<!-- Modal membre -->
<div class="modal fade" id="ajouterMembre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
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
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
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

@stop

@section('footer')

@stop
