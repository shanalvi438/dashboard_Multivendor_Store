@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
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
            padding-left: 50px;
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
            <div class="col-md-4" style="margin-left: 20px;">
                <div class="content-box d-flex">
                    <form action="{{ route('customerlist') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                </div>
            </div>
            <form action="{{ route('customerlist') }}" method="GET">
                <div class="row" style="margin-top: 5px; margin-bottom: 50px">
                    <div class="col-md-2">
                        <div class="dropdown" id="idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="idSearchInput" placeholder="Search..." oninput="filterid()">
                                <div class="dropdown-options" id="idOptions">
                                    <label class="idFilter" for="idFilter">
                                        <input type="checkbox" id="selectAllid" class="idFilter">
                                        <span class="option-text" name="id[]">Select All</span>
                                    </label>
                                    <div id="selectedidOptions"></div>
                                    @foreach ($customers as $customer)
                                    <label class="idFilter">
                                        <input type="checkbox" value="{{ $customer->id }}" name="id[]">
                                        <span class="option-text" name="id[]">{{ $customer->id }}</span>
                                    </label>
                                @endforeach
                                </div>
                                <div id="selectedidList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="first_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">First Name#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="first_nameSearchInput" placeholder="Search..."
                                    oninput="filterfirst_name()">
                                <div class="dropdown-options" id="first_nameOptions">
                                    <label class="first_nameFilter" for="first_nameFilter">
                                        <input type="checkbox" id="selectAllfirst_name" class="first_nameFilter">
                                        <span class="option-text" name="first_name[]">Select All</span>
                                    </label>
                                    <div id="selectedfirst_nameOptions"></div>
                                    @foreach ($customers as $customer)
                                        <label class="first_nameFilter">
                                            <input type="checkbox" value="{{ $customer->first_name }}" name="first_name[]">
                                            <span class="option-text" name="first_name[]">{{ $customer->first_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedfirst_nameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="last_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Last Name#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="last_nameSearchInput" placeholder="Search..."
                                    oninput="filterlast_name()">
                                <div class="dropdown-options" id="last_nameOptions">
                                    <label class="last_nameFilter" for="last_nameFilter">
                                        <input type="checkbox" id="selectAlllast_name" class="last_nameFilter">
                                        <span class="option-text" name="last_name[]">Select All</span>
                                    </label>
                                    <div id="selectedlast_nameOptions"></div>
                                    @foreach ($customers as $customer)
                                        <label class="last_nameFilter">
                                            <input type="checkbox" value="{{ $customer->last_name }}"
                                                name="last_name[]">
                                            <span class="option-text" name="id">{{ $customer->last_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedlast_nameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="genderDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Gender</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="genderSearchInput" placeholder="Search..."
                                    oninput="filtergender()">
                                <div class="dropdown-options" id="genderOptions">
                                    <label class="genderFilter" for="genderFilter">
                                        <input type="checkbox" id="selectAllgender" class="genderFilter">
                                        <span class="option-text" name="gender[]">Select All</span>
                                    </label>
                                    <div id="selectedgenderOptions"></div>
                                    @foreach ($customers as $customer)
                                        <label class="genderFilter">
                                            <input type="checkbox" value="{{ $customer->gender }}" name="gender[]">
                                            <span class="option-text" name="id">{{ $customer->gender }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedgenderList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="emailDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Email ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="emailSearchInput" placeholder="Search..."
                                    oninput="filteremail()">
                                <div class="dropdown-options" id="emailOptions">
                                    <label class="emailFilter" for="emailFilter">
                                        <input type="checkbox" id="selectAllemail" class="emailFilter">
                                        <span class="option-text" name="email[]">Select All</span>
                                    </label>
                                    <div id="selectedemailOptions"></div>
                                    @foreach ($customers as $customer)
                                        <label class="emailFilter">
                                            <input type="checkbox" value="{{ $customer->email }}" name="email[]">
                                            <span class="option-text" name="id">{{ $customer->email }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedemailList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="phone1Dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Phone No#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="phone1SearchInput" placeholder="Search..."
                                    oninput="filterphone1()">
                                <div class="dropdown-options" id="phone1Options">
                                    <label class="phone1Filter" for="phone1Filter">
                                        <input type="checkbox" id="selectAllphone1" class="phone1Filter">
                                        <span class="option-text" name="phone1[]">Select All</span>
                                    </label>
                                    <div id="selectedphone1Options"></div>
                                    @foreach ($customers as $customer)
                                        <label class="phone1Filter">
                                            <input type="checkbox" value="{{ $customer->phone1 }}" name="phone1[]">
                                            <span class="option-text" name="id">{{ $customer->phone1 }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedphone1List"></div>
                            </div>
                        </div>
                    </div>


                </div>

                {{-- <div class="col-md-3 d-flex"> Gender:
                        <div class="ul-form__radio-inline d-flex">
                            <label class="ul-radio__position radio radio-primary form-check-inline">
                            <input type="radio" name="gender" value="male" <?php if ($customers->gender == 'male') {
                                echo 'checked';
                            } ?>>
                            <span class="ul-form__radio-font">Male</span>
                            <span class="checkmark"></span>
                            </label>

                            <label class="ul-radio__position radio radio-primary form-check-inline">
                                <input type="radio" name="gender" value="female" <?php if ($customers->gender == 'female') {
                                    echo 'checked';
                                } ?>>
                                <span class="ul-form__radio-font">Female</span>
                                <span class="checkmark"></span>
                                </label>

                        </div>
                    </div> --}}
                <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>

            </form>
        </div>
    </div>


    <div class="separator-breadcrumb border-top"></div>
    <div class="breadcrumb">
        <h1>Customer Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Customers</h4>
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

        //first name == Saliha

        document.addEventListener('DOMContentLoaded', function() {
            let selectedfirst_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedfirst_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedfirst_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedfirst_nameOptions = selectedfirst_nameOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedfirst_nameOptions',
                            selectedfirst_nameOptions);
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
                    selectedfirst_nameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.first_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedfirst_nameOptions.includes(optionText)) {
                        selectedfirst_nameOptions.push(optionText);
                    } else {
                        selectedfirst_nameOptions = selectedfirst_nameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedfirst_nameOptions',
                        selectedfirst_nameOptions);
                });
            });

            document.getElementById('first_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('first_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedfirst_nameOptions', selectedfirst_nameOptions);
                $('#first_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedfirst_nameOptions');
        });

        function filterfirst_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('first_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('first_nameOptions');
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

        //last name

        document.addEventListener('DOMContentLoaded', function() {
            let selectedlast_nameOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedlast_nameOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedlast_nameOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedlast_nameOptions = selectedlast_nameOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedlast_nameOptions',
                            selectedlast_nameOptions);
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
                    selectedlast_nameOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.last_nameFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedlast_nameOptions.includes(optionText)) {
                        selectedlast_nameOptions.push(optionText);
                    } else {
                        selectedlast_nameOptions = selectedlast_nameOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedlast_nameOptions',
                        selectedlast_nameOptions);
                });
            });

            document.getElementById('last_nameDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('last_nameDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedlast_nameOptions', selectedlast_nameOptions);
                $('#last_nameDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedlast_nameOptions');
        });

        function filterlast_name() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('last_nameSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('last_nameOptions');
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
            let selectedgenderOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedgenderOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedgenderOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedgenderOptions = selectedgenderOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedgenderOptions',
                            selectedgenderOptions);
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
                    selectedgenderOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.genderFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedgenderOptions.includes(optionText)) {
                        selectedgenderOptions.push(optionText);
                    } else {
                        selectedgenderOptions = selectedgenderOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedgenderOptions',
                        selectedgenderOptions);
                });
            });

            document.getElementById('genderDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('genderDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedgenderOptions', selectedgenderOptions);
                $('#genderDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedgenderOptions');
        });

        function filtergender() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('genderSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('genderOptions');
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
            let selectedemailOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedemailOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedemailOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedemailOptions = selectedemailOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedemailOptions',
                            selectedemailOptions);
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
                    selectedemailOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.emailFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedemailOptions.includes(optionText)) {
                        selectedemailOptions.push(optionText);
                    } else {
                        selectedemailOptions = selectedemailOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedemailOptions',
                        selectedemailOptions);
                });
            });

            document.getElementById('emailDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('emailDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedemailOptions', selectedemailOptions);
                $('#emailDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedemailOptions');
        });

        function filteremail() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('emailSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('emailOptions');
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
            let selectedphone1Options = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedphone1Options');
                selectedOptionsDiv.innerHTML = '';

                selectedphone1Options.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedphone1Options = selectedphone1Options.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedphone1Options',
                            selectedphone1Options);
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
                    selectedphone1Options = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.phone1Filter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedphone1Options.includes(optionText)) {
                        selectedphone1Options.push(optionText);
                    } else {
                        selectedphone1Options = selectedphone1Options.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedphone1Options',
                        selectedphone1Options);
                });
            });

            document.getElementById('phone1Dropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('phone1Dropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedphone1Options', selectedphone1Options);
                $('#phone1Dropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedphone1Options');
        });

        function filterphone1() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('phone1SearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('phone1Options');
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
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
@endsection
