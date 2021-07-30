@extends('adminlte::page')

@section('title', __('Social Media'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Socialmedia') }} ({{ Utl::socialmediaCount() }})" currentActive="{{ __('Socialmedia') }}"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        @include('admin.socialmedia.create')
    </div>
    <div class="col-md-8">
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
    @include('admin.socialmedia.script')
@stop

@section('footer')
@include('layouts.partials._footer')
@stop
