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
                        Edit {{ Config('constants.REVIEW_RATINGS.REVIEW_RATINGS_TITLE') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route($modelName.'.index')}}" class="text-muted">
                            {{ Config('constants.REVIEW_RATINGS.REVIEW_RATINGS_TITLE') }}
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
                            {{ Config('constants.REVIEW_RATINGS.REVIEW_RATINGS_TITLE') }} Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                         
                            <!--begin::Input-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="rating">Rating</label> <span class="text-danger"> </span>
                                    <input type="text" name="rating"
                                        class="form-control form-control-solid form-control-lg" placeholder="First rating"
                                        value="{{ $modelDetails->rating ?? old('rating') }}">
                                    @if ($errors->has('rating'))
                                    <span class="error text-danger">{{ $errors->first('rating') }}</span>
                                    @endif
                                </div>
                            </div>


                            <!--begin::Input-->
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="review">Review</label> <span class="text-danger"> </span>
                                    <textarea type="review" name="review"
                                        class="form-control form-control-solid form-control-lg" rows="5"
                                        placeholder="review">{{ isset($modelDetails->review) ? $modelDetails->review :'' }}</textarea>
                                    @if ($errors->has('review'))
                                    <span class="error text-danger">{{ $errors->first('review') }}</span>
                                    @endif
                                </div>
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