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
                            Edit {{ Config('constants.BLOGS.BLOG_TITLE') }} </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName . '.index') }}" class="text-muted">
                                    {{ Config('constants.BLOGS.BLOGS_TITLE') }}
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
                <form method="post" action="{{ route($modelName . '.update', base64_encode($modelDetails->id)) }}"
                    class="mws-form" enctype="multipart/form-data" autocomplete="off">
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
                                        <label for="">Image </label> <span class="text-danger"> </span>
                                        <input type="file" name="image"
                                            value="{{ isset($modelDetails->image) ? $modelDetails->image : '' }}"
                                            class="form-control form-control-solid form-control-lg">
                                            @if(!empty($modelDetails->image ))
                                                <a class="fancybox-buttons" data-fancybox-group="button" href="{{ config('constants.BLOG_IMAGE_ROOT_URL').$modelDetails->image }}">
                                                    <img height="50" width="70" src="{{ config('constants.BLOG_IMAGE_ROOT_URL').$modelDetails->image }}">
                                                </a>
                                                @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="attachment">Attachment </label> <span class="text-danger"> </span>
                                        <input type="file" name="attachment"
                                            value="{{ isset($modelDetails->attachment) ? $modelDetails->attachment : '' }}"
                                            class="form-control form-control-solid form-control-lg">
                                            @if ($errors->has('attachment'))
                                            <span class="error text-danger">{{ $errors->first('attachment') }}</span>
                                            @endif

                                            @if(!empty($modelDetails->attachment))
                                            <?php $file = $modelDetails->attachment;
                                                $extension = substr($file, strpos($file, '.'))
                                            ?>
                                            @if($extension == '.docx' || $extension == '.doc')
                                                <div class="text-dark-75 mb-1 font-size-lg">
                                                    <a  href="{{ Config('constants.BLOG_IMAGE_ROOT_URL').$modelDetails->attachment }}" download="download">
                                                        <img height="50" width="50" src="{{asset('./public/img/doc.png')}}" />
                                                    </a>
                                                    </div>
                                                @elseif($extension == '.pdf')
                                                <div class="text-dark-75 mb-1 font-size-lg">
                                                    <a  href="{{ Config('constants.BLOG_IMAGE_ROOT_URL').$modelDetails->attachment }}" download="download">
                                                        <img height="50" width="50" src="{{asset('./public/img/pdf.png')}}" />
                                                    </a>
                                                    </div>
                                                    @elseif($extension == '.xlsx' || $extension == '.xls')
                                                    <div class="text-dark-75 mb-1 font-size-lg">
                                                    <a  href="{{ Config('constants.BLOG_IMAGE_ROOT_URL').$modelDetails->attachment }}" download="download">
                                                        <img height="50" width="50" src="{{asset('./public/img/xlxs.png')}}" />
                                                    </a>
                                                    </div>
                                                @endif
                                            @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="title"> Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="title"
                                            class="form-control form-control-solid form-control-lg" placeholder="Title"
                                            value="{{ $modelDetails->title ?? old('title') }}">
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
                                            class="form-control form-control-solid form-control-lg" placeholder="Sub Title"
                                            value="{{ $modelDetails->sub_title ?? old('sub_title') }}">
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
                                        <textarea type="text" name="description" id="description" class="form-control form-control-solid form-control-lg"
                                            placeholder="description">{{ isset($modelDetails->description) ? $modelDetails->description : '' }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="error text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <!-- <script src="{{ asset('/public/adminpnlx/js/ckeditor/ckeditor.js') }}"></script> -->
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
                                    <button type="submit"
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
