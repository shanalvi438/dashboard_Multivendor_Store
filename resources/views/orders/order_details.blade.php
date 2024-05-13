@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
@section('main-content')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
<style>
    .dropdown {
        position: relative;
    }

    .col-md-2 {
        max-width: 20%;
    }

    .dropdown-menu {
        position: absolute;
        background-color: #fff;
        border: 1px solid #ced4da;
        padding: 8px;
        max-height: 250px;
        max-width: 300px;
        overflow-y: auto;
        border-radius: 10px;
    }

    .dropdown-options {
        margin-top: 30px;
    }

    .dropdown-options label {
        display: block;
        margin-bottom: 5px;
    }

    .option-text {
        margin-left: 5px;
        font-size: 12px;
    }

    input:focus {
        border-color: #ced4da;
        outline: none;
    }

    .datetimerange {
        border-color: #ccc !important;
        max-width: 300px;
        border: 1px solid;
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 50px;
        padding-left: 52px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }

    .content-box {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .slider {
        position: relative;
        width: 800px;
        height: 5px;
        margin-left: 10px;
        display: flex;
    }

    .slider label {
        font-size: 28px;
        font-weight: 600;
        font-family: Open Sans;
        padding-left: 30px;
        color: black;
    }

    .slider input[type="range"] {
        width: 300px;
        height: 4px;
        background: black;
        border: none;
        outline: none;
    }

    .range input {
        margin-top: 10%;
        -webkit-transform: rotate(40deg);
        -moz-transform: rotate(40deg);
        -o-transform: rotate(40deg);
        transform: rotate(270deg);
        max-height: 5%;
    }

    .p {
        text-align: left;
        text-color: rgb(113, 107, 107);
        font-weight: 300;
        font-size: 18px;
    }

    .dropdown-toggle {
        display: flex;
        max-width: 300px;
        padding-right: 10px;
        padding-left: 10px;
        background-color: #f8f9fa;
        border: 2px solid #e2eaf1;
        cursor: pointer;
        padding-top: 0px;
        padding-bottom: 0px;
        overflow: hidden;
        border-radius: 10px;
    }

    .text-left {
        margin-right: auto;
    }

    #quantity {
        max-width: 300px;
        padding-right: 40px;
        padding-left: 40px;
        background-color: #f8f9fa;
        border: 3px solid #e2eaf1;
        cursor: pointer;
        padding-top: 12px;
        padding-bottom: 12px;
        overflow: hidden;
    }

    .input-bar {
        background-color: #f8f9fa;
        border: 2px solid #e2eaf1;
    }



    .btn-primary {
        background-color: rgb(46, 46, 226);
        color: white;
        transition: background-color 0.7s, color 0.7s;
    }

    .btn-primary:hover {
        background-color: white;
        color: rgb(46, 46, 226);
    }

    .selected-option {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 5px;
        background-color: #f0f0f0;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .remove-option {
        cursor: pointer;
    }
