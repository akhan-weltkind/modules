@extends('admin::admin.form')

@section('form_content')
    {!! AdminBootForm::open([
        'model'  => $entity,
        'store'  => $routePrefix . 'store',
        'update' => $routePrefix . 'update',
        'autocomplete' => 'off',
        'files'  => true
    ]) !!}

    {{--Пример текстового поля--}}
    <div class="col-md-6">
        {!! AdminBootForm::text('title', trans('admin::fields.title')) !!}
    </div>

    {{--Чтобы были seo поля раскоментируйте--}}
    {{--@include('admin::common.forms.seo')--}}
@endsection
