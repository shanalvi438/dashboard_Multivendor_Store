@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
    <style>
        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .message-hover {
            cursor: pointer;
            /* text-decoration: underline; */
            color: blue;
        }

        .tooltip {
            visibility: hidden;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 0;
            margin-left: -70px;
            /* Adjust as needed for tooltip positioning */
            opacity: 0;
            transition: opacity 0.2s;
            width: auto;
            /* Adjust the width as needed */
        }

        .tooltip-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endsection
@section('main-content')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
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
            <div class="col-md-3" style="margin-left: 22px; margin-bottom: 30px;">
                <div class="content-box d-flex">
                    <form action="{{ route('products.customerqueries') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                </div>
            </div>
            <form action="{{ route('products.customerqueries') }}" method="GET">

                <div class="row d-flex" style="margin-top: 30px;">
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
                                    @foreach ($data as $key => $value)
                                        <label class="customer_idFilter">
                                            <input type="checkbox" name="customer_id[]" value="{{ $value->customer_id }}">
                                            <span class="option-text" name="customer_id[]">{{ $value->customer_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcustomer_idList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="supplier_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Supplier Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="supplier_nameSearchInput" placeholder="Search..."
                                    oninput="filtersupplier_name()">
                                <div class="dropdown-options" id="supplier_nameOptions">
                                    <label class="supplier_nameFilter" for="supplier_nameFilter">
                                        <input type="checkbox" id="selectAllsupplier_name" class="supplier_nameFilter">
                                        <span class="option-text" name="supplier_name[]">Select All</span>
                                    </label>
                                    <div id="selectedsupplier_nameOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="supplier_nameFilter">
                                            <input type="checkbox" name="supplier_name[]"
                                                value="{{ $value->supplier_name }}">
                                            <span class="option-text"
                                                name="supplier_name[]">{{ $value->supplier_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedsupplier_nameList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="dropdown" id="customer_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="customer_nameSearchInput" placeholder="Search..."
                                    oninput="filtercustomer_name()">
                                <div class="dropdown-options" id="customer_nameOptions">
                                    <label class="customer_nameFilter" for="customer_nameFilter">
                                        <input type="checkbox" id="selectAllcustomer_name" class="customer_nameFilter">
                                        <span class="option-text" name="customer_name[]">Select All</span>
                                    </label>
                                    <div id="selectedcustomer_nameOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="customer_nameFilter">
                                            <input type="checkbox" name="customer_name[]"
                                                value="{{ $value->customer_name }}">
                                            <span class="option-text"
                                                name="customer_name[]">{{ $value->customer_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcustomer_nameList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="dropdown" id="pro_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Product Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <input type="text" id="pro_nameSearchInput" placeholder="Search..."
                                    oninput="filterpro_name()">
                                <div class="dropdown-options" id="pro_nameOptions">
                                    <label class="pro_nameFilter" for="pro_nameFilter">
                                        <input type="checkbox" id="selectAllpro_name" class="pro_nameFilter">
                                        <span class="option-text" name="pro_name[]">Select All</span>
                                    </label>
                                    <div id="selectedpro_nameOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="pro_nameFilter">
                                            <input type="checkbox" name="pro_name[]" value="{{ $value->pro_name }}">
                                            <span class="option-text" name="pro_name[]">{{ $value->pro_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedpro_nameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="pro_model_noDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Model No</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <input type="text" id="pro_model_noSearchInput" placeholder="Search..."
                                    oninput="filterpro_model_no()">
                                <div class="dropdown-options" id="pro_model_noOptions">
                                    <label class="pro_model_noFilter" for="pro_model_noFilter">
                                        <input type="checkbox" id="selectAllpro_model_no" class="pro_model_noFilter">
                                        <span class="option-text" name="pro_model_no[]">Select All</span>
                                    </label>
                                    <div id="selectedpro_model_noOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="pro_model_noFilter">
                                            <input type="checkbox" name="pro_model_no[]"
                                                value="{{ $value->pro_model_no }}">
                                            <span class="option-text"
                                                name="pro_model_no[]">{{ $value->pro_model_no }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedpro_model_noList"></div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-3">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Customer Contact</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="searchInput4" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="customer_contact_noFilter">
                                            <input type="checkbox" value="{{ $value->customer_contact_no }}">
                                            <span class="option-text">{{ $value->customer_contact_no }}</span>
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
    <div class="separator-breadcrumb border-top"></div>
    <div class="breadcrumb">
        <h1>Contact Supplier</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">Contact Supplier</h4>
                {{--
                        <p>.....</p>
     --}}
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        <thead>
                            <th>Sr#</th>
                            <th>Customer ID#</th>
                            <th>Supplier Name</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Customer Contact #</th>
                            <th>Product Name</th>
                            <th>Product Model #</th>
                            <th>Message</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->customer_id }}</td>
                                    <td>{{ $value->supplier_name }}</td>
                                    <td>{{ $value->customer_name }}</td>
                                    <td>{{ $value->customer_email }}</td>
                                    <td>{{ $value->customer_contact_no }}</td>
                                    <td>{{ $value->pro_name }}</td>
                                    <td>{{ $value->pro_model_no }}</td>
                                    <td>
                                        <div class="tooltip-container">
                                            <span class="">{{ Str::limit($value->message, 30) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a target="_blank" href="mailto:{{ $value->customer_email }}">
                                                <button type="button" class="btn btn btn-outline-secondary ">
                                                    <i class="nav-icon i-Email" title="email"
                                                        style="font-weight: bold;"></i>
                                                </button></a>
                                            <a target="_blank" href="{{ route('CustomerQueries.show', $value->id) }}">
                                                <button type="button" class="btn btn btn-outline-secondary ">
                                                    <i class="nav-icon i-Eye" title="view"
                                                        style="font-weight: bold;"></i>
                                                </button></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sr#</th>
                                <th>Customer ID#</th>
                                <th>Supplier Name</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Contact #</th>
                                <th>Product Name</th>
                                <th>Product Model #</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
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
                        selectedcustomer_idOptions = selectedcustomer_idOptions.filter(item =>
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
                    if (this.checked && !selectedcustomer_idOptions.includes(optionText)) {
                        selectedcustomer_idOptions.push(optionText);
                    } else {
                        selectedcustomer_idOptions = selectedcustomer_idOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcustomer_idOptions', selectedcustomer_idOptions);
                });
            });

            document.getElementById('customer_idDropdown').addEventListener('hidden.bs.dropdown', function() {
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

        function filtercustomer_name() {
            // Dropdown-option mein jo baki ke options hain, unhe select karne ke liye
            var options = $('.customer_nameFilter input[type="checkbox"]');
            // Checkboxes ko uncheck karne ke liye
            options.prop('checked', false);
            // Search input se match karne wale options ko check karne ke liye
            var searchValue = $('#customer_nameSearchInput').val().toLowerCase();
            options.each(function() {
                var optionText = $(this).next().text().toLowerCase();
                if (optionText.indexOf(searchValue) > -1) {
                    $(this).prop('checked', true);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectedsupplier_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedsupplier_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedsupplier_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedsupplier_nameOptions = selectedsupplier_nameOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedsupplier_nameOptions',
                            selectedsupplier_nameOptions);
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
                    selectedsupplier_nameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.supplier_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedsupplier_nameOptions.includes(optionText)) {
                        selectedsupplier_nameOptions.push(optionText);
                    } else {
                        selectedsupplier_nameOptions = selectedsupplier_nameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedsupplier_nameOptions',
                        selectedsupplier_nameOptions);
                });
            });

            document.getElementById('supplier_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('supplier_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedsupplier_nameOptions', selectedsupplier_nameOptions);
                $('#supplier_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedsupplier_nameOptions');
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedpro_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedpro_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedpro_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedpro_nameOptions = selectedpro_nameOptions.filter(item => item !==
                            option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedpro_nameOptions', selectedpro_nameOptions);
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
                    selectedpro_nameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.pro_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedpro_nameOptions.includes(optionText)) {
                        selectedpro_nameOptions.push(optionText);
                    } else {
                        selectedpro_nameOptions = selectedpro_nameOptions.filter(item => item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedpro_nameOptions', selectedpro_nameOptions);
                });
            });

            document.getElementById('pro_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('pro_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedpro_nameOptions', selectedpro_nameOptions);
                $('#pro_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedpro_nameOptions');
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedpro_model_noOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedpro_model_noOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedpro_model_noOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedpro_model_noOptions = selectedpro_model_noOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedpro_model_noOptions',
                            selectedpro_model_noOptions);
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
                    selectedpro_model_noOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.pro_model_noFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedpro_model_noOptions.includes(optionText)) {
                        selectedpro_model_noOptions.push(optionText);
                    } else {
                        selectedpro_model_noOptions = selectedpro_model_noOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedpro_model_noOptions', selectedpro_model_noOptions);
                });
            });

            document.getElementById('pro_model_noDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('pro_model_noDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedpro_model_noOptions', selectedpro_model_noOptions);
                $('#pro_model_noDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedpro_model_noOptions');
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

        //customer name === Saliha

        function filtercustomer_name() {
            var input, filter, options, option, i, txtValue;
            input = document.getElementById("customer_nameSearchInput");
            filter = input.value.toUpperCase();
            options = document.getElementsByClassName("customer_nameFilter");
            for (i = 0; i < options.length; i++) {
                option = options[i];
                txtValue = option.textContent || option.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                }
            }
        }

        //suppler Name === Saliha

        function filtersupplier_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('supplier_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('supplier_nameOptions');
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

        //product Name === Saliha

        function filterpro_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('pro_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('pro_nameOptions');
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

        // Model No === Saliha

        function filterpro_model_no() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('pro_model_noSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('pro_model_noOptions');
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
