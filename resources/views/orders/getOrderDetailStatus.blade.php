@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
@endsection
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
        padding-right: 70px;
        padding-left: 70px;
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
            <div class="col-md-4" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    @foreach ($status as $value => $orders)
                    <form action="{{  route('get_order_detail_status', ['id' => $orders->order_id]) }}" method="GET">
                        @endforeach
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                </div>
            </div>
            @foreach ($status as $value => $orders)
            <form action="{{ route('get_order_detail_status', ['id' => $orders->order_id]) }}" method="GET">
                @endforeach
                <div class="row" style="margin-top: 15px; margin-bottom: 0px">
                    <div class="col-md-3">
                        <div class="dropdown" id="order_idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Parcel ID</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="order_idSearchInput"  placeholder="Search..." oninput="filterorder_id()">
                                <div class="dropdown-options" id="order_idOptions">
                                    <label class="order_idFilter" for="order_idFilter">
                                        <input type="checkbox" id="selectAllorder_id" class="order_idFilter">
                                        <span class="option-text" name="order_id[]">Select All</span>
                                    </label>
                                    <div id="selectedorder_idOptions"></div>
                                    @foreach ($status as $value => $orders)
                                        <label class="order_idFilter">
                                            <input type="checkbox" name="order_id[]" value="{{ $orders->order_id }}">
                                            <span class="option-text" name="order_id[]">{{ $orders->order_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedorder_idList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dropdown" id="statusDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Order Status</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="statusSearchInput"  placeholder="Search..." oninput="filterstatus()">
                                <div class="dropdown-options" id="statusOptions">
                                    <label class="statusFilter" for="statusFilter">
                                        <input type="checkbox" id="selectAllstatus" class="statusFilter">
                                        <span class="option-text" name="status[]">Select All</span>
                                    </label>
                                    <div id="selectedstatusOptions"></div>
                                    @foreach ($status as $value => $orders)
                                        <label class="statusFilter">
                                            <input type="checkbox" name="status[]" value="{{ $orders->status }}">
                                            <span class="option-text" name="status">{{ $orders->status }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedstatusList"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 1200px">Submit</button>
            </form>
        </div>
    </div>
                <div class="breadcrumb">
                    <h1>Get Order Parcels Status</h1>
                </div>

                <div class="separator-breadcrumb border-top"></div>
                @php
                    $hasInProcessStatus = false;
                    $hasPackagingStatus = false;
                    $hasOutForDelivery = false;
                    $hasDelivered = false;
                    $hasFailedToDeliver = false;
                    $hasCanceled = false;
                @endphp

                @foreach ($status as $order)
                    @if ($order->status === 'In Process')
                        @php
                            $hasInProcessStatus = true;
                        @endphp
                    @endif
                    @if ($order->status === 'Packaging')
                        @php
                            $hasPackagingStatus = true;
                        @endphp
                    @endif
                    {{-- @if ($order->status === 'Out For Delivery')
                        @php
                            $hasOutForDelivery = true;
                        @endphp
                    @endif
                    @if ($order->status === 'Delivered')
                        @php
                            $hasDelivered = true;
                        @endphp
                    @endif
                    @if ($order->status === 'Failed to Deliver')
                        @php
                            $hasFailedToDeliver = true;
                        @endphp
                    @endif
                    @if ($order->status === 'Canceled')
                        @php
                            $hasCanceled = true;
                        @endphp
                    @endif --}}
                @endforeach




                <div class="col-md-12 mb-4">
                    <div class="card text-start">

                        <div class="card-body">
                            <h4 class="card-title mb-3">Get order Parcels Status</h4>

                            {{-- <p>All Orders list is below.</p> --}}

                            <div class="table-responsive">
                                <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                                    style="width:100%;">
                                    <thead>
                                        <th>Id #</th>
                                        <th>Parcel Id #</th>
                                        <th>Status</th>
                                        <th>DateTime</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($status as $value => $orders)
                                            <tr>

                                                <td>{{ $value + 1 }}</td>
                                                <td>{{ $orders->order_id }}</td>
                                                <td>{{ $orders->status }} </td>
                                                <td>{{ $orders->datetime }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Id #</th>
                                            <th>Parcel Id #</th>
                                            <th>Status</th>
                                            <th>DateTime</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
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
