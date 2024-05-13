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
    </style>
    <div class="card-body">
        <div class="filter-card" id="filterCard">
            <div class="col-md-4" style="margin-left: 22px;">
                <div class="content-box d-flex">
                    <form action="{{ route('sub-category.index') }}" method="GET">
                        <input type="text" name="dateTime" class="datetimerange" />
                    </form>
                    {{-- <button type="submit" class="btn btn-secondary" style="margin-left: 20px; margin-top: 3px;">Submit</button> --}}
                </div>
            </div>
            <form action="{{ route('Deals.index') }}" method="GET">
                <div class="row" style="margin-top: 5px; margin-bottom: 50px">
                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton8" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Product ID#</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8" style="max-width: 1000px;">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $product)
                                        <label class="idFilter">
                                            <input type="checkbox" value="{{ $product->id }}">
                                            <span class="option-text"> {{ $product->id }}</span>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton8" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8" style="max-width: 1000px;">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $product)
                                        <label class="nameFilter">
                                            <input type="checkbox" value="{{ $product->name }}">
                                            <span class="option-text"> {{ $product->name }}</span>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownMenuButton8" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <p class="text-left ">Supplier Name</p>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8" style="max-width: 1000px;">
                                <input type="text" id="searchInput" onkeyup="filterOptions()" placeholder="Search...">
                                <div class="dropdown-options">
                                    @foreach ($data as $key => $product)
                                        <label class="makeFilter">
                                            <input type="checkbox" value="{{ $product->make }}">
                                            <span class="option-text"> {{ $product->make }}</span>
                                        </label>
                                    @endforeach
                                </div>

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
            <h1>Deals of the day</h1>
        </div>
        <div class="col-md-6" style="text-align: right;  margin-left: auto;">
            <a href="{{ route('Deals.create') }}"><button
                    class="btn btn-outline-secondary  ladda-button example-button m-1" data-style="expand-left"><span
                        class="ladda-label">Add Deal Products</span></button></a>

        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12 mb-4">
        <div class="card text-start">

            <div class="card-body">
                <h4 class="card-title mb-3">Deal's Day</h4>
                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered"
                        style="width:100%">
                        @include('datatables.table_content')
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
