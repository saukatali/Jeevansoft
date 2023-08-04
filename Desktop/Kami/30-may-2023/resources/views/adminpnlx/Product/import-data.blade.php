@section('content')@extends('admin.layouts.default')
@section('content')
{{ HTML::style('css/admin/jui/css/jquery.ui.all.css') }}
{{ HTML::script('js/admin/chosen/chosen.jquery.min.js') }}
{{ HTML::style('css/admin/chosen.min.css') }}

<style>
    .cancel_btn {
        display: inline-block;
    }

    .cancel_btn:hover {
        color: #ffffff;
    }
</style>

<?php 
$segment2	=	Request::segment(1);
$segment3	=	Request::segment(2); 
$segment4	=	Request::segment(3);
if($segment4 == 'individual-user'){
	$pageTitle = "Individual User";
	$bredcrumTitle = "Individual User";
	$addBtnTitle = " Add Individual User";
}else if($segment4 == 'school-admin'){
	$pageTitle = "School Admin";
	$bredcrumTitle = "School Admin";
	$addBtnTitle = " Add School Admin";
} ?>
<style>
	.chosen-container-single .chosen-single{
		padding: 5px 5px 5px 8px;
		height: 35px;
	}
</style>
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".chosen-select").chosen({width: "100%"});
	}); 
</script>
<section class="content">
    <div class="row" style="padding:0 15px">
        <form action="{{route('User.importListdata', $slug)}}" method="post" class="my-4">
        {{ csrf_field() }}
            
                <div class="box" >
                    <div class="box-body">
                        <table
                            class="table table-hover"
                            id="taskTable">
                            <thead>
                                <tr class="text-capitalize">
                                    @if ($import_data && array_key_exists(0, $import_data))
                                        @foreach (array_keys($import_data[0]) as $key_name)
                                            <th>
                                                {{ str_replace('_', ' ', $key_name) }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($import_data as $key => $val)
                                    <tr>
                                        @foreach ($val as $k => $v)
                                            @if (!array_key_exists($key, $errors))
                                                <input type="hidden" name="keys[{{ $key }}][]"
                                                    value="{{ $k }}" />
                                                <input type="hidden" name="values[{{ $key }}][]"
                                                    value="{{ $v }}" />
                                            @endif
                                            <td>{{ $v }}
                                                @if (array_key_exists($key, $errors) && $errors[$key]->has($k))
                                                    <p class="text-danger" style="font-size: 15px">
                                                        {{ $errors[$key]->first($k) }}
                                                    </p>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
         
            <div class="loginFormbx">
                
                @if (count($import_data) > count($errors))
                    <button class="btn btn-success loginBtn themeBtn mx-auto mt-3">Continue with valid records</button>
                @endif

                @if ($slug == 'school-admin')
                <a href="{{route('User.index','school-admin')}}" class="btn btn-danger loginBtn themeBtn mx-auto mt-3 cancel_btn">Cancel</a>
                @else
                <a href="{{route('User.index','individual-user')}}" class="btn btn-danger loginBtn themeBtn mx-auto mt-3 cancel_btn">Cancel</a>
                @endif
            </div>
        </form>
    </div>
</section>
@stop

