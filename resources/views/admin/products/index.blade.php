@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Produtos</h3>

        <a href="{{route('admin.products.create')}}" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Ação</th>
            </tr>
            </thead>


            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>
                            <a href="{{route('admin.products.edit',['id'=>$product->id])}}" class="btn btn-primary btn-small">
                                <i class = "glyphicon glyphicon-pencil"></i>
                            </a>

                            <a href="{{route('admin.products.destroy',['id'=>$product->id])}}" class="btn btn-danger btn-small">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{ $products->render() }}

    </div>
@endsection