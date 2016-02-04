<div id="entites" class="tab-pane fade in active">
    <button type="button" class="btn btn-primary btn-form-entity-show" data-toggle="modal" data-target="#ajouterEntite">
	Ajouter une entité
    </button>
    <a id="button-filter-show-all">Tout</a> | 
    <a data-class='event' class='button-filter-type'>Evénements</a> | 
    <a data-class='location' class='button-filter-type'>Lieux</a> | 
    <a data-class='object' class='button-filter-type' >Objets</a> | 
    <a data-class='person' class='button-filter-type'>Personnes</a> | 
    <a data-class='activity' class='button-filter-type'>Activités</a> |
    <a data-class='organisation' class='button-filter-type'>Organisations</a>
    <br /><br />
    <br />
    <div id='successMsg-update' class="alert alert-success alert-success-new-entity" style="display: none">
	Entité ajoutée.
    </div>
    <table id="entities" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
	    <tr>
		<th>Nom</th>
		<th>Type</th>
	    </tr>
	</thead>
	<tbody class="tbody-entities">
	    @if(is_array($entities))
	    @foreach ($entities as $entity)
	<tr class="type-{{ $entity->type }}">
	    <td><a href="{{URL::to('admin/view/' . rawurlencode(Utils::formatURI($entity->URI))) }}" style="display: block;width: 100%; height: 100%;">{{ $entity->name }}</a></td>
	    <td>{{ $entity->type }}</td>
	</tr>
	@endforeach
	@endif
	</tbody>
    </table>
</div>
