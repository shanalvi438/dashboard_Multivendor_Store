<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Industry Mall | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="icon" href="{{ asset('upload/logo/logo.png') }}" type="image/x-icon">
    <script src="https://kit.fontawesome.com/7f543bc3df.js" crossorigin="anonymous"></script>
    @yield('before-css')
    {{-- theme css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    @if (Session::get('layout') == 'vertical')
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/styles/vendor/metisMenu.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
        <link rel="stylesheet" href="https://gull-html-laravel.ui-lib.com/assets/styles/vendor/sweetalert2.min.css">
    @endif
    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets\fonts\iconsmind\iconsmind.css') }}">
    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('website-assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://gull-html-laravel.ui-lib.com/assets/styles/vendor/sweetalert2.min.css">

    
    {{-- page specific css --}}
    @yield('page-css')
    <style>
        .badge-for-cancel {
            color: #fff;
            background-color: #f44336;
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .badge-for-timer {
            color: #fff;
            background-color: #2eb38d;
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .badge-for-light {
            color: #47404f;
            background-color: #bbb;
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .badge-for-success {
            color: #fff;
            background-color: #4caf50;
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        .selected-option {
            margin-bottom: 5px;
            /* Add margin below each selected option */
        }

        .remove-option {
            color: red;
            cursor: pointer;
            margin-left: 5px;
            /* Add margin between the option text and the cross icon */
            border: 1px solid darkgray;
            /* Add a dark gray round shape outline */
            border-radius: 20px;
            /* Make the outline round */
            padding: 2px;
            /* Add padding inside the outline */
        }
    </style>
</head>


<body class="text-start">
    @php
        $layout = session('layout');
    @endphp

    <!-- Pre Loader Strat  -->
    {{-- <div @if (request()->routeIs('products.index')) class=""@else class='
    loadscreen
    ' @endif id="preloader">

        <div
            @if (request()->routeIs('products.index')) class=""@else  class="loader spinner-bubble spinner-bubble-primary" @endif>


        </div>
    </div> --}}
    <!-- Pre Loader end  -->



    <!-- ===== Compact Layout start ====== -->
    @if ($layout == 'compact')
        @include('layouts.compact-vertical-sidebar.master')


        <!-- ===== Compact Layout End ====== -->

        <!-- ===== Horizontal Layout start ====== -->
    @elseif($layout == 'horizontal')
        @include('layouts.horizontal-bar.master')


        <!-- ===== Horizontal Layout End ====== -->



        <!-- ===== Vetical SIdebar Layout start ====== -->
    @elseif($layout == 'vertical')
        @include('layouts.vertical-sidebar.master')

        <!-- ===== Vetical SIdebar Layout End ====== -->




        <!-- ===== Large SIdebar Layout start ====== -->
    @elseif($layout == 'normal')
        @include('layouts.large-vertical-sidebar.master')


        <!-- ===== Large Sidebar Layout End ====== -->
    @else
        <!-- =====Deafult  Large SIdebar Layout start ====== -->

        @include('layouts.large-vertical-sidebar.master')


        <!-- ===== Large Sidebar Layout End ====== -->
    @endif
    <!-- ===== Search UI Start ====== -->
    {{-- @include('layouts.search') --}}
    <!-- ===== Search UI End ====== -->

    <!-- ===== Customizer UI Start ====== -->
    {{-- @include('layouts.common.customizer') --}}
    <!-- ===== Customizer UI Start ====== -->



    {{-- common js --}}
    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    {{-- page specific javascript --}}
    @yield('page-js')

    {{-- theme javascript --}}
    {{-- <script src="{{ mix('assets/js/es5/script.js') }}"></script>
        --}}

    <script src="{{ asset('assets/js/script.js') }}"></script>


    @if ($layout == 'compact')
        <script src="{{ asset('assets/js/sidebar.compact.script.js') }}">
            < /s>
            @elseif($layout == 'normal') <
                script src = "{{ asset('assets/js/sidebar.large.script.js') }}" >
        </script>
    @elseif($layout == 'horizontal')
        <script src="{{ asset('assets/js/sidebar-horizontal.script.js') }}"></script>
    @elseif($layout == 'vertical')
        <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
        <script src="{{ asset('assets/js/es5/script_2.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/layout-sidebar-vertical.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
    @endif



    {{-- <script src="https://gull-html-laravel.ui-lib.com/assets/js/vendor/sweetalert2.min.js"></script>
    <script src="https://gull-html-laravel.ui-lib.com/assets/js/sweetalert.script.js"></script> --}}

    <script src="https://kit.fontawesome.com/7f543bc3df.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.script.js')}}"></script>

    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>

    {{-- laravel js --}}
    {{-- <script src="{{ mix('assets/js/laravel/app.js') }}"></script>
        --}}
    <script src="{{ URL::asset('website-assets/js/toastr.min.js') }}"></script>
    @if ($errors->any())
        <script>
            toastr.error("{{ $errors->first() }}");
        </script>
    @endif
    {!! Toastr::message() !!}

    @yield('bottom-js')
    <script>
        $(document).ready(function() {

            $("#showButton").click(function() {
                $("#showDiv").removeClass("d-none");
            });

            $('#imageshow').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image").fadeIn("fast").attr('src', filePath1);
            });

            $('#imageshow1').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image1").fadeIn("fast").attr('src', filePath1);
            });

            $('#imageshow2').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image2").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow3').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image3").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow4').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image4").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow5').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image5").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow6').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image6").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow7').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image7").fadeIn("fast").attr('src', filePath1);
            });
            $('#imageshow8').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#show_image8").fadeIn("fast").attr('src', filePath1);
            });


            $('#ashow').change(function(event) {
                var filePath1 = URL.createObjectURL(event.target.files[0]);
                $("#aimage").fadeIn("fast").attr('src', filePath1);
            });

        });
    </script>


    <script>
        function updateOrderStatus(orderId, status) {

            var txt;
            if (confirm("If You Want to Update the Status Then Press Okay!")) {
                document.getElementById('status' + orderId).value = status;
                document.getElementById('orderForm' + orderId).submit();
            } else {
                txt = "You pressed Cancel!";
            }
            document.getElementById("demo").innerHTML = txt;

        }

        function updaterefundStatus(p_Id) {
            var txt;
            if (confirm("If you wish to update the refund status, please confirm by selecting 'OK'.")) {
                document.getElementById('orderForm1' + p_Id).submit();
            } else {

                txt = "You pressed Cancel!";
            }
            document.getElementById("demo").innerHTML = txt; // Not sure why you're setting innerHTML here
        }
    </script>
    <script>
        function toggleFilters() {
            var filterCard = document.getElementById("filterCard");
            if (filterCard.style.display === "none") {
                filterCard.style.display = "block";
            } else {
                filterCard.style.display = "none";
            }
        }
    </script>

    <script>
        function toggleFilters() {
            var filterCard = document.getElementById("filterCard");
            if (filterCard.style.display === "none") {
                filterCard.style.display = "block";
            } else {
                filterCard.style.display = "none";
            }
        }
    </script>

    <script>
        $(function() {
            $('.datetimerange').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY h:mm A'
                }
            });
        });
    </script>

    <script>
        function updatePriceValue(value, outputId) {
            document.getElementById(outputId).textContent = value;
        }

        function updatePriceSlider(value, sliderId) {
            document.getElementById(sliderId).textContent = value;
            document.querySelector('input[type="range"]').value = value;
        }
    </script>
    <script>
        function updatePriceValue(value, targetId) {
            document.getElementById(targetId).innerText = value;
        }

        // for select all == Saliha
        $(document).ready(function() {
            $('#selectAllNames').change(function() {
                $('.nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllid').change(function() {
                $('.idFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllname').change(function() {
                $('.nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllcity').change(function() {
                $('.cityFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllemail').change(function() {
                $('.emailFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllcontact').change(function() {
                $('.contactFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlladdres').change(function() {
                $('.addresFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllprofile_link').change(function() {
                $('.profile_linkFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllphone').change(function() {
                $('.phoneFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllphone1').change(function() {
                $('.phone1Filter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllgender').change(function() {
                $('.genderFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlllast_name').change(function() {
                $('.last_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllmodel_no').change(function() {
                $('.model_noFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });


        $(document).ready(function() {
            $('#selectAllmake').change(function() {
                $('.makeFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllsubcategories').change(function() {
                $('.nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllbrand_name').change(function() {
                $('.brand_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllslug').change(function() {
                $('.slugFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllcustomer_id').change(function() {
                $('.customer_idFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllcustomer_name').change(function() {
                $('.customer_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllsupplier_name').change(function() {
                $('.supplier_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllpro_name').change(function() {
                $('.pro_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllpro_model_no').change(function() {
                $('.pro_model_noFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });
        // for select all finished == Saliha

        $(document).ready(function() {
            $('#selectAllorder_item_id').change(function() {
                $('.order_item_idFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

         $(document).ready(function() {
          $('#selectAllid').change(function() {
                 $('.idFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
             });
        });

        $(document).ready(function() {
            $('#selectAllsku').change(function() {
                $('.skuFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllfirst_name').change(function() {
                $('.first_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlllast_name').change(function() {
                $('.last_nameFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllgender').change(function() {
                $('.genderFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllphone1').change(function() {
                $('.phone1Filter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllemail').change(function() {
                $('.emailFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlladdress').change(function() {
                $('.addressFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllshipping_city').change(function() {
                $('.shipping_cityFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAllstatus').change(function() {
                $('.statusFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
              // clear all == Saliha
        });

        $(document).ready(function() {
            $('#selectAlltitle').change(function() {
                $('.titleFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlluser_id').change(function() {
                $('.user_idFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlluser_type').change(function() {
                $('.user_typeFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function() {
            $('#selectAlldays').change(function() {
                $('.daysFilter input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });



        function updateLogo() {
            var brandId = document.getElementById('brand_id').value;
            var logoUrl = getLogoUrl(brandId); // Replace this with your logic to get the logo URL
            document.getElementById('brand_logo').src = logoUrl;
        }

        function getLogoUrl(brandId) {
            // Example logic to get the logo URL based on the brand ID
            switch (brandId) {
                case '1':
                    return 'logo1.png';
                case '2':
                    return 'logo2.png';
                    // Add more cases for each brand ID and corresponding logo URL
                default:
                    return 'default-logo.png'; // Default logo URL if brand ID is not found
            }
        }
    </script>

</body>

</html>
