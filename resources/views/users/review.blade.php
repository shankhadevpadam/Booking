@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Rating', true)

@section('plugins.Filepond', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <form role="form" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">     
                @csrf
                <x-adminlte-card>
                    <x-adminlte-select label="Package" name="notification_id">
                        @foreach ($filterData as $data)
                            <option value="{{ $data['notification_id'] }}">{{ $data['package_name'] }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-input label="Title" name="title" :value="old('title')" />

                    <x-adminlte-textarea label="Your Review" name="review" rows="10" />

                    <div class="form-group">
                        <label for="file" class="d-block">Tour Photos</label>
                        <input type="file" name="photos[]" id="photos" multiple />
                    </div>

                    @foreach ($errors->get('photos.*') as $message)
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message[0] }}</strong>
                        </span>
                    @endforeach

                    <div class="form-group">
                        <input id="star-rating" name="rating" class="kv-ltr-theme-fas-star rating-loading" data-min="0" data-max="5" data-step="0.5" data-size="sm">
                    </div>

                    @if ($errors->first('rating'))
                        <span class="invalid-feedback d-block mb-2" role="alert">
                            <strong>{{ $errors->first('rating') }}</strong>
                        </span>
                    @endif

                    <button type="submit" class="btn btn-primary">Submit</button>
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#star-rating').rating({
                hoverOnClear: false,
                theme: 'krajee-svg'
            });

            $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            $.fn.filepond.setDefaults({
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/*'],
            });

            $('#photos').filepond({
                allowMultiple: true,
                storeAsFile: true,
            });
        });
    </script>
@stop