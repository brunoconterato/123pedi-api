@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Estoque</h3>

        <a href="{{route('admin.retailers.stock.create',['retailerId'=>$retailerId])}}" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i>
        </a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Data de vencimento</th>
                <th>Ação</th>
            </tr>
            </thead>

            <tbody>
            @foreach($stockItems as $stockItem)
                <tr>
                    <td>{{$stockItem->id}}</td>
                    <td>{{$stockItem->product->name}}</td>
                    <td>{{$stockItem->quantity}}</td>
                    <td>{{$stockItem->price}}</td>
                    {{--TODO: imrimir expiration_date no formato correto--}}
                    <td>{{$stockItem->expiration_date}}</td>
                    <td>
                        <a href="{{route('admin.retailers.stock.edit', ['id'=>$stockItem->id])}}" class="btn btn-primary btn-small">
                            <i class = "glyphicon glyphicon-pencil"></i>
                        </a>

                        <a href="{{route('admin.retailers.stock.destroy',['id'=>$stockItem->id])}}" class="btn btn-danger btn-small">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $stockItems->render() !!}
    </div>
@endsection