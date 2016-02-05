@extends('admin/template')

@section('header')
<script type='text/javascript'>
    $(document).ready(function () {
	$('#button-filter-show-all').click(function () {
	    $('#entities tbody tr').show();
	});

	$('.button-filter-type').click(function () {
	    var c = $(this).attr('data-class');
	    $('#entities tbody tr').show();
	    $('#entities tbody tr:not(.type-' + c + ')').hide();
	});

	$('.btn-form-entity-show').on('click', function () {
	    $('.alert-success-new-entity').hide();
	});
    });

</script>
@stop

@section('contenu')

<ul class="nav nav-tabs" id='adminNavTab'>
    
    <li class="active"><a data-toggle="tab" href="#entites">Gestion des entités</a></li>
    <li>
	<a data-toggle="tab" href="#commentaires">
	    Gestion des commentaires
	    @if($nbCommentNotValidated > 0)
		({{$nbCommentNotValidated}})
	    @endif
	</a>
    </li>
    @if(Session::get('user')->admin == 1)
    <li><a data-toggle="tab" href="#membres">Gestion des membres</a></li>
    <li><a data-toggle="tab" href="#logs">Logs</a></li>
    @endif
</ul>
<br />
<div class="tab-content">
	
	@include('admin.index.entities')
	@include('admin.index.comments')
	@if(Session::get('user')->admin == 1)
	    @include('admin.index.users')
	    @include('admin.index.logs')
	@endif
</div>






@include('admin.index.modal-add-entity')
@include('admin.index.modal-add-user')

@stop