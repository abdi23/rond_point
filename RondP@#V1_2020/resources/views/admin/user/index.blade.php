@extends('adminlte::page')

@section('title', __('Users'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Users') }} ({{ Utl::userCount() }})" currentActive="{{ __('Users') }}"/>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials._table')
        </div>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/pace-progress/themes/blue/pace-theme-minimal.css') }}">
@stop

@section('adminlte_js')
    @include('layouts.partials._datatables')
    @include('layouts.partials._notification')
@stop

@section('footer')
    @include('layouts.partials._footer')
@stop
