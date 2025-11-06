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
@section('title', 'Users | ProdEmailTrackr')
@section('page_title', 'Users')
@section('page_icon')
    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
@endsection
@section('page_bread', 'Users')
@section('all_content')
    <div class="col-xl-12 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">User List</h6>
            </div>
            <div class="card-body">
                <table id="list_users">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Created Date</th>
                        <th>Status</th>
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
            list_users();
        });

        function list_users()
        {
            table = $('#list_users').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language: {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>'
                    },
                },
                ajax: "{{ route('list_users') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action'}
                ]
            });
        }

        function change_status(ele) {
            let user_id = $(ele).data('user-id');
            let stat = '';
            console.log($(ele).prop("checked"));
            console.log(user_id);
            if (user_id !== undefined) {
                if($(ele).prop("checked"))
                {
                    stat = 1;
                }
                else
                {
                    stat = 0;
                }
                $.ajax({
                    url: '{{ route('user_status_change') }}',
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                    },
                    data: {user_id: user_id, status: stat},
                    success: function (data) {
                        if (data.status) {
                            showToast('User status changed Successfully', 'success', 'Success')
                            $('#list_users').DataTable().destroy();
                            list_users();
                        } else {
                            showToast('Error occurred while changing status', 'error', 'Error')
                        }
                    }
                });
            }
        }
    </script>
@endsection
@section('footer_scripts')
    @include('admin.layouts.footer_scripts')
@endsection
