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
                            <div class="card-title" style=" margin-left: -20px; ">Total Products Vs Vendor</div>
                        </div>
                        <div class="col-6">
                            <div class="card-title" style=" text-align: end; ">Total Products: {{ $allproducts }} || Total
                                Vendor's: {{ $totalSupplier }}</div>
                        </div>

                        <div id="lineChartWIthDataLabel"
                            style="height: 300px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;"
                            _echarts_instance_="ec_1709707664537">
                            <div
                                style="position: relative; overflow: hidden; width: 613px; height: 300px; padding: 0px; margin-bottom: -250px; border-width: 0px; cursor: default;">
                                <canvas data-zr-dom-id="zr_0" width="766" height="375"
                                    style="position: absolute; left: 0px; top: 0px; width: 613px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-3" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('products.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Product Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="nameSearchInput" placeholder="Search..." oninput="filterNames()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllNames" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectedNamesOptions"></div>
                                    @foreach ($products as $key => $product)
                                        <label class="nameFilter">
                                            <input type="checkbox" name="name[]" value="{{ $product->name ?? null }}">
                                            <span class="option-text" name="name[]">{{ $product->name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedNamesList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="model_noDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Model No</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="model_noSearchInput" placeholder="Search..."
                                    oninput="filterModelNo()">

                                <div class="dropdown-options" id="model_noOptions">
                                    <label class="model_noFilter" for="model_noFilter">
                                        <input type="checkbox" id="selectAllmodel_no" class="model_noFilter">
                                        <span class="option-text" name="model_no[]">Select All</span>
                                    </label>
                                    <div id="selectedModelNoOptions"></div>
                                    @foreach ($products as $key => $product)
                                        <label class="model_noFilter">
                                            <input type="checkbox" name="model_no[]"
                                                value="{{ $product->model_no ?? null }}">
                                            <span class="option-text"
                                                name="model_no[]">{{ $product->model_no ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedmodel_noList"></div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id=" suppliernameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Supplier Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="makeSearchInput" placeholder="Search..."
                                    oninput="filtersuppliername()">
                                <div class="dropdown-options" id="makeOptions">
                                    <label class="makeFilter" for="makeFilter">
                                        <input type="checkbox" id="selectAllmake" class="makeFilter">
                                        <span class="option-text" name="make[]">Select All</span>
                                    </label>
                                    <div id="selectedmakeOptions"></div>
                                    @foreach ($products as $key => $product)
                                        <label class="makeFilter">
                                            <input type="checkbox" name="make[]" value="{{ $product->make ?? null }}">
                                            <span class="option-text" name="make[]">{{ $product->make ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedsuppliernameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="subcategoriesDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Sub Categories</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <input type="text" id="subcategoriesSearchInput" placeholder="Search..."
                                    oninput="filtersubcategories()" name="name[]">
                                <div class="dropdown-options" id="subcategoriesOptions" name="name[]">
                                    <label class="nameFilter" for="nameFilter" name="name[]">
                                        <input type="checkbox" id="selectAllsubcategories" class="nameFilter"
                                            name="name[]">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectedsubcategoriesOptions"></div>
                                    @foreach ($subcategories as $subcat)
                                        <label class="nameFilter" name="name[]">
                                            <input type="checkbox" name="name[]" value="{{ $subcat->name }}">
                                            <span class="option-text" name="name[]">{{ $subcat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedsubcategoriesList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="brand_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Brand</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5" style="max-width: 1000px;">
                                <input type="text" id="brand_nameSearchInput" placeholder="Search..."
                                    oninput="filterbrand_name()" name="brand_name[]">
                                <div class="dropdown-options" id="brand_nameOptions" name="brand_name[]">
                                    <label class="brand_nameFilter" for="brand_nameFilter" name="brand_name[]">
                                        <input type="checkbox" id="selectAllbrand_name" class="brand_nameFilter">
                                        <span class="option-text" name="brand_name[]">Select All</span>
                                    </label>
                                    <div id="selectedbrand_nameOptions"></div>
                                    @foreach ($brand as $brand)
                                        <label class="brand_idFilter d-flex" name="brand_name[]">
                                            <input type="checkbox" style="margin-bottom: 3px;" name="brand_id[]"
                                                value="{{ $brand->id ?? null }} ">
                                            <span class="option-text d-flex" name="brand_name[]">
                                                {{ $brand->brand_name ?? null }} <img src="{{ $brand->logo ?? null }}"
                                                    width="50" height="50"
                                                    alt="{{ $brand->brand_name ?? null }}">
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedbrand_nameList"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row d-flex">
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

                    <div class="col-md-4">
                        <div class="slider"><b>Tax:</b>
                            <label for="fader2"></label><input type="range" min="0" max="100"
                                value="0" id="fader2" step="20" list="volsettings2" name="tax_charges[]">
                            <datalist id="volsettings2">
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
                                    name="tax_charges[]">
                            </div>
                            <div id="rangeValue2" style="margin-left: 200px;">0</div>
                        </div>
                    </div>

                    {{-- <div class="col-md-3" style="margin-left: 10px;">
                            <div class="slider"><b>Commission:</b>
                                <label for="fader3"></label><input type="range" min="0" max="100"
                                    value="0" id="fader3" step="20" list="volsettings3"
                                    name="commission[]">
                                <datalist id="volsettings3">
                                    <option>0</option>
                                    <option>20</option>
                                    <option>40</option>
                                    <option>60</option>
                                    <option>80</option>
                                    <option>100</option>
                                </datalist>
                            </div>
                            <div class="content-box d-flex" style="margin-top: 10px;">
                                <div class="input-bar d-flex" style="margin-left: 120px;">
                                    <label for="priceInput3">Days:</label>
                                    <input type="number" id="priceInput3" min="0" max="100000" value="0"
                                        name="commission[]">
                                </div>
                                <div id="rangeValue3" style="margin-left: 170px;">0</div>
                            </div>
                        </div> --}}
                </div>

                <div class="row d-flex" style="margin-top: 20px;">
                </div>
                <div class="row d-flex" style="margin-top: 10px;">

                    <div class="col-md-2">
                        <div class="slider"><b>Return:</b>
                            <label for="fader4"></label><input type="range" min="0" max="100"
                                value="0" id="fader4" step="20" list="volsettings4"
                                name="new_return_days[]">
                            <datalist id="volsettings4">
                                <option>0</option>
                                <option>20</option>
                                <option>40</option>
                                <option>60</option>
                                <option>80</option>
                                <option>100</option>
                            </datalist>
                        </div>
                        <div class="content-box d-flex" style="margin-top: 10px;">
                            <div class="input-bar d-flex" style="margin-left: 90px;">
                                <label for="priceInput4">Days:</label>
                                <input type="number" id="priceInput4" min="0" max="100000" value="0"
                                    name="new_return_days[]">
                            </div>
                            <div id="rangeValue4" style="margin-left: 150px;">0</div>
                        </div>
                    </div>

                    <div class="col-md-2" style="margin-left: 210px;">
                        <div class="slider"><b>WarrantyDays:</b>
                            <label for="fader5"></label><input type="range" min="0" max="100"
                                value="0" id="fader5" step="20" list="volsettings5"
                                name="new_warranty_days[]">
                            <datalist id="volsettings5">
                                <option>0</option>
                                <option>20</option>
                                <option>40</option>
                                <option>60</option>
                                <option>80</option>
                                <option>100</option>
                            </datalist>
                        </div>
                        <div class="content-box d-flex" style="margin-top: 10px;">
                            <div class="input-bar d-flex" style="margin-left: 150px;">
                                <label for="priceInput5">Days:</label>
                                <input type="number" id="priceInput5" min="0" max="100000" value="0"
                                    name="new_warranty_days[]">
                            </div>
                            <div id="rangeValue5" style="margin-left: 180px;">0</div>
                        </div>
                    </div>


                </div>

                <button  class="btn btn-primary" style="margin-left: 1600px;">Submit</button>

            </form>

        </div>


    </div>


    <div class="separator-breadcrumb border-top"></div>
    <div class="breadcrumb col-lg-12">
        <div class="col-md-6 col-sm-6">
            <h1>All Products</h1>
        </div>
        <div class="col-md-6 col-sm-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('products.create') }}"><button
                    class="btn btn-outline-secondary ladda-button example-button m-1" data-style="expand-left"><span
                        class="ladda-label">Add Product</span></button></a>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Products</h4>
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        @include('datatables.table_content')
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        // ====

        // For selected Names
        document.addEventListener('DOMContentLoaded', function() {
            let selectedNamesOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedNamesOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedNamesOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedNamesOptions = selectedNamesOptions.filter(item => item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedNamesOptions', selectedNamesOptions);
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
                    selectedNamesOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedNamesOptions.includes(optionText)) {
                        selectedNamesOptions.push(optionText);
                    } else {
                        selectedNamesOptions = selectedNamesOptions.filter(item => item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedNamesOptions', selectedNamesOptions);
                });
            });

            document.getElementById('nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedNamesOptions', selectedNamesOptions);
                $('#nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedNamesOptions');
        });

        // For selected Model No
        document.addEventListener('DOMContentLoaded', function() {
            let selectedModelNoOptions = [];

            function updateSelectedModelNos() {
                const selectedOptionsDiv = document.getElementById('selectedModelNoOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedModelNoOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedModelNoOptions = selectedModelNoOptions.filter(item => item !==
                            option);
                        updateSelectedModelNos();
                        saveSelectedOptions('selectedModelNoOptions', selectedModelNoOptions);
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
                    selectedModelNoOptions = JSON.parse(savedOptions);
                    updateSelectedModelNos();
                }
            }

            document.querySelectorAll('.model_noFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedModelNoOptions.includes(optionText)) {
                        selectedModelNoOptions.push(optionText);
                    } else {
                        selectedModelNoOptions = selectedModelNoOptions.filter(item => item !==
                            optionText);
                    }
                    updateSelectedModelNos();
                    saveSelectedOptions('selectedModelNoOptions', selectedModelNoOptions);
                });
            });

            document.getElementById('model_noDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedModelNos();
            });

            document.getElementById('model_noDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedModelNos();
                saveSelectedOptions('selectedModelNoOptions', selectedModelNoOptions);
                $('#model_noDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedModelNoOptions');
        });

        // For selected Make
        document.addEventListener('DOMContentLoaded', function() {
            let selectedMakeOptions = [];

            function updateSelectedMakes() {
                const selectedOptionsDiv = document.getElementById('selectedmakeOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedMakeOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedMakeOptions = selectedMakeOptions.filter(item => item !== option);
                        updateSelectedMakes();
                        saveSelectedOptions('selectedMakeOptions', selectedMakeOptions);
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
                    selectedMakeOptions = JSON.parse(savedOptions);
                    updateSelectedMakes();
                }
            }

            document.querySelectorAll('.makeFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedMakeOptions.includes(optionText)) {
                        selectedMakeOptions.push(optionText);
                    } else {
                        selectedMakeOptions = selectedMakeOptions.filter(item => item !==
                            optionText);
                    }
                    updateSelectedMakes();
                    saveSelectedOptions('selectedMakeOptions', selectedMakeOptions);
                });
            });

            document.getElementById('makeDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedMakes();
            });

            document.getElementById('makeDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedMakes();
                saveSelectedOptions('selectedMakeOptions', selectedMakeOptions);
                $('#makeDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedMakeOptions');
        });

        //For Subcategories
        document.addEventListener('DOMContentLoaded', function() {
            let selectedsubcategoriesOptions = [];

            function updateSelectedsubcategories() {
                const selectedOptionsDiv = document.getElementById('selectedsubcategoriesOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedsubcategoriesOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedsubcategoriesOptions = selectedsubcategoriesOptions.filter(item =>
                            item !== option);
                        updateSelectedsubcategories();
                        saveSelectedOptions('selectedsubcategoriesOptions',
                            selectedsubcategoriesOptions);
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
                    selectedsubcategoriesOptions = JSON.parse(savedOptions);
                    updateSelectedsubcategories();
                }
            }

            document.querySelectorAll('.nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedsubcategoriesOptions.includes(optionText)) {
                        selectedsubcategoriesOptions.push(optionText);
                    } else {
                        selectedsubcategoriesOptions = selectedsubcategoriesOptions.filter(item =>
                            item !== optionText);
                    }
                    updateSelectedsubcategories();
                    saveSelectedOptions('selectedsubcategoriesOptions',
                        selectedsubcategoriesOptions);
                });
            });

            document.getElementById('subcategoriesDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedsubcategories();
            });

            document.getElementById('subcategoriesDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedsubcategories();
                saveSelectedOptions('selectedsubcategoriesOptions', selectedsubcategoriesOptions);
                $('#subcategoriesDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedsubcategoriesOptions');
        });

        //For brand_name
        document.addEventListener('DOMContentLoaded', function() {
            let selectedbrand_nameOptions = [];

            function updateSelectedbrand_name() {
                const selectedOptionsDiv = document.getElementById('selectedbrand_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                // Render selected options
                selectedbrand_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedbrand_nameOptions = selectedbrand_nameOptions.filter(item =>
                            item !== option);
                        updateSelectedbrand_name();
                        saveSelectedOptions('selectedbrand_nameOptions', selectedbrand_nameOptions);
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
                    selectedbrand_nameOptions = JSON.parse(savedOptions);
                    updateSelectedbrand_name();
                }
            }

            document.querySelectorAll('.brand_idFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.parentElement.querySelector('.option-text').textContent;
                    if (this.checked && !selectedbrand_nameOptions.includes(optionText)) {
                        selectedbrand_nameOptions.push(optionText);
                    } else {
                        selectedbrand_nameOptions = selectedbrand_nameOptions.filter(item =>
                            item !== optionText);
                    }
                    updateSelectedbrand_name();
                    saveSelectedOptions('selectedbrand_nameOptions', selectedbrand_nameOptions);
                });
            });

            document.getElementById('brand_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedbrand_name();
            });

            document.getElementById('brand_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedbrand_name();
                saveSelectedOptions('selectedbrand_nameOptions', selectedbrand_nameOptions);
                $('#brand_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedbrand_nameOptions');
        });

        // ===
        // search for data through input == Saliha
        function filterNames() {
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

        function filterModelNo() {
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

        function filtersuppliername() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('makeSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('makeOptions');
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

        function filtersubcategories() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('subcategoriesSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('subcategoriesOptions');
            li = ul.getElementsByTagName('label');

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

        function filterbrand_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('brand_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('brand_nameOptions');
            li = ul.getElementsByTagName('label');

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

            var slider4 = document.getElementById("fader4");
            var input4 = document.getElementById("priceInput4");
            var rangeValue4 = document.getElementById("rangeValue4");

            input4.addEventListener("input", function() {
                var value = parseInt(this.value);
                if (!isNaN(value) && value >= 0 && value <= 100000) {
                    slider4.value = value;
                    rangeValue4.textContent = value;
                }
            });

            slider4.addEventListener("input", function() {
                input4.value = this.value;
                rangeValue4.textContent = this.value;
            });

            var slider5 = document.getElementById("fader5");
            var input5 = document.getElementById("priceInput5");
            var rangeValue5 = document.getElementById("rangeValue5");

            input5.addEventListener("input", function() {
                var value = parseInt(this.value);
                if (!isNaN(value) && value >= 0 && value <= 100000) {
                    slider5.value = value;
                    rangeValue5.textContent = value;
                }
            });

            slider5.addEventListener("input", function() {
                input5.value = this.value;
                rangeValue5.textContent = this.value;
            });
        });
    </script>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/es5/widgets-statistics.min.js')}}"></script>
<script>
var options = {
    chart: {
        height: 350,
        type: 'line',
        shadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 1
        },
        toolbar: {
            show: false
        },
        animations: {
            enabled: true,
            easing: 'linear',
            speed: 500,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 550
            }
        },
    },
    colors: ['#77B6EA', '#545454'],
    dataLabels: {
        enabled: true,
    },
    stroke: {
        curve: 'smooth'
    },
    series: [{
            name: "[Products - 2024]",
            data: [{{ $allproducts }}]
        },
        {
            name: "[Suppliers - 2024]",
            data: [ {{ $totalSupplier }}]
        }
    ],
    grid: {
        borderColor: '#e7e7e7',
        row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
        },
    },
    markers: {
        size: 6
    },
    yaxis: {
        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        title: {
            text: 'Month'
        }
    },
    xaxis: {
        type: 'datetime',
        labels: {
            format: 'dd-MMM',
        },
        title: {
            text: 'Date'
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5
    }
}

var chart = new ApexCharts(
    document.querySelector("#lineChartWIthDataLabel"),
    options
);
chart.render();

</script>

@endsection
