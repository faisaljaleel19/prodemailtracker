<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="page-titles">
        <ol class="breadcrumb">
            <li><h5 class="bc-title">@yield('page_title')</h5></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">
                    @yield('page_icon')
                    Home </a>
            </li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">@yield('page_bread')</a></li>
        </ol>
{{--        <a class="text-primary fs-13" data-bs-toggle="offcanvas" href="#offcanvasExample1" role="button" aria-controls="offcanvasExample1">+ Add Task</a>--}}
    </div>
    <div class="container-fluid">
        <div class="row">
            @yield('all_content')
        </div>

    </div>
</div>

<!--**********************************
    Content body end
***********************************-->
