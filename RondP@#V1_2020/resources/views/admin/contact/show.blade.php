@extends('adminlte::page')

@section('title', __('Contacts'))

@section('content_header')
    <x-breadcrumbs title="{{ __('Contacts') }}" currentActive="{{ __('Detail Message') }}" :addLink="[route('contacts.index') => __('Contacts')]"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Detail Message') }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <th>{{ __('E-Mail') }}</th>
                        <td>{{ $contact->email }}</td>
                        <tr>
                            <th>{{ __('Subject') }}</th>
                            <td>{{ $contact->subject }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Message') }}</th>
                            <td>{{ $contact->message }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Date & Time') }}</th>
                            <td>{{ $contact->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/pace-progress/themes/blue/pace-theme-minimal.css') }}">
@stop

@section('footer')
@include('layouts.partials._footer')
@stop
