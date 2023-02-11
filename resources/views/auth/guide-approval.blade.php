@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title', __('Guide Approval'))

@section('auth_body')
    <div class="alert alert-success" role="alert">
        Thank you guide successfully approved.
    </div>
@stop
