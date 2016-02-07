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
            @if($dbpedia != null)
            @foreach($dbpedia as $db)
                @if(is_array($db->entity_locale))
                    @foreach($db->entity_locale as $retour)
                        <tr>
                            <td class="sameasValue">
                                <span class="entity btn btn-default center-block" target="_blank" style="background-color: rgb(34, 238, 70);">
                                    <span name="{{ $retour->URI }}" class="value">{{ $retour->name }}</span>
                                </span>
                            </td>
                            <td class="delete">
                                <button uri="{{ $retour->URI }}" class='btn btn-danger btn-block btn-delete'>
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="sameasValue">
                            <span class="entity btn btn-default center-block" target="_blank" style="background-color: rgb(34, 238, 70);">
                                <span name="{{ $db->entity_locale->URI }}" class="value">{{ $db->entity_locale->name }}</span>
                            </span>
                        </td>
                        <td class="delete">
                            <button uri="{{ $db->entity_locale->URI }}" class='btn btn-danger btn-block btn-delete'>
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
            @endif
	    <tr>
		<td class="new-LOD"></td>
		<td><button class="btn btn-primary btn-addLOD">Ajouter un lien LOD</button></td>
	    </tr>
	</tbody>
    </table>
</div>