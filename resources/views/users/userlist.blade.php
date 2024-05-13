@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
@endsection
@section('main-content')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
{{-- Userlist with filters all done === Saliha --}}
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
            padding-right: 45px;
            padding-left: 45px;
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
                    <form action="{{ route('userlist') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('userlist') }}" method="GET">
                <div class="row" style="margin-top: 5px; margin-bottom: 50px">

                    <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Username</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="nameSearchInput" placeholder="Search..." oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="nameFilter">
                                            <input type="checkbox" name="name[]" value="{{ $user->name ?? null }}">
                                            <span class="option-text" name="name[]">{{ $user->name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectednameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="emailDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Email</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="emailSearchInput" placeholder="Search..." oninput="filteremail()">
                                <div class="dropdown-options" id="emailOptions">
                                    <label class="emailFilter" for="emailFilter">
                                        <input type="checkbox" id="selectAllemail" class="emailFilter">
                                        <span class="option-text" name="email[]">Select All</span>
                                    </label>
                                    <div id="selectedemailOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="emailFilter">
                                            <input type="checkbox" name="email[]" value="{{ $user->email ?? null }}">
                                            <span class="option-text" name="email[]">{{ $user->email ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedemailList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="countryDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Country</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="countrySearchInput" placeholder="Search..."
                                    oninput="filtercountry()">
                                <div class="dropdown-options" id="countryOptions">
                                    <label class="countryFilter" for="countryFilter">
                                        <input type="checkbox" id="selectAllcountry" class="countryFilter">
                                        <span class="option-text" name="country[]">Select All</span>
                                    </label>
                                    <div id="selectedcountryOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="countryFilter">
                                            <input type="checkbox" name="country[]"
                                                value="{{ $user->country ?? null }}">
                                            <span class="option-text"
                                                name="country[]">{{ $user->country ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcountryList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="cityDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">City</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="citySearchInput" placeholder="Search..."
                                    oninput="filtercity()">
                                <div class="dropdown-options" id="cityOptions">
                                    <label class="cityFilter" for="cityFilter">
                                        <input type="checkbox" id="selectAllcity" class="cityFilter">
                                        <span class="option-text" name="city[]">Select All</span>
                                    </label>
                                    <div id="selectedcityOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="cityFilter">
                                            <input type="checkbox" name="city[]" value="{{ $user->city ?? null }}">
                                            <span class="option-text" name="city[]">{{ $user->city ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcityList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="dropdown" id="addresDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Address#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="addresSearchInput" placeholder="Search..."
                                    oninput="filteraddres()">
                                <div class="dropdown-options" id="addresOptions">
                                    <label class="addresFilter" for="addresFilter">
                                        <input type="checkbox" id="selectAlladdres" class="addresFilter">
                                        <span class="option-text" name="addres[]">Select All</span>
                                    </label>
                                    <div id="selectedaddresOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="addresFilter">
                                            <input type="checkbox" name="addres[]" value="{{ $user->addres ?? null }}">
                                            <span class="option-text" name="addres[]">{{ $user->addres ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedaddresList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="dropdown" id="genderDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Gender</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="genderSearchInput" placeholder="Search..."
                                    oninput="filtergender()">
                                <div class="dropdown-options" id="genderOptions">
                                    <label class="genderFilter" for="genderFilter">
                                        <input type="checkbox" id="selectAllgender" class="genderFilter">
                                        <span class="option-text" name="gender[]">Select All</span>
                                    </label>
                                    <div id="selectedgenderOptions"></div>
                                    @foreach ($users as $user)
                                        <label class="genderFilter">
                                            <input type="checkbox" name="gender[]" value="{{ $user->gender ?? null }}">
                                            <span class="option-text" name="gender[]">{{ $user->gender ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedgenderList"></div>
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
        <h1>User List</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">
            <div class="card-body">
                <h4 class="card-title mb-3">User List</h4>

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
            let selectedphoneOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedphoneOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedphoneOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedphoneOptions = selectedphoneOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedphoneOptions',
                            selectedphoneOptions);
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
                    selectedphoneOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.phoneFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedphoneOptions.includes(optionText)) {
                        selectedphoneOptions.push(optionText);
                    } else {
                        selectedphoneOptions = selectedphoneOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedphoneOptions',
                        selectedphoneOptions);
                });
            });

            document.getElementById('phoneDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('phoneDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedphoneOptions', selectedphoneOptions);
                $('#phoneDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedphoneOptions');
        });

        function filterphone() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('phoneSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('phoneOptions');
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
            let selectedcountryOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedcountryOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedcountryOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedcountryOptions = selectedcountryOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedcountryOptions',
                            selectedcountryOptions);
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
                    selectedcountryOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.countryFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedcountryOptions.includes(optionText)) {
                        selectedcountryOptions.push(optionText);
                    } else {
                        selectedcountryOptions = selectedcountryOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcountryOptions',
                        selectedcountryOptions);
                });
            });

            document.getElementById('countryDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('countryDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedcountryOptions', selectedcountryOptions);
                $('#countryDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedcountryOptions');
        });

        function filtercountry() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('countrySearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('countryOptions');
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
            let selectedcityOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedcityOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedcityOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedcityOptions = selectedcityOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedcityOptions',
                            selectedcityOptions);
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
                    selectedcityOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.cityFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedcityOptions.includes(optionText)) {
                        selectedcityOptions.push(optionText);
                    } else {
                        selectedcityOptions = selectedcityOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcityOptions',
                        selectedcityOptions);
                });
            });

            document.getElementById('cityDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('cityDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedcityOptions', selectedcityOptions);
                $('#cityDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedcityOptions');
        });

        function filtercity() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('citySearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('cityOptions');
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
            let selectedaddresOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedaddresOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedaddresOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedaddresOptions = selectedaddresOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedaddresOptions',
                            selectedaddresOptions);
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
                    selectedaddresOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.addresFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedaddresOptions.includes(optionText)) {
                        selectedaddresOptions.push(optionText);
                    } else {
                        selectedaddresOptions = selectedaddresOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedaddresOptions',
                        selectedaddresOptions);
                });
            });

            document.getElementById('addresDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('addresDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedaddresOptions', selectedaddresOptions);
                $('#addresDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedaddresOptions');
        });

        function filteraddres() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('addresSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('addresOptions');
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
