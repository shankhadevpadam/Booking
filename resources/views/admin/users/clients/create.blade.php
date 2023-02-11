@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Filepond', true)

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.clients.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="old('name')" />

                    <x-adminlte-input label="Email" name="email" :value="old('email')" />

                    <x-adminlte-input label="Phone" name="phone" :value="old('phone')" />

                    <x-adminlte-select2 label="Country" name="country_id">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @selected(old('country_id') == $country->id)>{{ $country->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input type="password" label="Password" name="password" />

                    <div class="form-group">
                        <label for="file" class="d-block">{{ __('Profile Picture') }}</label>
                        <input type="file" name="avatar" id="avatar" />

                        @if ($errors->has('avatar'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
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
@endsection