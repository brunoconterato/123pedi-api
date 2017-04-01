@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Clientes</h3>

        <a href="{{route('admin.clients.create')}}" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Role</th>
                <th>Ação</th>
            </tr>
            </thead>


            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->user->name}}</td>
                        <td>{{$client->user->role}}</td>
                        <td>
                            <a href="{{route('admin.clients.edit',['id'=>$client->id])}}" class="btn btn-primary btn-small">
                                <i class = "glyphicon glyphicon-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{ $clients->render() }}

    </div>
@endsection