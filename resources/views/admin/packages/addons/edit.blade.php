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
        	<a class="btn btn-primary" href="{{ route('admin.packages.addons.index', ['package' => $packageId]) }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.packages.addons.update', ['package' => $packageId, 'addon' => $addon->id]) }}" enctype="multipart/form-data">
                @csrf

                @method('PATCH')

                <x-adminlte-card>
                    <x-adminlte-select2 label="Package" name="addon_package_id">
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}" @selected(old('addon_package_id', $addon->addon_package_id) == $package->id)>{{ $package->name }}</option>  
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Price" name="price" :value="old('price', $addon->price)" />

                    <x-adminlte-select2 label="Number of Days" name="number_of_days">
                        @foreach (range(1, 20) as $value)
                            <option value="{{ $value }}" @selected(old('number_of_days', $addon->number_of_days) == $value)>{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-select2 label="Discount Type" name="discount_type">
                        <option value="">Please select discount type</option>
                        @foreach($discountTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_type', $addon->discount_type?->value) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Discount Amount / Percentage" name="discount_amount" :value="old('discount_amount', $addon->discount_amount)" />

                    <x-adminlte-input label="Package URL" name="url" :value="old('url', $addon->url)" />

                    <div class="form-group">
                        <label for="file" class="d-block">{{ __('Cover Picture') }}</label>
                        <input type="file" name="cover_picture" id="cover_picture" />

                        @if ($errors->has('cover_picture'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('cover_picture') }}</strong>
                            </span>
                        @endif

                        <div class="review-image-container">
                            @if($addon->getMedia('cover_picture')->isNotEmpty())
                                <div class="review-image">
                                    {{ $addon->getFirstMedia('cover_picture')->img('thumbnail') }}
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
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            $.fn.filepond.setDefaults({
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/*'],
            });

            $('#cover_picture').filepond({
                allowMultiple: false,
                storeAsFile: true,
            });
        })
    </script>
@endsection