<div id="membres" class="tab-pane fade">
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
			<a href="{{ URL::to('admin/users/' . $user->id) }}" class="btn btn-mini btn-primary">Voir</a>
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
