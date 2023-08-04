@extends('adminpnlx.layouts.default')
@section('content')

<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                    {{ Config('constants.NOTIFICATIONS.NOTIFICATION_TITLE') }}
                    </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end::Info-->

            @include('adminpnlx.elements.quick_links')
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">

            <form action='{{ route("$modelName.index") }}' method="get" class="kt-form kt-form--fit mb-0" autocomplete="off">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-custom card-stretch card-shadowless">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="text-dark font-weight-bold my-1 mr-5">
                                        {{ Config('constants.NOTIFICATIONS.NOTIFICATION_TITLE') }}
                                    </h3> 
                                </div>
                                <div class="card-toolbar">
                                    <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle " data-toggle="collapse" data-target="#collapseOne6">
                                        Search
                                    </a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                                    <div id="collapseOne6" class="collapse <?php echo !empty($searchVariable) ? 'show' : ''; ?>" data-parent="#accordionExample6">
                                        <div>
                                            <div class="row mb-6">
                                                <div class="col-lg-3 mb-lg-5 mb-6">
                                                    <label>Status</label>   
                                                     <select name="is_active" class="form-control select2init" value="{{$searchVariable['is_active'] ?? ''}}">
                                                    <option value="">All</option>
                                                    <option value="1" {{ isset($searchVariable['is_active']) && $searchVariable['is_active'] == 1 ? 'selected': '' }} >Activate</option>
                                                    <option value="0" {{ isset($searchVariable['is_active']) && $searchVariable['is_active'] == 0 ? 'selected': '' }} >Deactivate</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 mb-lg-5 mb-6">
                                                    <label> Name </label>

                                                    <input type="text" name="name" class="form-control" value="{{ isset($searchVariable['name']) ? $searchVariable['name'] : '' }}" placeholder="Name">
                                                </div>
                                               
                                            </div>

                                            <div class="row mt-8">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                                        <span>
                                                            <i class="la la-search"></i>
                                                            <span>Search</span>
                                                        </span>
                                                    </button>
                                                    &nbsp;&nbsp;

                                                    <a href='{{ route("$modelName.index") }}' class="btn btn-secondary btn-secondary--icon">
                                                        <span>
                                                            <i class="la la-close"></i>
                                                            <span>Clear Search</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>

                                            <!--begin: Datatable-->
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="dataTables_wrapper ">
                                    <div class="table-responsive">
                                        <table class="table dataTable table-head-custom table-head-bg table-borderless table-vertical-center" id="taskTable">
                                            <thead>
                                                <tr class="text-uppercase">

                                                    <th class="{{(($sortBy == 'title' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'title' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'title',
                                                    'order' => ($sortBy == 'title' && $order == 'desc') ? 'asc' : 'desc', $query_string))}}">
                                                     Title</a>
                                                    </th>

                                                    <th class="{{(($sortBy == 'not_from' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'not_from' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'not_from',
                                                    'order' => ($sortBy == 'not_from' && $order == 'desc') ? 'asc' : 'desc',  $query_string))}}">
                                                     From  </a>
                                                    </th>

                                                    <th class="{{(($sortBy == 'not_to' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'not_to' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'not_to',
                                                    'order' => ($sortBy == 'not_to' && $order == 'desc') ? 'asc' : 'desc',   $query_string))}}">
                                                     To </a>
                                                    </th>

                                                    <th class="{{(($sortBy == 'body' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'body' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'body',
                                                    'order' => ($sortBy == 'body' && $order == 'desc') ? 'asc' : 'desc',   $query_string))}}">
                                                     Body </a>
                                                    </th>

                                                    <th class="{{(($sortBy == 'created_at' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'created_at' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'created_at',
                                                    'order' => ($sortBy == 'created_at' && $order == 'desc') ? 'asc' : 'desc',  $query_string))}}">
                                                    Added On </a>
                                                    </th>
                                                     <th class="{{(($sortBy == 'is_active' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'is_active' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route($modelName.'.index',array( 'sortBy' => 'is_active',
                                                    'order' => ($sortBy == 'is_active' && $order == 'desc') ? 'asc' : 'desc',   
                                                    $query_string))}}"> Status </a>
                                                    </th>

                                                    {{-- <th class="text-right">Action</th> --}}
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (!empty($results))
                                                @foreach ($results as $result)
                                                <tr>
                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                             {{ $result->title ?? '' }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->not_from ?? '' }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->not_to }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->body }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->created_at }}
                                                        </div>
                                                    </td>

                                                    
                                                    <td>
                                                        @if ($result->is_read == 1)
                                                        <span class="label label-lg label-light-success label-inline">Read</span>
                                                        @else
                                                        <span class="label label-lg label-light-danger label-inline">Unread</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-right pr-2">
                                                       
                                                        {{-- <a href='{{ route("$modelName.show", base64_encode($result->id)) }}' class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip" data-placement="top" data-container="body" data-boundary="window" title="" data-original-title="View">
                                                            <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </a> --}}
                                                       
                                                    </td>

                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="6" style="text-align:center;">
                                                        {{ trans('Record not found.') }}
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>


                                        </table>

                                        <div class="text-right">
                                            {{ $results->links() }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<script>
    $(document).ready(function() {
        $('#datepickerfrom').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datepickerto').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $(".confirmDelete").click(function(e) {
            e.stopImmediatePropagation();
            url = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "Want to delete this ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "No, cancel",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    window.location.replace(url);
                } else if (result.dismiss === "cancel") {
                    Swal.fire(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    )
                }
            });
            e.preventDefault();
        });

        $(".status_any_item").click(function(e) {
            e.stopImmediatePropagation();
            url = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "Want to change status this ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, change it",
                cancelButtonText: "No, cancel",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    window.location.replace(url);
                }
            });
            e.preventDefault();
        });
    });

    function page_limit() {
        $("form").submit();
    }
</script>

@stop