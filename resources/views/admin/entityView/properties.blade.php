<div id="informations" class="tab-pane fade in active">
    <br />
    <div id='successMsg-update' class="alert alert-success alert-success-update" style="display: none">
	Mise à jour du champ effectuée.
    </div>
    <table id="entity-information" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
	    <tr>
		<th>Informations</th>
		<th width="35%">Local</th>
		@if($dbpediaInfo)
		<th>DBPedia</th>
		@endif
	    </tr>
	</thead>
	<tbody>
            @if($retours != null)
                @foreach($retours as $retour)
                    @if($retour->name != 'sameas')
                    <tr>
                    <td class="information-{{ $retour->name }}">{{ $retour->name }}</td>

                    @if($retour->entity_locale != null)
                    <td id="searchEntitis" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                        @if(is_array($retour->entity_locale))
                        @foreach($retour->entity_locale as $entity)
                        <span class="entity" style="background-color: pink; padding: 2px; margin: 2px;">
                            <span name="{{ $entity->URI }}" class="value">{{ $entity->name }}</span>
                            <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                        </span>
                        @endforeach
                        @else
                        <span class="entity" style="background-color: pink; padding: 2px; margin: 2px;">
                            <span name="{{ $retour->entity_locale->URI }}" class="value">{{ $retour->entity_locale->name }}</span>
                            <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                        </span>
                        @endif
                        <img class="loadingDelete" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                        <span contenteditable="true" class="value-edited searchEntities" style="display: inline-block; width: 100%;"></span>
                    </td>
                    @else
                    <td name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                        <span class="hidden" style="display: none">{{ $retour->value_locale }}</span>
                        <span contenteditable="true" class="value value-edited searchEntities" style="display: inline-block; width: 100%;">{{ $retour->value_locale }}</span>
                        <div style="position: relative; right: 0px;" class="input-group-btn" role="group">
                            <button type="button" style="position: relative; right: 0px;" name="{{ $retour->name }}" class="btn btn-warning btn-warning-locale btn-warning-name-{{ $retour->name }} disabled">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <button type="button" style="position: relative; right: 0px;" name="{{ $retour->name }}" class="btn btn-success btn-success-locale btn-success-name-{{ $retour->name }}  disabled">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </button>
                        </div>
                    </td>
                    @endif

                    @if($dbpediaInfo)
                    @if($retour->entity_dbpedia != null)
                    <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                        @if(is_array($retour->entity_dbpedia))
                        @foreach($retour->entity_dbpedia as $entity)
                        <span class="entity entity-dbpedia" name="{{ $entity->URI }}" style="background-color: pink; padding: 2px; margin: 2px;">
                            <span name="{{ $entity->URI }}" class="value">{{ $entity->name }}</span>
                        </span>
                        @endforeach    
                        @else
                        <span class="entity entity-dbpedia" name="{{ $retour->entity_dbpedia->URI }}" style="background-color: pink; padding: 2px; margin: 2px;">
                            <span name="{{ $retour->entity_dbpedia->URI }}" class="value">{{ $retour->entity_dbpedia->name }}</span>
                        </span>
                        @endif
                        <img class="loadingSet" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                    </td>
                    @else
                    <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                        <button type="button" name="{{ $retour->value_locale }}" class="btn btn-success-selected btn-success-selected-{{ $retour->name }}">
                            <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                        </button>
                        <span class="value">{{ $retour->value_dbpedia }}</span>
                    </td>
                    @endif
                    @endif
                    @endif
                @endforeach
            @endif
	</tbody>
    </table>
</div>