@extends('layouts.inner')

@section('content')
    @if (count($items))
        @foreach($items as $item)
            <p>{{ $item->title }}</p>
        @endforeach

        {{--Пагинатор--}}
        {!! $items->appends(\Request::except('page'))->links('common.paginate') !!}
    @else
        <p>@lang('DummySlug::index.no_records')</p>
    @endif
@endsection
