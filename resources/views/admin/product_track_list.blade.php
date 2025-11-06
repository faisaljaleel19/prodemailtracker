@section('custom_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <style>
        .modal-backdrop
        {
            width: 100% !important;
            height: 100% !important;
        }
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
@section('title', 'Product Tracker List | ProdEmailTrackr')
@section('page_title', 'Product Tracker List')
@section('page_icon')
    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
@endsection
@section('page_bread', 'Product Tracker List')
@section('all_content')
    <div class="col-xl-12 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">Order Trackers</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#track_list"><i class="la la-list me-2"></i> Product Tracker List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#track_details" id="track_d_tab"><i class="la la-address-book me-2"></i> Tracker Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="track_list" role="tabpanel">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-3">
                                <label for="order_no">Order Number</label>
                                <input type="text" class="form-control" id="order_no" name="order_no">
                            </div>
                            <div class="col-md-3">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-md-6 text-center">
                                <button class="btn btn-primary" id="search_tracker">Search</button>
                            </div>
                            <div class="col-md-6 text-center">
                                <button class="btn btn-danger" onclick="clear_filter()">Clear</button>
                            </div>
                        </div>
                        <div class="pt-4">
                            <table id="list_track_batches" class="display table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order Number</th>
                                    <th>Order Punched Date</th>
                                    <th>Order Confirmed Date</th>
                                    <th>Student Name</th>
                                    <th>Primary Email</th>
                                    <th>Primary Mobile No</th>
                                    <th>OH Number</th>
                                    <th>Premium ID</th>
                                    <th>Category</th>
                                    <th>Activation Status</th>
                                    <th>Mail Sent Status</th>
                                    <th>Created Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="my-3">
                            <button class="btn btn-secondary" id="edit_tracker">Edit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="track_details">
                        <div class="pt-4" id="tracker_section">
                            <div class="h4 text-center">Tracker Details</div>
                            <section class="row p-3">
                                <div class="h5 mt-2 text-center">Order & Customer Information</div>
                                <hr>
                                <div class="h6">Order # <span id="data_order_no"></span></div>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Order Punched Date</th>
                                            <td id="data_order_punched_date"></td>
                                        </tr>
                                        <tr>
                                            <th>Order Confirmed Date</th>
                                            <td id="data_order_confirmed_date"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Student Name</th>
                                            <td id="data_student_name"></td>
                                        </tr>
                                        <tr>
                                            <th>Primary Email</th>
                                            <td id="data_primary_email"></td>
                                        </tr>
                                        <tr>
                                            <th>Primary Mobile No</th>
                                            <td id="data_primary_mobile"></td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                            <section class="row p-3">
                                <div class="h5 mt-2 text-center">Product & Sales Information</div>
                                <hr>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>OH Number</th>
                                            <td id="data_oh_number"></td>
                                        </tr>
                                        <tr>
                                            <th>Premium ID</th>
                                            <td id="data_premium_id"></td>
                                        </tr>
                                        <tr>
                                            <th>Lead Details</th>
                                            <td id="data_lead_details"></td>
                                        </tr>
                                        <tr>
                                            <th>Sales User</th>
                                            <td id="data_sales_user"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Product Category</th>
                                            <td id="data_category"></td>
                                        </tr>
                                        <tr>
                                            <th>Syllabus</th>
                                            <td id="data_syllabus"></td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                            <section class="row p-3">
                                <div class="h5 mt-2 text-center">Activation & Other Information</div>
                                <hr>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Activation Status</th>
                                            <td id="data_activation_status"></td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Marked</th>
                                            <td id="data_delivery_marked"></td>
                                        </tr>
                                        <tr>
                                            <th>Mail Sent</th>
                                            <td id="data_mail_sent"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Task Creation Sent to India</th>
                                            <td id="data_task_creation_sent_to_india"></td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td id="data_remarks"></td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                            <section class="row p-3">
                                <div class="h5 mt-2 text-center">Order Created Date</div>
                                <hr>
                                <div class="col-6 table-responsive">
                                    <table class="table table-striped table-responsive-sm">
                                        <tr>
                                            <th>Created Date</th>
                                            <td id="data_created_date"></td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
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
@section('after_main')
<div class="bootstrap-modal">
    <!-- Modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tracker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tracker_id" name="tracker_id">
                    <div class="mt-3">
                        <label for="order_punched_date">Order Punched Date<sup class="text-danger font-w700">*</sup></label>
                        <input type="date" class="form-control" id="order_punched_date">
                    </div>
                    <div class="mt-3">
                        <label for="order_confirmed_date">Order Confirmed Date<sup class="text-danger font-w700">*</sup></label>
                        <input type="date" class="form-control" id="order_confirmed_date">
                    </div>
                    <div class="mt-3">
                        <label for="student_name">Student name<sup class="text-danger font-w700">*</sup></label>
                        <input type="text" class="form-control" id="student_name">
                    </div>
                    <div class="mt-3">
                        <label for="primary_email">Primary Email<sup class="text-danger font-w700">*</sup></label>
                        <input type="email" class="form-control" id="primary_email">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" for="primary_mobile_no">Primary Mobile Number<sup class="text-danger font-w700">*</sup></label>
                        <input type="text" class="form-control" placeholder="Mobile Number" name="primary_mobile_no" id="primary_mobile_no">
                        <span id="valid-msg" class="badge badge light badge-success hide">&nbsp; ✓ Valid</span>
                        <span id="error-msg" class="badge badge light badge-danger hide"></span>
                        <input type="hidden" name="primary_mobile_no_full" id="primary_mobile_no_full">
                    </div>
                    <div class="mt-3">
                        <label for="oh_no">OH Number<sup class="text-danger font-w700">*</sup></label>
                        <input type="text" class="form-control" id="oh_no">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" for="category">Product Category<sup class="text-danger font-w700">*</sup></label>
                        <select class="form-control" id="category" name="category">
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="siblings">Siblings<sup class="text-danger font-w700">*</sup></label>
                        <select class="form-control" id="siblings">
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div id="validate_error" class="alert alert-danger mt-3">
                        <sup class="text-danger font-w700">*</sup>Marked Fields Required
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_tracker">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script>
        var input = document.querySelector("#primary_mobile_no");
        const iti =window.intlTelInput(input, {
            initialCountry: "ae",
            onlyCountries: ["ae", "in", "qa", "bh", "om", "kw", "sa"],
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
        let table;
        let selected_data = [];
        $(document).ready(function () {
            $('#validate_error').hide();
            console.log("Working JS");
            $('#edit_tracker').attr('disabled','disabled');
            get_categories();
            list_product_track();
        });

        function list_product_track()
        {
            $('#list_track_batches').DataTable().destroy();
            table = $('#list_track_batches').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                select: 'single',
                language: {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>'
                    },
                },
                ajax: "{{ route('list_product_track') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    { data: 'order_punched_date', name: 'order_punched_date'},
                    { data: 'order_confirmed_date', name: 'order_confirmed_date'},
                    { data: 'student_name', name: 'student_name'},
                    { data: 'primary_email_id', name: 'primary_email_id'},
                    { data: 'primary_mobile_no', name: 'primary_mobile_no'},
                    { data: 'oh_number', name: 'oh_number'},
                    { data: 'premium_id', name: 'premium_id'},
                    { data: 'category', name: 'category'},
                    { data: 'activation_status', name: 'activation_status'},
                    { data: 'mail_sent', name: 'mail_sent'},
                    { data: 'created_at', name: 'created_at'}
                ],
            });
        }

        $('#list_track_batches').on( 'select.dt', function ( e, dt, type, indexes ) {
            selected_data = dt.rows(indexes).data();
            $('#edit_tracker').removeAttr('disabled');
            console.log(selected_data);
        } );

        $('#list_track_batches').on( 'deselect.dt', function ( e, dt, type, indexes ) {
            $('#edit_tracker').attr('disabled', 'disabled');
            selected_data = [];
        } );

        $('#track_d_tab').on('click', function(){
            console.log(selected_data);
            if((selected_data.length > 0)) {
                $('#tracker_section').removeClass('bg-danger-light');
                $('#data_id').html(selected_data[0]['id']);
                $('#data_order_no').html(selected_data[0]['order_number']);
                $('#data_order_punched_date').html(selected_data[0]['order_punched_date']);
                $('#data_order_confirmed_date').html(selected_data[0]['order_confirmed_date']);
                $('#data_student_name').html(selected_data[0]['student_name']);
                $('#data_primary_email').html(selected_data[0]['primary_email_id']);
                $('#data_primary_mobile').html(selected_data[0]['primary_mobile_no']);
                $('#data_oh_number').html(selected_data[0]['oh_number']);
                $('#data_premium_id').html(selected_data[0]['premium_id']);
                $('#data_sales_user').html(selected_data[0]['sales_user']);
                $('#data_lead_details').html(selected_data[0]['lead_details']);
                $('#data_category').html(selected_data[0]['category']);
                $('#data_syllabus').html(selected_data[0]['syllabus']);
                $('#data_activation_status').html(selected_data[0]['activation_status']);
                $('#data_delivery_marked').html(selected_data[0]['delivered_marked']);
                $('#data_mail_sent').html(selected_data[0]['mail_sent']);
                $('#data_task_creation_sent_to_india').html(selected_data[0]['task_creation_sent_to_india']);
                $('#data_remarks').html(selected_data[0]['remarks']);
                $('#data_created_date').html(selected_data[0]['created_at']);
            }
            else
            {
                showToast('Please select the tracker to view details', 'error', 'Error')
                $('#tracker_section').addClass('bg-danger-light');
                $('#data_id').html("");
                $('#data_order_no').html("");
                $('#data_order_punched_date').html("");
                $('#data_order_confirmed_date').html("");
                $('#data_student_name').html("");
                $('#data_primary_email').html("");
                $('#data_primary_mobile').html("");
                $('#data_oh_number').html("");
                $('#data_premium_id').html("");
                $('#data_sales_user').html("");
                $('#data_lead_details').html("");
                $('#data_category').html("");
                $('#data_syllabus').html("");
                $('#data_activation_status').html("");
                $('#data_delivery_marked').html("");
                $('#data_mail_sent').html("");
                $('#data_task_creation_sent_to_india').html("");
                $('#data_remarks').html("");
                $('#data_created_date').html('');
            }
        });

        $('#search_tracker').on('click', function(){
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let order_no = $('#order_no').val();
            $('#list_track_batches').DataTable().destroy();
            var table = $('#list_track_batches').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                select: 'single',
                language: {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>'
                    },
                },
                ajax: {
                    url: '{{ route('search_tracker') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: { from_date: from_date, to_date: to_date, order_no: order_no }
                },
                order: [[0, "desc" ]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_number', name: 'order_number'},
                    { data: 'order_punched_date', name: 'order_punched_date'},
                    { data: 'order_confirmed_date', name: 'order_confirmed_date'},
                    { data: 'student_name', name: 'student_name'},
                    { data: 'primary_email_id', name: 'primary_email_id'},
                    { data: 'primary_mobile_no', name: 'primary_mobile_no'},
                    { data: 'oh_number', name: 'oh_number'},
                    { data: 'premium_id', name: 'premium_id'},
                    { data: 'category', name: 'category'},
                    { data: 'activation_status', name: 'activation_status'},
                    { data: 'mail_sent', name: 'mail_sent'},
                    { data: 'created_at', name: 'created_at'}
                ],
            });
        });

        function clear_filter()
        {
            $('#order_no').val('');
            $('#from_date').val('');
            $('#to_date').val('');
            list_product_track();
        }

        $('#edit_tracker').on('click', function(){
            let tracker_id = selected_data[0]['id'];
            $.ajax({
                url: '{{ route('get_tracker') }}',
                beforeSend: function(){
                    $('#edit_tracker').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                complete: function(){
                    $('#edit_tracker').html('Edit');
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
                type: 'POST',
                dataType: 'json',
                data: {tracker_id: tracker_id},
                async: true,
                success: function (data) {
                    console.log(data.data.created_by);
                    if(data.status) {
                        $('#tracker_id').val(data.data.id);
                        $('#order_punched_date').val(data.data.order_punched_date);
                        $('#order_confirmed_date').val(data.data.order_confirmed_date);
                        $('#student_name').val(data.data.student_name);
                        $('#primary_email').val(data.data.primary_email_id);
                        $('#oh_no').val(data.data.oh_number);
                        $('#category').val(data.data.category);
                        iti.setNumber(data.data.primary_mobile_no);
                        $('#siblings').val(data.data.siblings);
                        $('#editModal').modal('show');
                    }
                    else
                    {

                    }
                }
            });
        });

        $('#update_tracker').on('click', function(){
            let tracker_id = $('#tracker_id').val();
            let order_punched_date = $('#order_punched_date').val();
            let order_confirmed_date = $('#order_confirmed_date').val();
            let student_name = $('#student_name').val();
            let primary_email = $('#primary_email').val();
            let primary_mobile_no = iti.getNumber();
            let siblings = $('#siblings').val();
            let oh_number = $('#oh_no').val();
            let category = $('#category').val();
            console.log(primary_mobile_no);
            if((order_punched_date !== '') && (order_confirmed_date !== '') && (student_name !== '') && (primary_email !== '') && (primary_mobile_no !== '') && (siblings !== '') && (iti.isValidNumber()) && (oh_number !== '') && (category !== ''))
            {
                $('#validate_error').hide();
                $.ajax({
                    url: '{{ route('update_tracker') }}',
                    beforeSend: function(){
                        $('#update_tracker').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#update_tracker').attr('disabled', 'disabled');
                    },
                    complete: function(){
                        $('#update_tracker').html('Save Changes');
                        $('#update_tracker').removeAttr('disabled');
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    type: 'POST',
                    dataType: 'json',
                    data:
                        {
                            tracker_id: tracker_id,
                            order_punched_date: order_punched_date,
                            order_confirmed_date: order_confirmed_date,
                            student_name: student_name,
                            primary_email: primary_email,
                            primary_mobile_no: primary_mobile_no,
                            oh_number: oh_number,
                            category: category,
                            siblings: siblings
                        },
                    async: true,
                    success: function (data) {
                        if(data.status) {
                            $('#tracker_id').val('');
                            $('#order_punched_date').val('');
                            $('#order_confirmed_date').val('');
                            $('#student_name').val('');
                            $('#primary_email').val('');
                            iti.setNumber('');
                            $('#siblings').val('');
                            $('#oh_no').val('');
                            $('#category').val('');
                            $('#editModal').modal('hide');
                            showToast('Tracker Updated Successfully', 'success', 'Success')
                            list_product_track();
                        }
                        else
                        {
                            showToast('Error Occurred while updating the tracker', 'error', 'Error')
                        }
                    }
                });
            }
            else
            {
                $('#validate_error').show();
            }
        });

        function get_categories()
        {
            $.ajax({
                url: '{{ route('get_product_categories') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
                type: 'POST',
                dataType: 'json',
                async: true,
                success: function (data) {
                    if(data.status)
                    {
                        let html = '';
                        html = '<option value="">-- Select Product Category --</option>';
                        for(let i = 0; i<data.data.length; i++)
                        {
                            html += '<option value="'+data.data[i].product_category_name+'">'+data.data[i].product_category_name+'</option>';
                        }
                        $('#category').html(html);
                    }
                }
            });
        }
    </script>
@endsection
@section('footer_scripts')
    @include('admin.layouts.footer_scripts')
@endsection
