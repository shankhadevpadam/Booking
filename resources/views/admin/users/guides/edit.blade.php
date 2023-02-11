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
        	<a class="btn btn-primary" href="{{ route('admin.guides.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.guides.update', $user) }}" enctype="multipart/form-data">

                @csrf

                @method('PATCH')

                <x-adminlte-card>
                    
                    <x-adminlte-input label="Name" name="name" :value="$user->name" />

                    <x-adminlte-input label="Email" name="email" :value="$user->email" />

                    <x-adminlte-input label="Phone" name="phone" :value="$user->phone" />

                    <x-adminlte-select2 label="Country" name="country_id">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @selected(old('country_id', $user->country_id) == $country->id)>{{ $country->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <div class="form-group">
                        <label for="file" class="d-block">{{ __('Profile Picture') }}</label>
                        <input type="file" name="avatar" id="avatar" />

                        @if ($errors->has('avatar'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif

                        <div class="review-image-container">
                            @if ($user->getMedia('avatar')->isNotEmpty())
                                <div class="review-image">
                                    {{ $user->getFirstMedia('avatar')->img('thumbnail') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>

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