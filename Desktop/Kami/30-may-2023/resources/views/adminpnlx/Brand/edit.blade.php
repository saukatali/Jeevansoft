@extends('adminpnlx.layouts.default')
@section('content')

<!--begin::Content-->
<script src="public/js/ckeditor/ckeditor.js"></script>
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
                        Edit {{ Config('constants.BRANDS.BRAND_TITLE') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route($modelName.'.index')}}" class="text-muted">
                                {{ Config('constants.BRANDS.BRANDS_TITLE') }}
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
            <form method="post" action="{{route($modelName.'.update', base64_encode($model->id))}}" class="mws-form"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card card-custom gutter-b">
                    <div class="card-header card-header-tabs-line">
                        <h3 class="card-title font-weight-bolder text-dark">
                            {{ Config('constants.BRANDS.BRAND_TITLE') }} Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="">Image </label> <span class="text-danger"> </span>
                                    <input type="file" name="image"
                                        value="{{ isset($model->image) ? $model->image :'' }}"
                                        class="form-control form-control-solid form-control-lg">
                                    @if(!empty($model->image))
                                    <div class="banner-image">
                                        <img height="100" width="100" src="{{ config('constants.BRAND_IMAGE_ROOT_URL').$model->image }}" />
                                        <a href='{{ route("$modelName.deleteImage", base64_encode($model->id)) }}'
                                            class="btn btn-icon btn-light btn-hover-danger btn-sm confirmDeleteImage"
                                            data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-boundary="window" title="" data-original-title="Delete">
                                            <span class="svg-icon svg-icon-md svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!--end::Input-->

                            <!--begin::Input-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="name">Name</label> <span class="text-danger"> * </span>
                                    <input type="text" name="name"
                                        class="form-control form-control-solid form-control-lg" placeholder="First Name"
                                        value="{{ isset($model->name) ? $model->name :'' }}">
                                    @if ($errors->has('name'))
                                    <span class="error text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!--begin::Input-->
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="description">Description</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="description" id="description"
                                            class="form-control form-control-solid form-control-lg"
                                            placeholder="description">{{isset($model->description) ? $model->description : old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                        <span class="error text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <script src="{{asset('/public/adminpnlx/js/ckeditor/ckeditor.js')}}"></script>
                                                <script>
                                                    CKEDITOR.replace(description, {
                                                        filebrowserUploadUrl: 'http://exbha.dev21.obtech.inet/base/uploder',
                                                        enterMode: CKEDITOR.ENTER_BR
                                                    });
                                                    CKEDITOR.config.allowedContent = true;
                                                </script>

                                </div>  
                                 <!--begin::Input-->

                            

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




<script>
$(document).ready(function() {

    $(".confirmDeleteImage").click(function(e) {
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


});
</script>

@stop