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

	$('.btn-add-entity').on('click', function () {
	    addEntity($('.entity-type').val(), $('.entity-name').val(), $('.entity-description').val(), $('.entity-image').val());
	});

	$('.btn-form-entity-show').on('click', function () {
	    $('.alert-success-new-entity').hide();
	});
    });

</script>
@stop

@section('contenu')

<ul class="nav nav-tabs" id='adminNavTab'>
    <li><a data-toggle="tab" href="#membres">Gestion des membres</a></li>
    <li class="active"><a data-toggle="tab" href="#entites">Gestion des entités</a></li>
    <li><a data-toggle="tab" href="#commentaires">Gestion des commentaires</a></li>
    <li><a data-toggle="tab" href="#logs">Logs</a></li>
</ul>
<br />
<div class="tab-content">
	@include('admin.index.users')
	@include('admin.index.entities')
	@include('admin.index.comments')
	@include('admin.index.logs')
</div>






@include('admin.index.modal-add-entity')
@include('admin.index.modal-add-user')

@stop