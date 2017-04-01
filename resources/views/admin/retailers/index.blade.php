@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Distribuidores</h3>

        <a href="{{route('admin.retailers.create')}}" class="btn btn-success">
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
                @foreach($retailers as $retailer)
                    <tr>
                        <td>{{$retailer->id}}</td>
                        <td>{{$retailer->user->name}}</td>
                        <td>{{$retailer->user->role}}</td>
                        <td>
                            <a href="{{route('admin.retailers.edit',['id'=>$retailer->id])}}" class="btn btn-primary btn-small">
                                <i class = "glyphicon glyphicon-pencil"></i>
                            </a>
                            <a href="{{route('admin.retailers.stock.index',['id'=>$retailer->id])}}" class="btn btn-warning btn-small">
                                <i class = "glyphicon glyphicon-list"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{ $retailers->render() }}

    </div>
@endsection