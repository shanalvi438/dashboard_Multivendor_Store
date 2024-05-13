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
    <div class="card-body">
        <div class="filter-card" id="filterCard">

            <div class="col-md-2" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('productreviews') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                </div>
            </div>
            <form action="{{ route('productreviews') }}" method="GET">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-2">
                        <div class="dropdown" id="order_item_idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Parcel ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="order_item_idSearchInput" placeholder="Search..."
                                    oninput="filterorder_item_id()">
                                <div class="dropdown-options" id="order_item_idOptions">
                                    <label class="order_item_idFilter" for="order_item_idFilter">
                                        <input type="checkbox" id="selectAllorder_item_id" class="order_item_idFilter">
                                        <span class="option-text" name="order_item_id[]">Select All</span>
                                    </label>
                                    <div id="selectedorder_item_idOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="order_item_idFilter">
                                            <input type="checkbox" name="order_item_id[]"
                                                value="{{ $item->order_item_id }}">
                                            <span class="option-text"
                                                name="order_item_id[]">{{ $item->order_item_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedorder_item_idList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Product ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="idSearchInput" placeholder="Search..." oninput="filterid()">
                                <div class="dropdown-options" id="idOptions">
                                    <label class="idFilter" for="idFilter">
                                        <input type="checkbox" id="selectAllid" class="idFilter">
                                        <span class="option-text" name="id[]">Select All</span>
                                    </label>
                                    <div id="selectedidOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="idFilter">
                                            <input type="checkbox" name="id[]" value="{{ $item->product->id }}">
                                            <span class="option-text" name="id[]">{{ $item->product->id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedidList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Product Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <input type="text" id="nameSearchInput" placeholder="Search..." oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="nameFilter">
                                            <input type="checkbox" name="name[]" value="{{ $item->product->name }}">
                                            <span class="option-text" name="name[]">{{ $item->product->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectednameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="model_noDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Model No#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <input type="text" id="model_noSearchInput" placeholder="Search..."
                                    oninput="filtermodel_no()">
                                <div class="dropdown-options" id="model_noOptions">
                                    <label class="model_noFilter" for="model_noFilter">
                                        <input type="checkbox" id="selectAllmodel_no" class="model_noFilter">
                                        <span class="option-text" name="model_no[]">Select All</span>
                                    </label>
                                    <div id="selectedmodel_noOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="model_noFilter">
                                            <input type="checkbox" name="model_no[]"
                                                value="{{ $item->product->model_no }}">
                                            <span class="option-text"
                                                name="model_no[]">{{ $item->product->model_no }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedmodel_noList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="skuDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton6" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">SKU#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                <input type="text" id="skuSearchInput" placeholder="Search..." oninput="filtersku()">
                                <div class="dropdown-options" id="skuOptions">
                                    <label class="skuFilter" for="skuFilter">
                                        <input type="checkbox" id="selectAllsku" class="skuFilter">
                                        <span class="option-text" name="sku[]">Select All</span>
                                    </label>
                                    <div id="selectedskuOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="skuFilter">
                                            <input type="checkbox" name="sku[]" value="{{ $item->product->sku }}">
                                            <span class="option-text" name="sku[]">{{ $item->product->sku }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedskuList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="customer_idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer ID</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="customer_idSearchInput" placeholder="Search..."
                                    oninput="filtercustomer_id()">
                                <div class="dropdown-options" id="customer_idOptions">
                                    <label class="customer_idFilter" for="customer_idFilter">
                                        <input type="checkbox" id="selectAllcustomer_id" class="customer_idFilter">
                                        <span class="option-text" name="customer_id[]">Select All</span>
                                    </label>
                                    <div id="selectedcustomer_idOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="customer_idFilter">
                                            <input type="checkbox" name="customer_id[]"
                                                value="{{ $item->customer_id }}">
                                            <span class="option-text"
                                                name="customer_id[]">{{ $item->customer_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcustomer_idList"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex" style="margin-top: 5px;">

                    <div class="col-md-2">
                        <div class="dropdown" id="customer_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton7" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                <input type="text" id="customer_nameSearchInput" placeholder="Search..."
                                    oninput="filtercustomer_name()">
                                <div class="dropdown-options" id="customer_nameOptions">
                                    <label class="customer_nameFilter" for="customer_nameFilter">
                                        <input type="checkbox" id="selectAllcustomer_name" class="customer_nameFilter">
                                        <span class="option-text" name="customer_name[]">Select All</span>
                                    </label>
                                    <div id="selectedcustomer_nameOptions"></div>
                                    @foreach ($review as $item)
                                        <label class="customer_nameFilter">
                                            <input type="checkbox" name="customer_name[]"
                                                value="{{ $item->customer_name }}">
                                            <span class="option-text"
                                                name="customer_name[]">{{ $item->customer_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcustomer_nameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="slider"><b>Price:</b>
                            <label for="fader1"></label><input type="range" min="0" max="100"
                                value="0" id="fader1" step="20" list="volsettings"
                                name="new_sale_price[]">
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
                                    name="new_sale_price[]">
                            </div>
                            <div id="rangeValue1" style="margin-left: 200px;">0</div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-2">
                        <div class="dropdown" id="ratingDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Rating</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="ratingSearchInput" name="rating[]" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($review as $item)
                                        <label class="ratingFilter">
                                            <input type="checkbox" name="rating[]" value="{{ $item->rating }}">
                                            <span class="option-text" name="rating[]">
                                                {{ $item->rating }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div> --}}
        </div>
        <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>
        </form>
    </div>
    </div>
    <div class="breadcrumb">
        <h1>Product Reviews</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">Product Reviews</h4>

                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        <thead>
                            <th>Parcel Id</th>
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                            <th>Product ID#</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Model No</th>
                            <th>SKU#</th>
                            <th>Price</th>
                            {{-- <th>Product Detail</th> --}}
                            <th>Rating</th>
                            <th>Comments</th>
                        </thead>
                        <tbody>
                            @foreach ($review as $item)
                                <tr>
                                    <td>{{ $item->order_item_id }}</td>
                                    <td>{{ $item->customer_id }}</td>
                                    <td>{{ $item->customer_name }}</td>
                                    <td> {{ $item->product->id ?? null }}</td>
                                    <td>
                                        <img src="{{ $item->product->url ?? null }}  " width="50" height="50"
                                            loading="lazy" alt="Placeholder Image">
                                    </td>
                                    <td>{{ $item->product->name ?? null }}</td>
                                    <td>{{ $item->product->model_no ?? null }}</td>
                                    <td>{{ $item->product->sku ?? null }}</td>
                                    <td>${{ $item->product->new_sale_price ?? null }}</td>
                                    {{-- <td style="width:250px">
                                        <span style=" font-weight: 600; ">Id:
                                            {{ $item->product->id ?? null }} </span> <br>
                                        <span style=" font-weight: 600; ">Name:
                                            {{ $item->product->name ?? null }} </span> <br>
                                        <span style=" font-weight: 600; ">Model #:
                                        </span>{{ $item->product->model_no ?? null }}<br>
                                        <span style=" font-weight: 600; ">SKU:
                                        </span>{{ $item->product->sku ?? null }}<br>
                                        <span style=" font-weight: 600; ">Price:
                                        </span>${{ $item->product->new_sale_price ?? null }}<br>
                                    </td> --}}

                                    <td>
                                        @php
                                            $rating = $item->rating;
                                            $maxRating = 5;
                                            $numStars = 5;
                                            $percentage = ($rating / $maxRating) * 100;
                                            $fullStars = floor($percentage / (100 / $numStars));
                                            $emptyStars = $numStars - $fullStars;
                                        @endphp
                                        <div class="star-rating">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <span class="star star-filled"></span>
                                            @endfor
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <span class="star star-partial"></span>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        @if (strlen($item->comment) > 5)
                                            <span onmouseover="showPopup('{{ $item->comment }}')" onmouseout="hidePopup()">{{ substr($item->comment, 0, 5) }}...</span>
                                        @else
                                            {{ $item->comment }}
                                        @endif
                                    </td>

                                    <div id="popup" style="display: none; position: absolute; background-color: gray; color: white; padding: 10px; border: 1px solid #302f2f; margin-left: 1520px;"></div>

                                    <script>
                                        function showPopup(comment) {
                                            document.getElementById("popup").innerHTML = comment;
                                            document.getElementById("popup").style.display = "block";
                                        }

                                        function hidePopup() {
                                            document.getElementById("popup").style.display = "none";
                                        }
                                    </script>

                                    {{-- <td>
                                        @if (strlen($item->comment) > 5)
                                            {{ substr($item->comment, 0, 5) }}...
                                            <span style="color: rgb(7, 92, 120); cursor: pointer;" onclick="showFullText(this)">Read more</span>
                                            <span style="display: none;">{{ substr($item->comment, 5) }}</span>
                                        @else
                                            {{ $item->comment }}
                                        @endif
                                    </td> --}}
                                    {{-- <td class="star-rating">
                                    <span class="star star-filled"></span>&nbsp;&nbsp;
                                    <span class="star star-filled"></span>&nbsp;&nbsp;
                                    <span class="star star-filled"></span>&nbsp;&nbsp;
                                    <span class="star star-filled"></span>&nbsp;&nbsp;
                                    <span class="star star-partial"></span>&nbsp;&nbsp;
                                </td> --}}

                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>

                            <th>Parcel Id</th>
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                            <th>Product ID#</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Model No</th>
                            <th>SKU#</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>Action</th>

                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        //update price slider value == Saliha
        var slider = document.getElementById("fader1");
        var input = document.getElementById("priceInput1");
        var rangeValue = document.getElementById("rangeValue1");
        slider.oninput = function() {
            input.value = this.value;
            rangeValue.textContent = this.value;
        };
        input.oninput = function() {
            slider.value = this.value;
            rangeValue.textContent = this.value;
        };

        // for option with cross icon == Saliha
        document.addEventListener('DOMContentLoaded', function() {
            let selectedorder_item_idOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedorder_item_idOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedorder_item_idOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedorder_item_idOptions = selectedorder_item_idOptions
                            .filter(item =>
                                item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedorder_item_idOptions',
                            selectedorder_item_idOptions);
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
                    selectedorder_item_idOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.order_item_idFilter input[type="checkbox"]').forEach(
                checkbox => {
                    checkbox.addEventListener('change', function() {
                        const optionText = this.nextElementSibling.textContent;
                        if (this.checked && !selectedorder_item_idOptions.includes(
                                optionText)) {
                            selectedorder_item_idOptions.push(optionText);
                        } else {
                            selectedorder_item_idOptions = selectedorder_item_idOptions
                                .filter(item =>
                                    item !==
                                    optionText);
                        }
                        updateSelectedOptions();
                        saveSelectedOptions('selectedorder_item_idOptions',
                            selectedorder_item_idOptions);
                    });
                });

            document.getElementById('order_item_idDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('order_item_idDropdown').addEventListener('submit', function(
                event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedorder_item_idOptions',
                    selectedorder_item_idOptions);
                $('#order_item_idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedorder_item_idOptions');
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedcustomer_idOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedcustomer_idOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedcustomer_idOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedcustomer_idOptions = selectedcustomer_idOptions.filter(
                            item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedcustomer_idOptions',
                            selectedcustomer_idOptions);
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
                    selectedcustomer_idOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.customer_idFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedcustomer_idOptions.includes(
                            optionText)) {
                        selectedcustomer_idOptions.push(optionText);
                    } else {
                        selectedcustomer_idOptions = selectedcustomer_idOptions.filter(
                            item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcustomer_idOptions',
                        selectedcustomer_idOptions);
                });
            });

            document.getElementById('customer_idDropdown').addEventListener('hidden.bs.dropdown',
                function() {
                    updateSelectedOptions();
                });

            document.getElementById('customer_idDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedcustomer_idOptions', selectedcustomer_idOptions);
                $('#customer_idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedcustomer_idOptions');
        });

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
        // ===
        // search for data through input == Saliha
        function filtercustomer_id() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('customer_idSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('customer_idOptions');
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

        function filterorder_item_id() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('order_item_idSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('order_item_idOptions');
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

        function showFullText(element) {
        var fullTextElement = element.nextElementSibling;
        element.style.display = 'none';
        fullTextElement.style.display = 'inline';
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
