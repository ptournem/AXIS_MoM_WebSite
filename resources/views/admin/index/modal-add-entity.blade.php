<!-- Modal entite -->
<div class="modal fade" id="ajouterEntite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
            <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Ajouter une entité</h4>
            </div>
	    <form role="form" method="POST" action="#" enctype="multipart/form-data">
		<div class="modal-body" id="addEntityModal">
		    <div class="alert" role="alert" style="display:none;"></div>

		    {!! csrf_field() !!}
		    <div class="form-group">
			<label for="entity-type" class=" control-label">Type :</label>
			<select id="entity-type" class="entity-type form-control" name="type" size="1">
			    <option value="event">Evénement</option>
			    <option value="location">Lieu</option>
			    <option value="object">Objet</option>
			    <option value="person">Personne</option>
			    <option value="activity">Activité</option>
			    <option value="organisation">Organisation</option>
			</select>
			<p id="addEntityModalError-type" class="text-danger" style="display:none;"></p>
		    </div>
		    <div class="form-group">
			<label for="entity-name" class=" control-label">Nom :</label>
			<input type="text" class="entity-name form-control" id="entity-name" name="name"/>
			<p id="addEntityModalError-name" class="text-danger" style="display:none;"></p>
		    </div>
		    <div class="form-group">
			<label for="entity-image" class=" control-label">Lien vers images :</label>
			<input type="text" class="entity-image form-control" id="entity-image" name="image" />
			<p id="addEntityModalError-image" class="text-danger" style="display:none;"></p>
		    </div>
		    <div class="form-group">
			<p> ou </p>
		    </div>
		    <div class="form-group">
			<label for="entity-imgFile" class=" control-label">Télécharger une image :</label>
			<input type="file" class="entity-imgFile" id="entity-imgFile" name="imgFile" />
			<p id="addEntityModalError-imgFile" class="text-danger" style="display:none;"></p>
		    </div>

		</div>
		<div class="modal-footer">
		    <button type="button" class="btn btn-default btn-close-add-entity" data-dismiss="modal">Fermer</button>
		    <button type="submit" class="btn btn-primary btn-add-entity">Créer</button>
		</div>
	    </form>
	</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
	// sur l'envoie du form
	$('#ajouterEntite form').on('submit', function (e) {
	    e.preventDefault(); // on arrête l'execution par défault
	    var fd = new FormData(this); //on récupère les datas
	    
	    $.ajax({ // on envoie la requête
		url: '{{route("admin.addEntity")}}',
		type: 'post',
		processData: false,
		contentType: false,
		data: fd,
		success: function(data) {
		    // on test si tout s'est bien passé
		    if (data.result) {
			// on affiche le message de succès
			$('#ajouterEntite .alert').removeClass('alert-danger').addClass('alert-success').text('Entité ajoutée avec succès ! Raffraichissez la page pour l\'afficher.').show('fade').delay(1500).hide(function () {
			    $('#ajouterEntite').modal('hide')
			});
		    } else {
			resetForm();
			// on affiche le message d'erreur
			$('#ajouterEntite .alert').removeClass('alert-success').addClass('alert-danger').text('Erreur : Veuillez remplir correctement le formulaire').show('fade').delay(1500).hide('fade');
			$.each(data.require, function (key, msg) {
			    $('#addEntityModalError-' + key).parent().addClass('has-error');
			    $('#addEntityModalError-' + key).text(msg).fadeIn(1000);
			})
		    }
		}
	    });
	});

	/**
	 * fonction de reset du formulaire
	 * @returns {undefined}
	 */
	function resetForm() {
	    $('#ajouterEntite form>div').removeClass('has-error');
	    $('#ajouterEntite form p').hide();
	}
    });
</script>