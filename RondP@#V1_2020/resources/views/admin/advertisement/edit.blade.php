@extends('adminlte::page')

@section('title', __('Edit Advertisement'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Edit Advertisement') }}" currentActive="{{ __('Edit') }}" :addLink="[route('advertisement.index') => __('Advertisement')]"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <form action="{{route('advertisement.update', [$ad->id])}}" method="POST" role="form" enctype="multipart/form-data">
            @method('PUT')
            @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" name="name"  class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name your ad unit') }}" required value="{{ $ad->name }}">
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
                                    <input type="radio" name="type" id="option1" autocomplete="off" value="image" @if($ad->type == 'image') checked @endif><i class="fas fa-image"></i> Image
                                </label>
                                <label class="btn bg-cyan">
                                    <input type="radio" name="type" id="option2" autocomplete="off" value="ga" @if($ad->type == 'ga') checked @endif><i class="fab fa-google"></i> Google Adsense
                                </label>
                                <label class="btn bg-cyan">
                                    <input type="radio" name="type" id="option3" autocomplete="off" value="script_code" @if($ad->type == 'script_code') checked @endif><i class="fas fa-code"></i> Script Code
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="ad_image" @if($ad->type != 'image') hidden @endif>
                        <div class="form-group">
                            <label for="upload">{{ __('Upload Image') }}</label>
                            <div class="upload-image row justify-content-md-center @if($image) ready @endif">
                                <input id="upload" type="file" name="image" value="Choose a file" accept="image/*"
                                       data-role="none" hidden>
                                <div class="col-12 col-md-8 text-center">
                                    <div class="upload-msg">{{ __('Click to select image') }}</div>
                                    <div id="display">
                                        <img id="image_preview_container" src="{{ $image }}" alt="preview image"
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
                                        <input type="number" name="width" class="form-control" placeholder="{{ __('Width') }}" value="{{ $width }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="number" name="height" class="form-control" placeholder="{{ __('Height') }}" value="{{ $height }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url">{{ __('URL') }}</label>
                            <input id="url" type="url" name="url"  class="form-control @error('url') is-invalid @enderror" placeholder="{{ __('https://www.example.com/') }}" value="{{ $url }}">
                            @error('url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div id="ad_ga" class="form-group" @if($ad->type != 'ga') hidden @endif>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ad_client">{{ __('Ad Client') }}</label>
                                <input id="ad_client" type="text" name="ad_client" class="form-control @error('ad_client') is-invalid @enderror" placeholder="" @if($ga) value="{{ $ga->ad_client }}" disabled @endif>
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
                                <input id="ad_slot" type="text" name="ad_slot" class="form-control @error('ad_slot') is-invalid @enderror" placeholder="" @if($ga) value="{{ $ga->ad_slot }}" disabled @endif>
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
                                @if($ga)
                                    @if($ga->ad_size == 'fixed')
                                        <option value="fixed" selected>{{ __('Fixed') }}</option>
                                        <option value="responsive">{{ __('Responsive') }}</option>
                                    @else
                                        <option value="fixed">{{ __('Fixed') }}</option>
                                        <option value="responsive" selected>{{ __('Responsive') }}</option>
                                    @endif
                                @else
                                    <option value="fixed" selected>{{ __('Fixed') }}</option>
                                    <option value="responsive">{{ __('Responsive') }}</option>
                                @endif
                            </select>
                        </div>
                        <div id="display_fixed" class="row" @if($ga) @if($ga->ad_size == 'responsive') style="display:none" @endif @endif>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="number" name="ad_width" class="form-control" placeholder="{{ __('Width') }}" @if($ga) value="{{ $ga->ad_width }}" @endif required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="number" name="ad_height" class="form-control" placeholder="{{ __('Height') }}" @if($ga) value="{{ $ga->ad_height }}" @endif required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="display_responsive" class="row" @if($ga) @if($ga->ad_size == 'fixed') style="display:none" @endif @else style="display:none" @endif>
                            <div class="form-group col-md-6">
                                <label for="ad_format">{{ __('Ad Format') }}</label>
                                <input id="ad_format" type="text" name="ad_format" class="form-control @error('ad_format') is-invalid @enderror" placeholder="" @if($ga) value="{{ $ga->ad_format }}" @endif>
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
                                    @if($ga)
                                        @if($ga->full_width_responsive == "true")
                                            <option id="true" value="true" selected>{{ __('true') }}</option>
                                            <option id="false" value="false">{{ __('false') }}</option>
                                        @else
                                            <option id="true" value="true">{{ __('true') }}</option>
                                            <option id="false" value="false" selected>{{ __('false') }}</option>
                                        @endif
                                    @else
                                        <option id="true" value="true" selected>{{ __('true') }}</option>
                                        <option id="false" value="false">{{ __('false') }}</option>
                                    @endif
                                </select>
                                @error('full_width_responsive')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="ad_script_code" class="form-group" @if($ad->type != 'script_code') hidden @endif>
                        <label for="ad_unit">{{ __('Ad Custom Code') }}</label>
                        <textarea id="custom" name="script_custom" class="form-control scripts" cols="30" rows="7">{{ $script_code }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">{{ __('Save') }}</button>
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
