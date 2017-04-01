@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Categorias</h3>

        <a href="{{route('admin.categories.create')}}" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
            </thead>


            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('admin.categories.edit',['id'=>$category->id])}}" class="btn btn-primary btn-small">
                                <i class = "glyphicon glyphicon-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{ $categories->render() }}

    </div>
@endsection