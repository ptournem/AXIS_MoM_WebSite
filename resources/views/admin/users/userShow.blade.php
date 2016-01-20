@extends('admin/template')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/AXIS_MOM.js') }}"></script>
@stop

@section('title')
    Administration AXIS-MOM
@stop

@section('contenu')
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>Nom</td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td>{{$user->password}}</td>
            </tr>
        </tbody>
    </table>

@stop

@section('footer')

@stop
