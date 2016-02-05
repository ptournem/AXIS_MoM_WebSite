<!-- Modal membre -->
<div class="modal fade" id="ajouterMembre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Création utilisateur</h4>
	    </div>
	    <div class="modal-body">
		<div class="alert" role="alert" style="display:none;"></div>
		<form role="form" method="POST" action="#">
		    {!! csrf_field() !!}
		    <div class="form-group">
			<label class=" control-label">Nom d'utilisateur</label>
		        <input type="email" class="form-control" name="name" value="{{ old('name') }}">
			<p id="ajouterMembreModalError-name" class="text-danger" style="display:none;"></p>
		    </div>
		    
		    <div class="form-group">
			<label class="control-label">Adresse email</label>
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
			<p id="ajouterMembreModalError-email" class="text-danger" style="display:none;"></p>
		    </div>

		    <div class="form-group">
			<label class="control-label">Mot de passe</label>
			<input type="password" class="form-control" name="password">
			<p id="ajouterMembreModalError-password" class="text-danger" style="display:none;"></p>
		    </div>
		    <div class="form-group">
			<label class="control-label">Confirmation du mot de passe</label>
			<input type="password" class="form-control" name="password_confirmation">
			<p id="ajouterMembreModalError-password_confirmation" class="text-danger" style="display:none;"></p>
		    </div>

		    <div class="form-group">    
			<label>
			    <input type="checkbox" name="admin" value='1' checked="{{old('admin')}}"> Administrateur
			</label>
		    </div>
		</form>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id='saveUser'>Save changes</button>
	    </div>
	</div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
	$('#ajouterMembre #saveUser').click(function(){
	    var data = $('#ajouterMembre form').serialize();
	    $.post("{{route('user.add')}}",data,function(data){
		if(data.result){
		    resetForm();
		    $('#ajouterMembre .alert').removeClass('alert-danger').addClass('alert-success').text('Utilisateur ajouté avec succès ! Raffraichissez la page pour l\'afficher.').show('fade').delay(1500).hide(function(){
			$('#ajouterMembre').modal('hide')
		    });

		}else {
		    resetForm();
		    $('#ajouterMembre form p').hide();
		    $.each(data.require,function(key,msg){
			console.log(key);
			console.log(msg);
			$('#ajouterMembreModalError-'+key).parent().addClass('has-error');
			$('#ajouterMembreModalError-'+key).text(msg).show('fade');
		    })

		}
	    });
	});
	
	function resetForm(){
	    $('#ajouterMembre form>div').removeClass('has-error');
	    $('#ajouterMembre form p').hide();
	}
    });
</script>