</style>

    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-3" style="margin-left: 5px;">
                <div class="content-box d-flex">
                    <form action="{{ route('order_details') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                </div>
            </div>
            <form action="{{ route('order_details') }}" method="GET">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-2">
                        <div class="dropdown" id="order_idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Order ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="order_idSearchInput" placeholder="Search..."
                                    oninput="filterorder_id()">
                                <div class="dropdown-options" id="order_idOptions">
                                    <label class="order_idFilter" for="order_idFilter">
                                        <input type="checkbox" id="selectAllorder_id" class="order_idFilter">
                                        <span class="option-text" name="order_id[]">Select All</span>
                                    </label>
                                    <div id="selectedorder_idOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="order_idFilter">
                                            <input type="checkbox" value="{{ $orders->order_id }}" name="order_id[]">
                                            <span class="option-text" name="order_id[]">{{ $orders->order_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedorder_idList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Parcel ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="idSearchInput" placeholder="Search..."
                                    oninput="filterid()">
                                <div class="dropdown-options" id="idOptions">
                                    <label class="idFilter" for="idFilter">
                                        <input type="checkbox" id="selectAllid" class="idFilter">
                                        <span class="option-text" name="id[]">Select All</span>
                                    </label>
                                    <div id="selectedidOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="idFilter">
                                            <input type="checkbox" value="{{ $orders->id }}" name="id[]">
                                            <span class="option-text" name="id">{{ $orders->id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedidList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Product Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="nameSearchInput" placeholder="Search..."
                                    oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($data as $value => $orders)
                                    <label class="nameFilter">
                                        <input type="checkbox" name="name[]" value="{{ $orders->product->name ?? null }}">
                                        <span class="option-text" name="name[]">{{ $orders->product->name ?? null }}</span>
                                    </label>
                                @endforeach
                                </div>
                                <div id="selectednameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="model_noDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Model No</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <input type="text" id="model_noSearchInput" placeholder="Search..."
                                    oninput="filtermodel_no()">
                                <div class="dropdown-options" id="model_noOptions">
                                    <label class="model_noFilter" for="model_noFilter">
                                        <input type="checkbox" id="selectAllmodel_no" class="model_noFilter">
                                        <span class="option-text" name="model_no[]">Select All</span>
                                    </label>
                                    <div id="selectedmodel_noOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="model_noFilter">
                                            <input type="checkbox" name="model_no[]" value="{{ $orders->product->model_no ?? null }}">
                                            <span class="option-text" name="model_no[]">{{ $orders->product->model_no ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedmodel_noList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="skuDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">SKU#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <input type="text" id="skuSearchInput" placeholder="Search..."
                                    oninput="filtersku()">
                                <div class="dropdown-options" id="skuOptions">
                                    <label class="skuFilter" for="skuFilter">
                                        <input type="checkbox" id="selectAllsku" class="skuFilter">
                                        <span class="option-text" name="sku[]">Select All</span>
                                    </label>
                                    <div id="selectedskuOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="skuFilter">
                                            <input type="checkbox" name="sku[]" value="{{ $orders->product->sku ?? null }}">
                                            <span class="option-text" name="sku[]">{{ $orders->product->sku ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedskuList"></div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton6" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Supplier Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                <input type="text" id="nameSearchInput" placeholder="Search..."
                                    oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($data as $value => $orders)
                                    <label class="nameFilter">
                                        <input type="checkbox" name="name[]" value="{{ $orders->vendor->name ?? null }}">
                                        <span class="option-text" name="name[]">{{ $orders->vendor->name ?? null }}</span>
                                    </label>
                                @endforeach
                                </div>
                                <div id="selectednameList"></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-2">
                        <div class="dropdown" id="customer_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton6" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                <input type="text" id="customer_nameSearchInput" placeholder="Search..."
                                    oninput="filtercustomer_name()">
                                <div class="dropdown-options" id="customer_nameOptions">
                                    <label class="customer_nameFilter" for="customer_nameFilter">
                                        <input type="checkbox" id="selectAllcustomer_name" class="customer_nameFilter">
                                        <span class="option-text" name="customer_name[]">Select All</span>
                                    </label>
                                    <div id="selectedcustomer_nameOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="customer_nameFilter">
                                            <input type="checkbox" name="customer_name[]" value="{{ $orders->order->first_name ?? null }} {{ $orders->order->last_name ?? null }}">
                                            <span class="option-text">{{ $orders->order->first_name ?? null }}
                                                {{ $orders->order->last_name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcustomer_nameList"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" style="margin-top: 5px;">

                    <div class="col-md-2">
                        <div class="dropdown" id="status">
                            <div class="dropdown-toggle" id="dropdownMenuButton7" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Current Status</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                <input type="text" id="statusSearchInput" placeholder="Search..."  oninput="filterstatus()">
                                <div class="dropdown-options" id="statusOptions">
                                    <label class="statusFilter" for="statusFilter">
                                        <input type="checkbox" id="selectAllstatus" class="statusFilter">
                                        <span class="option-text" name="status[]">Select All</span>
                                    </label>
                                    <div id="selectedstatusOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="statusFilter">
                                            <input type="checkbox" name="status[]" value="{{ $orders->status }}" id="status_{{ $loop->index }}">
                                            <span class="option-text" name="status[]">
                                                @if ($orders->customer_cancel_status == 'Canceled')
                                                    <span class="badge-for-light">{{ $orders->status }}</span><br>
                                                @elseif ($orders->status == 'Canceled')
                                                    <span class="badge-for-light">{{ $orders->status }}</span><br>
                                                @else
                                                    <span class="badge-for-success">{{ $orders->status }}</span><br>
                                                @endif
                                                {{ $orders->updated_at }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedstatusList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="slider"><b>Price:</b>
                            <label for="fader1"></label><input type="range" min="0" max="100"
                                value="0" id="fader1" step="20" list="volsettings"
                                name="p_price[]">
                            <datalist id="volsettings">
                                <option>0</option>
                                <option>20</option>
                                <option>40</option>
                                <option>60</option>
                                <option>80</option>
                                <option>100</option>
                            </datalist>
                        </div>
                        <div class="content-box d-flex" style="margin-top: 10px;">
                            <div class="input-bar d-flex" style="margin-left: 80px;">
                                <label for="priceInput1">$:</label>
                                <input type="number" id="priceInput1" min="0" max="100000" value="0"
                                    name="p_price[]">
                            </div>
                            <div id="rangeValue1" style="margin-left: 200px;">0</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>
            </form>

        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @php
        $auth = app('Illuminate\Contracts\Auth\Guard');
    @endphp
    <div class="breadcrumb">
        <h1>All Parcels</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Parcels</h4>

                {{-- <p>All Orders list is below.</p> --}}

                <div class="table-responsive" >
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%;">
                        <thead>
                            <th>Order Id#</th>
                            <th>Parcel Id #</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Model No</th>
                            <th>SKU</th>
                            <th>Supplier</th>
                            <th>Price</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th style="width:100px;">Customer Status</th>
                            <th style="width:100px;">Refund Detail</th>
                            <th>Current Status</th>
                            <th>Update Status</th>
                            <th>View Status</th>

                        </thead>
                        <tbody>
                            @foreach ($data as $value => $orders)
                                <tr>
                                    <td>{{ $orders->order_id }}</td>
                                    <td>{{ $orders->id }}</td>
                                    <td>
                                        <img src="{{ $orders->product->url ?? null }}  " width="50" height="50"
                                            loading="lazy" alt="Placeholder Image">
                                    </td>
                                    <td> {{ $orders->product->name ?? null }}</td>
                                    <td>{{ $orders->product->model_no ?? null }}</td>
                                    <td>{{ $orders->product->sku ?? null }}</td>
                                    <td>{{ $orders->vendor->name ?? null }}</td>
                                    <td>${{ $orders->p_price ?? null }}</td>
                                    {{-- <td style="width:250px">
                                        <span style=" font-weight: 600; ">Name:
                                            {{ $orders->product->name ?? null }} </span> <br>
                                        <span style=" font-weight: 600; ">Model #:
                                        </span>{{ $orders->product->model_no ?? null }}<br>
                                        <span style=" font-weight: 600; ">SKU:
                                        </span>{{ $orders->product->sku ?? null }}<br>
                                        <span style=" font-weight: 600; ">Supplier:
                                        </span>{{ $orders->vendor->name ?? null }}<br>
                                        <span style=" font-weight: 600; ">Price:
                                        </span>${{ $orders->p_price ?? null }}<br>
                                    </td> --}}

                                    {{-- <td>{{ $orders->vendor->name ?? null }}</td> --}}
                                    <td>{{ $orders->created_at }}</td>
                                    <td>{{ $orders->order->first_name ?? null }} {{ $orders->order->last_name ?? null }}
                                    </td>
                                    <td style="width:110px">
                                        @if ($orders->customer_cancel_status == 'Canceled')
                                            <span class="badge-for-cancel">{{ $orders->customer_cancel_status }}
                                            </span><br>{{ $orders->customer_cancel_time }}
                                            <br>
                                            <span style=" font-weight: 700; ">Type:
                                            </span>Customer <br>
                                            <span style=" font-weight: 700; ">Reason:
                                            </span>{{ $orders->customer_cancel_reason }}
                                        @else
                                            {{-- @if ($orders->status == 'Canceled')
                                        <span class="badge-for-success" selected
                                                disabled>{{ $orders->status }}</span><br>
                                            {{ $orders->updated_at }} <br>
                                            <span style=" font-weight: 700; ">Type:
                                            </span>Supplier
                                        @else

                                        <span class="badge-for-success" selected
                                        disabled>{{ $orders->status }}</span><br>
                                    {{ $orders->updated_at }}
                                        @endif
                                             --}}
                                        @endif


                                    </td>
                                    <td>
                                        @if ($orders->customer_cancel_status == 'Canceled')
                                            @if ($orders->refund_status != 1)
                                                <span class="badge-for-timer" id="timer{{ $loop->iteration }}"></span>
                                            @else
                                                <span class="badge-for-timer">Refunded</span>
                                            @endif
                                            <br>
                                            <br>




                                            @if ($auth->check() && $auth->user()->role == 'Admin')
                                                <form id="orderForm1{{ $orders->id }}"
                                                    action="{{ route('refundedStatus', ['id' => $orders->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button onclick="updaterefundStatus('{{ $orders->id }}')"
                                                        onclick="updaterefundStatus($orders->id)"
                                                        style="font-size: smaller;"
                                                        class="btn btn-outline-secondary"><span>Click
                                                            Refunded</span></button>
                                                </form>
                                            @endif
                                        @elseif ($orders->status == 'Canceled')
                                            @if ($orders->refund_status != 1)
                                                <span class="badge-for-timer" id="timer{{ $loop->iteration }}"></span>
                                            @else
                                                <span class="badge-for-timer">Refunded</span>
                                            @endif
                                            <br>
                                            <br>


                                            @if ($auth->check() && $auth->user()->role == 'Admin')
                                                <form id="orderForm1{{ $orders->id }}"
                                                    action="{{ route('refundedStatus', ['id' => $orders->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button onclick="updaterefundStatus('{{ $orders->id }}')"
                                                        style="font-size: smaller;"
                                                        class="btn btn-outline-secondary"><span>Click
                                                            Refunded</span></button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="width:110px">
                                        @if ($orders->customer_cancel_status == 'Canceled')
                                            <span class="badge-for-light" selected
                                                disabled>{{ $orders->status }}</span><br>
                                            {{ $orders->updated_at }} <br>
                                        @elseif ($orders->status == 'Canceled')
                                            <span class="badge-for-light" selected
                                                disabled>{{ $orders->status }}</span><br>
                                            {{ $orders->updated_at }} <br>
                                        @else
                                            <span class="badge-for-success" selected
                                                disabled>{{ $orders->status }}</span><br>
                                            {{ $orders->updated_at }}
                                        @endif
                                    </td>
                                    @if ($orders->customer_cancel_status == 'Canceled')
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $orders->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    {{ $orders->status }}
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $orders->id }}">

                                                    <a class="dropdown-item" href="#">Can't Update More Status</a>

                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <form method="POST" id="orderForm{{ $orders->id }}"
                                                action="{{ route('order_details_status', ['id' => $orders->id]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton{{ $orders->id }}" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        {{ $orders->status }}
                                                    </button>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $orders->id }}">
                                                        @php
                                                            $isInProcess = false;
                                                            $isInPackaging = false;
                                                            $isInOutForDelivery = false;
                                                            $isInDelivered = false;
                                                            $isInFailedToDeliver = false;
                                                            $isInCanceled = false;
                                                            foreach ($orders->order_tracker as $tracker) {
                                                                if ($tracker->status == 'In Process') {
                                                                    $isInProcess = true;
                                                                }
                                                                if ($tracker->status == 'Packaging') {
                                                                    $isInPackaging = true;
                                                                }
                                                                if ($tracker->status == 'Out For Delivery') {
                                                                    $isInOutForDelivery = true;
                                                                }
                                                                if ($tracker->status == 'Delivered') {
                                                                    $isInDelivered = true;
                                                                }
                                                                if ($tracker->status == 'Failed to Deliver') {
                                                                    $isInFailedToDeliver = true;
                                                                }
                                                                if ($tracker->status == 'Canceled') {
                                                                    $isInProcess = true;
                                                                    $isInPackaging = true;
                                                                    $isInOutForDelivery = true;
                                                                    $isInDelivered = true;
                                                                    $isInFailedToDeliver = true;
                                                                    $isInCanceled = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if (!$isInProcess)
                                                            <a class="dropdown-item"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'In Process')">In
                                                                Process</a>
                                                        @endif
                                                        @if (!$isInPackaging)
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'Packaging')">Packaging</a>
                                                        @endif
                                                        @if (!$isInOutForDelivery)
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'Out For Delivery')">Out
                                                                of Delivery</a>
                                                        @endif
                                                        @if (!$isInDelivered)
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'Delivered')">Delivered</a>
                                                        @endif
                                                        @if (!$isInFailedToDeliver)
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'Failed to Deliver')">Failed
                                                                to Deliver</a>
                                                        @endif
                                                        @if (!$isInCanceled)
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateOrderStatus('{{ $orders->id }}', 'Canceled')">Canceled</a>
                                                        @else
                                                            <a class="dropdown-item" href="#">Can't Update More
                                                                Status</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="status" id="status{{ $orders->id }}"
                                                    value="{{ $orders->status }}">
                                            </form>

                                        </td>
                                    @endif

                                    <td>
                                        <div class="d-flex 2">
                                            <a href="{{ url('get_order_detail_status/' . $orders->id) }}"
                                                class="btn btn-outline-secondary"><i class="nav-icon i-Eye "></i></a>

                                        </div>
                                    </td>
                                    </form>

                                    <script>
                                        // Get the cancel time from PHP and convert it to milliseconds
                                        var cancelTime{{ $loop->iteration }} = new Date("{{ $orders->updated_at }}").getTime();

                                        // Calculate 15 days in milliseconds
                                        var fifteenDaysInMillis{{ $loop->iteration }} = 15 * 24 * 60 * 60 * 1000;

                                        // Calculate the target time (15 days after cancel time)
                                        var targetTime{{ $loop->iteration }} = cancelTime{{ $loop->iteration }} +
                                            fifteenDaysInMillis{{ $loop->iteration }};

                                        // Update the timer every second
                                        var timerInterval{{ $loop->iteration }} = setInterval(function() {
                                            // Get the current time
                                            var now = new Date().getTime();

                                            // Calculate the remaining time
                                            var remainingTime = targetTime{{ $loop->iteration }} - now;

                                            // Check if the timer has expired
                                            if (remainingTime <= 0) {
                                                clearInterval(timerInterval{{ $loop->iteration }});
                                                document.getElementById("timer{{ $loop->iteration }}").innerHTML = "Expired";
                                            } else {
                                                // Calculate days, hours, minutes, and seconds
                                                var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                                                var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                                                // Update the timer element with the remaining time
                                                document.getElementById("timer{{ $loop->iteration }}").innerHTML = days + "d " + hours + "h " +
                                                    minutes + "m " + seconds + "s ";
                                            }
                                        }, 1000);
                                    </script>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Order Id#</th>
                                <th>Parcel Id #</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Model No</th>
                                <th>SKU</th>
                                <th>Supplier</th>
                                <th>Price</th>
                                {{-- <th>Vendor Name</th> --}}
                                <th>Order Date</th>
                                <th>Customer Name</th>
                                <th>Customer Status</th>
                                <th style="width:100px;">Refund Detail</th>
                                <th style=" width: 60px ">Current Status</th>
                                <th>Update Status</th>
                                <th>View Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
           document.addEventListener('DOMContentLoaded', function() {
                var slider1 = document.getElementById("fader1");
                var input1 = document.getElementById("priceInput1");
                var rangeValue1 = document.getElementById("rangeValue1");

                input1.addEventListener("input", function() {
                    var value = parseInt(this.value);
                    if (!isNaN(value) && value >= 0 && value <= 100000) {
                        slider1.value = value;
                        rangeValue1.textContent = value;
                    }
                });

                slider1.addEventListener("input", function() {
                    input1.value = this.value;
                    rangeValue1.textContent = this.value;
                });
            });

             // for option with cross icon == Saliha
        document.addEventListener('DOMContentLoaded', function() {
            let selectedorder_idOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedorder_idOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedorder_idOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedorder_idOptions = selectedorder_idOptions
                            .filter(item =>
                                item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedorder_idOptions',
                            selectedorder_idOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedorder_idOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.order_idFilter input[type="checkbox"]').forEach(
                checkbox => {
                    checkbox.addEventListener('change', function() {
                        const optionText = this.nextElementSibling.textContent;
                        if (this.checked && !selectedorder_idOptions.includes(
                                optionText)) {
                            selectedorder_idOptions.push(optionText);
                        } else {
                            selectedorder_idOptions = selectedorder_idOptions
                                .filter(item =>
                                    item !==
                                    optionText);
                        }
                        updateSelectedOptions();
                        saveSelectedOptions('selectedorder_idOptions',
                            selectedorder_idOptions);
                    });
                });

            document.getElementById('order_idDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('order_idDropdown').addEventListener('submit', function(
                event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedorder_idOptions',
                    selectedorder_idOptions);
                $('#order_idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedorder_idOptions');
        });

        function filterorder_id() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('order_idSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('order_idOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectedidOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedidOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedidOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedidOptions = selectedidOptions
                            .filter(item =>
                                item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedidOptions',
                            selectedidOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedidOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.idFilter input[type="checkbox"]').forEach(
                checkbox => {
                    checkbox.addEventListener('change', function() {
                        const optionText = this.nextElementSibling.textContent;
                        if (this.checked && !selectedidOptions.includes(
                                optionText)) {
                            selectedidOptions.push(optionText);
                        } else {
                            selectedidOptions = selectedidOptions
                                .filter(item =>
                                    item !==
                                    optionText);
                        }
                        updateSelectedOptions();
                        saveSelectedOptions('selectedidOptions',
                            selectedidOptions);
                    });
                });

            document.getElementById('idDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('idDropdown').addEventListener('submit', function(
                event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedidOptions',
                    selectedidOptions);
                $('#idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedidOptions');
        });

        function filterid() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('idSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('idOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectednameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectednameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectednameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectednameOptions = selectednameOptions.filter(
                            item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectednameOptions',
                            selectednameOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectednameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectednameOptions.includes(
                            optionText)) {
                        selectednameOptions.push(optionText);
                    } else {
                        selectednameOptions = selectednameOptions.filter(
                            item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectednameOptions',
                        selectednameOptions);
                });
            });

            document.getElementById('nameDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectednameOptions', selectednameOptions);
                $('#nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectednameOptions');
        });

        function filtername() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('nameOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectedmodel_noOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedmodel_noOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedmodel_noOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedmodel_noOptions = selectedmodel_noOptions.filter(
                            item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedmodel_noOptions',
                            selectedmodel_noOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedmodel_noOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.model_noFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedmodel_noOptions.includes(
                            optionText)) {
                        selectedmodel_noOptions.push(optionText);
                    } else {
                        selectedmodel_noOptions = selectedmodel_noOptions.filter(
                            item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedmodel_noOptions',
                        selectedmodel_noOptions);
                });
            });

            document.getElementById('model_noDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('model_noDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedmodel_noOptions', selectedmodel_noOptions);
                $('#model_noDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedmodel_noOptions');
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedskuOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedskuOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedskuOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedskuOptions = selectedskuOptions.filter(
                            item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedskuOptions',
                            selectedskuOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedskuOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.skuFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedskuOptions.includes(
                            optionText)) {
                        selectedskuOptions.push(optionText);
                    } else {
                        selectedskuOptions = selectedskuOptions.filter(
                            item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedskuOptions',
                        selectedskuOptions);
                });
            });

            document.getElementById('skuDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('skuDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedskuOptions', selectedskuOptions);
                $('#skuDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedskuOptions');
        });

        function filtermodel_no() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('model_noSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('model_noOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        function filtersku() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('skuSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('skuOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectedcustomer_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedcustomer_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedcustomer_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedcustomer_nameOptions = selectedcustomer_nameOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedcustomer_nameOptions',
                            selectedcustomer_nameOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedcustomer_nameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.customer_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedcustomer_nameOptions.includes(optionText)) {
                        selectedcustomer_nameOptions.push(optionText);
                    } else {
                        selectedcustomer_nameOptions = selectedcustomer_nameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcustomer_nameOptions',
                        selectedcustomer_nameOptions);
                });
            });

            document.getElementById('customer_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('customer_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedcustomer_nameOptions', selectedcustomer_nameOptions);
                $('#customer_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedcustomer_nameOptions');
        });

        //customer name === Saliha

        function filtercustomer_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('customer_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('customer_nameOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

        // status === Saliha

        document.addEventListener('DOMContentLoaded', function() {
            let selectedstatusOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedstatusOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedstatusOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedstatusOptions = selectedstatusOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedstatusOptions',
                            selectedstatusOptions);
                    });

                    selectedOptionDiv.appendChild(removeIcon);
                    selectedOptionsDiv.appendChild(selectedOptionDiv);
                });
            }

            function saveSelectedOptions(key, selectedOptions) {
                localStorage.setItem(key, JSON.stringify(selectedOptions));
            }

            function loadSelectedOptions(key) {
                const savedOptions = localStorage.getItem(key);
                if (savedOptions) {
                    selectedstatusOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.statusFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedstatusOptions.includes(optionText)) {
                        selectedstatusOptions.push(optionText);
                    } else {
                        selectedstatusOptions = selectedstatusOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedstatusOptions',
                        selectedstatusOptions);
                });
            });

            document.getElementById('statusDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('statusDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedstatusOptions', selectedstatusOptions);
                $('#statusDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedstatusOptions');
        });

        function filterstatus() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('statusSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('statusOptions');
            li = ul.getElementsByTagName('label');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('span')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }

    </script>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
