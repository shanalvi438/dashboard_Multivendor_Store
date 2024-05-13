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


    <div class="row">
        <div class="">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="card-title" style=" margin-left: -20px; ">Total Supplier || Active Vs In Active
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title" style=" text-align: end; ">Total Supplier: {{ $totalSupplier }} ||
                                Active: {{ $totalActiveSupplier }} || InActive: {{ $totalInActiveSupplier }}</div>
                        </div>
                    </div>
                    <div id="basicLine1"
                        style="height: 300px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;"
                        _echarts_instance_="ec_1709707664528">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-4" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('vendors.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('vendors.index') }}" method="GET">
                <div class="row" style="margin-top: 5px; margin-bottom: 50px">

                    <div class="col-md-2">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Vendor Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="nameSearchInput" placeholder="Search..."
                                    oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($vendor as $key => $vendors)
                                        <label class="nameFilter">
                                            <input type="checkbox" name="name[]" value="{{ $vendors->name ?? null }}">
                                            <span class="option-text" name="name[]">{{ $vendors->name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectednameList"></div>
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
                                    @foreach ($vendor as $key => $vendors)
                                        <label class="phone1Filter">
                                            <input type="checkbox" value="{{ $vendors->phone1 }}" name="phone1[]">
                                            <span class="option-text" name="id">{{ $vendors->phone1 }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedphone1List"></div>
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
                                    @foreach ($vendor as $key => $vendors)
                                        <label class="emailFilter">
                                            <input type="checkbox" value="{{ $vendors->email }}" name="email[]">
                                            <span class="option-text" name="id">{{ $vendors->email }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedemailList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="dropdown" id="statusDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Status</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="statusSearchInput" placeholder="Search..."
                                    oninput="filterstatus()">
                                <div class="dropdown-options" id="statusOptions">
                                    <label class="statusFilter" for="statusFilter">
                                        <input type="checkbox" id="selectAllstatus" class="statusFilter">
                                        <span class="option-text" name="status[]">Select All</span>
                                    </label>
                                    <div id="selectedstatusOptions"></div>
                                    @foreach ($vendor as $key => $vendors)
                                        <label class="statusFilter">
                                            <input type="checkbox" value="{{ $vendors->status }}" name="status[]">
                                            <span class="option-text" name="id">{{ $vendors->status }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedstatusList"></div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-3 d-flex">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status[]" type="checkbox" id="activeSwitch">
                                    <label class="form-check-label" name="status[]" for="activeSwitch">Active</label>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-left: 30px;">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status[]" type="checkbox" id="inactiveSwitch" checked>
                                    <label class="form-check-label" name="status[]" for="inactiveSwitch">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <script>
                        $(document).ready(function() {
                            // Initial data load
                            loadData();

                            // Handle switch changes
                            $('#activeSwitch, #inactiveSwitch').change(function() {
                                loadData();
                            });

                            // Function to load data based on selected status
                            function loadData() {
                                var active = $('#activeSwitch').is(':checked') ? 1 : 0;
                                var inactive = $('#inactiveSwitch').is(':checked') ? 1 : 0;

                                $.ajax({
                                    url: 'your-api-url',
                                    type: 'GET',
                                    data: {
                                        active: active,
                                        inactive: inactive
                                    },
                                    success: function(data) {
                                        // Update the list with filtered data
                                        updateList(data);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }

                            // Function to update the list with filtered data
                            function updateList(data) {
                                // Update your list here
                            }
                        });
                    </script> --}}

                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>
            </form>
        </div>
    </div>

    <div class="breadcrumb">
        <div class="col-md-6">
            <h1>Vendor's Management</h1>
        </div>
        <div class="col-md-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('vendors.create') }}"><button
                    class="btn btn-outline-secondary  ladda-button example-button m-1" data-style="expand-left"><span
                        class="ladda-label">Add Vendor</span></button></a>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All Vendors</h4>

                {{-- <p>.....</p> --}}

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
         // For selected Name
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
        var a = document.getElementById("basicLine1");
        if (a) {
            var r = echarts.init(a);
            r.setOption({
                    tooltip: {
                        show: !0,
                        trigger: "axis",
                        axisPointer: {
                            type: "line",
                            animation: !0
                        },
                    },
                    grid: {
                        top: "10%",
                        left: "40",
                        right: "40",
                        bottom: "40"
                    },
                    xAxis: {
                        type: "category",
                        data: [
                            "1/11/2018",
                            "2/11/2018",
                            "3/11/2018",
                            "4/11/2018",
                            "5/11/2018",
                            "6/11/2018",
                            "7/11/2018",
                            "8/11/2018",
                            "9/11/2018",
                            "10/11/2018",
                            "11/11/2018",
                            "12/11/2018",
                            "13/11/2018",
                            "14/11/2018",
                            "15/11/2018",
                            "16/11/2018",
                            "17/11/2018",
                            "18/11/2018",
                            "19/11/2018",
                            "20/11/2018",
                            "21/11/2018",
                            "22/11/2018",
                            "23/11/2018",
                            "24/11/2018",
                            "25/11/2018",
                            "26/11/2018",
                            "27/11/2018",
                            "28/11/2018",
                            "29/11/2018",
                            "30/11/2018",
                        ],
                        axisLine: {
                            show: !1
                        },
                        axisLabel: {
                            show: !0
                        },
                        axisTick: {
                            show: !1
                        },
                    },
                    yAxis: {
                        type: "value",
                        axisLine: {
                            show: !1
                        },
                        axisLabel: {
                            show: !0
                        },
                        axisTick: {
                            show: !1
                        },
                        splitLine: {
                            show: !0
                        },
                    },
                    series: [{
                        name: "Active",

                        data: [

                            400, 800, 325, 900, 700, 800, 400, 900, 800, 800, 300,
                            405, 500, 1100, 900, 1450, 1200, 1350, 1200, 1400, 1e3,
                            800, 950, 705, 690, 921, 1020, 903, 852, 630,

                        ],
                        type: "line",
                        showSymbol: !0,
                        smooth: !0,
                        color: "#639",
                        lineStyle: {
                            opacity: 1,
                            width: 2
                        },
                    }, ],
                }),
                $(window).on("resize", function() {
                    setTimeout(function() {
                        r.resize();
                    }, 500);
                });
        }
    </script>
@endsection
