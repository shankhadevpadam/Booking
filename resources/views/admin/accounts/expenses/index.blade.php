@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Moment', true)

@section('plugins.Pikaday', true)

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="">
                @csrf

                <x-adminlte-card>
                    <div class="row">
                        <div class="col-md-2">
                            <x-adminlte-input label="Date" name="date" class="date" />
                        </div>

                        <div class="col-md-2">
                            <x-adminlte-input name="amount" label="Amount">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <select name="" id="">
                                            <option value="">USD</option>
                                            <option value="">EURO</option>
                                        </select>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="col-md-2">
                            <x-adminlte-select label="Vendor" name="vendor" id="vendor">
                                <option value="">Transportation</option>
                                <option value="">Flight</option>
                                <option value="">Hotel</option>
                            </x-adminlte-select>
        
                            <div id="new-category" class="form-group d-none">
                                <label for="new-category">New Category</label>
                                <div class="input-group">
                                    <input name="new_category" value="" class="form-control">
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-2">
                            <x-adminlte-select label="Expenses Account" name="expenses" id="expenses">
                                <option value="">Transportation</option>
                                <option value="">Flight</option>
                                <option value="">Hotel</option>
                            </x-adminlte-select>
        
                            <div id="new-category" class="form-group d-none">
                                <label for="new-category">New Category</label>
                                <div class="input-group">
                                    <input name="new_category" value="" class="form-control">
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-2">
                            <x-adminlte-select label="Trip Expenses" name="trip_expenses" id="trip_expenses">
                                <option value="">Transportation</option>
                                <option value="">Flight</option>
                                <option value="">Hotel</option>
                            </x-adminlte-select>
        
                            <div id="new-category" class="form-group d-none">
                                <label for="new-category">New Category</label>
                                <div class="input-group">
                                    <input name="new_category" value="" class="form-control">
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-2">
                            <x-adminlte-select label="Guide Expenses" name="guide_expenses" id="guide_expenses">
                                <option value="">Transportation</option>
                                <option value="">Flight</option>
                                <option value="">Hotel</option>
                            </x-adminlte-select>
        
                            <div id="new-category" class="form-group d-none">
                                <label for="new-category">New Category</label>
                                <div class="input-group">
                                    <input name="new_category" value="" class="form-control">
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-4">
                            <x-adminlte-textarea label="Notes" name="notes" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </x-adminlte-card>
            </form>

            <div class="modal fade" id="add-new-category" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addNewCategoryModalLabel" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewCategoryModalLabel">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="category">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        new Pikaday({ 
            field: document.querySelector('.date'),
            format: 'YYYY-MM-DD',
            minDate: new Date(),
            setDefaultDate: true,
            defaultDate: new Date() 
        });

        $(document).ready(function () {
            $('#vendor').select2()
                .on('select2:open', () => {
                $(".select2-results:not(:has(a))").append('<a href="#" id="add-new" style="padding: 6px;height: 20px;display: inline-table;">Create new item +</a>');
            })

            $('body').on('click', '#add-new', function() {
                $('#add-new-category').modal('show');

                $('#vendor').select2('close');
            })
        })
    </script>
@stop