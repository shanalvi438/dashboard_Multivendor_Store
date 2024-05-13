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

    <?php
    $total_commission1 = 0;
    $total_product_price1 = 0;
    $totalTax1 = 0;
    ?>
    @foreach ($data as $value => $orders)
        <tr style="display: none">

            <?php
            $product_price = $orders->p_price;
            $commissionAmount = ($orders->product->subcategories->commission / 100) * $product_price;
            $total_commission1 += $commissionAmount;

            $TaxAmount = ($orders->product->tax_charges / 100) * $product_price;
            $totalTax1 += $TaxAmount;
            ?>
            <!-- <td>{{ $orders->product->new_sale_price ?? null }} </td> -->

        </tr>
    @endforeach
    <div class="row">
        <div class="">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title" style=" margin-left: -20px; ">Commission Chart</div>
                        </div>
                        <div class="col-6">
                            <div class="card-title" style=" text-align: end; ">Total Commission Charged:
                                ${{ $total_commission1 }}
                            </div>
                        </div>
                    </div>
                    <div id="columnDataLabel"
                        style="height: 300px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;"
                        _echarts_instance_="ec_1709707664532">


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-4" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('commissions.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('commissions.index') }}" method="GET">
                <div class="row" style="margin-top: 10px;">
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
                                <input type="text" id="idSearchInput" placeholder="Search..." oninput="filterid()">
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
                                            <input type="checkbox" name="name[]"
                                                value="{{ $orders->product->name ?? null }}">
                                            <span class="option-text"
                                                name="name[]">{{ $orders->product->name ?? null }}</span>
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
                                            <input type="checkbox" name="model_no[]"
                                                value="{{ $orders->product->model_no ?? null }}">
                                            <span class="option-text"
                                                name="model_no[]">{{ $orders->product->model_no ?? null }}</span>
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
                                <input type="text" id="skuSearchInput" placeholder="Search..." oninput="filtersku()">
                                <div class="dropdown-options" id="skuOptions">
                                    <label class="skuFilter" for="skuFilter">
                                        <input type="checkbox" id="selectAllsku" class="skuFilter">
                                        <span class="option-text" name="sku[]">Select All</span>
                                    </label>
                                    <div id="selectedskuOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="skuFilter">
                                            <input type="checkbox" name="sku[]"
                                                value="{{ $orders->product->sku ?? null }}">
                                            <span class="option-text"
                                                name="sku[]">{{ $orders->product->sku ?? null }}</span>
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
                                            <input type="checkbox" name="customer_name[]"
                                                value="{{ $orders->order->first_name ?? null }} {{ $orders->order->last_name ?? null }}">
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
                                value="0" id="fader1" step="20" list="volsettings1" name="commission[]">
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
                                value="0" id="fader2" step="20" list="volsettings" name="p_price[]">
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
        <h1>Commissions Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Commissions</h4>

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
                            <th>Product Commission %</th>
                            <th>Product Price</th>
                            <th>Commission Charges</th>
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
                                    <td>{{ $orders->product->subcategories->commission ?? null }}%
                                    </td>

                                    <?php
                                    $product_price = $orders->p_price;
                                    $commissionAmount = ($orders->product->subcategories->commission / 100) * $product_price;
                                    $total_commission += $commissionAmount;

                                    $TaxAmount = ($orders->product->tax_charges / 100) * $product_price;
                                    $totalTax += $TaxAmount;
                                    ?>
                                    <!-- <td>{{ $orders->product->new_sale_price ?? null }} </td> -->
                                    <td>${{ $orders->p_price ?? null }} </td>
                                    <?php
                                    $total_product_price += $orders->p_price;
                                    ?>

                                    <td>-${{ $commissionAmount }}</td>
                                    <td>{{ $orders->created_at }}</td>
                                    <td>
                                        <img src="{{ $orders->product->url ?? null }}  " width="50" height="50"
                                            loading="lazy" alt="Placeholder Image">
                                    </td>


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
                                <th>Product Commission %</th>
                                <th>Product Price</th>
                                <th>Commission Charges</th>
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

    </script>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>

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
@endsection
