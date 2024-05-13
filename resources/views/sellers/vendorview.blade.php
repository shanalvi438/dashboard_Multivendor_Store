<?php
// dd($bankCard)
// echo "<pre>";
//     print_r($edit);
// echo "</pre>";
// die;
?>

@extends('layouts.master')
@section('page-css')
  
@endsection
@section('page-css')
    <link rel="stylesheet" href="/assets/styles/vendor/datatables.min.css">
    {{-- <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection


@section('before-css')
    {{-- css link sheet  --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_dots.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">

    <style>
        p {
            font-size: 16px;
            /* Initial font size */
            font-family: Arial, sans-serif;
            /* Font family */
            color: #333;
            /* Text color */
            border: 1px solid #ccc;
            /* Border */
            padding: 10px;
            /* Padding */
            transition: all 0.3s ease;
            /* Transition for smooth effect */
        }

        /* Define styles for the paragraph when hovered */
        p:hover {
            transform: scale(1.1);
            /* Zoom effect */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* Box shadow for visual effect */
        }

        .image-container_1 {
            max-height: 400px;
            /* Set the maximum height you want for the images */
            overflow-y: auto;
            /* Add a vertical scrollbar if needed */
        }

        .img-thumbnail_1 {
            display: block;
            margin-bottom: 10px;
            /* Add some spacing between images */
        }
    </style>
@endsection
@endsection

@section('main-content')

<div class="breadcrumb">

    <h1>Seller Information</h1>

</div>
{{-- <div class="separator-breadcrumb border-top"></div> --}}


{{-- {-------Tabs Start-------} --}}





<div class="col-md-12 mb-4">
    <div class="card text-start">

        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab"
                        aria-controls="homeBasic" aria-selected="true">Vendor Profile Status</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab"
                        aria-controls="profileBasic" aria-selected="false">Payment Verified </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab"
                        aria-controls="contactBasic" aria-selected="false">Trusted Supplier</a>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="row">
                            
                        {{-- ------------------Alert Button------------------ --}}
                    
                        <head>
                           
                            {{-- <title>Popup Alert</title> --}}
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                                integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
                        
                        
                            <style>
                                .popup-container {
                                    position: fixed;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #fff;
                                    padding: 20px;
                                    border-radius: 5px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                    z-index: 1000;
                                    display: none;
                                }
                                .popup-container{
                                    width: 500px;
                                    text-align: center;
                                }
                                @keyframes shake {
                                    0% { transform: translateX(0); }
                                    25% { transform: translateX(-5px); }
                                    50% { transform: translateX(5px); }
                                    75% { transform: translateX(-5px); }
                                    100% { transform: translateX(0); }
                                }

                                .shake {
                                    animation: shake 0.5s ease-in-out infinite;
                                }
                                /* .popup-container .close-btn {
                                    position: absolute;
                                    top: 5px;
                                    right: 5px;
                                    cursor: pointer;
                                } */
                            </style>
                        </head>
                        
                        <body>
                            <div class="row">

                                <div class="col-md-10">
                                    <div class="form-group col-md-12">
                                        {{-- <label for="inputEmail18" class="ul-form__label">Status: (Active || Inactive)</label> --}}
                                        <div class="ul-form__checkbox-inline">
                                            <label class="switch">
                                                <input type="checkbox" id="popup-trigger" name="radio" value="1" @if($vendors->status == '1') checked @endif class="coupon-status-toggle">
                                                <span class="slider round"></span>
                                            </label>
                                            @if ($vendors->status == '1')
                                            {{-- <span class="badge badge-secondary text-bg-success">Active</span> --}}
                                            <button type="button" class="btn btn-raised btn-raised-secondary m-1" disabled>Active</button>
                                            {{-- <span class=""></span> --}}
                                            @elseif ($vendors->status == '0')
                                                <span class="">In_Active</span>
                                            @endif
                                        </div>
                                        <small id="passwordHelpBlock" class="ul-form__text form-text">Select Your Status</small>
                                    </div>

                                    {{-- <button id="popup-trigger" class="btn col-md-1" style="border-radius: 55px; background-color: #0CC27E; width:200px; height: 100;">vendor Profile Statis</button> --}}
                                </div>
                                {{-- <div class="col"> --}}
                                    {{-- <h4> --}}
                                        {{-- @if ($vendors->status == '1') --}}
                                        {{-- <span class="badge badge-secondary text-bg-success">Active</span> --}}
                                        {{-- <span class="badge badge-secondary text-bg-success shake">Active</span> --}}
                                    {{-- @elseif ($vendors->status == '0') --}}
                                        {{-- <span class="badge badge-danger text-bg-danger shake">In_Active</span> --}}
                                    {{-- @endif --}}
                                    {{-- </h4> --}}
                                {{-- </div> --}}
                            </div>
                          
                               
                            
                            <div class="popup-container" id="popup" >
                                <h2>Are you Sure!</h2>
                                <p>You want to update User Status!</p>
                                
                                <div class="rounded  d-block col-md-12" id="update-btn">
                                    
             
                                </div>
                                {{-- === --}}
                               
                                <form action="{{ route('vendors.update', ['vendor' => $vendors->id]) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail18" class="ul-form__label">Status: <span id="statusText">Active</span></label>
                                                    <div class="ul-form__checkbox-inline">
                                                        <label class="switch">
                                                            <input type="checkbox" name="radio" value="1" @if($vendors->status == '1') checked @endif class="coupon-status-toggle" onchange="updateStatusText(this)">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>

                                                    <script>
                                                        function updateStatusText(checkbox) {
                                                            var statusText = document.getElementById("statusText");
                                                            if (checkbox.checked) {
                                                                statusText.innerText = "Active";
                                                            } else {
                                                                statusText.innerText = "Inactive";
                                                            }
                                                        }
                                                    </script>
                                        {{-- <label for="inputEmail18" class="ul-form__label">Status: (Active || Inactive)</label>
                                                <div class="ul-form__checkbox-inline">
                                                    <label class="switch">
                                                        <input type="checkbox" name="radio" value="1" @if($vendors->status == '1') checked @endif class="coupon-status-toggle">
                                                        <span class="slider round"></span>
                                                    </label>
                                                   
                                                </div> --}}
                                                <small id="passwordHelpBlock" class="ul-form__text form-text">Select Your Status</small>
                                            </div>

                                            <div class="form-group col-md-12" hidden>
                                                <label for="inputEmail18" class="ul-form__label">Verified Status  <span class="badge  badge-round-success md"><p style="font-size: revert;">✓</p></span></label>
                                                <div class="ul-form__checkbox-inline">
                                                    
                                                    <label class="switch">
                                                        <input type="checkbox"  name="verified" value="1" @if($vendors->verified_status == '1') checked @endif class="coupon-status-toggle"  >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12" hidden>
                                                <label for="inputEmail18" class="ul-form__label">Trusted Status  <span class="badge  badge-round-info md"><p style="font-size: revert;">✓</p></span></label>
                                                <div class="ul-form__checkbox-inline">
                                                    
                                                    <label class="switch">
                                                        <input type="checkbox"  name="trusted" value="1" @if($vendors->trusted_status == '1') checked @endif class="coupon-status-toggle"  >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="custom-separator"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-outline-secondary  ladda-button example-button m-1" id="update-btn" onclick="closePopup(true)">Update</button>
                                                    {{-- <button type="button" class="btn btn-outline-secondary m-1" onclick="closePopup(false)">Cancel</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                               
                                {{-- === --}}
                            </div>
                        </body>    
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#popup-trigger').click(function() {
                                        $('#popup').fadeIn();
                                    });
                                });
                            
                                function closePopup(update) {
                                    if (update) {
                                        // public\assets\img\icons8-check.gif
                                        $('#update-btn').html('<i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #63E6BE;" style="display: none;"></i>');
                                    } else {
                                        $('#update-btn').html('<i class="fas fa-times cross-icon fa-bounce fa-4x" style="color: #cc0000;" style="display: none;"></i>');
                                    }
                                    $('#popup').fadeOut(10000);
                                }
                            </script>
                            
                        
                            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
                            </script>
                        
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
                            </script>
                        </body>

                        {{-- ------------------Alert Button------------------ --}}

                        <div class="col-md-12" style="padding: 20px;">
                            <!-- SmartWizard html -->

                            <div id="smartwizard" class="sw-theme-dots">
                                <ul style="justify-content: center;">
                                    <li><a href="#step-1">Step 1<br /><small>Company Profile</small></a></li>
                                    <li><a href="#step-5">Step 2<br /><small>Slider's</small></a></li>
                                    <li><a href="#step-6">Step 3<br /><small>Porfolio's</small></a></li>
                                    {{-- <li><a href="#step-7">Step 3<br /><small>Service's</small></a></li>
                                    <li><a href="#step-8">Step 3<br /><small>About's</small></a></li> --}}
                                </ul>

                                {{-- <span> --}}
                                    {{-- <div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end">
                                        <div class="btn-group me-2 sw-btn-group" role="group">
                                            <button class="btn btn-secondary sw-btn-prev disabled"
                                                type="button">Previous</button>
                                            <button class="btn btn-secondary sw-btn-next" type="button">Next</button>
                                        </div>
                                        <div class="btn-group me-2 sw-btn-group-extra" role="group">
                                        </div>
                                    </div> --}}
                                {{-- </span> --}}


                                {{-- ===Step-1=== --}}

                                <div>
                                    <div id="step-1" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Profile Info </h3>
                                                        </div>
                                                        <div class="form-group avatar">
                                                            <figure class="figure col-md-2 col-sm-3 col-xs-12 ">
                                                                {{-- <img class="img-rounded img-responsive" --}}



                                                            </figure>

                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Company
                                                                        Name:</label>
                                                                    @if ($edit && isset($edit->company_name))
                                                                        {!! Form::text('company_name', $edit->company_name, [
                                                                            'id' => 'company_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('company_name', null, ['id' => 'company_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>
                                                                @foreach ($edit as $key => $edit)
                                                                        {{-- {{$edit->user}} --}}
                                                                @endforeach
                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">First Name:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('first_name', $edit->user->first_name, [
                                                                            'id' => 'first_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('first_name', null, ['id' => 'first_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11" class="ul-form__label">Last
                                                                        Name:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('last_name', $edit->user->last_name, [
                                                                            'id' => 'last_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('last_name', null, ['id' => 'last_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Phone# 1</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('phone1', $edit->user->phone1, ['id' => 'phone1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('phone1', null, ['id' => 'phone1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Phone# 2:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('phone2', $edit->user->phone2, ['id' => 'phone2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('phone2', null, ['id' => 'phone2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Country:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('country', $edit->user->country, ['id' => 'country', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('country', null, ['id' => 'country', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">City:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('city', $edit->user->city, ['id' => 'city', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Address:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('address1', $edit->user->address1, ['id' => 'address1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('address1', null, ['id' => 'address1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Address2:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('address2', $edit->user->address2, ['id' => 'address2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('address2', null, ['id' => 'address2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <!-- <div class="form-group col-md-4">
                                                                    <label for="inputEmail12" class="ul-form__label">NTN:</label>
                                                                    @if ($edit && $edit->user)
                                                                    {!! Form::text  ('ntn', $edit->user->ntn, ['id' => 'ntn', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                    {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                                                                    </div> -->

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Trade License
                                                                        Number</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('trade_license_number', $edit->user->strn, [
                                                                            'id' => 'strn',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                            'type' => 'number',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('trade_license_number', null, [
                                                                            'id' => 'strn',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                            'type' => 'number',
                                                                        ]) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Total
                                                                        Employee:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('total_employees', $edit->user->total_employees, [
                                                                            'id' => 'total_employees',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('total_employees', null, ['id' => 'total_employees', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Established
                                                                        In:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('established_in', $edit->user->established_in, [
                                                                            'id' => 'established_in',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('established_in', null, ['id' => 'established_in', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Main
                                                                        Market:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('main_market', $edit->user->main_market, [
                                                                            'id' => 'main_market',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('main_market', null, ['id' => 'main_market', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Member
                                                                        Since:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('member_since', $edit->user->member_since, [
                                                                            'id' => 'member_since',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('member_since', null, ['id' => 'member_since', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Certification:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('certifications', $edit->user->certifications, [
                                                                            'id' => 'certifications',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('certifications', null, ['id' => 'certifications', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Website
                                                                        Link:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('website_link', $edit->user->website_link, [
                                                                            'id' => 'website_link',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('website_link', null, ['id' => 'website_link', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <!-- <div class="form-group col-md-4">
                                                                    <label for="inputEmail12" class="ul-form__label">Accept Payment
                                                                        Type:</label>
                                                                    @if ($edit && $edit->user)
                                                {!! Form::text('accepted_payment_type', $edit->user->accepted_payment_type, [
                                                    'id' => 'accept_payment_type',
                                                    'class' => 'form-control',
                                                    'readonly',
                                                ]) !!}
                                                @else
                                                {!! Form::text('accepted_payment_type', null, [
                                                    'id' => 'accept_payment_type',
                                                    'class' => 'form-control',
                                                    'readonly',
                                                ]) !!}
                                                @endif
                                                                </div> -->

                                                                <div class="form-group col-md-4">
                                                                    <label for="accept_payment_type"
                                                                        class="ul-form__label">Accept
                                                                        Payment Type:</label>
                                                                    @php
                                                                        $selectedOption =
                                                                            $edit && $edit->user
                                                                                ? $edit->user->accepted_payment_type
                                                                                : null;
                                                                    @endphp
                                                                    {!! Form::select(
                                                                        'accepted_payment_type',
                                                                        [
                                                                            'VISA CARD' => 'VISA CARD',
                                                                            'MASTER CARD' => 'MASTER CARD',
                                                                            'CASH ON DELIVERY' => 'CASH ON DELIVERY',
                                                                        ],
                                                                        $selectedOption,
                                                                        [
                                                                            'id' => 'accept_payment_type',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ],
                                                                    ) !!}
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Major
                                                                        Clients:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('major_clients', $edit->user->major_clients, [
                                                                            'id' => 'major_clients',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('major_clients', null, ['id' => 'major_clients', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Export:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_export', $edit->user->annual_export, [
                                                                            'id' => 'annaul_export',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_export', null, ['id' => 'annaul_export', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Import:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_import', $edit->user->annual_import, [
                                                                            'id' => 'annaul_import',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_import', null, ['id' => 'annaul_import', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Revenue:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_revenue', $edit->user->annual_revenue, [
                                                                            'id' => 'annaul_revenue',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_revenue', null, ['id' => 'annaul_revenue', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Logo:</label>

                                                                    @if ($edit && isset($edit->logo))
                                                                        <a href="{{ asset($edit->logo) }}"
                                                                            class="image-popup">
                                                                            <img src="{{ asset($edit->logo) }}"
                                                                                class="img-thumbnail"
                                                                                style="width:100px;height:100px;" />
                                                                        </a>
                                                                    @else
                                                                        {{-- Handle the case where $edit is null or does not have a 'logo' property --}}
                                                                        <p>No logo available</p>
                                                                    @endif
                                                                </div>

                                                            </div>


                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- ===Step-6=== --}}


                                    <div id="step-2" class="">
                                        <div class="table-responsive">
                                            <table id="deafult_ordering_table"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Account Title</th>
                                                        <th>Account No</th>
                                                        <th>IBAN No</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Branch Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bankDetail as $key => $value)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->account_title }}</td>
                                                            <td>{{ $value->account_no }}</td>
                                                            <td>{{ $value->iban_no }}</td>
                                                            <td>{{ $value->bank_name }}</td>
                                                            <td>{{ $value->bank_address }}</td>
                                                            <td>{{ $value->branch_code }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Account Title</th>
                                                        <th>Account No</th>
                                                        <th>IBAN No</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Branch Code</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>



                                    {{-- ===Step-7=== --}}


                                    <div id="step-3" class="">
                                        <div class="table-responsive">
                                            <table id="deafult_ordering_table1"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendordocument as $key => $value)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->document_name }}</td>
                                                            <td>
                                                                <div id="" style="display: flex;">
                                                                    @if ($value->document_file)
                                                                        @foreach (json_decode($value->document_file) as $file)
                                                                            @if (Str::endsWith($file, '.pdf'))
                                                                                {{-- Display PDF if it's a PDF file --}}
                                                                                {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                                <a href="{{ asset($file) }}"
                                                                                    download>
                                                                                    <embed src="{{ asset($file) }}"
                                                                                        type="application/pdf"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;">
                                                                                    <button type="button"
                                                                                        class="btn  btn-outline-secondary ">
                                                                                        <i class=" nav-icon i-Download"
                                                                                            style="font-weight: bold;"></i>
                                                                                    </button>
                                                                                    <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                                </a>
                                                                            @else
                                                                                {{-- Display image if it's not a PDF file --}}

                                                                                <a href="{{ asset($file) }}"
                                                                                    class="image-popup">
                                                                                    <img src="{{ asset($file) }}"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;" />
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <p>images is empty or null</p>
                                                                    @endif


                                                                </div>
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    {{-- ===Step-8=== --}}


                                    <div id="step-4" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Become a Verified Supplier

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Front:</label>
                                                                    @if ($edit && $edit->id_front)
                                                                        @if (Str::endsWith($edit->id_front, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_front) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_front) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif
                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Back:</label>
                                                                    @if ($edit && $edit->id_back)
                                                                        @if (Str::endsWith($edit->id_back, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_back) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_back) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif


                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Trade
                                                                        License:</label>

                                                                    @if ($edit && $edit->trade_license)
                                                                        @if (Str::endsWith($edit->trade_license, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->trade_license) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->trade_license) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif

                                                                </div>

                                                            </div>
                                                        </div>

                                                        {{-- <hr> --}}



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    {{-- ===Step-2=== --}}




                                    <div id="step-5" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Slider Image's
                                                                <!-- <span class="badge  badge-round-info md"> -->
                                                                <!-- <p style="font-size: revert;">✓</p> -->
                                                                </span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div id="f_i_thumnails"
                                                                    class="form-group col-md-12 gap-10">
                                                                    <div id="loopImg" class=""
                                                                        style="display: flex;">

                                                                        @if (!empty($edit->slider_images))
                                                                            @php
                                                                                $decodedImages = json_decode(
                                                                                    $edit->slider_images,
                                                                                );
                                                                            @endphp

                                                                            @if ($decodedImages !== null)
                                                                                @foreach ($decodedImages as $key => $value)
                                                                                    <a href="{{ asset($value) }}"
                                                                                        style="margin: auto;"
                                                                                        class="image-popup">
                                                                                        <img src="{{ asset($value) }}"
                                                                                            class="img-thumbnail "
                                                                                            style="width:250px;height:130px;" />
                                                                                    </a>
                                                                                    {{-- <span class="delete-icon" data-image-index="{{ $key }}">Delete</span> --}}
                                                                                @endforeach
                                                                            @else
                                                                                <p>Invalid JSON data in
                                                                                    $edit->slider_images</p>
                                                                            @endif
                                                                        @else
                                                                            <p>images is empty or null</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- ===Step-5=== --}}

                                    <div id="step-6" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Porfolio Image's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    @foreach ($porfolie as $item)
                                                                        {{$item->title}}
                                                                    @endforeach
                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">
                                                                        <img src="{{ asset('$porfolie->image') }}"
                                                                            alt="abc">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    {{-- ===Step-4=== --}}



                                    <div id="step-7" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Service's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    @foreach ($services as $item)
                                                                        
                                                                    {{ $item->title   }}
                                                                    @endforeach
                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">
                                                                        @foreach ($services as $item)
                                                                        
                                                                        {{$item->description}}
                                                                        @endforeach
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <img src="{{ asset('$services->image') }}"
                                                                        alt="abc">
                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">


                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">

                                                                    </div>
                                                                    <div id="f_i_thumnails"
                                                                        class="form-group  gap-10">
                                                                        <div id="loopImg" class="gap-10">


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- ===Step-3=== --}}

                                    {{-- Test --}}
                                    <div id="step-8" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Service's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <p>{{ $edit->about }}</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="row">
                                                    {{-- ------------------Alert Button------------------ --}}
                    
                        <head>
                           
                            <title>Popup Alert</title>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                                integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
                        
                        
                            <style>
                                .popup-container {
                                    position: fixed;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #fff;
                                    padding: 20px;
                                    border-radius: 5px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                    z-index: 1000;
                                    display: none;
                                }
                                .popup-container{
                                    width: 500px;
                                    text-align: center;
                                }
                                /* .popup-container .close-btn {
                                    position: absolute;
                                    top: 5px;
                                    right: 5px;
                                    cursor: pointer;
                                } */
                            </style>
                        </head>
                        
                        <body>
                            <div class="row">
                                <div class="col-md-10">

                                    <div class="form-group col-md-12">
                                        <label for="inputEmail18" class="ul-form__label">Verified Status  <span class="badge  badge-round-success md"><p style="font-size: revert;">✓</p></span></label>
                                        <div class="ul-form__checkbox-inline">
                                            
                                            <label class="switch">
                                                <input type="checkbox" id="popup-triggerr"  name="verified" value="1" @if($vendors->verified_status == '1') checked @endif class="coupon-status-toggle"  >
                                                <span class="slider round"></span>
                                            </label>

                                            @if ($vendors->verified_status == '1')
                                        {{-- <span class="badge  badge-success badge-round-info md text-bg-success"> --}}
                                            {{-- <i class="fas fa-check tick-icon fa-solid fa-badge-check fa-shake fa-4x" style="color: #74C0FC;"></i> --}}
                                            <button type="button" class="btn btn-raised btn-raised-secondary m-1">Verified</button>
                                            {{-- <i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #00f7ff; background-color:#0f0f0f; " style="display: none;"></i> --}}
                                        {{-- </span> --}}
                                        @elseif ($vendors->verified_status == '0')
                                        {{-- <h6>
                                            <i class="fa-solid fa-x fa-shake fa-4x" style="color: #ff0000;"></i>
                                        </h6> --}}
                                        <button type="button" class="btn btn-raised btn-raised-secondary m-1">Unverified</button>
                                        {{-- <span class="badge  badge-round-secondary md"><p style="font-size: revert;">x</p></span> --}}
                                          @endif

                                           
                                        </div>
                                    </div>


                                    {{-- <button id="popup-triggerr" class="btn btn-primary col-md-1" style="border-radius: 55px; background-color: #0CC27E; width:200px; height: 100;">Vendor Payment Verified Status</button> --}}
                                </div>
                                {{-- <div class="col-md-2">
                                    <h4>
                                        @if ($vendors->verified_status == '1')
                                        <span class="badge  badge-success badge-round-info md text-bg-success">
                                            <i class="fas fa-check tick-icon fa-solid fa-badge-check fa-shake fa-4x" style="color: #74C0FC;"></i>
                                            <i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #00f7ff; background-color:#0f0f0f; " style="display: none;"></i>
                                        </span>
                                        @elseif ($vendors->verified_status == '0')
                                        <h6>
                                            <i class="fa-solid fa-x fa-shake fa-4x" style="color: #ff0000;"></i>
                                        </h6>
                                        <span class="badge  badge-round-secondary md"><p style="font-size: revert;">x</p></span>
                                    @endif
                                    </h4>
                                </div> --}}
                            </div>


                            <div class="popup-container" id="popupp" >
                                <h2>Are you Sure!</h2>
                                <p>You want to update User Status!</p>
                                
                                <div class="rounded  d-block col-md-12" id="update-btnn">

                                </div>
                                {{-- === --}}



                                <form action="{{ route('vendors.update', ['vendor' => $vendors->id]) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                <div class="card-body">
                                   <div class="row">
                                            <div class="form-group col-md-12" hidden>
                                                <label for="inputEmail18" class="ul-form__label">Status: (Active || Inactive)</label>
                                                    <div class="ul-form__checkbox-inline">
                                                    <label class="switch">
                                                        <input type="checkbox"  name="radio" value="1" @if($vendors->status == '1') checked @endif class="coupon-status-toggle"  >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <small id="passwordHelpBlock" class="ul-form__text form-text">
                                                    Select Your Status
                                                </small>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="inputEmail18" class="ul-form__label">Verified Status  <span class="badge  badge-round-success md"><p style="font-size: revert;">✓</p></span></label>
                                                <div class="ul-form__checkbox-inline">
                                                    
                                                    <label class="switch">
                                                        <input type="checkbox"  name="verified" value="1" @if($vendors->verified_status == '1') checked @endif class="coupon-status-toggle"  >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12" hidden>
                                                <label for="inputEmail18" class="ul-form__label">Trusted Status  <span class="badge  badge-round-info md"><p style="font-size: revert;">✓</p></span></label>
                                                <div class="ul-form__checkbox-inline">
                                                    
                                                    <label class="switch">
                                                        <input type="checkbox"  name="trusted" value="1" @if($vendors->trusted_status == '1') checked @endif class="coupon-status-toggle"  >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="custom-separator"></div>
                                        </div>
                                    </div>    
                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-outline-secondary  ladda-button example-button m-1" id="update-btnn" onclick="closePopupp(true)">Update</button>
                                                    {{-- <button type="button" class="btn btn-outline-secondary m-1" onclick="closePopupp(false)">Cancel</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                               
                                {{-- === --}}
                            </div>
                            
                        
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#popup-triggerr').click(function() {
                                        $('#popupp').fadeIn();
                                    });
                                });
                            
                                function closePopupp(update) {
                                    // console.log("Close popup called");
                                    if (update) {
                                        // public\assets\img\icons8-check.gif
                                        $('#update-btnn').html('<i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #63E6BE;" style="display: none;"></i>');
                                    } else {
                                        $('#update-btnn').html('<img src="{{asset('assets/img/x.gif')}}" class="img-fluid rounded-top" width="100px" alt="123333333333333333"/>');
                                    }
                                    $('#popupp').fadeOut(1000);
                                }
                            </script>
                            
                        
                            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
                            </script>
                        
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
                            </script>
                        </body>

                        {{-- ------------------Alert Button------------------ --}}


                        <div class="col-md-12" style="padding: 20px;">
                            <!-- SmartWizard html -->

                            <div id="smartwizard2" class="sw-theme-dots">
                                <ul style="justify-content: center;">
                                    <li><a href="#step-2">Step 1<br /><small>Bank Detail</small></a></li>
                                    <li><a href="#step-9">Step 2<br /><small>Bank Cards</small></a></li>
                                </ul>

                                <span>
                                    <div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end">
                                        <div class="btn-group me-2 sw-btn-group" role="group">
                                            <button class="btn btn-secondary sw-btn-prev disabled"
                                                type="button">Previous</button>
                                            <button class="btn btn-secondary sw-btn-next" type="button">Next</button>
                                        </div>
                                        <div class="btn-group me-2 sw-btn-group-extra" role="group">
                                        </div>
                                    </div>
                                </span>


                                {{-- ===Step-1=== --}}


                                <div>
                                    <div id="step-1" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Profile Info </h3>
                                                        </div>
                                                        <div class="form-group avatar">
                                                            <figure class="figure col-md-2 col-sm-3 col-xs-12 ">
                                                                {{-- <img class="img-rounded img-responsive" --}}



                                                            </figure>

                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Company
                                                                        Name:</label>
                                                                    @if ($edit && isset($edit->company_name))
                                                                        {!! Form::text('company_name', $edit->company_name, [
                                                                            'id' => 'company_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('company_name', null, ['id' => 'company_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">First Name:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('first_name', $edit->user->first_name, [
                                                                            'id' => 'first_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('first_name', null, ['id' => 'first_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputtext11" class="ul-form__label">Last
                                                                        Name:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('last_name', $edit->user->last_name, [
                                                                            'id' => 'last_name',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('last_name', null, ['id' => 'last_name', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Phone# 1</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('phone1', $edit->user->phone1, ['id' => 'phone1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('phone1', null, ['id' => 'phone1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Phone# 2:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('phone2', $edit->user->phone2, ['id' => 'phone2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('phone2', null, ['id' => 'phone2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Country:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('country', $edit->user->country, ['id' => 'country', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('country', null, ['id' => 'country', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">City:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('city', $edit->user->city, ['id' => 'city', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Address:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('address1', $edit->user->address1, ['id' => 'address1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('address1', null, ['id' => 'address1', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Address2:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('address2', $edit->user->address2, ['id' => 'address2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @else
                                                                        {!! Form::text('address2', null, ['id' => 'address2', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <!-- <div class="form-group col-md-4">
                                                                    <label for="inputEmail12" class="ul-form__label">NTN:</label>
                                                                    @if ($edit && $edit->user)
                                                    {!! Form::text('ntn', $edit->user->ntn, ['id' => 'ntn', 'class' => 'form-control', 'readonly']) !!}
                                                    @else
                                                    {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'readonly']) !!}
                                                    @endif
                                                                                                                    </div> -->

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Trade License
                                                                        Number</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('trade_license_number', $edit->user->strn, [
                                                                            'id' => 'strn',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                            'type' => 'number',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('trade_license_number', null, [
                                                                            'id' => 'strn',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                            'type' => 'number',
                                                                        ]) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Total
                                                                        Employee:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('total_employees', $edit->user->total_employees, [
                                                                            'id' => 'total_employees',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('total_employees', null, ['id' => 'total_employees', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Established
                                                                        In:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('established_in', $edit->user->established_in, [
                                                                            'id' => 'established_in',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('established_in', null, ['id' => 'established_in', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Main
                                                                        Market:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('main_market', $edit->user->main_market, [
                                                                            'id' => 'main_market',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('main_market', null, ['id' => 'main_market', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Member
                                                                        Since:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('member_since', $edit->user->member_since, [
                                                                            'id' => 'member_since',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('member_since', null, ['id' => 'member_since', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Certification:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('certifications', $edit->user->certifications, [
                                                                            'id' => 'certifications',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('certifications', null, ['id' => 'certifications', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Website
                                                                        Link:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('website_link', $edit->user->website_link, [
                                                                            'id' => 'website_link',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('website_link', null, ['id' => 'website_link', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <!-- <div class="form-group col-md-4">
                                                                    <label for="inputEmail12" class="ul-form__label">Accept Payment
                                                                        Type:</label>
                                                                    @if ($edit && $edit->user)
                                                {!! Form::text('accepted_payment_type', $edit->user->accepted_payment_type, [
                                                    'id' => 'accept_payment_type',
                                                    'class' => 'form-control',
                                                    'readonly',
                                                ]) !!}
                                                @else
                                                {!! Form::text('accepted_payment_type', null, [
                                                    'id' => 'accept_payment_type',
                                                    'class' => 'form-control',
                                                    'readonly',
                                                ]) !!}
                                                @endif
                                                                </div> -->

                                                                <div class="form-group col-md-4">
                                                                    <label for="accept_payment_type"
                                                                        class="ul-form__label">Accept
                                                                        Payment Type:</label>
                                                                    @php
                                                                        $selectedOption =
                                                                            $edit && $edit->user
                                                                                ? $edit->user->accepted_payment_type
                                                                                : null;
                                                                    @endphp
                                                                    {!! Form::select(
                                                                        'accepted_payment_type',
                                                                        [
                                                                            'VISA CARD' => 'VISA CARD',
                                                                            'MASTER CARD' => 'MASTER CARD',
                                                                            'CASH ON DELIVERY' => 'CASH ON DELIVERY',
                                                                        ],
                                                                        $selectedOption,
                                                                        [
                                                                            'id' => 'accept_payment_type',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ],
                                                                    ) !!}
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Major
                                                                        Clients:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('major_clients', $edit->user->major_clients, [
                                                                            'id' => 'major_clients',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('major_clients', null, ['id' => 'major_clients', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Export:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_export', $edit->user->annual_export, [
                                                                            'id' => 'annaul_export',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_export', null, ['id' => 'annaul_export', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Import:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_import', $edit->user->annual_import, [
                                                                            'id' => 'annaul_import',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_import', null, ['id' => 'annaul_import', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Annual
                                                                        Revenue:</label>
                                                                    @if ($edit && $edit->user)
                                                                        {!! Form::text('annual_revenue', $edit->user->annual_revenue, [
                                                                            'id' => 'annaul_revenue',
                                                                            'class' => 'form-control',
                                                                            'readonly',
                                                                        ]) !!}
                                                                    @else
                                                                        {!! Form::text('annual_revenue', null, ['id' => 'annaul_revenue', 'class' => 'form-control', 'readonly']) !!}
                                                                    @endif
                                                                </div>


                                                                <div class="form-group col-md-4">
                                                                    <label for="inputEmail12"
                                                                        class="ul-form__label">Logo:</label>

                                                                    @if ($edit && isset($edit->logo))
                                                                        <a href="{{ asset($edit->logo) }}"
                                                                            class="image-popup">
                                                                            <img src="{{ asset($edit->logo) }}"
                                                                                class="img-thumbnail"
                                                                                style="width:100px;height:100px;" />
                                                                        </a>
                                                                    @else
                                                                        {{-- Handle the case where $edit is null or does not have a 'logo' property --}}
                                                                        <p>No logo available</p>
                                                                    @endif
                                                                </div>

                                                            </div>


                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- ===Step-6=== --}}


                                    <div id="step-9" class="">
                                        <div class="table-responsive">
{{--                                             
                                            <table id="deafult_ordering_table"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                
                                                        <th>vendor_profile_id</th>
                                                        <th>vendor_id</th>
                                                        <th>card_holder_name</th>
                                                        <th>card_number</th>
                                                        <th>cvv</th>
                                                        <th>valid_date</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    @foreach ($bdata as $items)
                                                        <tr>
                                                            
                                                            <td>{{ $items->card_holder_name }}</td>
                                                            <td>{{ $items->card_number }}</td>
                                                            <td>{{ $items->valid_date }}</td>
                                                        
                                                            <td>{{ $items->card_holder_name }}</td>
                                                            <td>{{ $items->card_number }}</td>
                                                            <td>{{ $items->cvv }}</td>
                                                            <td>{{ $items->valid_date }}</td>
                                                        </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Account Title</th>
                                                        <th>Account No</th>
                                                        <th>IBAN No</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Branch Code</th>
                                                    </tr>
                                                </tfoot>
                                            </table> --}}
                                            <div class="row g-3">
                                                @foreach ($bdata as $items)
                                                    @if($items->card_type === 'UniPay' || $items->card_type === 'Master' || $items->card_type === 'Platinum' || $items->card_type === 'Visa')
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="bg-primary shadow-sm rounded p-4 mb-4">
                                                                {{-- <h3 class="text-5 fw-400 mb-4">Credit or Debit Cards <span class="text-muted text-4">(for payments)</span></h3> --}}
                                                                {{-- <hr class="mb-4 mx-n4"> --}}
                                                                <div class="account-card account-card-primary text-white rounded p-3 hover-card">
                                                                    <p class="text-4">{{ $items->card_number }}</p>
                                                                    <p class="d-flex align-items-center"> 
                                                                        <span class="account-card-expire text-uppercase d-inline-block opacity-7 me-2">Valid<br>thru<br></span> 
                                                                        <span class="text-4 opacity-9">{{ $items->valid_date }}</span> 
                                                                        <span class="badge bg-warning text-dark text-0 fw-800 rounded-pill px-1 ms-auto">{{ $items->card_holder_name }}</span>
                                                                    </p>
                                                                    <p class="d-flex align-items-center m-0"> 
                                                                        <span class="text-uppercase fw-500">{{ $items->cvv }}</span>
                                                                        <h5 class="ms-auto">{{ $items->card_type }}</h5>
                                                                    </p>
                                                                    <div class="account-card-overlay rounded"> 
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#edit-card-details" class="text-light btn-link mx-2" onclick="showEditCardModal()">
                                                                            <span class="me-1"><i class="fas fa-edit"></i></span>Edit
                                                                        </a> 
                                                                        <a href="#" class="text-light btn-link mx-2">
                                                                            <span class="me-1"><i class="fas fa-minus-circle"></i></span>Delete
                                                                        </a> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            
                                        </div>
                                    </div>




                                    <div id="step-2" class="">
                                        <div class="table-responsive">
                                           <div class="col-md-6">
                                            @foreach ($bankDetail as $key => $value)
                                            <div class="bg-primary shadow-sm rounded p-4 mb-4">
                                                <h3 class="text-5 fw-400 mb-4">Bank Accounts <span class="text-muted text-4">(for withdrawal)</span></h3>
                                                <hr class="mb-4 mx-n4">
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-6">
                                                        <div class="account-card account-card-primary text-white rounded hover-card">
                                                            <div class="row g-0">
                                                                <div class="col-3 d-flex justify-content-center p-3"><br>
                                                                    <div class="my-auto text-center"> <span class="text-13" style="font-size: 70px;"><i
                                                                                class="fas fa-university"></i></span>
                                                                        <p class="badge bg-warning text-dark text-0 fw-500 rounded-pill px-2 mb-0">Primary</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-9 border-start">
                                                                    <div class="py-4 my-2 ps-4">
                                                                        <p class="text-4 fw-500 mb-1">{{ $value->account_title }}</p>
                                                                        <p class="text-4 fw-500 mb-1">{{ $value->iban_no }}</p>
                                                                        <p class="text-4 fw-500 mb-1">{{ $value->bank_name }}</p>
                                                                        <p class="text-4 opacity-9 mb-1">{{ $value->account_no }}</p>
                                                                        <p class="text-4 opacity-9 mb-1">{{ $value->bank_address }}</p>
                                                                        <p class="text-4 opacity-9 mb-1">{{ $value->branch_code }}</p>
                                                                        <p class="m-0">Approved <span class="text-3"><i
                                                                                    class="fas fa-check-circle"></i></span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="account-card-overlay rounded">
                                                                <a href="#" data-bs-target="#bank-account-details" data-bs-toggle="modal"
                                                                    class="text-light btn-link mx-2" onclick="showBankAccountModal()">
                                                                    <span class="me-1"><i class="fas fa-share"></i></span>More Details</a>
                                                                <a href="#" class="text-light btn-link mx-2">
                                                                    <span class="me-1"><i class="fas fa-minus-circle"></i></span>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        {{-- <div class="col-12 col-md-6"> <a href="#" data-bs-target="#add-new-bank-account"
                                                                data-bs-toggle="modal"
                                                                class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0"
                                                                onclick="showAddBankAccountModal()">
                                                                <p class="w-100 text-center lh-base m-0"> <span class="text-3"><i
                                                                            class="fas fa-plus-circle"></i></span> <span class="d-block text-body text-3">Add New
                                                                        Bank Account</span> </p>
                                                            </a> </div> --}}
                                                </div>
                                            </div>

                                            @endforeach
                                           </div>
                                            
                                            {{-- <table id="deafult_ordering_table"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Account Title</th>
                                                        <th>Account No</th>
                                                        <th>IBAN No</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Branch Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                 
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>

                                                        </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Account Title</th>
                                                        <th>Account No</th>
                                                        <th>IBAN No</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Branch Code</th>
                                                    </tr>
                                                </tfoot>
                                            </table> --}}
                                        </div>
                                    </div>



                                    {{-- ===Step-7=== --}}


                                    <div id="step-3" class="">
                                        <div class="table-responsive">
                                            <table id="deafult_ordering_table1"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendordocument as $key => $value)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->document_name }}</td>
                                                            <td>
                                                                <div id="" style="display: flex;">
                                                                    @if ($value->document_file)
                                                                        @foreach (json_decode($value->document_file) as $file)
                                                                            @if (Str::endsWith($file, '.pdf'))
                                                                                {{-- Display PDF if it's a PDF file --}}
                                                                                {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                                <a href="{{ asset($file) }}"
                                                                                    download>
                                                                                    <embed src="{{ asset($file) }}"
                                                                                        type="application/pdf"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;">
                                                                                    <button type="button"
                                                                                        class="btn  btn-outline-secondary ">
                                                                                        <i class=" nav-icon i-Download"
                                                                                            style="font-weight: bold;"></i>
                                                                                    </button>
                                                                                    <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                                </a>
                                                                            @else
                                                                                {{-- Display image if it's not a PDF file --}}

                                                                                <a href="{{ asset($file) }}"
                                                                                    class="image-popup">
                                                                                    <img src="{{ asset($file) }}"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;" />
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <p>images is empty or null</p>
                                                                    @endif


                                                                </div>
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    {{-- ===Step-8=== --}}


                                    <div id="step-4" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Become a Verified Supplier

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Front:</label>
                                                                    @if ($edit && $edit->id_front)
                                                                        @if (Str::endsWith($edit->id_front, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_front) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_front) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif
                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Back:</label>
                                                                    @if ($edit && $edit->id_back)
                                                                        @if (Str::endsWith($edit->id_back, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_back) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_back) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif


                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Trade
                                                                        License:</label>

                                                                    @if ($edit && $edit->trade_license)
                                                                        @if (Str::endsWith($edit->trade_license, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->trade_license) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->trade_license) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif

                                                                </div>

                                                            </div>
                                                        </div>

                                                        {{-- <hr> --}}



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    {{-- ===Step-2=== --}}




                                    <div id="step-5" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Slider Image's
                                                                <!-- <span class="badge  badge-round-info md"> -->
                                                                <!-- <p style="font-size: revert;">✓</p> -->
                                                                </span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div id="f_i_thumnails"
                                                                    class="form-group col-md-12 gap-10">
                                                                    <div id="loopImg" class=""
                                                                        style="display: flex;">

                                                                        @if (!empty($edit->slider_images))
                                                                            @php
                                                                                $decodedImages = json_decode(
                                                                                    $edit->slider_images,
                                                                                );
                                                                            @endphp

                                                                            @if ($decodedImages !== null)
                                                                                @foreach ($decodedImages as $key => $value)
                                                                                    <a href="{{ asset($value) }}"
                                                                                        style="margin: auto;"
                                                                                        class="image-popup">
                                                                                        <img src="{{ asset($value) }}"
                                                                                            class="img-thumbnail "
                                                                                            style="width:250px;height:130px;" />
                                                                                    </a>
                                                                                    {{-- <span class="delete-icon" data-image-index="{{ $key }}">Delete</span> --}}
                                                                                @endforeach
                                                                            @else
                                                                                <p>Invalid JSON data in
                                                                                    $edit->slider_images</p>
                                                                            @endif
                                                                        @else
                                                                            <p>images is empty or null</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- ===Step-5=== --}}



                                    <div id="step-6" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Porfolio Image's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    @foreach ($porfolie as $item)
                                                                        
                                                                    {{ $item->title  }}
                                                                    @endforeach
                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">
                                                                        <img src="{{ asset('$porfolie->image') }}"
                                                                            alt="abc">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    {{-- ===Step-4=== --}}



                                    <div id="step-7" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Service's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    @foreach ($services as $items)
                                                                        
                                                                    {{ $items->item }}
                                                                    @endforeach

                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">
                                                                        @foreach ($services as $items)
                                                                        
                                                                        {{ $items->description }}
                                                                       
                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <img src="{{ asset('$services->image') }}"
                                                                        alt="abc">
                                                                </div>
                                                                <div id="f_i_thumnails" class="form-group  gap-10">
                                                                    <div id="loopImg" class="gap-10">


                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">

                                                                    </div>
                                                                    <div id="f_i_thumnails"
                                                                        class="form-group  gap-10">
                                                                        <div id="loopImg" class="gap-10">


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- ===Step-3=== --}}

                                    {{-- Test --}}
                                    <div id="step-8" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Service's

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <p>{{ $edit->about }}</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                    <div class="row">
                                                    {{-- ------------------Alert Button------------------ --}}
                    
                        <head>
                           
                            <title>Popup Alert</title>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                                integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
                        
                        
                            <style>
                                .popup-container {
                                    position: fixed;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #fff;
                                    padding: 20px;
                                    border-radius: 5px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                    z-index: 1000;
                                    display: none;
                                }
                                .popup-container{
                                    width: 500px;
                                    text-align: center;
                                }
                                /* .popup-container .close-btn {
                                    position: absolute;
                                    top: 5px;
                                    right: 5px;
                                    cursor: pointer;
                                } */
                            </style>
                        </head>
                        
                        <body>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail18" class="ul-form__label">Trusted Status  <span class="badge  badge-round-info md"><p style="font-size: revert;">✓</p></span></label>
                                        <div class="ul-form__checkbox-inline">
                                            
                                            <label class="switch">
                                                <input type="checkbox" id="popup-triggers"  name="trusted" value="1" @if($vendors->trusted_status == '1') checked @endif class="coupon-status-toggle"  >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        @if ($vendors->trusted_status == '1')
                                        <button type="button" class="btn btn-raised btn-raised-secondary m-1">Verified</button>
                                        @elseif ($vendors->trusted_status == '0')
                                        @endif
                                    </div>
                                    {{-- <button id="popup-triggers" class="btn btn-primary col-md-1" style="border-radius: 55px; background-color: #0CC27E; width:200px; height: 100;">Trusted Supplies Status</button> --}}
                                </div>
                                {{-- <div class="col-md-2">
                                    <h4>
                                        @if ($vendors->trusted_status == '1')
                                        <span class="badge  badge-secondary badge-round-info md">
                                            <i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #63E6BE;" style="display: none;"></i>
                                        </span>
                                        @elseif ($vendors->trusted_status == '0')
                                        <h6>
                                            <i class="fa-solid fa-x fa-shake fa-4x" style="color: #ff0000;"></i>
                                        </h6>
                                        <span class="badge  badge-round-secondary md"><p style="font-size: revert;">x</p></span>
                                    @endif
                                    </h4>
                                </div> --}}
                            </div>
                            
                            <div class="popup-container" id="popups" >
                                <h2>Are you Sure!</h2>
                                <p>You want to update User Status!</p>
                                
                                <div class="rounded  d-block col-md-12" id="update-btns">
                                    
                                </div>
                                {{-- === --}}
                                <form action="{{ route('vendors.update', ['vendor' => $vendors->id]) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12" hidden>
                                            <label for="inputEmail18" class="ul-form__label">Status: (Active || Inactive)</label>
                                                <div class="ul-form__checkbox-inline">
                                                <label class="switch">
                                                    <input type="checkbox"  name="radio" value="1" @if($vendors->status == '1') checked @endif class="coupon-status-toggle"  >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <small id="passwordHelpBlock" class="ul-form__text form-text">
                                                Select Your Status
                                            </small>
                                        </div>

                                        <div class="form-group col-md-12" hidden>
                                            <label for="inputEmail18" class="ul-form__label">Verified Status  <span class="badge  badge-round-success md"><p style="font-size: revert;">✓</p></span></label>
                                            <div class="ul-form__checkbox-inline">
                                                
                                                <label class="switch">
                                                    <input type="checkbox"  name="verified" value="1" @if($vendors->verified_status == '1') checked @endif class="coupon-status-toggle"  >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="inputEmail18" class="ul-form__label">Trusted Status  <span class="badge  badge-round-info md"><p style="font-size: revert;">✓</p></span></label>
                                            <div class="ul-form__checkbox-inline">
                                                
                                                <label class="switch">
                                                    <input type="checkbox"  name="trusted" value="1" @if($vendors->trusted_status == '1') checked @endif class="coupon-status-toggle"  >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="custom-separator"></div>
                                    </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-outline-secondary  ladda-button example-button m-1" id="update-btnn" onclick="closePopups(true)">Update</button>
                                                    {{-- <button type="button" class="btn btn-outline-secondary m-1" onclick="closePopups(false)">Cancel</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                               
                                {{-- === --}}
                            </div>
                            
                        
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#popup-triggers').click(function() {
                                        $('#popups').fadeIn();
                                    });
                                });
                            
                                function closePopups(update) {
                                    if (update) {
                                        // public\assets\img\icons8-check.gif
                                        $('#update-btns').html('<i class="fas fa-check tick-icon fa-bounce fa-4x" style="color: #63E6BE;" style="display: none;"></i>');
                                    } else {
                                        $('#update-btns').html('<img src="{{asset('assets/img/x.gif')}}" class="img-fluid rounded-top" width="100px" alt="123333333333333333"/>');
                                    }
                                    $('#popups').fadeOut(1000);
                                }
                            </script>
                            
                        
                            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
                            </script>
                        
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
                            </script>
                        </body>

                        {{-- ------------------Alert Button------------------ --}}

                        
                        <div class="col-md-12" style="padding: 20px;">
                            <!-- SmartWizard html -->

                            <div id="smartwizard3" class="sw-theme-dots">
                                <ul style="justify-content: center;">
                                    <li><a href="#step-4">Step 1<br /><small>Company Profile</small></a></li>
                                    <li><a href="#step-3">Step 2<br /><small>Company Register Documen</small></a></li>
                                </ul>

                                <span>
                                    <div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end">
                                        <div class="btn-group me-2 sw-btn-group" role="group">
                                            <button class="btn btn-secondary sw-btn-prev disabled"
                                                type="button">Previous</button>
                                            <button class="btn btn-secondary sw-btn-next" type="button">Next</button>
                                        </div>
                                        <div class="btn-group me-2 sw-btn-group-extra" role="group">
                                        </div>
                                    </div>
                                </span>


                                {{-- ===Step-1=== --}}


                                <div>

                                    {{-- ===Step-7=== --}}


                                    <div id="step-3" class="">
                                        <div class="table-responsive">
                                            <table id="deafult_ordering_table1"
                                                class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendordocument as $key => $value)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->document_name }}</td>
                                                            <td>
                                                                <div id="" style="display: flex;">
                                                                    @if ($value->document_file)
                                                                        @foreach (json_decode($value->document_file) as $file)
                                                                            @if (Str::endsWith($file, '.pdf'))
                                                                                {{-- Display PDF if it's a PDF file --}}
                                                                                {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                                <a href="{{ asset($file) }}"
                                                                                    download>
                                                                                    <embed src="{{ asset($file) }}"
                                                                                        type="application/pdf"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;">
                                                                                    <button type="button"
                                                                                        class="btn  btn-outline-secondary ">
                                                                                        <i class=" nav-icon i-Download"
                                                                                            style="font-weight: bold;"></i>
                                                                                    </button>
                                                                                    <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                                </a>
                                                                            @else
                                                                                {{-- Display image if it's not a PDF file --}}

                                                                                <a href="{{ asset($file) }}"
                                                                                    class="image-popup">
                                                                                    <img src="{{ asset($file) }}"
                                                                                        class="img-thumbnail"
                                                                                        style="width:100px;height:80px;" />
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <p>images is empty or null</p>
                                                                    @endif


                                                                </div>
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id#</th>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    {{-- ===Step-8=== --}}


                                    <div id="step-4" class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Become a Verified Supplier

                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Front:</label>
                                                                    @if ($edit && $edit->id_front)
                                                                        @if (Str::endsWith($edit->id_front, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_front) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_front) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_front) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif
                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Owner ID Card
                                                                        Back:</label>
                                                                    @if ($edit && $edit->id_back)
                                                                        @if (Str::endsWith($edit->id_back, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->id_back) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->id_back) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->id_back) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif


                                                                </div>

                                                                <div id="f_i_thumnails" class="form-group col-md-4">
                                                                    <label for="inputtext11"
                                                                        class="ul-form__label">Trade
                                                                        License:</label>

                                                                    @if ($edit && $edit->trade_license)
                                                                        @if (Str::endsWith($edit->trade_license, '.pdf'))
                                                                            {{-- Display PDF if it's a PDF file --}}
                                                                            {{-- <embed src="{{ asset($file) }}" type="application/pdf" class="img-thumbnail"  style="width:100px;height:80px;" > --}}
                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                download>
                                                                                <embed
                                                                                    src="{{ asset($edit->trade_license) }}"
                                                                                    type="application/pdf"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;">
                                                                                <button type="button"
                                                                                    class="btn  btn-outline-secondary ">
                                                                                    <i class=" nav-icon i-Download"
                                                                                        style="font-weight: bold;"></i>
                                                                                </button>
                                                                                <!-- You can replace 'path_to_pdf_icon_image.png' with an image of a PDF icon -->
                                                                            </a>
                                                                        @else
                                                                            {{-- Display image if it's not a PDF file --}}

                                                                            <a href="{{ asset($edit->trade_license) }}"
                                                                                class="image-popup">
                                                                                <img src="{{ asset($edit->trade_license) }}"
                                                                                    class="img-thumbnail"
                                                                                    style="width:100px;height:80px;" />
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <h6>No Image</h6>
                                                                    @endif

                                                                </div>

                                                            </div>
                                                        </div>

                                                        {{-- <hr> --}}



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- {-------Tabs End-------} --}}



@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smartwizard/4.4.1/js/jquery.smartWizard.min.js"></script>
<script>
    $(document).ready(function(){
        $('#smartwizard2').smartWizard({
            selected: 0, // Initial step
            keyNavigation: false, // Enable keyboard navigation
            autoAdjustHeight: false,
        });
        $('#smartwizard3').smartWizard({
            selected: 0, // Initial step
            keyNavigation: false, // Enable keyboard navigation
            autoAdjustHeight: false,
        });
    });
</script>


@section('page-js')
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.script.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/vendor/jquery.smartWizard.min.js') }}"></script>

<script>
    $(document).ready(function() {
    $('#smartwizard').smartwizard({
        selected: 0, // Initial step
        keyNavigation: false, // Enable keyboard navigation
        autoAdjustHeight: false,
    });
    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ asset('assets/js/vendor/quill.min.js') }}"></script>
<script src="{{ URL::asset('website-assets/js/toastr.min.js') }}"></script>
@if ($errors->any())
    <script>
        toastr.error("{{ $errors->first() }}");
    </script>
@endif
{!! Toastr::message() !!}

<!-- Include jQuery -->

<!-- Include a lightbox library (e.g., Magnific Popup) for the pop-up effect -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<!-- Add a JavaScript function to initialize the pop-up -->
<script>
    $(document).ready(function() {
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });

</script>
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/smart.wizard.script.js') }}"></script>
<script src="{{ asset('assets/js/quill.script.js') }}"></script>


<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
