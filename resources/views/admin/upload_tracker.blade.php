@section('custom_styles')
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
@section('title', 'Upload Tracker | ProdEmailTrackr')
@section('page_title', 'Upload Tracker')
@section('page_icon')
    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
@endsection
@section('page_bread', 'Upload Tracker')
@section('all_content')
    <div class="col-xl-12 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">Upload Tracker</h6>
            </div>
            <form class="profile-form" action="{{ route('upload_tracker') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 m-b30">
                            <label class="form-label">Select File</label>
                            <input type="file" class="form-control" name="track_file" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">UPLOAD</button>
                    <a class="btn btn-secondary" href="{{ asset('templates/OrderTracker_F_template.xlsx') }}"><i class="fa fa-paperclip"></i> &nbsp; Download Template</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xl-12 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">Tracker Upload Batch List</h6>
            </div>
            <div class="card-body">
                <table id="list_track_batches">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Batch No.</th>
                            <th>Uploaded By</th>
                            <th>Uploaded At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
        $(document).ready(function () {
            console.log("Working JS");
            list_track_batches();
        });

        function list_track_batches()
        {
            table = $('#list_track_batches').DataTable({
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
                    {data: 'uploaded_by', name: 'uploaded_by'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action'}
                ]
            });
        }

        $('#list_track_batches').on('click', 'button', function () {
            let batch_no = $(this).data('batch');
            console.log(batch_no);
            if(batch_no !== undefined)
            {
                swal({
                    title: 'Do you want to delete this batch data?',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    console.log(result);
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('batch_delete') }}',
                            type: 'POST',
                            dataType: 'json',
                            async: true,
                            headers: {
                                'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                            },
                            data: { batch_no: batch_no },
                            success: function (data) {
                                if(data.status)
                                {
                                    Swal.fire('Deleted!', 'Tracker Batch deleted Successfully', 'success')
                                    $('#list_track_batches').DataTable().destroy();
                                    list_track_batches();
                                }
                                else
                                {
                                    Swal.fire('Error!', 'Error occurred while deleting the batch', 'error')
                                }
                            }
                        });
                        Swal.fire('Saved!', '', 'success')
                    } else {
                        Swal.fire('Deletion cancelled', '', 'info')
                    }
                })
            }
        });
    </script>
@endsection
@section('footer_scripts')
    @include('admin.layouts.footer_scripts')
@endsection
