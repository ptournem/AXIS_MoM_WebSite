@extends('admin/template')

@section('contenu')
    <h2 class="Entity-name">Utilisateur : {{$user->name}}</h2>
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