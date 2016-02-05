<div id="membres" class="tab-pane fade">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterMembre">
	Ajouter un membre
    </button>
    <div class="alert" id='userAlert' role="alert" style="display:none; margin-top : 15px; margin-bottom:-15px;"></div>
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
			<a href="{{ action('UserController@getShow' , array('id'=> $user->id)) }}" class="btn btn-mini btn-primary">Voir</a>
		    </td>
		    <td>
			<button data-id='{{$user->id}}' type="button" class='btn btn-danger btn-block delUser'>
			    Supprimer
			</button>
		    </td>
		</tr>
		@endforeach
	    </tbody>
	</table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
	$('.delUser').on('click',function(){
	    if(confirm('Supprimer cet utilisateur ?')){
		$.post("{{route('user.delete')}}",{id: $(this).attr('data-id'),'_token':'{{csrf_token()}}'},function(data){
			if(data.result){
			    $('#userAlert.alert').removeClass('alert-danger').addClass('alert-success').text('Utilisateur supprimé avec succès ! Raffraichissez la page pour l\'afficher.');
			}else {
			    $('#userAlert.alert').removeClass('alert-success').addClass('alert-danger').text('Erreur lors de la suppression, ré-essayer plus tard.');
			}
			$('#userAlert.alert').fadeIn(1000).delay(2500).fadeOut(1000)
		},'json');
	    }
	});
    });
</script>
