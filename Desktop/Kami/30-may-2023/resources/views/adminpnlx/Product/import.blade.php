@extends('adminpnlx.layouts.default')
@section('content')

<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js">
</script>


<body>

    <script src="ckeditor/ckeditor.js"></script>

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
                        </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul
                            class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName.'.index')}}" class="text-muted">
                                    {{ Config('constants.PRODUCTS.PRODUCTS_TITLE') }}
                                </a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->

                @include("adminpnlx.elements.quick_links")
            </div>
        </div>
        <!--end::Subheader-->

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <form method="post" action='{{route("$modelName.store")}}' class="mws-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header card-header-tabs-line">
                            <h3 class="card-title font-weight-bolder text-dark">
                               Import {{ Config('constants.PRODUCTS.PRODUCT_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="mt-2">
                                  <a href='{{route("$modelName.export", "category")}}' class="btn btn-dark font-weight-bold text-uppercase px-9 offset-1">Category File </a>
                                  <a href='{{route("$modelName.export", "sample")}}' class="btn btn-dark font-weight-bold text-uppercase px-9">Sample File </a>
                            </div>

                        <div class="card-body">
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-7">
                                    <div class="form-group">
                                        <input type="file" name="file"
                                            class="form-control form-control-solid form-control-lg offset-2" accept=".xls,.csv,.ods,.xlsx" required>
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('file'))
                                        <span class="error text-danger">{{ $errors->first('file') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                
                                
                                 <!--begin::Input-->
                                 <div class="col-xl-7">
                                     <button button type="submit"
                                        class="btn btn-success font-weight-bold text-uppercase px-9 py-4 offset-2">
                                        Import
                                    </button>
                                </div> 

                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>







    @stop