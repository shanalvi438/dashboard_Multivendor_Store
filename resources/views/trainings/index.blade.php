@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
@endsection
@section('main-content')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-s9sR2uQ1C6e3pUaGZeYOKwJ+1tK1OlR0J07qL0vE0vOm2/JZSBXLhDkf5ypQyQ2jj/7Vb8S0s1JSbm6G4FfFAg=="
        crossorigin="anonymous" />
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
                <div class="col-md-4" style="margin-left: 22px;">
                    <div class="content-box d-flex">
                        <form action="{{ route('trainings.index') }}" method="GET">
                            <input type="text" name="dateTime" class="datetimerange" />
                        </form>
                        {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                    </div>
                </div>
                <form action="{{ route('trainings.index') }}" method="GET">

                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class=" text-left">Instructor Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="nameFilter">
                                            <input type="checkbox"
                                                value="{{ $value->instructor->name ?? null }}">
                                            <span
                                                class="option-text">{{ $value->instructor->name ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Training Category</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="titleFilter">
                                            <input type="checkbox" value="{{ $value->training_category->title ?? null }}">
                                            <span class="option-text">{{ $value->training_category->title ?? null }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Skill Level</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="skilllevelFilter">
                                            <input type="checkbox"value="{{ $value->skilllevel }}">
                                            <span class="option-text">{{ $value->skilllevel }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Address</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="addressFilter">
                                            <input type="checkbox"value="{{ $value->address }}">
                                            <span class="option-text">{{ $value->address }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left">Course Type</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $value)
                                        <label class="coursetypeFilter">
                                            <input type="checkbox"value="{{ $value->coursetype }}">
                                            <span class="option-text">{{ $value->coursetype }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>


    <div class="breadcrumb">
        <div class="col-md-6">
            <!-- Container-fluid starts-->
            <h5>Course Features Detail</h5>
        </div>
        <div class="col-md-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('trainings.create') }}">
                <button class="btn btn-outline-secondary ladda-button example-button m-1" data-style="expand-left"><span
                        class="ladda-label">Add Course detail</span></button></a>
        </div>
        </a>
    </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">
            <div class="card-body">
                <h4 class="card-title mb-3">All Course Features</h4>
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Rating</th>
                                <th>Lectures</th>
                                <th>Duration</th>
                                <th>Skill Level</th>
                                <th>Language</th>
                                <th>Course Type</th>
                                <th>Address</th>
                                <th>Title</th>
                                <!-- <th>SubCategory</th> -->
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->instructor->name ?? null }}</td>
                                    <td>{{ $value->training_category->title ?? null }}</td>

                                    <td>
                                        @php
                                            $rating = $value->rating;
                                            $maxRating = 100;
                                            $numStars = 5;
                                            $percentage = ($rating / $maxRating) * 100;
                                            $fullStars = floor($percentage / (100 / $numStars));
                                            $emptyStars = $numStars - $fullStars;
                                        @endphp
                                        <div class="star-rating">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star text-warning"></i>
                                            @endfor
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star text-warning"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ $value->lectures }}</td>
                                    <td>{{ $value->duration }}hrs</td>
                                    <td>{{ $value->skilllevel }}</td>
                                    <td>{{ $value->language }}</td>
                                    <td>{{ $value->coursetype }}</td>
                                    <td>{{ $value->address }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td><img src="{{ $value->image }}" width="60px" height="40px">
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a target="_blank" href="{{ route('trainings.edit', $value->id) }}">
                                                <button type="submit" class="btn rounded-pill btn-outline-secondary">
                                                    <i class="fa fa-edit me-2 font-success" title="Edit"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <!-- <a href="https://www.industrymall.net/blog/blogs/ {{ $value->id }}" target="_blank"
                                            class="btn btn-outline-secondary">
                                            <i class="nav-icon i-Eye" title="view"></i>
                                        </a> -->
                                            <form action="{{ route('trainings.destroy', $value->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this trainings page?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn rounded-pill btn-outline-secondary">
                                                    <i class="fa fa-trash" title="delete" aria-hidden="true"></i>
                                                </button>
                                            </form>

                                            <!-- <a href="{{ asset('blog_categories/' . $value->id . '/destroy') }}">
                                                                        <i class="fa fa-trash font-danger"></i></a>
                                                                   </a> -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    @endsection

    @section('page-js')
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    @endsection
