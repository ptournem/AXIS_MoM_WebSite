<div id="logs" class="tab-pane fade">
    <form id="logs-form" class="form-inline">
	{!! csrf_field() !!}  
	<input type="button" class="btn btn-primary" id="btn-reset-log" value="Vider les logs"/>
    </form>
    <br />
    <table id="logs-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
	    <tr>
		<th width="20%">Date</th>
		<th width="20%">User</th>
		<th>Message</th>
	    </tr>
	</thead>
	<tbody>
	    @foreach($logs as $log)
	    <tr>
		<td>{{$log->created_at}}</td>
		<td>@if($log->user != null){{$log->user->name}}@endif</td>
		<td>{{$log->message}}</td>
	    </tr>
	    @endforeach

	</tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
	var logDelete = "{{route('log.deleteAll')}}";
	$('#btn-reset-log').click(function () {
	    $.post(logDelete, $('#logs-form').serialize(), function (data) {
		if (data.result) {
		    $('#logs-table tbody').html('');
		}
	    }, 'json');
	});
    })
</script>