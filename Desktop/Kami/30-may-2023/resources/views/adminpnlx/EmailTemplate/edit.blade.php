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
                        Edit {{ Config('constants.EMAIL_TEMPLATES.EMAIL_TEMPLATE_TITLE') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route($modelName.'.index')}}" class="text-muted">
                            {{ Config('constants.EMAIL_TEMPLATES.EMAIL_TEMPLATE_TITLE') }}
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
            <form method="post" action="{{route($modelName.'.update', base64_encode($modelDetails->id))}}"
                class="mws-form" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card card-custom gutter-b">
                    <div class="card-header card-header-tabs-line">
                        <h3 class="card-title font-weight-bolder text-dark">
                        {{ Config('constants.EMAIL_TEMPLATES.EMAIL_TEMPLATE_TITLE') }} Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                           
                             <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="name"> Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="name"
                                            class="form-control form-control-solid form-control-lg" placeholder=" Name"
                                            value="{{$modelDetails->name ?? old('name') }}">
                                        @if ($errors->has('name'))
                                        <span class="error text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="subject"> Subject</label> <span class="text-danger"> * </span>
                                        <input type="text" name="subject"
                                            class="form-control form-control-solid form-control-lg" placeholder="Subject"
                                            value="{{ $modelDetails->subject ?? old('subject') }}">
                                        @if ($errors->has('subject'))
                                        <span class="error text-danger">{{ $errors->first('subject') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="action">Constants</label> <span class="text-danger"> * </span>
                                        <input type="action" name="action"
                                            class="form-control form-control-solid form-control-lg" placeholder="action"
                                            value="{{$modelDetails->action ?? old('action') }}">
                                        @if ($errors->has('action'))
                                        <span class="error text-danger">{{ $errors->first('action') }}</span>
                                        @endif
                                    </div>
                                </div>

                            <!--begin::Input-->
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="body">Email Body</label> <span class="text-danger"> </span>
                                    <textarea type="body" name="body" id="description"
                                        class="form-control form-control-solid form-control-lg" rows="5"
                                        placeholder="body">{{$modelDetails->body ?? old('body') }}</textarea>
                                    @if ($errors->has('body'))
                                    <span class="error text-danger">{{ $errors->first('body') }}</span>
                                    @endif
                                </div>
                                <script>
                                    CKEDITOR.replace(description, {
                                        filebrowserUploadUrl: 'http://exbha.dev21.obtech.inet/base/uploder',
                                        enterMode: CKEDITOR.ENTER_BR
                                    });
                                    CKEDITOR.config.allowedContent = true;
                                </script>
                            </div>

                        </div>

                        <div class="d-flex justify-content-between border-top mt-5 pt-10">

                            <div>
                                <button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
                                    Submit
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