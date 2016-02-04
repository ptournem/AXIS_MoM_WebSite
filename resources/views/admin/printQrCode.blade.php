@extends('admin/template')

@section('title')

@stop 

@section('header')
<script type="text/javascript">
    window.print();
</script>
@stop

@section('contenu')
<div class="text-center" >
     {!! QrCode::size(600)->generate(action('PublicController@anyEntity',['uid'=>Utils::formatURI($entity->URI)])); !!}
     <p> Retrouvez plus d'information sur </p>
     <h2> {{$entity->name}}</h2>
     <p> en scannant avec votre mobile ou tablette le QrCode ci-dessus.  </p>
</div>
@stop
