<div id="LODLink" class="tab-pane fade">
    <br />
    <div id='successMsg-update' class="alert alert-success alert-success-update" style="display: none">
	Mise à jour du champ effectuée.
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
	    @foreach($dbpedia as $retour)
	    <tr>
		<td class="sameasValue">
		    <span contenteditable="true" 
			  class="value value-edited" 
			  style="display: block; width: 100%; height: 100%;">{{ $retour->entity_locale->name }}</span>
		    <span class="hidden" style="display: none">{{ $retour->entity_locale->name }}</span>
		    <!-- <div contenteditable="false" style="position: relative; right: 0px;" class="input-group-btn" role="group">
			<button type="button" style="position: relative; right: 0px;" name="{{ $retour->entity_locale->name }}" class="btn btn-warning btn-warning-sameas btn-warning-name-{{ $retour->name }} disabled">
			    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
			<button type="button" style="position: relative; right: 0px;" name="{{ $retour->entity_locale->name }}" class="btn btn-success btn-success-sameas btn-success-name-{{ $retour->name }}  disabled">
			    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			</button>
		    </div> -->
		</td>
		<td>
		    <button class='btn btn-danger btn-block btn-delete' uid="3">
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