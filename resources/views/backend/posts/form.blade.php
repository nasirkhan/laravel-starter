
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', old('title'), ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', old('slug'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('intro', 'Intro') !!}
            {!! Form::textarea('intro', old('intro'), ['class' => 'form-control', 'rows' => '3']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('content', 'Content') !!}
            {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'featured_image';
            $field_lable = 'Featured Image';
            $field_placeholder = $field_lable;
            ?>

            {!! Form::label("$field_name", "$field_lable") !!}
            <div class="input-group">
                {!! Form::text("$field_name", old("$field_name"), ['class' => 'form-control', 'id' => "$field_name", 'required']) !!}
                <span class="input-group-btn">
                    <button id="btn_{{$field_name}}" data-input="{{$field_name}}" data-preview="holder" class="btn btn-info" type="button"><i class="fa fa-folder-open"></i> Browse</button>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('category_id', 'Category') !!}
            {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control', 'placeholder' => 'Select an option', 'required']) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', array(
            'Article'=>'Article',
            'Achievement'=>'Achievement',
            'CSR'=>'CSR',
            'News'=>'News',
            ),old('type') , ['class' => 'form-control', 'placeholder' => 'Select an option', 'required'])
            !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('is_featured', 'Is Featured') !!}
            {!! Form::select('is_featured', array(
            'No'=>'No',
            'Yes'=>'Yes',
            ),old('is_featured') , ['class' => 'form-control', 'required'])
            !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', array(
            '1'=>'Published',
            '0'=>'Unpublished',
            '2'=>'Draft'
            ), old('status') , ['class' => 'form-control'])
            !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('published_at', 'Publish Time') !!}
            {!! Form::text('published_at', old('published_at') , ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('meta_title', 'Meta Title') !!}
            {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('meta_keywords', 'Meta Keyword') !!}
            {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('order', 'Order') !!}
            {!! Form::text('order', old('order'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('meta_description', 'Meta Description') !!}
            {!! Form::text('meta_description', old('meta_description'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('meta_og_image', 'meta_og_image') !!}
            {!! Form::text('meta_og_image', old('meta_og_image'), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('meta_og_url', 'meta_og_url') !!}
            {!! Form::text('meta_og_url', old('meta_og_url'), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

@push('after-scripts')

<script type="text/javascript" src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="/vendor/laravel-filemanager/js/lfm.js"></script>

<script type="text/javascript">

$('#btn_featured_image').filemanager('image');

CKEDITOR.replace( 'content', {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
});

</script>

@endpush
