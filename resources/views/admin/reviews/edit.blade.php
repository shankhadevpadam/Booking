@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Rating', true)

@section('plugins.Filepond', true)

@section('plugins.FlatPickr', true)

@section('plugins.Select2', true)

@section('plugins.SummerNote', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.reviews.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <form role="form" action="{{ route('admin.reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PATCH')

                <x-adminlte-card>
                    <x-adminlte-select2 label="Package" name="package_id">
                        <option value="">Select package</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}" @selected(old('package_id', $package->id) == $review->package_id)>{{ $package->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Title" name="title" :value="$review->title" autocomplete="off" />

                    @php
                        $configSummerNote = [
                            "height" => "250",
                            "toolbar" => [
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link']],
                                ['view', ['fullscreen', 'codeview', 'help']]
                            ],
                        ]
                    @endphp

                    <x-adminlte-text-editor label="Your Review" id="review" name="review" :config="$configSummerNote">
                        {{ $review->review }}
                    </x-adminlte-text-editor>

                    <x-adminlte-input label="Review Date" class="datepicker" name="review_date" :value="$review->review_date" autocomplete="off" />

                    <div class="form-group">
                        <label for="user_id">Client</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="{{ $review->user_id }}" selected="selected">{{ $review->user->name }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="guide_id">Guide</label>
                        <select name="guide_id" id="guide_id" class="form-control">
                            <option value="{{ $review->guide_id }}" selected="selected">{{ $review->guide->name }}</option>
                        </select>
                        <a id="reset-guide" class="text-sm" href="javascript:;">Reset</a>
                    </div>

                    <div class="form-group">
                        <label for="file" class="d-block">{{ __('Tour Photos') }}</label>
                        <input type="file" name="photos[]" id="photos" multiple />
                    </div>

                    @foreach ($errors->get('photos.*') as $message)
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message[0] }}</strong>
                        </span>
                    @endforeach

                    <div class="review-image-container">
                        @if($review->getMedia()->isNotEmpty())
                            @foreach ($review->getMedia() as $media)
                                <div id="media-{{ $media->id }}" class="review-image">
                                    <span class="tools-delete" onclick="deleteMedia({{ $media->id }})">
                                        <i class="far fa-times-circle"></i>
                                    </span>
                                    <img src="{{ $media->getUrl('thumbnail') }}" />
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <input id="star-rating" name="rating" class="kv-ltr-theme-fas-star rating-loading" value="{{ $review->rating }}" data-min="0" data-max="5" data-step="0.5" data-size="sm">
                    </div>

                    @if ($errors->first('rating'))
                        <span class="invalid-feedback d-block mb-2" role="alert">
                            <strong>{{ $errors->first('rating') }}</strong>
                        </span>
                    @endif

                    <x-adminlte-select2 label="Published Status" name="is_published">
                        <option value="0" @selected(old('is_published', $review) == 0)>Pending</option>
                        <option value="1" @selected(old('is_published', $review) == 1)>Published</option>
                    </x-adminlte-select2>

                    <button type="submit" class="btn btn-primary">Update</button>

                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true,
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#star-rating').rating({
                hoverOnClear: false,
                theme: 'krajee-svg'
            });

            $('#review').summernote({
                tabsize: 2,
                height: 200
            });

            $('#user_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose the client',
                dataType: 'json',
                type: 'GET',
                delay: 250,
                ajax: {
                    url: '{{ route('admin.users.users', ['role' => 'Client']) }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results:  $.map(data, function (item) {
                              return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                      };
                    },
                    cache: true
                }
            });

            $('#guide_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose the guide',
                allowClear: true,
                dataType: 'json',
                type: 'GET',
                delay: 250,
                ajax: {
                    url: '{{ route('admin.users.users', ['role' => 'Guide']) }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results:  $.map(data, function (item) {
                              return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                      };
                    },
                    cache: true
                }
            });

            $('#reset-guide').click(function () {
                $('#guide_id').empty().trigger('change');
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

        function deleteMedia(id) {
            $.ajax({
                method: 'POST',
                url: '{{ route("admin.delete.media") }}',
                data: {id: id},
                success: function (response) {
                    if (response.success) {
                        $('#media-' + id).fadeOut(300, function () {
                            $(this).remove();
                        })
                    }
                }
            })
        }
    </script>
@stop