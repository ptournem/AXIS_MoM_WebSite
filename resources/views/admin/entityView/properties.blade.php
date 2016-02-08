
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
                    <td class="information-{{ $retour->name }}" language="{{ $retour->lang }}">{{ $retour->name }}</td>

                    @if($retour->entity_locale != null)
                    <td id="searchEntitis" name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                        @if(is_array($retour->entity_locale))
                        @foreach($retour->entity_locale as $entity)
                        <span class="entity btn btn-default center-block" target="_blank" style="background-color: rgb(34, 238, 70);">
                            <span name="{{ $entity->URI }}" class="value">{{ $entity->name }}</span>
                            <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                        </span>
                        @endforeach
                        @else
                        <span class="entity btn btn-default center-block" target="_blank" style="background-color: rgb(34, 238, 70);">
                            <span name="{{ $retour->entity_locale->URI }}" class="value">{{ $retour->entity_locale->name }}</span>
                            <span class="glyphicon glyphicon-remove entity-delete" aria-hidden="true" style="position-top: 0px; position-left: 0px;"></span>
                        </span>
                        @endif
                        <img class="loadingDelete" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                        <span contenteditable="true" class="value-edited searchEntities form-control"></span>
                    </td>
                    @else
                    <td name="{{ $retour->name }}" class="information-{{ $retour->name }} locale-value">
                        @if($retour->type == "date")
                        <div class="input-group date" name="{{ $retour->name }}" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" name="{{ $retour->name }}" class="form-control" value="{{ $retour->value_locale }}" disabled>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                        @else
                        <span class="hidden" style="display: none">{{ $retour->value_locale }}</span>
			<div class="input-group">
			    <span contenteditable="true" class="value value-edited searchEntities form-control"/>{{ $retour->value_locale }}</span>                      
			    <div class="input-group-btn" role="group">
				<button type="button"  name="{{ $retour->name }}" class="btn btn-warning btn-warning-locale btn-warning-name-{{ $retour->name }} disabled">
				    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
				<button type="button"  name="{{ $retour->name }}" class="btn btn-success btn-success-locale btn-success-name-{{ $retour->name }}  disabled">
				    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</button>
			    </div>
			</div>
			@endif
                    </td>
                    @endif

                    @if($dbpediaInfo)
                    @if($retour->entity_dbpedia != null)
                    <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                        @if(is_array($retour->entity_dbpedia))
                        @foreach($retour->entity_dbpedia as $entity)
                        <span class="entity entity-dbpedia btn btn-default center-block" target="_blank" name="{{ $entity->URI }}">
                            <span name="{{ $entity->URI }}" class="value">{{ $entity->name }}</span>
                        </span>
                        @endforeach    
                        @else
                        <span class="entity entity-dbpedia btn btn-default center-block" target="_blank" name="{{ $retour->entity_dbpedia->URI }}">
                            <span name="{{ $retour->entity_dbpedia->URI }}" class="value">{{ $retour->entity_dbpedia->name }}</span>
                        </span>
                        @endif
                        <img class="loadingSet" src="{{ URL::asset('img/waiting.gif') }}" style="display: block; display: none;"/>
                    </td>
                    @else
                    <td class="information-{{ $retour->name }}" name="{{ $retour->name }}">
                        @if($retour->value_dbpedia != null)
			    @if($retour->type== 'date')
				<button type="button" name="{{ $retour->name }}" class="btn btn-success-selected btn-success-selected-{{ $retour->name }}">
			    @else 
				<button type="button" name="{{ $retour->name }}" class="btn btn-success-selected btn-success-selected-{{ $retour->name }} typeDate">
			    @endif
                            <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                        </button>
                        @endif
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