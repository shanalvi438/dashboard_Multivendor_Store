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
    </style>
    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <form action="{{ route('sub-category.index') }}" method="GET">
                <div class="col-md-4" style="margin-left: 22px;">
                    <div class="content-box d-flex">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </div>
            </form>
        </div>
        <form action="{{ route('sub-category.index') }}" method="GET">

            <div class="row" style="margin-top: 15px;">
                <div class="col-md-2">
                    <div class="dropdown" id="slugDropdown">
                        <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <p class="text-left">Slug</p>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <input type="text" id="slugSearchInput" placeholder="Search..." oninput="filterslug()">
                            <div class="dropdown-options" id="slugOptions">
                                <label class="slugFilter" for="slugFilter">
                                    <input type="checkbox" id="selectAllslug" class="slugFilter">
                                    <span class="option-text" name="slug[]">Select All</span>
                                </label>
                                <div id="selectedslugOptions"></div>
                                @foreach ($data as $key => $donor)
                                    <label class="slugFilter">
                                        <input type="checkbox" name="slug[]" value="{{ $donor->slug ?? null }}">
                                        <span class="option-text" name="slug[]">{{ $donor->slug ?? null }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div id="selectedslugList"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="dropdown" id="nameDropdown">
                        <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <p class="text-left">Category</p>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <input type="text" id="nameearchInput" placeholder="Search..."
                                oninput="filtername()">
                            <div class="dropdown-options" id="nameOptions">
                                <label class="nameFilter" for="nameFilter">
                                    <input type="checkbox" id="selectAllname" class="nameFilter">
                                    <span class="option-text" name="name[]">Select All</span>
                                </label>
                                <div id="selectednameOptions"></div>
                                @foreach ($data as $key => $donor)
                                    <label class="nameFilter">
                                        <input type="checkbox" name="name[]"
                                            value="{{ $donor->categories->name ?? null }}">
                                        <span class="option-text"
                                            name="name[]">{{ $donor->categories->name ?? null }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div id="selectednameList"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3" style="margin-left: 100px;">
                    <div class="col-md-4">
                        <div class="slider"><b>Commission:</b>
                            <label for="fader1"></label><input type="range" min="0" max="100" value="0"
                                id="fader1" step="20" list="volsettings1" name="commission[]">
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
                                <label for="priceInput1">$:</label>
                                <input type="number" id="priceInput1" min="0" max="100000" value="0"
                                    name="commission[]">
                            </div>
                            <div id="rangeValue1" style="margin-left: 200px;">0</div>
                        </div>
                    </div>

                </div>

            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>
        </form>

    </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="breadcrumb">
        <div class="col-md-6">
            <h1>All sub Categories</h1>
        </div>
        <div class="col-md-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('sub-category.create') }}"><button
                    class="btn btn-outline-secondary ladda-button example-button m-1" data-style="expand-left"><span
                        class="ladda-label">Create Sub-Category</span></button></a>
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">
            <div class="card-body">
                <h4 class="card-title mb-3">All Sub Categories</h4>
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        @include('datatables.table_content')
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
    <script>
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
                        selectednameOptions = selectednameOptions.filter(item =>
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
                    if (this.checked && !selectednameOptions.includes(optionText)) {
                        selectednameOptions.push(optionText);
                    } else {
                        selectednameOptions = selectednameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectednameOptions',
                        selectednameOptions);
                });
            });

            document.getElementById('nameDropdown').addEventListener('hidden.bs.dropdown', function() {
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

        //SLUG
        document.addEventListener('DOMContentLoaded', function() {
            let selectedslugOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedslugOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedslugOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedslugOptions = selectedslugOptions.filter(item => item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedslugOptions', selectedslugOptions);
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
                    selectedslugOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.slugFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedslugOptions.includes(optionText)) {
                        selectedslugOptions.push(optionText);
                    } else {
                        selectedslugOptions = selectedslugOptions.filter(item => item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedslugOptions', selectedslugOptions);
                });
            });

            document.getElementById('slugDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('slugDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedslugOptions', selectedslugOptions);
                $('#slugDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedslugOptions');
        });

        function filtername() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('nameearchInput');
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

        function filterslug() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('slugSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('slugOptions');
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
    </script>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
