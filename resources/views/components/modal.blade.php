@props([
	'id' => '',
	'class' => 'modal-lg',
	'title' => '',
])

<div id="{{ $id }}" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div {{ $attributes->merge(['class' => 'modal-dialog '. $class]) }}>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">{{ __($title) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
	            <div class="row">
	            	{{ $slot }}
	            </div>
	        </div>
        </div>
     </div>
</div>