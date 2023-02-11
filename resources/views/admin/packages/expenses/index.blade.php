@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Datepicker', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    @foreach (range(1, 20) as $i)
                        <li class="page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                    @endforeach
                </ul>
              </nav>
        </div>

        <div class="col-md-6 col-sm-12">
            <x-adminlte-card title="Company Expenses">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-link active" id="nav-transportation-tab" data-toggle="tab" href="#nav-transportation" role="tab" aria-controls="nav-transportation" aria-selected="true">Transportation</a>
                      <a class="nav-link" id="nav-permit-tab" data-toggle="tab" href="#nav-permit" role="tab" aria-controls="nav-permit" aria-selected="false">Permit</a>
                      <a class="nav-link" id="nav-dinner-with-client-tab" data-toggle="tab" href="#nav-dinner-with-client" role="tab" aria-controls="nav-dinner-with-client" aria-selected="false">Dinner With Client</a>
                      <a class="nav-link" id="nav-hotel-tab" data-toggle="tab" href="#nav-hotel" role="tab" aria-controls="nav-city-hotel" aria-selected="false">Hotel</a>
                    </div>
                </nav>
                
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-transportation" role="tabpanel" aria-labelledby="nav-transportation-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Airport Arrival" name="airport_arrival" placeholder="0.00">
                                    <x-slot name="infoSlot">
                                        <div class="btn-group">
                                            <span class="text-sm text-info cursor-pointer" data-toggle="dropdown" aria-expanded="false">Choose option</span>
                                            <div class="dropdown-menu">
                                              <a class="dropdown-item" href="#">Action</a>
                                              <a class="dropdown-item" href="#">Another action</a>
                                              <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Airport Departure" name="airport_departure" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Domestic Arrival" name="domestic_arrival" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Domestic Departure" name="domestic_departure" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Private Transport" name="private_transport" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Public Transport" name="public_transport" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Guide Flight" name="guide_flight" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Client Flight" name="client_flight" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Miscellaneous" name="miscellaneous" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-permit" role="tabpanel" aria-labelledby="nav-permit-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Restricted Permit" name="restricted_permit" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="ACAP" name="acap" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="MCAP" name="mcap" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="TIMS" name="tims" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Government Tea" name="government_tea" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-dinner-with-client" role="tabpanel" aria-labelledby="nav-dinner-with-client-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Restaurant Name" name="restaurant_name" />
                            </div>
                            
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of People" name="number_of_people" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Amount" name="amount" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-hotel" role="tabpanel" aria-labelledby="nav-hotel-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Hotel Name" name="hotel_name" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Days" name="number_of_days" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Rooms" name="number_of_rooms" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of People" name="number_of_people" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Per day Cost" name="per_day_cost" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>

        <div class="col-md-6 col-sm-12">
            <x-adminlte-card title="Guide Expenses">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-link active" id="nav-guide-tab" data-toggle="tab" href="#nav-guide" role="tab" aria-controls="nav-guide" aria-selected="true">Guide</a>
                      <a class="nav-link" id="nav-porter-tab" data-toggle="tab" href="#nav-porter" role="tab" aria-controls="nav-porter" aria-selected="false">Porter</a>
                      <a class="nav-link" id="nav-guide-transportation-tab" data-toggle="tab" href="#nav-guide-transportation" role="tab" aria-controls="nav-guide-transportation" aria-selected="false">Transportation</a>
                      <a class="nav-link" id="nav-guide-permit-tab" data-toggle="tab" href="#nav-guide-permit" role="tab" aria-controls="nav-guide-permit" aria-selected="false">Permit</a>
                      <a class="nav-link" id="nav-accomodation-tab" data-toggle="tab" href="#nav-accomodation" role="tab" aria-controls="nav-accomodation" aria-selected="false">Accomodation</a>
                      <a class="nav-link" id="nav-full-board-package-tab" data-toggle="tab" href="#nav-full-board-package" role="tab" aria-controls="nav-city-full-board-package" aria-selected="false">Full Board Package</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-guide" role="tabpanel" aria-labelledby="nav-guide-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Guide" name="number_of_guide" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Days" name="number_of_days" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Per Day Cost" name="per_day_cost" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-porter" role="tabpanel" aria-labelledby="nav-porter-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Porter" name="number_of_porter" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Days" name="number_of_days" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Per Day Cost" name="per_day_cost" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-guide-transportation" role="tabpanel" aria-labelledby="nav-guide-transportation-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Public Transport" name="public_transport" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Pickup Cost" name="pickup_cost" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Drop Cost" name="drop_cost" placeholder="0.00" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Miscellaneous" name="miscellaneous" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-guide-permit" role="tabpanel" aria-labelledby="nav-guide-permit-tab">
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="National Park Permit" name="national_park_permit" placeholder="0.00" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Conservation Area Permit" name="conservation_area_permit" placeholder="0.00" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-accomodation" role="tabpanel" aria-labelledby="nav-accomodation-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of People" name="number_of_people" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Days" name="number_of_days" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Per Day Cost" name="per_day_cost" placeholder="0" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-full-board-package" role="tabpanel" aria-labelledby="nav-full-board-package-tab">
                        <div class="row mt-3">
                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of People" name="number_of_people" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Number of Days" name="number_of_days" placeholder="0" />
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <x-adminlte-input label="Per Day Cost" name="per_day_cost" placeholder="0" />
                            </div>

                            <div class="col-md-12">
                                <x-adminlte-textarea label="Remarks" rows=5 name="remarks" />
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>

        <div class="col-sm-12 mb-2">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
@stop

@section('js')
    @include('admin.includes.scripts')

    <script type="text/javascript">
       
    </script>
@stop