@extends('adminpnlx.layouts.default')
@section('content')

<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js">
</script>


<body>

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
                            Add New
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
                                    {{ Config('constants.BLOGS.BLOGS_TITLE') }}
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
                                {{ Config('constants.BLOGS.BLOG_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="image">Image</label> <span class="text-danger"> * </span>
                                        <input type="file" name="image" id="imgInp"
                                            class="form-control form-control-solid form-control-lg">
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('image'))
                                        <span class="error text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                        <img height="40" width="70" id="image_view" src="#" alt="Upload Image" style="display:none; margin-left:20px;"/>   
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="attachment">Attachment</label> <span class="text-danger"> * </span>
                                        <input type="file" name="attachment"
                                            class="form-control form-control-solid form-control-lg">
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('attachment'))
                                        <span class="error text-danger">{{ $errors->first('attachment') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="title"> Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="title"
                                            class="form-control form-control-solid form-control-lg" placeholder="Title"
                                            value="{{old('title') }}">
                                        @if ($errors->has('title'))
                                        <span class="error text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="sub_title">Sub Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="sub_title"
                                            class="form-control form-control-solid form-control-lg"
                                            placeholder="Sub Title" value="{{old('sub_title') }}">
                                        @if ($errors->has('sub_title'))
                                        <span class="error text-danger">{{ $errors->first('sub_title') }}</span>
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
                                            placeholder="description">{{old('description')}}</textarea>
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

                            </div>

                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div>
                                    <button button type="submit"
                                        class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (e.target.result) {
                    $('#image_view').attr('src', e.target.result);
                    $('#image_view').css("display", "block")
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });
</script>

    @stop