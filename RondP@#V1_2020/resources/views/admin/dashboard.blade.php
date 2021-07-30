@extends('adminlte::page')

@section('title', __('Dashboard'))

@section('content_header')
    <h1>{{ __('Dashboard') }}</h1>
@stop

@section('content')
    <div class="row">
        @can('read-posts')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('posts.index') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Posts') }}</span>
                            <span class="info-box-number">{{ Dashboard::countPost() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-pages')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('pages.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-copy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Pages') }}</span>
                            <span class="info-box-number">{{ Dashboard::countPage() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        <div class="clearfix hidden-md-up"></div>

        @can('read-categories')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('categories.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tags"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Categories') }}</span>
                            <span class="info-box-number">{{ Dashboard::countCategory() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-tags')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('tags.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbtack"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Tags') }}</span>
                            <span class="info-box-number">{{ Dashboard::countTag() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-users')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('users.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Users') }}</span>
                            <span class="info-box-number">{{ Dashboard::countUser() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-roles')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('roles.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-fuchsia elevation-1"><i class="fas fa-user-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Roles') }}</span>
                            <span class="info-box-number">{{ Dashboard::countRole() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-permissions')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('permissions.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-olive elevation-1"><i class="fas fa-shield-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Permissions') }}</span>
                            <span class="info-box-number">{{ Dashboard::countPermission() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan

        @can('read-galleries')
            <div class="col-12 col-sm-6 col-md-3">
                <a class="link-info-box" href="{{ route('galleries.index') }}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-hdd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('Galleries') }}</span>
                            <span class="info-box-number">{{ Dashboard::countGallery() }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endcan
    </div>

    @if(env('ANALYTICS_VIEW_ID'))
        @can('read-analytics')
            @if(Settings::check_connection())
                @if(Settings::checkCredentialFileExists())
                    <h4 class="mt-4 mb-4">{{ __('Google Analytics') }} <small>(<a href="{{ route('analytics.index') }}">{{ __('See More') }}</a>)</small></h4>
                    <div class="row">
                        <div class="col-md-4">
                            @include('admin.analytics.device')
                        </div>
                        <div class="col-md-8">
                            @include('admin.analytics.visitors_pageviews')
                        </div>
                    </div>
                @endif
            @endif
        @endcan
    @endif
@stop

@section('adminlte_css')
    <style>
        .card {
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, .125);
        }
        .link-info-box {
            color: #000;
        }
    </style>
@stop

@section('adminlte_js')
    @include('admin.analytics.script')
@stop

@section('footer')
    @include('layouts.partials._footer')
@stop
