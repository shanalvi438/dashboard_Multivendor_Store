@extends('layouts.master')
@section('page-css')
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
        padding-right: 70px;
        padding-left: 70px;
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
                <form action="{{ route('dispute.index') }}" method="GET">
                    <input type="text" name="dateTime" class="datetimerange" />
                </form>
                {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
            </div>
        </div>
            <form action="{{ route('dispute.index') }}" method="GET">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-3">
                        <div class="dropdown" id="titleDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Title</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="titleSearchInput" placeholder="Search..."
                                    oninput="filtertitle()">
                                <div class="dropdown-options" id="titleOptions">
                                    <label class="titleFilter" for="titleFilter">
                                        <input type="checkbox" id="selectAlltitle" class="titleFilter">
                                        <span class="option-text" name="title[]">Select All</span>
                                    </label>
                                    <div id="selectedtitleOptions"></div>
                                    @foreach ($data as $key => $value)
                                    <label class="titleFilter">
                                            <input type="checkbox" value="{{ $value->title }}" name="title[]">
                                            <span class="option-text" name="title[]">{{ $value->title }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedtitleList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dropdown" id="user_idDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">User ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <input type="text" id="user_idSearchInput" placeholder="Search..."
                                    oninput="filteruser_id()">
                                <div class="dropdown-options" id="user_idOptions">
                                    <label class="user_idFilter" for="user_idFilter">
                                        <input type="checkbox" id="selectAlluser_id" class="user_idFilter">
                                        <span class="option-text" name="user_id[]">Select All</span>
                                    </label>
                                    <div id="selecteduser_idOptions"></div>
                                    @foreach ($data as $key => $value)
                                    <label class="user_idFilter">
                                            <input type="checkbox" value="{{ $value->user_id }}" name="user_id[]">
                                            <span class="option-text" name="user_id[]">{{ $value->user_id }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selecteduser_idList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dropdown" id="user_typeDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">User Type#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <input type="text" id="user_typeSearchInput" placeholder="Search..."
                                    oninput="filteruser_type()">
                                <div class="dropdown-options" id="user_typeOptions">
                                    <label class="user_typeFilter" for="user_typeFilter">
                                        <input type="checkbox" id="selectAlluser_type" class="user_typeFilter">
                                        <span class="option-text" name="user_type[]">Select All</span>
                                    </label>
                                    <div id="selecteduser_typeOptions"></div>
                                    @foreach ($data as $key => $value)
                                    <label class="user_typeFilter">
                                            <input type="checkbox" value="{{ $value->user_type }}" name="user_type[]">
                                            <span class="option-text" name="user_type[]">{{ $value->user_type }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selecteduser_typeList"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="dropdown" id="nameDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="nameSearchInput" placeholder="Search..." oninput="filtername()">
                                <div class="dropdown-options" id="nameOptions">
                                    <label class="nameFilter" for="nameFilter">
                                        <input type="checkbox" id="selectAllname" class="nameFilter">
                                        <span class="option-text" name="name[]">Select All</span>
                                    </label>
                                    <div id="selectednameOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="nameFilter">
                                            <input type="checkbox" name="name[]" value="{{ $value->name ?? null }}">
                                            <span class="option-text" name="name[]">{{ $value->name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectednameList"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row d-flex" style="margin-top: 0px; margin-bottom: 50px">

                    <div class="col-md-3">
                        <div class="dropdown" id="cityDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Address#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="citySearchInput" placeholder="Search..." oninput="filtercity()">
                                <div class="dropdown-options" id="cityOptions">
                                    <label class="cityFilter" for="cityFilter">
                                        <input type="checkbox" id="selectAllcity" class="cityFilter">
                                        <span class="option-text" name="city[]">Select All</span>
                                    </label>
                                    <div id="selectedcityOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="cityFilter">
                                            <input type="checkbox" name="city[]" value="{{ $value->city ?? null }}">
                                            <span class="option-text" name="city[]">{{ $value->city ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcityList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dropdown" id="contactDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Contact No#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="contactSearchInput" placeholder="Search..." oninput="filtercontact()">
                                <div class="dropdown-options" id="contactOptions">
                                    <label class="contactFilter" for="contactFilter">
                                        <input type="checkbox" id="selectAllcontact" class="contactFilter">
                                        <span class="option-text" name="contact[]">Select All</span>
                                    </label>
                                    <div id="selectedcontactOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="contactFilter">
                                            <input type="checkbox" name="contact[]" value="{{ $value->contact ?? null }}">
                                            <span class="option-text" name="contact[]">{{ $value->contact ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedcontactList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dropdown" id="emailDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Email</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="emailSearchInput" placeholder="Search..." oninput="filteremail()">
                                <div class="dropdown-options" id="emailOptions">
                                    <label class="emailFilter" for="emailFilter">
                                        <input type="checkbox" id="selectAllemail" class="emailFilter">
                                        <span class="option-text" name="email[]">Select All</span>
                                    </label>
                                    <div id="selectedemailOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="emailFilter">
                                            <input type="checkbox" name="email[]" value="{{ $value->email ?? null }}">
                                            <span class="option-text" name="email[]">{{ $value->email ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedemailList"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dropdown" id="profile_linkDropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Profile Link</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="profile_linkSearchInput" placeholder="Search..." oninput="filterprofile_link()">
                                <div class="dropdown-options" id="profile_linkOptions">
                                    <label class="profile_linkFilter" for="profile_linkFilter">
                                        <input type="checkbox" id="selectAllprofile_link" class="profile_linkFilter">
                                        <span class="option-text" name="profile_link[]">Select All</span>
                                    </label>
                                    <div id="selectedprofile_linkOptions"></div>
                                    @foreach ($data as $key => $value)
                                        <label class="profile_linkFilter">
                                            <input type="checkbox" name="profile_link[]" value="{{ $value->profile_link ?? null }}">
                                            <span class="option-text" name="profile_link[]">{{ $value->profile_link ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="selectedprofile_linkList"></div>
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
        <h1>Dispute's Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">Dispute List</h4>
                {{--
                        <p>.....</p>
     --}}
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <th>Sr#</th>
                            <th>Title</th>
                            <th>User Id</th>
                            <th>User Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Profile Link</th>
                            <th>Message</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ $value->user_id }}</td>
                                    <td>{{ $value->user_type }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->contact }}</td>
                                    <td>{{ $value->city . $value->state . $value->country }}</td>
                                    <td>{{ $value->profile_link }}</td>
                                    <td>
                                        <div class="tooltip-container">
                                            <span class="">{{ Str::limit($value->message, 30) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a target="_blank" href="mailto:{{ $value->email }}">
                                                <button type="button" class="btn btn btn-outline-secondary ">
                                                    <i class="nav-icon i-Email" title="email"
                                                        style="font-weight: bold;"></i>
                                                </button></a>
                                            <a target="_blank" href="{{ route('disputes.show', $value->id) }}">
                                                <button type="button" class="btn btn btn-outline-secondary ">
                                                    <i class="nav-icon i-Eye" title="view" style="font-weight: bold;"></i>
                                                </button></a>


                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sr#</th>
                                <th>Title</th>
                            <th>User Id</th>
                                <th>User Type</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Profile Link</th>
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
            let selectedtitleOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedtitleOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedtitleOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedtitleOptions = selectedtitleOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedtitleOptions',
                            selectedtitleOptions);
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
                    selectedtitleOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.titleFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedtitleOptions.includes(optionText)) {
                        selectedtitleOptions.push(optionText);
                    } else {
                        selectedtitleOptions = selectedtitleOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedtitleOptions',
                        selectedtitleOptions);
                });
            });

            document.getElementById('titleDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('titleDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedtitleOptions', selectedtitleOptions);
                $('#titleDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedtitleOptions');
        });

        function filtertitle() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('titleSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('titleOptions');
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
            let selectedcontactOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedcontactOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedcontactOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedcontactOptions = selectedcontactOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedcontactOptions',
                            selectedcontactOptions);
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
                    selectedcontactOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.contactFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedcontactOptions.includes(optionText)) {
                        selectedcontactOptions.push(optionText);
                    } else {
                        selectedcontactOptions = selectedcontactOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedcontactOptions',
                        selectedcontactOptions);
                });
            });

            document.getElementById('contactDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('contactDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedcontactOptions', selectedcontactOptions);
                $('#contactDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedcontactOptions');
        });

        function filtercontact() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('contactSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('contactOptions');
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
            let selectedprofile_linkOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selectedprofile_linkOptions');
                selectedOptionsDiv.innerHTML = '';

                selectedprofile_linkOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selectedprofile_linkOptions = selectedprofile_linkOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selectedprofile_linkOptions',
                            selectedprofile_linkOptions);
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
                    selectedprofile_linkOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.profile_linkFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selectedprofile_linkOptions.includes(optionText)) {
                        selectedprofile_linkOptions.push(optionText);
                    } else {
                        selectedprofile_linkOptions = selectedprofile_linkOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selectedprofile_linkOptions',
                        selectedprofile_linkOptions);
                });
            });

            document.getElementById('profile_linkDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('profile_linkDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selectedprofile_linkOptions', selectedprofile_linkOptions);
                $('#profile_linkDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selectedprofile_linkOptions');
        });

        function filterprofile_link() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('profile_linkSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('profile_linkOptions');
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
            let selecteduser_idOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selecteduser_idOptions');
                selectedOptionsDiv.innerHTML = '';

                selecteduser_idOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selecteduser_idOptions = selecteduser_idOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selecteduser_idOptions',
                            selecteduser_idOptions);
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
                    selecteduser_idOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.user_idFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selecteduser_idOptions.includes(optionText)) {
                        selecteduser_idOptions.push(optionText);
                    } else {
                        selecteduser_idOptions = selecteduser_idOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selecteduser_idOptions',
                        selecteduser_idOptions);
                });
            });

            document.getElementById('user_idDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('user_idDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selecteduser_idOptions', selecteduser_idOptions);
                $('#user_idDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selecteduser_idOptions');
        });

        function filteruser_id() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('user_idSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('user_idOptions');
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
            let selecteduser_typeOptions = [];

            function updateSelectedOptions() {
                const selectedOptionsDiv = document.getElementById('selecteduser_typeOptions');
                selectedOptionsDiv.innerHTML = '';

                selecteduser_typeOptions.forEach(option => {
                    const selectedOptionDiv = document.createElement('div');
                    selectedOptionDiv.classList.add('selected-option');
                    selectedOptionDiv.textContent = option;

                    const removeIcon = document.createElement('span');
                    removeIcon.classList.add('remove-option');
                    removeIcon.textContent = 'x';
                    removeIcon.addEventListener('click', function(event) {
                        event.stopPropagation();
                        selecteduser_typeOptions = selecteduser_typeOptions.filter(item =>
                            item !== option);
                        updateSelectedOptions();
                        saveSelectedOptions('selecteduser_typeOptions',
                            selecteduser_typeOptions);
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
                    selecteduser_typeOptions = JSON.parse(savedOptions);
                    updateSelectedOptions();
                }
            }

            document.querySelectorAll('.user_typeFilter input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const optionText = this.nextElementSibling.textContent;
                    if (this.checked && !selecteduser_typeOptions.includes(optionText)) {
                        selecteduser_typeOptions.push(optionText);
                    } else {
                        selecteduser_typeOptions = selecteduser_typeOptions.filter(item =>
                            item !==
                            optionText);
                    }
                    updateSelectedOptions();
                    saveSelectedOptions('selecteduser_typeOptions',
                        selecteduser_typeOptions);
                });
            });

            document.getElementById('user_typeDropdown').addEventListener('hidden.bs.dropdown', function() {
                updateSelectedOptions();
            });

            document.getElementById('user_typeDropdown').addEventListener('submit', function(event) {
                event.preventDefault();
                updateSelectedOptions();
                saveSelectedOptions('selecteduser_typeOptions', selecteduser_typeOptions);
                $('#user_typeDropdown').dropdown('toggle');
            });

            loadSelectedOptions('selecteduser_typeOptions');
        });

        function filteruser_type() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('user_typeSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById('user_typeOptions');
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

    </script>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
