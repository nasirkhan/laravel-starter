<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Category Name', 'required']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('code', 'Code') !!}
            {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => 'Code']) !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('order', 'Order') !!}
            {!! Form::text('order', old('order'), ['class' => 'form-control', 'placeholder' => 'Order']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
        </div>
    </div>
</div>
