@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
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
            <div class="col-md-3" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('brands.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
                <form action="{{ route('brands.index') }}" method="GET">
                <div class="row" style="margin-top: 5px; margin-bottom: 0px;">
                    <div class="col-md-2">
                        <div class="dropdown" id="brand_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton5" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Brand</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5"
                                style="max-width: 1000px;">
                                <input type="text" id="brand_nameSearchInput" placeholder="Search..."
                                    oninput="filterbrand_name()" name="brand_name[]">
                                <div class="dropdown-options" id="brand_nameOptions" name="brand_name[]">
                                    <label class="brand_nameFilter" for="brand_nameFilter" name="brand_name[]">
                                        <input type="checkbox" id="selectAllbrand_name" class="brand_nameFilter">
                                        <span class="option-text" name="brand_name[]">Select All</span>
                                    </label>
                                    <div id="selectedbrand_nameOptions"></div>
                                    @foreach ($allbrands as $brand)
                                    <label class="brand_nameFilter d-flex">
                                        <input type="checkbox" name="brands[]" style="margin-bottom: 3px;"
                                               value="{{ $brand->brand_name }}">
                                        <span class="option-text d-flex"> {{ $brand->brand_name }} <img
                                                src="{{ asset($brand->logo) }}" width="50" height="50"
                                                alt="{{ $brand->brand_name }}">
                                        </span>
                                    </label>
                                @endforeach
                                </div>
                                <div id="selectedbrand_nameList"></div>
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
                <h1>Brand's Management</h1>
        </div>
        <div class="col-md-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('brands.create')}}"><button class="btn btn-outline-secondary  ladda-button example-button m-1" data-style="expand-left"><span class="ladda-label">Add Brand</span></button></a>

        </div>
    </div>

            <div class="separator-breadcrumb border-top"></div>
            <div class="col-md-12 mb-4">
                <div class="card text-start">

                    <div class="card-body">
                        <h4 class="card-title mb-3">All Brand's</h4>


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
                 document.addEventListener('DOMContentLoaded', function() {
            let selectedbrand_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedbrand_nameOptions');
                selectedOptionsDiv.innerHTML = '';

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
                        updateSelectedOptions();
                        saveSelectedOptions('selectedbrand_nameOptions',
                            selectedbrand_nameOptions);
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
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.brand_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedbrand_nameOptions.includes(optionText)) {
                        selectedbrand_nameOptions.push(optionText);
                    } else {
                        selectedbrand_nameOptions = selectedbrand_nameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedbrand_nameOptions',
                        selectedbrand_nameOptions);
                });
            });

            document.getElementById('brand_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('brand_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedbrand_nameOptions', selectedbrand_nameOptions);
                $('#brand_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedbrand_nameOptions');
        });

        function filterbrand_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('brand_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('brand_nameOptions');
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
            @endsection

