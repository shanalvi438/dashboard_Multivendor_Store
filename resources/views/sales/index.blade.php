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

    <div class="row">
        <div class="">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title" style=" margin-left: 0px; ">
                                <h4>Sale Chart</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title" style=" text-align: end; ">Total Sale: {{ $totalSale }} </div>
                        </div>
                    </div>
                    <div id="zoomableLine-chart1"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-3" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('sales.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('sales.index') }}" method="GET">
                <div class="row" style="margin-top: 15px;">

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

                <div class="row d-flex" style="margin-top: 5px; margin-bottom: 100px">

                    <div class="col-md-4">
                        <div class="slider"><b>Commission:</b>
                            <label for="fader1"></label><input type="range" min="0" max="100"
                                value="0" id="fader1" step="20" list="volsettings1"
                                name="commission[]">
                            <datalist id="volsettings1">
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
                                <label for="priceInput1">%:</label>
                                <input type="number" id="priceInput1" min="0" max="100000" value="0"
                                    name="commission[]">
                            </div>
                            <div id="rangeValue1" style="margin-left: 200px;">0</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="slider"><b>Price:</b>
                            <label for="fader2"></label><input type="range" min="0" max="100"
                                value="0" id="fader2" step="20" list="volsettings"
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
                                <label for="priceInput2">$:</label>
                                <input type="number" id="priceInput2" min="0" max="100000" value="0"
                                    name="p_price[]">
                            </div>
                            <div id="rangeValue2" style="margin-left: 200px;">0</div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>

            </form>
        </div>
    </div>

    <div class="breadcrumb">
        <h1>All Sales</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Sales</h4>

                {{-- <p>All Orders list is below.</p> --}}

                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%;">
                        <thead>
                            {{-- <th>Sr No</th> --}}
                            <th>Order Id#</th>
                            <th>Parcel Id #</th>
                            <th>Vendor Name</th>
                            <th>Customer Name</th>
                            <th>Product Name</th>
                            <th>Product Model</th>
                            <th>Product Sku</th>
                            <th>Product Commission</th>
                            <th>Product Price</th>
                            <th>Order Date</th>
                            {{-- <th>Shipping Date</th> --}}
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $total_commission = 0;
                            $total_product_price = 0;
                            $totalTax = 0;
                            ?>
                            @foreach ($data as $value => $orders)
                                <tr>

                                    {{-- <td>{{ $value + 1 }}</td> --}}

                                    <td>{{ $orders->order_id }}</td>
                                    <td>{{ $orders->id }}</td>
                                    <td>{{ $orders->vendor->name ?? null }}</td>
                                    <td>{{ $orders->order->first_name ?? null }} {{ $orders->order->last_name ?? null }}
                                    </td>

                                    <td>{{ $orders->product->name ?? null }} </td>
                                    <td>{{ $orders->product->model_no ?? null }} </td>

                                    <td>{{ $orders->product->sku ?? null }} </td>
                                    <td>{{ $orders->product->subcategories->commission ?? null }}% </td>

                                    <?php
                                    if ($orders->status === 'Delivered') {
                                        $product_price = $orders->p_price;
                                        $commissionAmount = ($orders->product->subcategories->commission / 100) * $product_price;
                                        $total_commission += $commissionAmount;

                                        $TaxAmount = ($orders->product->tax_charges / 100) * $product_price;
                                        $totalTax += $TaxAmount;
                                    }
                                    ?>
                                    <td>${{ $orders->p_price ?? null }} </td>

                                    <?php
                                    if ($orders->status === 'Delivered') {
                                        $total_product_price += $orders->p_price;
                                    }
                                    ?>
                                    {{-- <td>{{ $orders->first_name }}</td> --}}

                                    {{-- <td>{{ $orders->last_name }}</td> --}}

                                    <td>{{ $orders->created_at }}</td>
                                    <td>
                                        <img src="{{ $orders->product->url ?? null }}  " width="50" height="50"
                                            loading="lazy" alt="Placeholder Image">
                                    </td>
                                    {{-- <td>{{ $orders->shipping }}</td> --}}
                                    {{-- <td>
                                    @if ($orders->product)
                                    @if ($orders->product->url)
                                    <img src="{{ $product->product_image->url }}" width="50" height="50" loading="lazy" alt="Placeholder Image" - Order ID:
                                {{ $orders->id }}">
                                <p>Order ID: {{ $orders->id }}</p>
                                @else
                                @if ($orders->product->product_image)
                                <img src="{{ $product->product_image->url }}" width="50" height="50" loading="lazy" alt="Placeholder Image" - Order ID:
                                    {{ $orders->id }}">
                                <p>Order ID: {{ $orders->id }}</p>
                                @endif
                                @endif
                                @else
                                <img src="{{ asset('path-to-your-placeholder-image.jpg') }}" loading="lazy" width="50" height="50" alt="Placeholder Image">
                                <p>No image available</p>
                                @endif
                                </td> --}}

                                    <td>
                                        <div class="btn btn-outline-secondary ladda-button example-button m-1">
                                            {{ $orders->status }}</div>
                                    </td>

                                    <td>
                                        <a href="{{ url('get_order_detail_status/' . $orders->id) }}"
                                            class="btn btn-outline-secondary">Details</a>
                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                {{-- <th>Sr No</th> --}}
                                <th>Order Id#</th>
                                <th>Parcel Id #</th>
                                <th>Vendor Name</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Product Model</th>
                                <th>Product Sku</th>
                                <th>Product Commission</th>
                                <th>Product Price</th>
                                <th>Order Date</th>
                                {{-- <th>Shipping Date</th> --}}
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">


            <div class="card-body">
                <h4 class="card-title mb-3">Amount</h4>


                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%;">
                        <thead>

                            <th>Total Product Price</th>
                            <th>Total Product Tax</th>
                            <th>Total Commision</th>
                            <th>Grand Total(You Earn)</th>
                        </thead>
                        <tbody>

                            <tr>
                                <td>+${{ $total_product_price }}</td>
                                <td>+${{ $totalTax }}</td>
                                <td>-${{ $total_commission }}</td>
                                <td>${{ $total_product_price - $total_commission }}</td>

                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Product Price</th>
                                <th>Total Product Tax</th>
                                <th>Total Commision</th>
                                <th>Grand Total(You Earn)</th>



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

            document.addEventListener('DOMContentLoaded', function() {
                var slider2 = document.getElementById("fader2");
                var input2 = document.getElementById("priceInput2");
                var rangeValue2 = document.getElementById("rangeValue2");

                input2.addEventListener("input", function() {
                    var value = parseInt(this.value);
                    if (!isNaN(value) && value >= 0 && value <= 100000) {
                        slider2.value = value;
                        rangeValue2.textContent = value;
                    }
                });

                slider2.addEventListener("input", function() {
                    input2.value = this.value;
                    rangeValue2.textContent = this.value;
                });
            });

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
                            selectednameOptions = selectednameOptions.filter(item => item !== option);
                            updateSelectedOptions();
                            saveSelectedOptions('selectednameOptions', selectednameOptions);
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
                        if (this.checked && !selectednameOptions.includes(optionText)) {
                            selectednameOptions.push(optionText);
                        } else {
                            selectednameOptions = selectednameOptions.filter(item => item !==
                                optionText);
                        }
                        updateSelectedOptions();
                        saveSelectedOptions('selectednameOptions', selectednameOptions);
                    });
                });

                document.getElementById('nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                    updateSelectedOptions();
                });

                document.getElementById('nameDropdown').addEventListener('submit', function(event) {
                    event.preventDefault();
                    updateSelectedOptions();
                    saveSelectedOptions('selectednameOptions', selectedNamesOptions);
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> --}}
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/dashboard.v1.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/apexcharts.dataseries.js') }}"></script>
    <script src="{{ asset('assets/js/es5/apexChart.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/apexBarChart.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/apexPieDonutChart.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/chartjs.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/apexColumnChart.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            var e = {
                chart: {
                    height: 350,
                    type: "line",
                    zoom: {
                        enabled: !1
                    },
                    toolbar: {
                        show: !0
                    },
                },
                tooltip: {
                    enabled: !0,
                    shared: !0,
                    followCursor: !1,
                    intersect: !1,
                    inverseOrder: !1,
                    custom: void 0,
                    fillSeriesColor: !1,
                    theme: !1,
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    curve: "smooth"
                },
                series: [{
                    name: "Desktops",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
                }, ],
                grid: {
                    row: {
                        colors: ["#f3f3f3", "transparent"],
                        opacity: 0.5
                    }
                },
                xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                    ],
                },
            };
            new ApexCharts(document.querySelector("#basicLine-chart"), e).render();
            e = {
                chart: {
                    height: 350,
                    type: "line",
                    shadow: {
                        enabled: !0,
                        color: "#000",
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 1,
                    },
                    toolbar: {
                        show: !1
                    },
                    animations: {
                        enabled: !0,
                        easing: "linear",
                        speed: 500,
                        animateGradually: {
                            enabled: !0,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: !0,
                            speed: 550
                        },
                    },
                },
                colors: ["#77B6EA", "#545454"],
                dataLabels: {
                    enabled: !0
                },
                stroke: {
                    curve: "smooth"
                },
                series: [{
                        name: "High - 2013",
                        data: [28, 29, 33, 36, 32, 32, 33]
                    },
                    {
                        name: "Low - 2013",
                        data: [12, 11, 14, 18, 17, 13, 13]
                    },
                ],
                grid: {
                    borderColor: "#e7e7e7",
                    row: {
                        colors: ["#f3f3f3", "transparent"],
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 6
                },
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                    title: {
                        text: "Month"
                    },
                },
                yaxis: {
                    title: {
                        text: "Temperature"
                    },
                    min: 5,
                    max: 40
                },
                legend: {
                    position: "top",
                    horizontalAlign: "right",
                    floating: !0,
                    offsetY: -25,
                    offsetX: -5,
                },
            };
            new ApexCharts(
                document.querySelector("#lineChartWIthDataLabel"),
                e
            ).render();
            for (var t = 14844186e5, a = [], r = 0; r < 120; r++) {
                var o = [(t += 864e5), dataSeries[1][r].value];
                a.push(o);
            }
            e = {
                chart: {
                    type: "area",
                    stacked: !1,
                    height: 350,
                    zoom: {
                        type: "x",
                        enabled: !0
                    },
                    toolbar: {
                        autoSelected: "zoom"
                    },
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "XYZ MOTORS1",
                    data: a
                }],
                markers: {
                    size: 0
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: !1,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100],
                    },
                },
                yaxis: {
                    min: 2e7,
                    max: 25e7,
                    labels: {
                        formatter: function(e) {
                            return (e / 1e6).toFixed(0);
                        },
                    },
                    title: {
                        text: "Price"
                    },
                },
                xaxis: {
                    type: "datetime"
                },
                tooltip: {
                    shared: !1,
                    y: {
                        formatter: function(e) {
                            return (e / 1e6).toFixed(0);
                        },
                    },
                },
            };
            new ApexCharts(document.querySelector("#zoomableLine-chart1"), e).render();
            e = {
                chart: {
                    height: 350,
                    type: "line",
                    dropShadow: {
                        enabled: !0,
                        top: 3,
                        left: 3,
                        blur: 1,
                        opacity: 0.2
                    },
                },
                stroke: {
                    width: 7,
                    curve: "smooth"
                },
                series: [{
                    name: "Likes",
                    data: [
                        4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7,
                        5,
                    ],
                }, ],
                xaxis: {
                    type: "datetime",
                    categories: [
                        "1/11/2000",
                        "2/11/2000",
                        "3/11/2000",
                        "4/11/2000",
                        "5/11/2000",
                        "6/11/2000",
                        "7/11/2000",
                        "8/11/2000",
                        "9/11/2000",
                        "10/11/2000",
                        "11/11/2000",
                        "12/11/2000",
                        "1/11/2001",
                        "2/11/2001",
                        "3/11/2001",
                        "4/11/2001",
                        "5/11/2001",
                        "6/11/2001",
                    ],
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        gradientToColors: ["#FDD835"],
                        shadeIntensity: 1,
                        type: "horizontal",
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100],
                    },
                },
                markers: {
                    size: 4,
                    opacity: 0.9,
                    colors: ["#FFA41B"],
                    strokeColor: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    },
                },
                yaxis: {
                    min: -10,
                    max: 40,
                    title: {
                        text: "Engagement"
                    }
                },
            };
            new ApexCharts(document.querySelector("#gradientLineChart"), e).render();
            var n = 0,
                i = [];
            !(function(e, t, a) {
                for (var r = 0; r < t;) {
                    var o = e,
                        s = Math.floor(Math.random() * (a.max - a.min + 1)) + a.min;
                    i.push({
                        x: o,
                        y: s
                    }), (n = e), (e += 864e5), r++;
                }
            })(new Date("11 Feb 2017 GMT").getTime(), 10, {
                min: 10,
                max: 90
            });
            e = {
                chart: {
                    height: 350,
                    type: "line",
                    animations: {
                        enabled: !0,
                        easing: "linear",
                        dynamicAnimation: {
                            speed: 2e3
                        },
                    },
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    dropShadow: {
                        enabled: !0,
                        top: 3,
                        left: 3,
                        blur: 1,
                        opacity: 0.2
                    },
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    curve: "smooth"
                },
                series: [{
                    data: i
                }],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        gradientToColors: ["#FDD835"],
                        shadeIntensity: 1,
                        type: "horizontal",
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100],
                    },
                },
                markers: {
                    size: 0
                },
                xaxis: {
                    type: "datetime",
                    range: 7776e5
                },
                yaxis: {
                    max: 100
                },
                legend: {
                    show: !1
                },
            };
            var s = new ApexCharts(document.querySelector("#realTimeLine-chart"), e);
            s.render();
            window.setInterval(function() {
                    var e, t;
                    (e = {
                        min: 10,
                        max: 90
                    }),
                    (n = t = n + 864e5),
                    i.push({
                            x: t,
                            y: Math.floor(Math.random() * (e.max - e.min + 1)) + e.min,
                        }),
                        s.updateSeries([{
                            data: i
                        }]);
                }, 2e3),
                window.setInterval(function() {
                    (i = i.slice(i.length - 10, i.length)),
                    s.updateSeries([{
                        data: i
                    }], !1, !0);
                }, 6e4);
            e = {
                chart: {
                    height: 350,
                    type: "line",
                    zoom: {
                        enabled: !1
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: [5, 7, 5],
                    curve: "smooth",
                    dashArray: [0, 8, 5]
                },
                series: [{
                        name: "Session Duration",
                        data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10],
                    },
                    {
                        name: "Page Views",
                        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35],
                    },
                    {
                        name: "Total Visits",
                        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47],
                    },
                ],
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                xaxis: {
                    categories: [
                        "01 Jan",
                        "02 Jan",
                        "03 Jan",
                        "04 Jan",
                        "05 Jan",
                        "06 Jan",
                        "07 Jan",
                        "08 Jan",
                        "09 Jan",
                        "10 Jan",
                        "11 Jan",
                        "12 Jan",
                    ],
                },
                tooltip: {
                    y: [{
                            title: {
                                formatter: function(e) {
                                    return e + " (mins)";
                                },
                            },
                        },
                        {
                            title: {
                                formatter: function(e) {
                                    return e + " per session";
                                },
                            },
                        },
                        {
                            title: {
                                formatter: function(e) {
                                    return e;
                                },
                            },
                        },
                    ],
                },
                grid: {
                    borderColor: "#f1f1f1"
                },
            };
            new ApexCharts(document.querySelector("#dashedLineChart"), e).render();
            var d = {
                chart: {
                    id: "chart2",
                    type: "line",
                    height: 230,
                    toolbar: {
                        autoSelected: "pan",
                        show: !1
                    },
                },
                colors: ["#546E7A"],
                stroke: {
                    width: 3
                },
                dataLabels: {
                    enabled: !1
                },
                fill: {
                    opacity: 1
                },
                markers: {
                    size: 0
                },
                series: [{
                    data: (i = (function(e, t, a) {
                        var r = 0,
                            o = [];
                        for (; r < t;) {
                            var n = e,
                                i =
                                Math.floor(
                                    Math.random() * (a.max - a.min + 1)
                                ) + a.min;
                            o.push([n, i]), (e += 864e5), r++;
                        }
                        return o;
                    })(new Date("11 Feb 2017").getTime(), 185, {
                        min: 30,
                        max: 90,
                    })),
                }, ],
                xaxis: {
                    type: "datetime"
                },
            };
            new ApexCharts(document.querySelector("#chart-line2"), d).render();
            e = {
                chart: {
                    id: "chart1",
                    height: 130,
                    type: "area",
                    brush: {
                        target: "chart2",
                        enabled: !0
                    },
                    selection: {
                        enabled: !0,
                        xaxis: {
                            min: new Date("19 Jun 2017").getTime(),
                            max: new Date("14 Aug 2017").getTime(),
                        },
                    },
                },
                colors: ["#008FFB"],
                series: [{
                    data: i
                }],
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.91,
                        opacityTo: 0.1
                    },
                },
                xaxis: {
                    type: "datetime",
                    tooltip: {
                        enabled: !1
                    }
                },
                yaxis: {
                    tickAmount: 2
                },
            };
            new ApexCharts(document.querySelector("#brushLine-chart"), e).render();
        });
    </script>
@endsection
