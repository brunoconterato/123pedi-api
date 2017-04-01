<div class="form-group">
    {!! Form::label('Name', 'Nome:') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Manufacturer', 'Fabricante:') !!}
    {!! Form::text('manufacturer', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Brand', 'Marca:') !!}
    {!! Form::text('brand', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Description', 'Descrição:') !!}
    {!! Form::textArea('description', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Image', 'Link da Imagem:') !!}
    {!! Form::text('image_url', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Category', 'Categoria:') !!}
    {!! Form::select('category_id', $categories , null, ['class'=>'form-control']) !!}
</div>