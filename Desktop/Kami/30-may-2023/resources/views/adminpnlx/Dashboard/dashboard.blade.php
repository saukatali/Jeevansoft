@extends('adminpnlx.layouts.default')
@section('content')
<!--begin::Content-->
<style>
li {
    color: white
}
</style>
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Dashboard
                    </h5>
                </div>
            </div>
            <!--end::Info-->
            @include("adminpnlx.elements.quick_links")
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!-- <h1 class="text-center">Coming soon...</h1> -->
            <div class="row">

                <div class="col-lg-3">
                    <!--begin::Stats Widget 13-->
                    <a href="" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Shopping/Cart3.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path
                                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                            fill="#000000" fill-rule="nonzero"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="card-title font-weight-bolder text-light font-size-h2 mb-0 mt-6 d-block">
                                {{ !empty($totalCustmorers) ? $totalCustmorers : '0'}}
                            </div>
                            <div class="font-weight-bold text-light  font-size-sm">
                                Total User
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Stats Widget 13-->
                </div>


                <div class="col-lg-3">
                    <!--begin::Stats Widget 13-->
                    <a href="" class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <span class="svg-icon svg-icon-white svg-icon-3x">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path
                                            d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            fill="#000000" fill-rule="nonzero"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="card-title font-weight-bolder text-light font-size-h2 mb-0 mt-6 d-block">
                                {{ !empty($totalContactEnquiry) ? $totalContactEnquiry : '0'}}
                            </div>
                            <div class="font-weight-bold text-light  font-size-sm">
                                Total Contact Enquiry
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Stats Widget 13-->
                </div>

                <div class="col-lg-3">
                    <!--begin::Stats Widget 13-->
                    <a href="" class="card card-custom bg-dark bg-hover-state-dark card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <span class="svg-icon svg-icon-white svg-icon-3x">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Chat-smile.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5"></polygon>
                                        <path
                                            d="M13,2 C18.5228475,2 23,6.4771525 23,12 C23,17.5228475 18.5228475,22 13,22 C7.4771525,22 3,17.5228475 3,12 C3,6.4771525 7.4771525,2 13,2 Z M7.16794971,13.5547002 C8.67758127,15.8191475 10.6456687,17 13,17 C15.3543313,17 17.3224187,15.8191475 18.8320503,13.5547002 C19.1384028,13.0951715 19.0142289,12.4743022 18.5547002,12.1679497 C18.0951715,11.8615972 17.4743022,11.9857711 17.1679497,12.4452998 C16.0109146,14.1808525 14.6456687,15 13,15 C11.3543313,15 9.9890854,14.1808525 8.83205029,12.4452998 C8.52569784,11.9857711 7.90482849,11.8615972 7.4452998,12.1679497 C6.98577112,12.4743022 6.86159725,13.0951715 7.16794971,13.5547002 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="card-title font-weight-bolder text-light font-size-h2 mb-0 mt-6 d-block">
                                {{ !empty($totalEmailLogs) ? $totalEmailLogs : '0'}}
                            </div>
                            <div class="font-weight-bold text-light  font-size-sm">
                                Total Email
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Stats Widget 13-->
                </div>


                <div class="col-lg-3">
                    <a href="" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-white svg-icon-3x">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                            fill="#000000" opacity="0.3"></path>
                                        <path
                                            d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                                            fill="#000000"></path>
                                        <path
                                            d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                            </span>
                            <div class="card-title font-weight-bolder text-light font-size-h2 mb-0 mt-6 d-block">
                                {{ $totalOrders ? $totalOrders : '0'}}
                            </div>
                            <div class="font-weight-bold text-light  font-size-sm">
                                Total Order
                            </div>
                        </div>
                    </a>
                </div>
            </div>



            @if(!empty($totalCustmorers) && ($totalCustmorers > 0))
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Charts Widget 5-->
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b card-stretch gutter-b">
                        <!--begin::Card header-->
                        <div class="card-header h-auto border-0">
                            <div class="card-title py-5">
                                <h3 class="card-label">
                                    <span class="d-block text-dark font-weight-bolder">Total Customers </span>
                                    <span class="d-block text-muted mt-2 font-size-sm">
                                    </span>
                                </h3>
                            </div>
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="kt_charts_widget_5_chart"></div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Card body-->
                    </div>
                    <!--end:: Card-->
                </div>
            </div>
            @endif



            <div class="row">
                <div class="col-12">
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Recent Customers </span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route('User.index') }}"
                                    class="btn btn-info font-weight-bolder font-size-sm mr-3">View All</a>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-0 pb-3">
                            <div class="tab-content">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table
                                        class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                        <thead>
                                            <tr class="text-left text-uppercase">
                                                <th>
                                                    <span class="text-dark-75">SN</span>
                                                </th>
                                                <th style="min-width: 25px" class="pl-7">
                                                    <span class="text-dark-75">Name</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">Email</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">PHONE NUMBER</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">Status</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($lastThreeCustomers))
                                            <?php $counter = 1; ?>
                                            @foreach($lastThreeCustomers as $customer)
                                            <tr>
                                                <td>
                                                    <div class="symbol symbol-30 symbol-light mr-4">
                                                        <span class="symbol-label font-weight-bold text-dark-75">
                                                            {{$counter}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="text-muted font-weight-bold d-block">
                                                            {{$customer["first_name"]. ' ' . $customer["last_name"]}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted font-weight-bold d-block">{{$customer["email"]}}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted font-weight-bold d-block">{{$customer["phone_number"]}}</span>
                                                </td>
                                                <td>
                                                    @if($customer["is_active"] == 1)
                                                    <span
                                                        class="label label-lg label-light-success label-inline">Activated</span>
                                                    @elseif($customer["is_active"] == 0)
                                                    <span
                                                        class="label label-lg label-light-danger label-inline">Deactivated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5">
                                                    <div class="symbol symbol-30 symbol-light mr-4">
                                                        <span class="symbol-label font-weight-bold text-dark-75">
                                                            Record not found.
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-12">
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Recent Enquiry
                                </span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">
                                    <!-- More than {{$totalCustmorers ?? ''}}+ Contests -->
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route('ContactEnquiry.index') }}"
                                    class="btn btn-info font-weight-bolder font-size-sm mr-3">View All</a>
                            </div>
                        </div>
                        <!--end::Header-->


                        <!--begin::Body-->
                        <div class="card-body pt-0 pb-3">
                            <div class="tab-content">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table
                                        class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                        <thead>
                                            <tr class="text-left text-uppercase">
                                                <th>
                                                    <span class="text-dark-75">SN</span>
                                                </th>
                                                <th style="min-width: 25px" class="pl-7">
                                                    <span class="text-dark-75"> NAME</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">EMAIL</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">Subject</span>
                                                </th>

                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">Message</span>
                                                </th>
                                                <th style="min-width: 25px">
                                                    <span class="text-dark-75">Status</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($lastThreeContactEnquirys))
                                            <?php $counter = 1; ?>
                                            @foreach($lastThreeContactEnquirys as $customer)
                                            <tr>
                                                <td>
                                                    <div class="symbol symbol-30 symbol-light mr-4">
                                                        <span class="symbol-label font-weight-bold text-dark-75">
                                                            {{$counter}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="text-muted font-weight-bold d-block">
                                                            {{$customer["name"]}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted font-weight-bold d-block">
                                                        {{$customer["email"]}}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="text-muted font-weight-bold d-block">
                                                        {{$customer["subject"]}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted font-weight-bold d-block">
                                                        {{$customer["message"]}}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($customer["is_read"] == 1)
                                                    <span
                                                        class="label label-lg label-light-success label-inline">Read</span>
                                                    @else
                                                    <span
                                                        class="label label-lg label-light-danger label-inline">Unread</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5">
                                                    <div class="symbol symbol-30 symbol-light mr-4">
                                                        <span class="symbol-label font-weight-bold text-dark-75">
                                                            Record not found.
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>



<script>
var allCustomers = [
    <?php
      if(!empty($allCustomers)){
      	foreach($allCustomers as $allCustomerss){
      		?>[<?php echo $allCustomerss['month']?>, <?php echo$allCustomerss['users']; ?>],
    <?php
      }
      }
      ?>
];
var allCustomers1 = [
    <?php
      if(!empty($allCustomers)){
      	foreach($allCustomers as $allCustomerss){
      		?>[<?php echo $allCustomerss['month']?>, <?php echo$allCustomerss['users']; ?>],
    <?php
      }
      }
      ?>
];
$(document).ready(function() {
    var _initChartsWidget5 = function() {
        var element = document.getElementById("kt_charts_widget_5_chart");

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Total Customers',
                type: 'bar',
                data: allCustomers
            }],
            chart: {
                stacked: true,
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    stacked: true,
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: ['12%']
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                type: 'datetime',
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },

                }
            },
            yaxis: {
                //max: 120,
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    formatter: function(val, index) {
                        return Math.round(val);
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['base']['info'], KTApp.getSettings()[
                'colors']['theme']['base']['primary'], KTApp.getSettings()['colors']['theme'][
                'light'
            ]['primary']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    _initChartsWidget5();

});
</script>
@stop