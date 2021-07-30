@extends('adminlte::page')

@section('title', __('Google Analytics'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Google Analytics') }}" currentActive="{{ __('Google Analytics') }}"/>
@stop

@section('content')
    @empty(env('ANALYTICS_VIEW_ID'))
    @else
        @can('read-analytics')
            @if(Settings::check_connection())
                @if(Settings::checkCredentialFileExists())
                    <div class="row">
                        <div class="col-md-4">
                            @include('admin.analytics.device')
                        </div>
                        <div class="col-md-8">
                            @include('admin.analytics.visitors_pageviews')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.analytics.pages')
                        </div>
                        <div class="col-md-6">
                            @include('admin.analytics.browser')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.analytics.operating_system')
                        </div>
                        <div class="col-md-6">
                            @include('admin.analytics.country')
                        </div>
                    </div>
                @endif
            @endif
        @endcan
    @endempty
@endsection

@section('adminlte_js')
    @include('admin.analytics.script')
@stop

@section('footer')
    @include('layouts.partials._footer')
@stop
