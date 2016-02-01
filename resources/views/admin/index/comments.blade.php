<div id="commentaires" class="tab-pane fade">
    <table id="comments" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
	    <tr>
		<th>Date</th>
		<th>Auteur</th>
		<th>Adresse mail</th>
		<th>Commentaire</th>
		<th>Oeuvre</th>
		<th>Validation</th>
		<th>Supprimé</th>
	    </tr>
	</thead>
	<tbody>
	    @if(is_array($comments))
	    @foreach($comments as $comment)
	    <tr data-id="{{$comment->id}}">
		<td>{{$comment->createDt}}</td>
		<td>{{$comment->authorName}}</td>
		<td>{{$comment->email}}</td>
		<td>{{$comment->comment}}</td>
		<td style="text-align: center;"><a href="{{url('admin/view',[Utils::formatURI($comment->entity->URI)])}}">{{$comment->entity->name}}</a></td>
		<td>
		    @if($comment->validated)
		    <button type="button" class="btn btn-danger comment-deny">
			<span class="glyphicon glyphicon-remove"></span>
			Refuser
		    </button> 
		    @else
		    <button type="button" class="btn btn-success comment-grant">
			<span class="glyphicon glyphicon-ok"></span>
			Valider
		    </button> 
		    @endif
		</td>
		<td>
		    <button type="button" class="btn btn-danger comment-remove">
			<span class="glyphicon glyphicon-trash"></span>
			Supprimer
		    </button></td>

	    </tr>
	    @endforeach
	    @endif
	</tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
	// récupération des routes
	var commentGrant = "{{route('comment.grant')}}";
	var commentDeny = "{{route('comment.deny')}}";
	var commentRemove = "{{route('comment.remove')}}";

	var token = "{{csrf_token()}}";

	// click sur le bouton deny
	$('#comments').on('click', '.comment-deny', function () {
	    var $button = $(this);
	    $.post(commentDeny, {id: formatURI($button.parents('tr').attr('data-id')), _token: token}, function (data) {
		if (data.result) {
		    // changement des classes
		    $button.removeClass('btn-danger comment-deny').addClass('btn-success comment-grant').html('<span class="glyphicon glyphicon-ok"></span> Valider');
		}
	    }, 'json');
	});

	// click sur le bouton accepter
	$('#comments').on('click', '.comment-grant', function () {
	    var $button = $(this);
	    $.post(commentGrant, {id: formatURI($button.parents('tr').attr('data-id')), _token: token}, function (data) {
		if (data.result) {
		    // changement des classes
		    $button.removeClass('btn-success  comment-grant').addClass('btn-danger comment-deny').html('<span class="glyphicon glyphicon-remove"></span> Refuser');
		}
	    }, 'json');
	});

	// click sur le bouton remove
	$('#comments').on('click', '.comment-remove', function () {
	    var $button = $(this);
	    $.post(commentRemove, {id: formatURI($button.parents('tr').attr('data-id')), _token: token}, function (data) {
		if (data.result) {
		    // suppresion de la ligne 
		    $button.parents('tr').get(0).remove();
		}
	    }, 'json');
	});
    });
</script>