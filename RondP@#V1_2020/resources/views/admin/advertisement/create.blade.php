@extends('adminlte::page')

@section('title', __('Create new ad unit'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Create New Ad Unit') }}" currentActive="{{ __('New Add') }}" :addLink="[route('advertisement.index') => __('Advertisement')]"/>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <form id="advertisementForm" action="{{route('advertisement.store')}}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" name="name"  class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name your ad unit') }}" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('Type') }}</label>
                            <div id="ads_type" class="form-group">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn bg-cyan active">
                                        <input type="radio" name="type" id="option1" autocomplete="off" value="image" checked><i class="fas fa-image"></i>
                                        {{ __('Image') }}
                                    </label>
                                    <label class="btn bg-cyan">
                                        <input type="radio" name="type" id="option2" autocomplete="off" value="ga"><i class="fab fa-google"></i>  {{ __('Google Adsense') }}
                                    </label>
                                    <label class="btn bg-cyan">
                                        <input type="radio" name="type" id="option3" autocomplete="off" value="script_code"><i class="fas fa-code"></i>  {{ __('Script Code') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="ad_image">
                            <div class="form-group">
                                <label for="upload">{{ __('Upload Image') }}</label>
                                <div class="upload-image row justify-content-md-center">
                                    <input id="upload" type="file" name="image" value="Choose a file" accept="image/*"
                                           data-role="none" hidden>
                                    <div class="col-12 col-md-8 text-center">
                                        <div class="upload-msg">{{ __('Click to select image') }}</div>
                                        <div id="display">
                                            <img id="image_preview_container" src="#" alt="preview image"
                                                 style="max-width: 100%;">
                                        </div>
                                        <div class="buttons text-center mt-3">
                                            <button id="reset" type="button" class="reset btn btn-danger">{{ __('Change Image') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('Size') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="number" name="width" class="form-control" placeholder="{{ __('Width') }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="number" name="height" class="form-control" placeholder="{{ __('Height') }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="url">{{ __('URL') }}</label>
                                <input id="url" type="url" name="url" class="form-control @error('url') is-invalid @enderror" placeholder="{{ __('https://www.example.com/') }}">
                                @error('url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div id="ad_ga" class="form-group" hidden>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ad_client">{{ __('Ad Client') }}</label>
                                    <input id="ad_client" type="text" name="ad_client" class="form-control @error('ad_client') is-invalid @enderror" placeholder="">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> e.g: ca-pub-1234567891234567
                                    </small>
                                    @error('ad_client')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ad_slot">{{ __('Ad Slot') }}</label>
                                    <input id="ad_slot" type="text" name="ad_slot" class="form-control @error('ad_slot') is-invalid @enderror" placeholder="">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> e.g: 5678
                                    </small>
                                    @error('ad_slot')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ad_size">{{ __('Ad Size') }}</label>
                                <select id="ad_size" class="form-control" name="ad_size">
                                    <option value="fixed" selected>{{ __('Fixed') }}</option>
                                    <option value="responsive">{{ __('Responsive') }}</option>
                                </select>
                            </div>
                            <div id="display_fixed" class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="number" name="ad_width" class="form-control" placeholder="{{ __('Width') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="number" name="ad_height" class="form-control" placeholder="{{ __('Height') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="display_responsive" class="row" style="display:none">
                                <div class="form-group col-md-6">
                                    <label for="ad_format">{{ __('Ad Format') }}</label>
                                    <input id="ad_format" type="text" name="ad_format" class="form-control @error('ad_format') is-invalid @enderror" placeholder="">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> e.g: "auto", "rectangle", "vertical", "horizontal" or "rectangle, horizontal"
                                    </small>
                                    @error('ad_format')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="full_width_responsive">{{ __('Full width responsive') }}</label>
                                    <select id="full_width_responsive" class="form-control" name="full_width_responsive">
                                        <option id="true" value="true" selected>{{ __('true') }}</option>
                                        <option id="false" value="false">{{ __('false') }}</option>
                                    </select>
                                    @error('full_width_responsive')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="ad_script_code" class="form-group" hidden>
                            <label for="ad_unit">{{ __('Ad Custom Code') }}</label>
                            <textarea id="custom" name="script_custom" class="form-control scripts" cols="30" rows="7">//Using Script Code Custom</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">{{ __('Create') }}</button>
                        <a href="{{ route('advertisement.index') }}" class="btn btn-warning">{{ __('Back') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/pace-progress/themes/blue/pace-theme-minimal.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/codemirror/lib/codemirror.css') }}">
    @include('admin.advertisement.style')
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('vendor/codemirror/addon/selection/active-line.js') }}"></script>
    @include('layouts.partials._notification')
    @include('admin.advertisement.script')
@stop

@section('footer')
    @include('layouts.partials._footer')
@stop


