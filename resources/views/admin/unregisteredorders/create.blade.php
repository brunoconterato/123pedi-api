@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{ route('admin.orders.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Pedido</h3>

        @include('errors._check')



        {!! Form::open(['route'=>'admin.orders.store',
                        'class'=>'form',
                        'enctype'=>'multipart/form-data',
                        'method'=>'post',
                        'files' => true])
        !!}


        {{--Tentativa fracassada de fazer dinamically dropdown lists--}}
        <div class="form-group">
            <label>Pet Shop
                <select name="petshop" id="petShop_id" class="form-control">
                    @foreach($petShops as $petShop)
                        <option value="{{ $petShop->id }}">
                            {{ $petShop->user->name}}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>



        <div class="form-group">
            <label>Total: </label>
            <p id="total"></p>
            <a href="#" id="btnNewItem" class="btn btn-default">Novo Item</a>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <label>
                                <select id="stockItem" class="form-control input-sm" name="stockItem">
                                    <option value=""></option>
                                </select>
                            </label>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<select id="stockItem" class="form-control" name="stockItem">--}}
                            {{--@foreach($pharmacyItems->where('petshop_id','=',$petShop->id) as $pharmacyItem)--}}
                                {{--<option value="{{$pharmacyItem->id}}" data-price="{{$pharmacyItem->price}}">--}}
                                    {{--{{$pharmacyItem->id}} --- {{$pharmacyItem->price}}--}}
                                {{--</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    </td>
                    <td>
                        {!! Form::text('items[0][qtd]', 1, ['class'=>'form-control']) !!}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <label for="Incluir receita:">Incluir Receita: </label>
            {!! Form::file('image', null) !!}
        </div>

        <div class="form-group">
            <p>Cliente:</p>
            <select class="form-control" name="client_id">
                @foreach($clients as $client)
                    <option value="{{$client->id}}">
                        {{$client->user->name}}
                    </option>
                @endforeach
            </select>
        </div>

        {{--Código antigo funcional--}}
        {{--<div class="form-group">--}}
            {{--<p>Pet Shop:</p>--}}
            {{--<select class="form-control" name="petshop_id">--}}
                {{--@foreach($petShops as $petShop)--}}
                    {{--<option value="{{$petShop->id}}">--}}
                        {{--{{$petShop->user->name}}--}}
                    {{--</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
        {{--</div>--}}

        <div class="form-group">
            {!! Form::submit('Criar pedido', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('post-script')
    {{--Tentativa lixo de fazer puxar pelo estoque do pet shop--}}
    <script>
        $('#petShop_id').on('change', function(e) {
            console.log(e);
            var petshop_id = e.target.value;

            $.get('{{ url('information') }}/create/ajax-state?state_id=' + petshop_id, function(data) {
                console.log(data);
                $('#stockItem').empty();
                $.each(data, function(index,subCatObj){
                    $('#stockItem').append(''+subCatObj.name+'');
                });
            });
        });
    </script>

    <script>
        $('#btnNewItem').click(function(){

            var row = $('table tbody > tr:last'),
                    newRow = row.clone(),
                    lenght = $("table tbody tr").length;

            newRow.find('td').each(function(){

                var td = $(this),
                        input = td.find('input,select'),
                        name = input.attr('name');

                input.attr('name', name.replace( (lenght - 1) + "", lenght + ""));

            });

            newRow.find('input').val(1);
            newRow.insertAfter(row);
            calculateTotal();
        });

        $(document.body).on('click', 'select', function(){
            calculateTotal();
        });

        $(document.body).on('blur', 'input', function(){
            calculateTotal();
        });

        function calculateTotal(){
            var total = 0,
                    trlen = $('table tbody tr').length,
                    tr = null, price, qtd;

            for(var i=0; i<trlen; i++)
            {
                tr = $('table tbody tr').eq(i);
                price = tr.find(':selected').data('price');
                qtd = tr.find('input').val();
                total += price * qtd;
            }

            $('#total').html(total);
        };
    </script>

@endsection