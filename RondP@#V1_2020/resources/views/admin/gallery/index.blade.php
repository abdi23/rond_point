@extends('adminlte::page')

@section('title', __('Galleries'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Galleries') }} ({{ Utl::galleryCount() }})" currentActive="{{ __('Galleries') }}"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('admin.gallery.create')
        @include('layouts.partials._table')
    </div>
</div>
@stop

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/pace-progress/themes/blue/pace-theme-minimal.css') }}">
@stop

@section('adminlte_js')
<script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@include('layouts.partials._datatables')
@include('layouts.partials._notification')

@if($errors->has('file'))
<script>
    toastr.error("{{ $errors->first('file') }}")
</script>
@endif
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@stop

@section('footer')
@include('layouts.partials._footer')
@stop
