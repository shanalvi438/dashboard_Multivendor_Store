<?php
// dd($bankCard);
?>
@extends('layouts.master')
@section('before-css')
    {{-- css link sheet  --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_dots.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
@section('page-css')
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/choices.min.css') }}">

    <style>
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
    {{-- {{$edit->pay}} --}}

    <h1>Seller Verification Management's</h1>

    {{-- @if (count($errors) > 0)
                    <div class="alert alert-danger d-flex">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
</div>

<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-4">
    <div class="card text-start">

        <div class="card-body">
            <h4 class="card-title mb-3">Basic Tab</h4>
            <p>Takes the basic nav from above and adds the <code>.nav-tabs</code> class to generate a tabbed interface
            </p>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab"
                        aria-controls="homeBasic" aria-selected="true">Profile Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab"
                        aria-controls="profileBasic" aria-selected="false">Trusted Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab"
                        aria-controls="contactBasic" aria-selected="false">Payment Vefirfied</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                    <div class="col-md-12 mb-4">
                        @if (Auth::user()->role == 'Vendor')
                            @if (Auth::user()->status == '1')
                                <span>Status: </span>
                                <span class="btn btn-primary">Active</span>
                            @else
                                <span>Status:</span>
                                <span class="btn btn-danger bg-danger" style="color: white"> In Active </span>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-md-12" style="padding: 20px;">
                                <!-- SmartWizard html -->
                                {!! Form::model($edit, [
                                    'method' => 'PATCH',
                                    'action' => ['App\Http\Controllers\VendorsController@vendorProfileSave', $edit->id],
                                    'class' => 'form-horizontal',
                                    'files' => 'true',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}
                                <div id="smartwizard" class="sw-theme-dots">
                                    <ul style="justify-content: center;">
                                        <li><a href="#step-1">Step 1<br /><small>Profile Info</small></a></li>
                                        <li><a href="#step-2">Step 2<br /><small>Sliders</small></a></li>
                                        <!-- <li><a href="#step-3">Step 3<br /><small>Portfolio</small></a></li> -->
                                        <li><a href="#step-4">Step 3<br /><small>About</small></a></li>
                                    </ul>

                                    <span>
                                        <div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end">
                                            <div class="btn-group me-2 sw-btn-group" role="group">
                                                <button class="btn btn-secondary sw-btn-prev disabled"
                                                    type="button">Previous</button>
                                                <button class="btn btn-secondary sw-btn-next"
                                                    type="button">Next</button>
                                            </div>
                                            <div class="btn-group me-2 sw-btn-group-extra" role="group">
                                            </div>
                                        </div>
                                    </span>

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
                                                                <div>
                                                                    <figure class="figure col-md-2 col-sm-3 col-xs-12"
                                                                        style="margin: revert;">
                                                                        <img class="img-rounded img-responsive"
                                                                            @if ($edit && isset($edit->logo)) <img src="{{ asset($edit->logo) }}" style="width:100px;height:80px;" alt="logo">
                                                                        @else
                                                                            {{-- Handle the case where $edit is null or does not have a 'logo' property --}}
                                                                            <p>N/A</p> @endif
                                                                            </figure>
                                                                        <div class="form-inline col-md-10 col-sm-9 col-xs-12"
                                                                            style="margin-left: 40px;">
                                                                            <input type="file" id="logo"
                                                                                name="logo"
                                                                                class="file-uploader pull-left">
                                                                        </div>
                                                                </div>
                                                            </div>

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    {!! Form::hidden('user_id', $edit->user->id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                                    {!! Form::hidden('user_id', $edit->user->id, ['id' => 'id', 'class' => 'form-control']) !!}


                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Company Name:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('company_name', null, ['id' => 'company_name', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('company_name'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('company_name') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">First Name:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('first_name', $edit->user->first_name, ['id' => 'first_name', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('first_name'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('first_name') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Last Name:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('last_name', $edit->user->last_name, ['id' => 'last_name', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('last_name'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('last_name') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Phone# 1<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('phone1', $edit->user->phone1, [
                                                                            'id' => 'phone1',
                                                                            'class' => 'form-control',
                                                                            'maxlength' => '18',
                                                                            'onkeypress' => 'return onlyDecimalNumberKey(event)',
                                                                        ]) !!}
                                                                        @if ($errors->has('phone1'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('phone1') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Phone# 2:</label>
                                                                        {!! Form::text('phone2', $edit->user->phone2, [
                                                                            'id' => 'phone2',
                                                                            'class' => 'form-control',
                                                                            'maxlength' => '18',
                                                                            'onkeypress' => 'return onlyDecimalNumberKey(event)',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Country:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('country', $edit->user->country, ['id' => 'country', 'class' => 'form-control']) !!}
                                                                        {{-- {!! Form::select('countries',  [], ['id' => 'countries', 'class' => 'form-control']) !!} --}}
                                                                        {{-- <select class="form-control selectpicker countrypicker" id="country" name="country" ata-flag="true">
                                                                                <option value=""></option>  
                                                                            </select> --}}

                                                                        @if ($errors->has('country'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('country') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>


                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">City:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('city', $edit->user->city, ['id' => 'city', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('city'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('city') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Address:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('address1', $edit->user->address1, ['id' => 'address1', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('address1'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('address1') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Address2:</label>
                                                                        {!! Form::text('address2', $edit->user->address2, ['id' => 'address2', 'class' => 'form-control']) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">

                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Tagline<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('tagline', null, ['id' => 'tagline', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('tagline'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('tagline') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">

                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Tax Registration
                                                                            Title:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('tax_reg_title', $edit->user->tax_reg_title, [
                                                                            'id' => 'tax_reg_title',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                        @if ($errors->has('tax_reg_title'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('tax_reg_title') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Tax Registration
                                                                            Number:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('tax_reg_number', $edit->user->tax_reg_number, [
                                                                            'id' => 'tax_reg_number',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                        @if ($errors->has('tax_reg_number'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('tax_reg_number') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Accept Payment
                                                                            Type:<span
                                                                                style="color: red;">*</span></label>
                                                                        {{-- {!! Form::text('accepted_payment_type', $edit->user->accepted_payment_type,  ['id' => 'accept_payment_type', 'class' => 'form-control']) !!} --}}
                                                                        <select id="choices-multiple-remove-button"
                                                                            name="accepted_payment_type[]"
                                                                            class="form-control"
                                                                            placeholder="Select Payment Type" multiple>

                                                                            @foreach ($accepted_payment_type as $value)
                                                                                <option value="{{ $value->id }}"
                                                                                    @if ($edit->paymethod->contains('pay_id', $value->id)) selected @endif>
                                                                                    {{ $value->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Total
                                                                            Employee:</label>
                                                                        {!! Form::text('total_employees', $edit->user->total_employees, [
                                                                            'id' => 'total_employees',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Established
                                                                            In:</label>
                                                                        {!! Form::text('established_in', $edit->user->established_in, [
                                                                            'id' => 'established_in',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Main
                                                                            Market:</label>
                                                                        {!! Form::text('main_market', $edit->user->main_market, ['id' => 'main_market', 'class' => 'form-control']) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Member
                                                                            Since:</label>
                                                                        {!! Form::text('member_since', $edit->user->member_since, ['id' => 'member_since', 'class' => 'form-control']) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Certification:</label>
                                                                        {!! Form::text('certifications', $edit->user->certifications, [
                                                                            'id' => 'certifications',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Website
                                                                            Link:</label>
                                                                        {!! Form::text('website_link', $edit->user->website_link, ['id' => 'website_link', 'class' => 'form-control']) !!}
                                                                    </div>


                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Major
                                                                            Clients:</label>
                                                                        {!! Form::text('major_clients', $edit->user->major_clients, [
                                                                            'id' => 'major_clients',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Annual
                                                                            Export:</label>
                                                                        {!! Form::text('annual_export', $edit->user->annual_export, [
                                                                            'id' => 'annaul_export',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Annual
                                                                            Import:</label>
                                                                        {!! Form::text('annual_import', $edit->user->annual_import, [
                                                                            'id' => 'annaul_import',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputEmail12"
                                                                            class="ul-form__label">Annual
                                                                            Revenue:</label>
                                                                        {!! Form::text('annual_revenue', $edit->user->annual_revenue, [
                                                                            'id' => 'annaul_revenue',
                                                                            'class' => 'form-control',
                                                                        ]) !!}
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Profile
                                                                            Reviews<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::text('rating', null, ['id' => 'rating', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('rating'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('rating') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group"style="text-align: right;">
                                                                    <div class="">
                                                                        <input class="btn btn-outline-secondary"
                                                                            type="submit" value="Update Profile">
                                                                    </div>
                                                                </div>


                                                            </div>




                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="step-2" class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">Slider</h3>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="">
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Slider
                                                                            Images:<span
                                                                                style="color: red;">*</span></label>

                                                                        <input type="file" name="slider_images[]"
                                                                            id="imageInput" class="form-control"
                                                                            multiple>
                                                                        <button type="button"
                                                                            class="d-none form-control"
                                                                            style="width: auto;"id="chooseImages">Choose
                                                                            Images</button>

                                                                        @if ($errors->has('slider_images'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('slider_images') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="form-group col-md-8">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Images</label>

                                                                        <div id="loopImg" style="display: flex;">
                                                                            {{-- @foreach (json_decode($edit->slider_images) as $value)
                                                                                <img src="{{ asset($value) }}" class="img-thumbnail" style="width:100px;height:80px;" />
                                                                            @endforeach --}}
                                                                            @if (!empty($edit->slider_images))
                                                                                @php
                                                                                    $decodedImages = json_decode(
                                                                                        $edit->slider_images,
                                                                                    );
                                                                                @endphp

                                                                                @if ($decodedImages !== null)
                                                                                    @foreach ($decodedImages as $key => $value)
                                                                                        <img src="{{ asset($value) }}"
                                                                                            class="img-thumbnail_1"
                                                                                            style="width:100px;height:80px;" />

                                                                                        {{-- <span class="delete-icon" data-image-index="{{ $key }}">Delete</span> --}}{{-- <span class="delete-icon"  data-image-index="{{ $key }}">Delete</span> --}}
                                                                                    @endforeach
                                                                                @else
                                                                                    <p>Invalid JSON data in
                                                                                        $edit->slider_images</p>
                                                                                @endif
                                                                            @else
                                                                                <p>images is empty or null</p>
                                                                            @endif
                                                                        </div>
                                                                        <div id="thumbnails"></div>
                                                                        <div id="fileLimitMessage"
                                                                            style="color: red;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group"style="text-align: right;">
                                                                <div class="">
                                                                    <input class="btn btn-outline-secondary"
                                                                        type="submit" value="Update Profile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="step-4" class="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-transparent">
                                                            <h3 class="card-title">About</h3>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="">
                                                                <div class="row">

                                                                    <div class="form-group col-md-12">

                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">About:<span
                                                                                style="color: red;">*</span></label>
                                                                        {!! Form::textarea('about', null, ['id' => 'description', 'class' => 'form-control']) !!}
                                                                        @if ($errors->has('about'))
                                                                            <span style="color: red;"
                                                                                class="invalid-feedback1 font-weight-bold">{{ $errors->first('about') }}</span
                                                                                style="color: red;">
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                                <div class="form-group"style="text-align: right;">
                                                                    <div class="">
                                                                        <input class="btn btn-outline-secondary"
                                                                            type="submit" value="Update Profile">
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

                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <div class="separator-breadcrumb border-top"></div>
                    <div class="col-md-12 mb-4">
                        @if (Auth::user()->role == 'Vendor')
                        @if (Auth::user()->trusted_status == '1')
                        <span>Status: </span>
                            <span class="btn btn-primary">Verified</span>
                        @else
                            <span>Status:</span>
                            <span class="btn btn-danger bg-danger" style="color: white"> Unverified </span> 
                        @endif
                    @endif
                </div>
                {{-- <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">
                    Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.
                    @if (Auth::user()->role == 'Vendor')
                    @if (Auth::user()->verified_status == '1')
                    <span>Status: </span>
                        <span class="btn btn-primary">Verified</span>
                    @else
                        <span>Status:</span>
                        <span class="btn btn-danger bg-danger" style="color: white"> Unverified </span> 
                    @endif
                @endif
                </div> --}}
                        <div class="row">
                            <div class="col-md-12" style="padding: 20px;">
                                <!-- SmartWizard html -->

                                <div id="smartwizardes" class="sw-theme-dots">
                                    <ul style="justify-content: center;">
                                        <li><a href="#step-1">Step 1<br /><small>Bank Details</small></a></li>
                                        <li><a href="#step-3">Step 2<br /><small>Bank Card</small></a></li>
                                        <li><a href="#step-2">Step 3<br /><small>ID & Comapny Details</small></a></li>
                                        <li><a href="#step-4">Step 4<br /><small>Company<br> Registration
                                                    Documents</small></a></li>
                                    </ul>

                                    <span>
                                        <div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end">
                                            <div class="btn-group me-2 sw-btn-group" role="group">
                                                <button class="btn btn-secondary sw-btn-prev disabled"
                                                    type="button">Previous</button>
                                                <button class="btn btn-secondary sw-btn-next"
                                                    type="button">Next</button>
                                            </div>
                                            <div class="btn-group me-2 sw-btn-group-extra" role="group">
                                            </div>
                                        </div>
                                    </span>
                                    <div>
                                        <h4>Become a Payment Verified Supplier
                                            <span class="badge  badge-round-info md">
                                                <p style="font-size: revert;">✓</p>
                                            </span>
                                        </h4>

                                        <div id="add-new-bank-account" class="modal fade" aria-hidden="true">
                                            {!! Form::model($edit, [
                                                'method' => 'POST',
                                                'action' => ['App\Http\Controllers\VendorsController@trustedSellerSave', $edit->id],
                                                'class' => 'form-horizontal',
                                                'files' => 'true',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {!! Form::hidden('vendor_profile_id', $edit->id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                        {!! Form::hidden('vendor_id', $edit->vendor_id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                        <h5 class="modal-title fw-400">Add bank account</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            onclick="hideAddBankAccountModal()"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3">
                                                            <label for="inputtext11" class="ul-form__label">Account
                                                                Title:</label>
                                                            {!! Form::text('account_title', null, ['id' => 'account_title', 'class' => 'form-control']) !!}
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="inputtext11" class="ul-form__label">Account
                                                                No:</label>
                                                            {!! Form::text('account_no', null, ['id' => 'account_no', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="inputEmail12" class="ul-form__label">IBAN
                                                                No</label>
                                                            {!! Form::text('iban_no', null, ['id' => 'iban_no', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="inputEmail12" class="ul-form__label">Bank
                                                                Name:</label>
                                                            {!! Form::text('bank_name', null, ['id' => 'bank_name', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="inputEmail12" class="ul-form__label">Bank
                                                                Address:</label>
                                                            {!! Form::text('bank_address', null, ['id' => 'bank_address', 'class' => 'form-control']) !!}
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="inputEmail12" class="ul-form__label">Branch
                                                                Code:</label>
                                                            {!! Form::text('branch_code', null, ['id' => 'branch_code', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" id="remember-me"
                                                                name="remember" type="checkbox">
                                                            <label class="form-check-label" for="remember-me">I
                                                                confirm the bank account
                                                                details above</label>
                                                        </div>
                                                        <div class="d-grid"><button class="btn btn-primary"
                                                                type="submit" onclick="hideAddBankAccountModal()">Add
                                                                Bank Account</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <script>
                                            function showAddBankAccountModal() {
                                                var modal = document.getElementById('add-new-bank-account');
                                                modal.classList.add('show');
                                                modal.style.display = 'block';
                                                document.body.classList.add('modal-open');
                                            }

                                            function hideAddBankAccountModal() {
                                                var modal = document.getElementById('add-new-bank-account');
                                                modal.classList.remove('show');
                                                modal.style.display = 'none';
                                                document.body.classList.remove('modal-open');
                                            }
                                        </script>


                                        {{-- //Step-1 Bank Detail --}}
                                        <div class="col-12 col-md-12" id="step-1">
                                            <div class="custom-container justify-content-center">
                                                <a href="#" data-bs-target="#add-new-bank-account"
                                                    data-bs-toggle="modal"
                                                    class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0"
                                                    onclick="showAddBankAccountModal()">
                                                    <p class="w-100 text-center lh-base m-0">
                                                        <span class="text-3"><i class="fas fa-plus-circle"></i></span>
                                                        <span class="d-block text-body text-3">Add New Bank
                                                            Account</span>
                                                    </p>
                                                </a>
                                            </div>
                                            <br><br>
                                            <?php
                                            use App\Models\VendorBankDetail;
                                            $data = VendorBankDetail::all();
                                            // use App\Models\
                                            $bankDetail = VendorBankDetail::where('vendor_id')->get();
                                            ?>

                                            {{-- @foreach ($data as $data) --}}

                                            <div class="col-md-6">
                                                @foreach ($bankDetail as $key => $value)
                                                    <div class="bg-primary shadow-sm rounded p-4 mb-4">
                                                        <h3 class="text-5 fw-400 mb-4">Bank Accounts <span
                                                                class="text-muted text-4">(for withdrawal)</span></h3>
                                                        <hr class="mb-4 mx-n4">
                                                        <div class="row g-3">
                                                            <div class="col-12 col-md-6">
                                                                <div
                                                                    class="account-card account-card-primary text-white rounded hover-card">
                                                                    <div class="row g-0">
                                                                        <div
                                                                            class="col-3 d-flex justify-content-center p-3">
                                                                            <br>
                                                                            <div class="my-auto text-center"> <span
                                                                                    class="text-13"
                                                                                    style="font-size: 70px;"><i
                                                                                        class="fas fa-university"></i></span>
                                                                                <p
                                                                                    class="badge bg-warning text-dark text-0 fw-500 rounded-pill px-2 mb-0">
                                                                                    Primary</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-9 border-start">
                                                                            <div class="py-4 my-2 ps-4">
                                                                                <p class="text-4 fw-500 mb-1">
                                                                                    {{ $value->account_title }}</p>
                                                                                <p class="text-4 fw-500 mb-1">
                                                                                    {{ $value->iban_no }}</p>
                                                                                <p class="text-4 fw-500 mb-1">
                                                                                    {{ $value->bank_name }}</p>
                                                                                <p class="text-4 opacity-9 mb-1">
                                                                                    {{ $value->account_no }}</p>
                                                                                <p class="text-4 opacity-9 mb-1">
                                                                                    {{ $value->bank_address }}</p>
                                                                                <p class="text-4 opacity-9 mb-1">
                                                                                    {{ $value->branch_code }}</p>
                                                                                <p class="m-0">Approved <span
                                                                                        class="text-3"><i
                                                                                            class="fas fa-check-circle"></i></span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="account-card-overlay rounded">
                                                                        <a href="#"
                                                                            data-bs-target="#bank-account-details"
                                                                            data-bs-toggle="modal"
                                                                            class="text-light btn-link mx-2"
                                                                            onclick="showBankAccountModal()">
                                                                            <span class="me-1"><i
                                                                                    class="fas fa-share"></i></span>More
                                                                            Details</a>
                                                                        <a href="#"
                                                                            class="text-light btn-link mx-2">
                                                                            <span class="me-1"><i
                                                                                    class="fas fa-minus-circle"></i></span>Delete</a>
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


                                            <div class="bg-white shadow-sm rounded p-4 mb-4">
                                                <div class="row g-3">
                                                    @foreach ($data as $key => $item)
                                                        <div class="col-8 col-md-6">
                                                            <div
                                                                class="account-card account-card-primary text-white rounded hover-card">
                                                                <div class="row g-0">
                                                                    <div
                                                                        class="col-3 d-flex justify-content-center p-3">
                                                                        <br>
                                                                        <div class="my-auto text-center"> <span
                                                                                class="text-13"
                                                                                style="font-size: 70px;"><i
                                                                                    class="fas fa-university"></i></span>
                                                                            <p
                                                                                class="badge bg-warning text-dark text-0 fw-500 rounded-pill px-2 mb-0">
                                                                                Primary</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-9 border-start">
                                                                        <div class="py-4 my-2 ps-4">
                                                                            <p class="text-4 fw-500 mb-1">Account
                                                                                Title:</p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->account_title }}</p>
                                                                            <p class="text-4 fw-500 mb-1">Bank Name:
                                                                            </p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->bank_name }}</p>
                                                                            <p class="text-4 fw-500 mb-1">Branch Code:
                                                                            </p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->bank_name }}</p>
                                                                            <p class="text-4 fw-500 mb-1">Account
                                                                                Number:</p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->account_no }}</p>


                                                                            <p class="text-4 fw-500 mb-1">IBN:</p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->iban_no }}</p>
                                                                            <p class="text-4 fw-500 mb-1">Bank
                                                                                Address::</p>
                                                                            <p class="text-4 opacity-9 mb-1">
                                                                                {{ $item->bank_address }}</p>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="account-card-overlay rounded">
                                                                    <a href="#"
                                                                        data-bs-target="#bank-account-details"
                                                                        data-bs-toggle="modal"
                                                                        class="text-light btn-link mx-2"
                                                                        onclick="showBankAccountModal()">
                                                                        <span class="me-1"><i
                                                                                class="fas fa-share"></i></span>More
                                                                        Details</a>
                                                                    <a href="#"
                                                                        class="text-light btn-link mx-2">
                                                                        <span class="me-1"><i
                                                                                class="fas fa-minus-circle"></i></span>Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
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







                                        </div>
                                        {{-- /////////////////////////////////////////////// --}}
                                        {{-- ///////////////////////////////////////////////// --}}
                                        {{-- //Step-3 Bank Card --}}
                                        <div id="add-new-bank-card" class="modal fade" aria-hidden="true">
                                            {!! Form::model($edit, [
                                                'method' => 'POST',
                                                'action' => ['App\Http\Controllers\VendorsController@sellerCardSave', $edit->id],
                                                'class' => 'form-horizontal',
                                                'files' => 'true',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {!! Form::hidden('vendor_profile_id', $edit->id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                        {!! Form::hidden('vendor_id', $edit->vendor_id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                        <h5 class="modal-title fw-400">Add bank account</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" onclick="hideAddBankCardtModal()"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3">
                                                            <label for="inputtext11" class="ul-form__label">Card
                                                                Holder Name</label>
                                                            {!! Form::text('card_holder_name', null, ['id' => 'card_holder_name', 'class' => 'form-control']) !!}
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="inputtext11" class="ul-form__label">Card
                                                                Number</label>
                                                            {!! Form::text('card_number', null, ['id' => 'card_number', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="inputEmail12"
                                                                class="ul-form__label">CVV</label>
                                                            {!! Form::text('cvv', null, ['id' => 'cvv', 'class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="valid_date" class="ul-form__label">Valid Date
                                                                (Month/Year)</label>
                                                            <input type="month" id="valid_date" name="valid_date"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="card_type" class="ul-form__label">Card
                                                                Type</label>
                                                            {{-- <input type="month" id="valid_date" name="valid_date" class="form-control"> --}}
                                                            <select class="form-control" name="card_type">
                                                                <option value="Master">Master</option>
                                                                <option value="Visa">Visa</option>
                                                                <option value="Platinum">Platinum</option>
                                                                <option value="UniPay">UniPay</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" id="remember-me"
                                                                name="remember" type="checkbox">
                                                            <label class="form-check-label" for="remember-me">I
                                                                confirm the bank account
                                                                details above</label>
                                                        </div>
                                                        <div class="d-grid"><button class="btn btn-primary"
                                                                type="submit" onclick="hideAddBankCardtModal()">Add
                                                                Bank Card</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>

                                        <script>
                                            function showAddBankCardtModal() {
                                                var modal = document.getElementById('add-new-bank-card');
                                                modal.classList.add('show');
                                                modal.style.display = 'block';
                                                document.body.classList.add('modal-open');
                                            }

                                            function hideAddBankCardtModal() {
                                                var modal = document.getElementById('add-new-bank-card');
                                                modal.classList.remove('show');
                                                modal.style.display = 'none';
                                                document.body.classList.remove('modal-open');
                                            }
                                        </script>


                                        <div class="col-12 col-md-12" id="step-3">
                                            <div class="custom-container justify-content-center">
                                                <a href="#" data-bs-target="#add-new-bank-account"
                                                    data-bs-toggle="modal"
                                                    class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0"
                                                    onclick="showAddBankCardtModal()">
                                                    <p class="w-100 text-center lh-base m-0">
                                                        <span class="text-3"><i class="fas fa-plus-circle"></i></span>
                                                        <span class="d-block text-body text-3">Add Bank Card</span>
                                                    </p>
                                                </a>
                                            </div>
                                            <br><br>
                                            <?php
                                            // use App\Models\VendorBankDetail;
                                            // echo "<pre>";
                                            //     print_r($data);
                                            // echo "</pre>";
                                            //         echo "Hello";
                                            ?>

                                            {{-- ????? --}}
                                            <div class="row g-3">
                                                @foreach ($bankCard as $items)
                                                    {{-- @foreach ($bdata as $items) --}}
                                                    @if (
                                                        $items->card_type === 'UniPay' ||
                                                            $items->card_type === 'Master' ||
                                                            $items->card_type === 'Platinum' ||
                                                            $items->card_type === 'Visa')
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="bg shadow-sm rounded p-4 mb-4">
                                                                {{-- <h3 class="text-5 fw-400 mb-4">Credit or Debit Cards <span class="text-muted text-4">(for payments)</span></h3> --}}
                                                                {{-- <hr class="mb-4 mx-n4"> --}}
                                                                <div
                                                                    class="account-card account-card-primary text-white rounded p-3 hover-card">
                                                                    <p class="text-4">{{ $items->card_number }}</p>
                                                                    <p class="d-flex align-items-center">
                                                                        <span
                                                                            class="account-card-expire text-uppercase d-inline-block opacity-7 me-2">Valid<br>thru<br></span>
                                                                        <span
                                                                            class="text-4 opacity-9">{{ $items->valid_date }}</span>
                                                                        <span
                                                                            class="badge bg-warning text-dark text-0 fw-800 rounded-pill px-1 ms-auto">{{ $items->card_holder_name }}</span>
                                                                    </p>
                                                                    <p class="d-flex align-items-center m-0">
                                                                        <span
                                                                            class="text-uppercase fw-500">{{ $items->cvv }}</span>
                                                                    <h5 class="ms-auto">{{ $items->card_type }}</h5>
                                                                    </p>
                                                                    <div class="account-card-overlay rounded">
                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#edit-card-details"
                                                                            class="text-light btn-link mx-2"
                                                                            onclick="showEditCardModal()">
                                                                            <span class="me-1"><i
                                                                                    class="fas fa-edit"></i></span>Edit
                                                                        </a>
                                                                        <a href="#"
                                                                            class="text-light btn-link mx-2">
                                                                            <span class="me-1"><i
                                                                                    class="fas fa-minus-circle"></i></span>Delete
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    {{-- @endforeach --}}
                                                @endforeach
                                            </div>


                                        </div>

                                        {{-- //Step-2 ID Card and Other Company Documents --}}

                                        <div id="step-2" class="">
                                            {!! Form::model($edit, [
                                                'method' => 'PATCH',
                                                'action' => ['App\Http\Controllers\VendorsController@verifiedSellerSave', $edit->id],
                                                'class' => 'form-horizontal',
                                                'files' => 'true',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header bg-transparent">
                                                                <h3 class="card-title">Become a Trusted Supplier

                                                                    <span class="badge  badge-round-info md">
                                                                        <p style="font-size: revert;">✓</p>
                                                                    </span>
                                                                </h3>

                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="form-group col-md-3">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Owner ID Card
                                                                            Front:</label>
                                                                        <input type="file" name="id_front"
                                                                            class="form-control">

                                                                    </div>
                                                                    <div id="f_i_thumnails"
                                                                        class="form-group col-md-1">
                                                                        @if ($edit->id_front)
                                                                            <img src="{{ asset($edit->id_front) }}"
                                                                                class=""
                                                                                style="width:100px;height:80px;">
                                                                        @else
                                                                            <h6>No Image</h6>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Owner ID Card
                                                                            Back:</label>
                                                                        <input type="file" name="id_back"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div id="f_i_thumnails"
                                                                        class="form-group col-md-1">
                                                                        @if ($edit->id_back)
                                                                            <img src="{{ asset($edit->id_back) }}"
                                                                                class=""
                                                                                style="width:100px;height:80px;">
                                                                        @else
                                                                            <h6>No Image</h6>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Trade
                                                                            License:</label>
                                                                        <input type="file" name="trade_license"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div id="f_i_thumnails"
                                                                        class="form-group col-md-1">
                                                                        @if ($edit->trade_license)
                                                                            <img src="{{ asset($edit->trade_license) }}"
                                                                                class=""
                                                                                style="width:100px;height:80px;">
                                                                        @else
                                                                            <h6>No Image</h6>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group "
                                                                        style="margin-top: 20px;text-align:right;">
                                                                        <input class="btn btn-outline-secondary"
                                                                            type="submit" value="Update">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        
                                        <div id="step-4" class="">
                                            {!! Form::model($edit, [
                                                'method' => 'POST',
                                                'action' => ['App\Http\Controllers\VendorsController@SellerDocumentSave', $edit->id],
                                                'class' => 'form-horizontal',
                                                'files' => 'true',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            {{-- <div class="card-header bg-transparent">
                                                <h3 class="card-title">Become a Trusted Supplier  
                                                    @if (!$edit->id_front == '' && !$edit->id_back == '')
                                                    <span class="badge  badge-round-info md"><p style="font-size: revert;">✓</p></span></h3>
                                                    @endif
                                                
                                                </div> --}}
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    {!! Form::hidden('vendor_profile_id', $edit->id, ['id' => 'id', 'class' => 'form-control']) !!}
                                                                    {!! Form::hidden('vendor_id', $edit->vendor_id, ['id' => 'id', 'class' => 'form-control']) !!}

                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Document
                                                                            Name:</label>
                                                                        <input type="text" name="document_name"
                                                                            class="form-control">

                                                                    </div>


                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputtext11"
                                                                            class="ul-form__label">Registration
                                                                            Document:</label>

                                                                        <input type="file" name="document_file[]"
                                                                            id="imageInput" class="form-control"
                                                                            multiple>
                                                                        <button type="button"
                                                                            class="d-none form-control"
                                                                            style="width: auto;"
                                                                            id="chooseImages">Choose
                                                                            Images</button>

                                                                    </div>
                                                                    <div class="form-group col-md-4"
                                                                        style="margin-top: auto;">

                                                                        <div class="">
                                                                            <input class="btn btn-outline-secondary"
                                                                                type="submit" value="Add Document">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-8">

                                                                        <div id="thumbnails"></div>
                                                                        <div id="fileLimitMessage"
                                                                            style="color: red;"></div>
                                                                    </div>

                                                                    <script>
                                                                        document.getElementById('chooseImages').addEventListener('click', function() {
                                                                            document.getElementById('imageInput').click();

                                                                        });

                                                                        document.getElementById('imageInput').addEventListener('change', function() {

                                                                            var RemoveImg = document.getElementById('loopImg');
                                                                            if (RemoveImg) {
                                                                                RemoveImg.style.display = 'none';
                                                                            }

                                                                            var files = this.files;
                                                                            var maxImages = 6; // Set your maximum image limit here
                                                                            var fileLimitMessage = document.getElementById('fileLimitMessage');
                                                                            if (files.length > maxImages) {
                                                                                fileLimitMessage.textContent = 'Please select a maximum of ' + maxImages + ' files.';
                                                                                this.value = ''; // Clear selected files
                                                                            } else {
                                                                                fileLimitMessage.textContent = ''; // Clear the message if within the limit
                                                                            }
                                                                        });
                                                                        document.getElementById('imageInput').addEventListener('change', function() {

                                                                            var thumbnails = document.getElementById('thumbnails');
                                                                            thumbnails.innerHTML = ''; // Clear previous thumbnails

                                                                            var files = this.files;
                                                                            var maxImages = 6; // Set your maximum image limit here
                                                                            for (var i = 0; i < Math.min(files.length, maxImages); i++) {
                                                                                var img = document.createElement('img');
                                                                                img.src = URL.createObjectURL(files[i]);
                                                                                img.style.maxWidth = '100px';
                                                                                thumbnails.appendChild(img);
                                                                            }
                                                                        });
                                                                    </script>


                                                                </div>
                                                                {!! Form::close() !!}
                                                                <br>
                                                                <br>
                                                                <div class="table-responsive">
                                                                    <table id="deafult_ordering_table1"
                                                                        class="display table table-striped table-bordered"
                                                                        style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Id#</th>
                                                                                <th>Document Name</th>
                                                                                <th>Document File</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            use App\Models\VendorDocument;
                                                                            $vendordocument = VendorDocument::get();
                                                                            ?>
                                                                            @foreach ($vendordocument as $key => $data)
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>{{ $data->document_name }}</td>
                                                                                    <td>
                                                                                        <div id=""
                                                                                            style="display: flex;">
                                                                                            @if ($data->document_file)
                                                                                                @foreach (json_decode($data->document_file) as $file)
                                                                                                    @if (Str::endsWith($file, '.pdf'))
                                                                                                        {{-- Display PDF if it's a PDF file --}}
                                                                                                        <embed
                                                                                                            src="{{ asset($file) }}"
                                                                                                            type="application/pdf"
                                                                                                            class="img-thumbnail"
                                                                                                            style="width:100px;height:80px;">
                                                                                                    @else
                                                                                                        {{-- Display image if it's not a PDF file --}}
                                                                                                        <img src="{{ asset($file) }}"
                                                                                                            class="img-thumbnail"
                                                                                                            style="width:100px;height:80px;" />
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            @else
                                                                                                <p>images is empty or
                                                                                                    null</p>
                                                                                            @endif


                                                                                        </div>
                                                                                    </td>

                                                                                    <td>
                                                                                        <a
                                                                                            href="{{ URL::to('vendor_document/' . $data->id . '/delete') }}">
                                                                                            <button type="button"
                                                                                                class="btn btn-outline-danger">
                                                                                                <i class="nav-icon i-Remove-Basket"
                                                                                                    title="delete"></i>
                                                                                            </button>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>Id#</th>
                                                                                <th>Document Name</th>
                                                                                <th>Document File</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
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
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>








<br>


{!! Form::close() !!}

<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script>
    $(document).ready(function() {
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            // maxItemCount:5,
            // searchResultLimit:5,
            // renderChoiceLimit:5
        });
    });
</script>
<script src="https://cdn.tiny.cloud/1/ki85z92gad4jwy6pn6wzw9uctxkdmgs0nn8tawovzdc0j1zb/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: "textarea#description",
        relative_urls: false,
        paste_data_images: true,
        image_title: true,
        automatic_uploads: true,
        // images_upload_url: '/post/image/upload',
        // images_upload_url: '{{ asset('upload') }}',
        images_upload_url: '{{ URL::to('/uploads3') }}',
        file_picker_types: "image",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        // override default upload handler to simulate successful upload
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    var id = "blobid" + new Date().getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(",")[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                };
            };
            input.click();
        }
    });
</script>
@endsection

@section('page-js')
<script>
    function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function onlyDecimalNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/vendor/jquery.smartWizard.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#smartwizard').smartWizard({
            selected: 0, // Initial step
            keyNavigation: false, // Enable keyboard navigation

        });
    });
    $(document).ready(function() {
        $('#smartwizardes').smartWizard({
            selected: 0, // Initial step
            keyNavigation: false, // Enable keyboard navigation
            autoAdjustHeight: false,
        });

    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ asset('assets/js/vendor/quill.min.js') }}"></script>
<script src="{{ URL::asset('website-assets/js/toastr.min.js') }}"></script>

<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>

</script>
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/smart.wizard.script.js') }}"></script>
<script src="{{ asset('assets/js/quill.script.js') }}"></script>

<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection
