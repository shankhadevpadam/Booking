@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Filepond', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.home') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    
                @csrf

                @method('PATCH')

                <x-adminlte-card>
                    
                    <x-adminlte-input label="Name" name="name" :value="$user->name" />

                    <x-adminlte-input label="Email" name="email" :value="$user->email" />

                    <x-adminlte-input label="Phone" name="phone" :value="$user->phone" />

                    <x-adminlte-input type="password" label="Password" name="password" />

                    <div class="text-info">[Please enter the password if you want to change.]</div>

                    <div class="form-group">
                        <label for="file" class="d-block">Profile Picture</label>
                        <input type="file" name="avatar" id="avatar" />

                        @if ($errors->has('avatar'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif

                        @if ($user->getMedia('avatar')->isNotEmpty())
                            {{ $user->getFirstMedia('avatar')->img('thumbnail') }}
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
	@include('admin.includes.scripts')

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            $.fn.filepond.setDefaults({
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/*'],
            });

            $('#avatar').filepond({
                allowMultiple: false,
                storeAsFile: true,
            });
        })
    </script>
@stop