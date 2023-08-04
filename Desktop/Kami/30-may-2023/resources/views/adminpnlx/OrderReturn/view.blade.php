@extends('adminpnlx.layouts.default')
@section('content')
    <!--begin::Content-->
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin:: Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            View {{ Config('constants.ORDERS.ORDER_TITLE') }}
                        </h5>

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName . '.index') }}" class="text-muted">
                                    {{ Config('constants.ORDERS.ORDER_TITLE') }}
                                </a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
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
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1">
                                        <span class="nav-text">
                                            {{ Config('constants.ORDERS.ORDER_TITLE') }} Details
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_2">
                                        <span class="nav-text">
                                            User Details
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_3">
                                        <span class="nav-text">
                                            Order Items
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body px-0">
                        <div class="tab-content px-10">
                            <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Order Number:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{  $modelDetails->order_id ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Total Amount:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
											{{  $modelDetails->order_amount ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Total Discount:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
											{{  $modelDetails->total_discount ?? '' }}
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Created On:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ isset($modelDetails->created_at) ? $modelDetails->created_at : '' }}
                                        </span>
                                    </div>
                                </div>

								<div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Payment Type:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @if ($modelDetails->payment_type == 1)
                                            <span class="label label-lg label-light-success label-inline">COD</span>
                                            @else
                                            <span class="label label-lg label-light-primary label-inline">Online</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>


								<div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Status:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @if ($modelDetails->order_status == 0)
                                            <span class="label label-lg label-light-warning label-inline">Panding</span>
                                            @elseif ($modelDetails->order_status == 1)
                                            <span class="label label-lg label-light-primary label-inline">Confirmed</span>
                                            @elseif ($modelDetails->order_status == 2)
                                            <span class="label label-lg label-light-info label-inline">Dispatched</span>
                                            @elseif ($modelDetails->order_status == 3)
                                            <span class="label label-lg label-light-success label-inline">Delivered</span>
                                            @else
                                            <span class="label label-lg label-light-danger label-inline">Cancel</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>


                            </div>
                            <!--end::Tab Content-->

							<div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">First Name:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{  $modelDetails->userData->first_name ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Last Name:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $modelDetails->userData->last_name ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Email:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $modelDetails->userData->email ?? '' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Phone Number:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $modelDetails->userData->phone_number ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Status:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @if ($modelDetails->userData->is_active == 1)
                                                <span class="label label-lg label-light-success label-inline">Activated</span>
                                            @else
                                                <span class="label label-lg label-light-danger label-inline">Deactivated</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Added On:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ isset($modelDetails->created_at) ? $modelDetails->created_at : '' }}
                                        </span>
                                    </div>
                                </div>


                            </div>
                            <!--end::Tab Content-->

							<div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">

                                
                            @if(!empty($modelDetails->itemData))
                            @foreach ($modelDetails->itemData as $item)
                                
                            @endforeach
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Name:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $item ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Price:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
											{{ $item->price ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Quantity:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
											{{ $item->quantity ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Total Price:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $item->total_price ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Created On:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ isset($item->created_at) ? $item->created_at : '' }}
                                        </span>
                                    </div>
                                </div>

								<div class="form-group row my-2">
                                    <label class="col-4 col-form-label"> Image:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @if (!empty($item->image))
                                                <img height="100" width="100"
                                                    src="{{ config('constants.USER_IMAGE_ROOT_URL') . $item->image }}" />
                                            @endif
                                        </span>
                                    </div>
                                </div>

                            @endif
                            </div>
                            <!--end::Tab Content-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
            <!--end::Container-->
        </div>
    </div>
    <!--end::Content-->
@stop
