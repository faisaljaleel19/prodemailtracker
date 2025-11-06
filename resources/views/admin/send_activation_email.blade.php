@section('custom_styles')
<style>
    .select-info .select-item{
        color: #c6164f;
        font-weight: 900;
        font-size: 1.3em;
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
@section('title', 'Send Activation Email | ProdEmailTrackr')
@section('page_title', 'Send Activation Email')
@section('page_icon')
<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
@endsection
@section('page_bread', 'Send Activation Email')
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
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="track_list" role="tabpanel">
                    <div class="pt-4">
                        <table id="list_track_batches" class="display table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order Number</th>
                                <th>Student Name</th>
                                <th>Primary Email</th>
                                <th>Mail Sent Status</th>
                                <th>Mail Sent Date</th>
                                <th>Category</th>
                                <th>Activation Status</th>
                                <th>View Email Template</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
{{--                        <div class="row my-3">--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <button type="button" class="btn btn-primary" id="select_all">Select All</button>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <button type="button" class="btn btn-secondary" id="deselect_all">Deselect All</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="d-flex justify-content-center">
                            <div class="p-2">
                                <button type="button" class="btn btn-primary" id="select_all">Select All</button>
                            </div>
                            <div class="p-2">
                                <button type="button" class="btn btn-secondary" id="deselect_all">Deselect All</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <div class="p-2">
                                <button type="button" class="btn btn-success" id="send_activation_email"><i class="la la-envelope"></i>&nbsp; Send Activation Email</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="track_details">
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
@section('custom_scripts')
<script>
    let table;
    let selected_data = [];
    $(document).ready(function () {
        console.log("Working JS");
        list_product_track();
    });

    function list_product_track()
    {
        table = $('#list_track_batches').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            select: 'multi',
            language: {
                paginate: {
                    next: '<i class="fa-solid fa-angle-right"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>'
                },
            },
            ajax: "{{ route('list_trackers_in_send_email') }}",
            order: [[0, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'order_number', name: 'order_number'},
                { data: 'student_name', name: 'student_name'},
                { data: 'primary_email_id', name: 'primary_email_id'},
                {
                    data: 'mail_sent',
                    name: 'mail_sent',
                    render: function (data, type, row, meta) {
                        if(data == 'Yes')
                        {
                            return '<span class="badge badge-pill badge-success">Sent</span>';
                        }
                        else
                        {
                            return '<span class="badge badge-pill badge-danger">Not Sent</span>';
                        }
                    }
                },
                { data: 'sent_date', name: 'sent_date'},
                { data: 'category', name: 'category'},
                { data: 'activation_status', name: 'activation_status'},
                {
                    data: 'id', name: 'id',
                    render: function (data, type, row, meta) {
                        return '<button class="btn btn-primary btn-sm" data-id="'+ data +'"><i class="fa fa-eye"></i>&nbsp; View Email</button>';
                    }
                },
            ]
        });
    }

    // $('#list_track_batches').on( 'select.dt', function ( e, dt, type, indexes ) {
    //     selected_data = dt.rows(indexes).data();
    //     console.log(selected_data);
    // } );

    $('#list_track_batches').on( 'select.dt', function ( e, dt, type, indexes ) {
            selected_data = $('#list_track_batches').DataTable().rows('.selected').data();
            console.log(selected_data);
    } );

    $('#list_track_batches').on( 'deselect.dt', function ( e, dt, type, indexes ) {
        selected_data = [];
        $('#total_select').html('');
    } );

    $('#track_d_tab').on('click', function(){

    });

    $('#select_all').on('click', function () {
        $('#list_track_batches').DataTable().rows().select();
        selected_data = $('#list_track_batches').DataTable().rows('.selected').data();
    });

    $('#deselect_all').on('click', function () {
        $('#list_track_batches').DataTable().rows().deselect();
        $('#list_track_batches tbody').removeClass('selected');
    });

    $('#send_activation_email').on('click', function(){
        let all_checked = [];
       if(selected_data.length > 0)
       {
           for (let i = 0; i < selected_data.length; i++) {
               all_checked[i] = selected_data[i]['id'];
           }
           console.log(selected_data);
           $.ajax({
               xhr: function()
               {
                   var xhr = new window.XMLHttpRequest();
                   //Upload progress
                   xhr.upload.addEventListener("progress", function(evt){
                       if (evt.lengthComputable) {
                           var percentComplete = evt.loaded / evt.total;
                           //Do something with upload progress
                           percentComplete = Math.floor(percentComplete * 100);
                           console.log(percentComplete);
                       }
                   }, false);
                   //Download progress
                   xhr.addEventListener("progress", function(evt){
                       if (evt.lengthComputable) {
                           var percentComplete = evt.loaded / evt.total;
                           //Do something with download progress
                           percentComplete = Math.floor(percentComplete * 100);
                           console.log(percentComplete);
                       }
                   }, false);
                   return xhr;
               },
               url: '{{ route('mail_send_activation') }}',
               beforeSend: function(){
                 $('#send_activation_email').html('<i class="fa fa-spinner fa-spin"></i>&nbsp; Sending Email...');
                 $('#send_activation_email').attr('disabled','disabled');
               },
               complete: function(){
                   $('#send_activation_email').html('<i class="la la-envelope"></i>&nbsp; Send Activation Email');
                   $('#send_activation_email').removeAttr('disabled');
               },
               headers: {
                   'X-CSRF-TOKEN': '{{ @csrf_token() }}'
               },
               type: 'POST',
               dataType: 'json',
               data: {all_checked: all_checked},
               async: true,
               success: function (data) {
                   if(data.status) {
                       showToast('Mail Sent Successfully', 'success', 'Success');
                       $('#list_track_batches').DataTable().destroy();
                       list_product_track();
                   }
                   else
                   {
                       let msg = 'From Selected '+ data.total_selected + ' only ' + data.total_sent + ' Mail Sent';
                       showToast(msg, 'warning', 'Warning');
                       $('#list_track_batches').DataTable().destroy();
                       list_product_track();
                   }
               }
           });
       }
       else
       {
           showToast('No Trackers are selected', 'error', 'Error');
       }
    });

    $('#list_track_batches').on('click', 'button', function(){
       let tracker_id = $(this).data('id');
       if(tracker_id !== undefined)
       {
           let url = '{{ route('view_email_template' , ['tracker_id' => "trackid"]) }}';
           url = url.replace('trackid', tracker_id);
           window.open( url, '_blank');
       }
    });
</script>
@endsection
@section('footer_scripts')
@include('admin.layouts.footer_scripts')
@endsection
