@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <style>
        div.iti{
            display: block
        }
        .hide{
            display: none
        }
        input.error { border: 1px solid red; }
        label.error {
            /*background: url('images/unchecked.gif') no-repeat;*/
            padding-left: 16px;
            margin-left: .3em;
            color: red;
        }
        label.valid {
            /*background: url('images/checked.gif') no-repeat;*/
            display: block;
            width: 16px;
            height: 16px;
        }
    </style>
@endsection
@extends('admin.layouts.mainlayout')
@section('nav_header')
    @include('admin.layouts.nav_header')
@endsection
@section('chat_box')
    @include('admin.layouts.chat_box')
@endsection
@section('header')
    @include('admin.layouts.header')
@endsection
@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection
@section('title', 'Create Tracker | ProdEmailTrackr')
@section('page_title', 'Create Tracker')
@section('page_icon')
    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
@endsection
@section('page_bread', 'Create Tracker')
@section('all_content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add/Create Tracker Manually</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <form action="{{ route('add_tracker') }}" method="POST" id="tracker_form">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="order_number">Order Number<sup class="text-danger font-w700">*</sup></label>
                                <input type="text" class="form-control" placeholder="Order No." name="order_number" id="order_number" value="{{ old('order_number') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="order_punched_date">Order Punched Date<sup class="text-danger font-w700">*</sup></label>
                                <input type="date" class="form-control" name="order_punched_date" id="order_punched_date" value="{{ old('order_punched_date') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="order_confirmed_date">Order Confirmed Date<sup class="text-danger font-w700">*</sup></label>
                                <input type="date" class="form-control" name="order_confirmed_date" id="order_confirmed_date" value="{{ old('order_confirmed_date') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="student_name">Student Name<sup class="text-danger font-w700">*</sup></label>
                                <input type="text" class="form-control" placeholder="Student Name" name="student_name" id="student_name" value="{{ old('student_name') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="primary_email_id">Primary Email ID<sup class="text-danger font-w700">*</sup></label>
                                <input type="email" class="form-control" placeholder="Primary Email" name="primary_email_id" id="primary_email_id" value="{{ old('primary_email_id') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="primary_mobile_no">Primary Mobile Number<sup class="text-danger font-w700">*</sup></label>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="primary_mobile_no" id="primary_mobile_no">
                                <span id="valid-msg" class="badge badge light badge-success hide">&nbsp; ✓ Valid</span>
                                <span id="error-msg" class="badge badge light badge-danger hide"></span>
                                <input type="hidden" name="primary_mobile_no_full" id="primary_mobile_no_full">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="country">Country<sup class="text-danger font-w700">*</sup></label>
                                <select class="form-control" id="country">
                                    <option value="">--Select Country--</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="India">India</option>
                                    <option value="Kuwait">Kuwait</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="oh_number">OH Number<sup class="text-danger font-w700">*</sup></label>
                                <input type="text" class="form-control" placeholder="OH Number" name="oh_number" id="oh_number">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="premium_id">Premium ID<sup class="text-danger font-w700">*</sup></label>
                                <input type="text" class="form-control" placeholder="Premium ID" name="premium_id" id="premium_id">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="sales_user">Sales User</label>
                                <input type="text" class="form-control" placeholder="Sales User" name="sales_user" id="sales_user">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="lead_details">Lead Details</label>
                                <select class="form-control" id="lead_details" name="lead_details">
                                    <option value="Auto Created" selected>Auto Created</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="siblings">Siblings<sup class="text-danger font-w700">*</sup></label>
                                <select class="form-control" id="siblings" name="siblings">
                                    <option value="">--Select--</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="category">Product Category<sup class="text-danger font-w700">*</sup></label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">-- Select Product Category --</option>
                                    @foreach($category as $c)
                                        <option value="{{ $c->product_category_name }}">{{ $c->product_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="syllabus">Syllabus</label>
                                <select class="form-control" id="syllabus" name="syllabus">
                                    <option value="">-- Select Syllabus --</option>
                                    @foreach($syllabus as $s)
                                        <option value="{{ $s->syllabus_name }}">{{ $s->syllabus_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="activation_status">Activation Status<sup class="text-danger font-w700">*</sup></label>
                                <select class="form-control" id="activation_status" name="activation_status">
                                    <option value="">-- Select Activation Status --</option>
                                    @foreach($activation_status as $as)
                                        <option value="{{ $as->status_name }}">{{ $as->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="delivery_marked">Delivery Marked</label>
                                <select class="form-control" name="delivery_marked" id="delivery_marked">
                                    <option value="">-- Select Status --</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
{{--                            <div class="mb-3 col-md-6">--}}
{{--                                <label class="form-label" for="auto_created_leads_sent_to_india_on">Auto Created Leads - Sent to India on</label>--}}
{{--                                <input type="date" class="form-control" name="auto_created_leads_sent_to_india_on" id="auto_created_leads_sent_to_india_on">--}}
{{--                            </div>--}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="task_created_sent_to_india">Task created Sent to India</label>
                                <select class="form-control" name="task_created_sent_to_india" id="task_created_sent_to_india">
                                    <option value="">-- Select Status --</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="remarks">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks"></textarea>
                            </div>
{{--                            <div class="mb-3 col-md-6">--}}
{{--                                <label class="form-label" for="manually_created_link_sent_to_india">Manually Created Link sent to India</label>--}}
{{--                                <select class="form-control" name="manually_created_link_sent_to_india" id="manually_created_link_sent_to_india">--}}
{{--                                    <option value="">-- Select Status --</option>--}}
{{--                                    <option value="Yes">Yes</option>--}}
{{--                                    <option value="No">No</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-center my-3">
                                <button type="submit" class="btn btn-primary col-6 submit_btn"><i class="fa fa-plus"></i> CREATE TRACKER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('main_content')
    @include('admin.layouts.main_content')
@endsection
@section('others')
    @include('admin.layouts.others')
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script>
        var input = document.querySelector("#primary_mobile_no");
        const iti =window.intlTelInput(input, {
            initialCountry: "ae",
            onlyCountries: ["ae", "in", "qa", "bh", "om","sa","kw"],
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        });
        const errorMsg = document.querySelector("#error-msg");
        const validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin

        const reset = () => {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', () => {
            reset();
            if (input.value.trim()) {
                if (iti.isValidNumber()) {
                    validMsg.classList.remove("hide");
                    $('#primary_mobile_no_full').val(iti.getNumber());
                    let countryData = iti.getSelectedCountryData();
                    let countryName = countryData.name.split('(')[0];
                    countryName = countryName.trim();
                    $('#country').val(countryName);
                    console.log(countryName);
                } else {
                    input.classList.add("error");
                    const errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
        $(document).ready(function () {
            console.log("Working JS");
        });

        function list_track_batches()
        {
            var table = $('#list_track_batches').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language: {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>'
                    },
                },
                ajax: "{{ route('list_batch_trackers') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'batch_no', name: 'batch_no'},
                    { data: 'created_at', name: 'created_at'}
                ]
            });
        }

        $("#tracker_form").validate({
            rules: {
                order_number: "required",
                order_punched_date: "required",
                order_confirmed_date: "required",
                student_name: "required",
                primary_email_id: "required",
                primary_mobile_no: "required",
                country: "required",
                oh_number: "required",
                siblings: "required",
                premium_id: "required",
                category: "required",
                activation_status: "required"
            },
            messages: {
                order_number: "Please enter Order Number",
                order_punched_date: "Please enter Order Punched Date",
                order_confirmed_date: "Please enter Order Confirmed Date",
                student_name: "Please enter Student Name",
                primary_email_id: "Please enter Primary Email",
                primary_mobile_no: "Please enter Mobile No",
                country: "Please select country",
                siblings: "Please select Yes/No",
                oh_number: "Please enter OH Number",
                premium_id: "Please enter Premium ID",
                category: "Please select Product Category",
                activation_status: "Please select Activation Status"
            },
            submitHandler: function(form) { // <- pass 'form' argument in
                $(".submit_btn").attr("disabled", true);
                form.submit(); // <- use 'form' argument here.
            }
        });
    </script>
@endsection
@section('footer_scripts')
    @include('admin.layouts.footer_scripts')
@endsection
