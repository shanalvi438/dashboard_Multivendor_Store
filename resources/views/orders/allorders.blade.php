@extends('layouts.master')
@section('page-css')
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

    {{-- <div class="separator-breadcrumb border-top"></div> --}}


    <div class="row">
        <div class="">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title" style=" margin-left: -20px; ">Total Order Vs Sales</div>
                        </div>
                        <div class="col-6">
                            <div class="card-title" style=" text-align: end; ">Total Orders: {{ $allorders }} || Total
                                Parcel's: {{ $allparcels }}</div>
                        </div>
                    </div>
                    <div id="stackedPointerArea1"
                        style="height: 300px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;"
                        _echarts_instance_="ec_1709707664537">
                        <div
                            style="position: relative; overflow: hidden; width: 613px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                            <canvas data-zr-dom-id="zr_0" width="766" height="375"
                                style="position: absolute; left: 0px; top: 0px; width: 613px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-2" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('allorders') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('allorders') }}" method="GET">
                <div class="row" style="margin-top: 15px;">

                    <div class="col-md-2">
                        <div class="dropdown" id="idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Order ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="idSearchInput" placeholder="Search..." oninput="filterid()">
                                <div class="dropdown-options" id="idOptions">
                                    <label class="idFilter d-flex" for="idFilter" name="id[]">
                                        <input type="checkbox" id="selectAllid" class="idFilter" name="id[]">
                                        <span class="option-text" name="id[]">Select All</span>
                                    </label>
                                    <div id="selectedidOptions"></div>
                                    @foreach ($data as $value => $orders)
                                        <label class="idFilter">
                                            <input type="checkbox" name="id[]" value="{{ $orders->id ?? null }}">
                                            <span class="option-text" name="id[]">{{ $orders->id ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedidList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="first_nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Customer Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="first_nameSearchInput" placeholder="Search..."
                                    oninput="filterfirst_name()">
                                <div class="dropdown-options" id="first_nameOptions">
                                    <label class="first_nameFilter" for="first_nameFilter">
                                        <input type="checkbox" id="selectAllfirst_name" class="first_nameFilter">
                                        <span class="option-text" name="first_name[]">Select All</span>
                                    </label>
                                    <div id="selectedfirst_nameOptions"></div>
                                    @foreach ($data as $value => $orders)
                                    <label class="first_nameFilter">
                                        <input type="checkbox" name="first_name[]" value="{{ $orders->first_name ?? '' }} {{ $orders->last_name ?? '' }}">
                                        <span class="option-text" name="first_name[]">{{ $orders->first_name ?? '' }} {{ $orders->last_name ?? '' }}</span>
                                    </label>
                                @endforeach
                                </div>
                                <div id="selectedfirst_nameList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown" id="shipping_cityDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Location</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="shipping_citySearchInput" placeholder="Search..."
                                    oninput="filtershipping_city()">
                                <div class="dropdown-options" id="shipping_cityOptions">
                                    <label class="shipping_cityFilter" for="shipping_cityFilter">
                                        <input type="checkbox" id="selectAllshipping_city" class="shipping_cityFilter">
                                        <span class="option-text" name="shipping_city[]">Select All</span>
                                    </label>
                                    <div id="selectedshipping_cityOptions"></div>
                                    @foreach ($data as $value => $orders)

                                        {{-- <label class="shipping_cityFilter">
                                            <input type="checkbox" name="shipping_city[]"
                                                value="{{ $orders->shipping_shipping_city ?? null }},{{ $orders->shipping_city ?? null }},{{ $orders->shipping_state ?? null }} , {{ $orders->shipping_zipcode ?? null }},{{ $orders->shipping_country ?? null }}">
                                            <span class="option-text"
                                                name="shipping_city[]">{{ $orders->shipping_shipping_city ?? null }},{{ $orders->shipping_city ?? null }},{{ $orders->shipping_state ?? null }}
                                                ,
                                                {{ $orders->shipping_zipcode ?? null }},{{ $orders->shipping_country ?? null }}</span>
                                        </label> --}}

                                        <label class="shipping_cityFilter">
                                            <input type="checkbox" name="shipping_city[]" value="{{ $orders->shipping_city ?? null }}">
                                            <span class="option-text" name="shipping_city[]">{{ $orders->shipping_city ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedshipping_cityList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="slider"><b>Amount:</b>
                            <label for="fader1"></label><input type="range" min="0" max="100" value="0" id="fader1" step="20" list="volsettings" name="total_price">
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
                                <input type="number" id="priceInput1" min="0" max="100000" value="0" name="total_price">
                            </div>
                            <div id="rangeValue1" style="margin-left: 200px;">0</div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 1600px;">Submit</button>

            </form>

        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="breadcrumb">
        <h1>All Orders</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">All orders</h4>
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%;">
                        @include('datatables.table_content')
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
       document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    const totalPriceSlider = document.getElementById('fader1').value;
    const totalPriceInput = document.getElementById('priceInput1').value;
    const totalPrice = totalPriceSlider !== '0' ? totalPriceSlider : totalPriceInput;
    this.querySelector('input[name="total_price"]').value = totalPrice;
    this.submit();
});

        //Order ID == Saliha
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
                        selectedidOptions = selectedidOptions.filter(item =>
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

            document.querySelectorAll('.idFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedidOptions.includes(optionText)) {
                        selectedidOptions.push(optionText);
                    } else {
                        selectedidOptions = selectedidOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedidOptions',
                        selectedidOptions);
                });
            });

            document.getElementById('idDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('idDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedidOptions', selectedidOptions);
                $('#idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedidOptions');
        });

        //Order ID === Saliha

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
//customer Name == Saliha
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

        //customer name === Saliha

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

        document.addEventListener('DOMContentLoaded', function() {
            let selectedshipping_cityOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedshipping_cityOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedshipping_cityOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedshipping_cityOptions = selectedshipping_cityOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedshipping_cityOptions',
                            selectedshipping_cityOptions);
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
                    selectedshipping_cityOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.shipping_cityFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedshipping_cityOptions.includes(optionText)) {
                        selectedshipping_cityOptions.push(optionText);
                    } else {
                        selectedshipping_cityOptions = selectedshipping_cityOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedshipping_cityOptions',
                        selectedshipping_cityOptions);
                });
            });

            document.getElementById('shipping_cityDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('shipping_cityDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedshipping_cityOptions', selectedshipping_cityOptions);
                $('#shipping_cityDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedshipping_cityOptions');
        });

        //shipping_city/Location === Saliha

        function filtershipping_city() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('shipping_citySearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('shipping_cityOptions');
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
        "use strict";
        $(document).ready(function() {
            // zoom line chart
            var y = document.getElementById("zoomBar");
            if (y) {
                var b = echarts.init(y);
                b.setOption({
                        tooltip: {
                            trigger: "axis",
                            axisPointer: {
                                type: "shadow",
                                shadowStyle: {
                                    opacity: 0
                                }
                            },
                        },
                        grid: {
                            top: "8%",
                            left: "3%",
                            right: "4%",
                            bottom: "3%",
                            containLabel: !0,
                        },
                        xAxis: {
                            data: data.map(item => item.order_date),
                            axisLabel: {
                                inside: !0,
                                textStyle: {
                                    color: "#fff"
                                }
                            },
                            axisTick: {
                                show: !1
                            },
                            axisLine: {
                                show: !1
                            },
                            z: 10,
                        },
                        yAxis: {
                            axisLine: {
                                show: !1
                            },
                            axisTick: {
                                show: !1
                            },
                            axisLabel: {
                                textStyle: {
                                    color: "#999"
                                }
                            },
                            splitLine: {
                                show: !1
                            },
                        },
                        dataZoom: [{
                            type: "inside"
                        }],
                        series: [{
                                name: "Total Orders",
                                type: "bar",
                                itemStyle: {
                                    normal: {
                                        color: "rgba(0,0,0,0.05)"
                                    }
                                },
                                barGap: "-100%",
                                barCategoryGap: "40%",
                                data: data.map(item => item.total_orders),
                                animation: !1,
                            },
                            {
                                name: "Completed Orders",
                                type: "bar",
                                itemStyle: {
                                    normal: {
                                        color: new echarts.graphic.LinearGradient(
                                            0,
                                            0,
                                            0,
                                            1,
                                            [{
                                                    offset: 0,
                                                    color: "#83bff6"
                                                },
                                                {
                                                    offset: 0.5,
                                                    color: "#188df0"
                                                },
                                                {
                                                    offset: 1,
                                                    color: "#188df0"
                                                },
                                            ]
                                        ),
                                    },
                                    emphasis: {
                                        color: new echarts.graphic.LinearGradient(
                                            0,
                                            0,
                                            0,
                                            1,
                                            [{
                                                    offset: 0,
                                                    color: "#2378f7"
                                                },
                                                {
                                                    offset: 0.7,
                                                    color: "#2378f7"
                                                },
                                                {
                                                    offset: 1,
                                                    color: "#83bff6"
                                                },
                                            ]
                                        ),
                                    },
                                },
                                data: data.map(item => item.completed_orders),

                            },
                        ],
                    }),
                    $(window).on("resize", function() {
                        setTimeout(function() {
                            b.resize();
                        }, 500);
                    });
                }

            var v = document.getElementById("stackedPointerArea1");
if (v) {
    var L = echarts.init(v);

    // Simplified data structure for demonstration
    var data = [
        { month: "Jan", day: 1, orders: {{ $allorders }}, sales: {{ $allparcels }} },
        { month: "Jan", day: 2, orders: {{ $allorders }}, sales: {{ $allparcels}} },
        // Add more data points as needed
    ];

    // Prepare xAxisData and seriesData
    var xAxisData = [];
    var seriesData = {
        Orders: [{{ $allorders }}],
        Sales: [{{ $allparcels }}]
    };

    data.forEach(function(item) {
        xAxisData.push(item.day + ' ' + item.month);
        seriesData.Orders.push(item.orders);
        seriesData.Sales.push(item.sales);
    });

    var option = {
        tooltip: {
            trigger: "axis",
            axisPointer: {
                animation: true
            }
        },
        grid: {
            left: "4%",
            top: "4%",
            right: "3%",
            bottom: "10%"
        },
        xAxis: {
            type: "category",
            boundaryGap: false,
            data: xAxisData,
            axisLabel: {
                color: "#666",
                fontSize: 12,
                fontStyle: "normal",
                fontWeight: 400,
            },
            axisLine: {
                lineStyle: {
                    color: "#ccc",
                    width: 1
                }
            },
            axisTick: {
                lineStyle: {
                    color: "#ccc",
                    width: 1
                }
            },
            splitLine: {
                show: false,
                lineStyle: {
                    color: "#ccc",
                    width: 1
                }
            },
        },
        yAxis: {
            type: "value",
            min: 0,
            max: 200,
            interval: 50,
            axisLabel: {
                formatter: "{value}",
                color: "#666",
                fontSize: 12,
                fontStyle: "normal",
                fontWeight: 400,
            },
            axisLine: {
                lineStyle: {
                    color: "#ccc",
                    width: 1
                }
            },
            axisTick: {
                lineStyle: {
                    color: "#ccc",
                    width: 1
                }
            },
            splitLine: {
                lineStyle: {
                    color: "#ddd",
                    width: 1,
                    opacity: 0.5
                },
            },
        },
        series: [{
                name: "Orders",
                type: "line",
                smooth: true,
                data: seriesData.Orders,
                symbolSize: 8,
                lineStyle: {
                    color: "rgb(255, 87, 33)",
                    opacity: 1,
                    width: 1.5,
                },
                itemStyle: {
                    color: "#ff5721",
                    borderColor: "#ff5721",
                    borderWidth: 1.5,
                },
                areaStyle: {
                    normal: {
                        color: {
                            type: "linear",
                            x: 0,
                            y: 0,
                            x2: 0,
                            y2: 1,
                            colorStops: [{
                                    offset: 0,
                                    color: "rgba(255, 87, 33, 1)",
                                },
                                {
                                    offset: 0.3,
                                    color: "rgba(255, 87, 33, 0.7)",
                                },
                                {
                                    offset: 1,
                                    color: "rgba(255, 87, 33, 0)",
                                },
                            ],
                        },
                    },
                },
            },
            {
                name: "Sales",
                type: "line",
                smooth: true,
                data: seriesData.Sales,
                symbolSize: 8,
                lineStyle: {
                    color: "rgb(95, 107, 194)",
                    opacity: 1,
                    width: 1.5,
                },
                itemStyle: {
                    color: "#5f6cc1",
                    borderColor: "#5f6cc1",
                    borderWidth: 1.5,
                },
                areaStyle: {
                    normal: {
                        color: {
                            type: "linear",
                            x: 0,
                            y: 0,
                            x2: 0,
                            y2: 1,
                            colorStops: [{
                                    offset: 0,
                                    color: "rgba(95, 107, 194, 1)",
                                },
                                {
                                    offset: 0.5,
                                    color: "rgba(95, 107, 194, 0.7)",
                                },
                                {
                                    offset: 1,
                                    color: "rgba(95, 107, 194, 0)",
                                },
                            ],
                        },
                    },
                },
            },
        ],
    };

    L.setOption(option);

    $(window).on("resize", function() {
        setTimeout(function() {
            L.resize();
        }, 500);
    });
}

        });
    </script>
@endsection
