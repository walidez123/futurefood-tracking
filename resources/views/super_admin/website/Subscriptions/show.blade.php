@extends('layouts.master')
@section('pageTitle', 'Add Client')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="fafa-commenting"></span>
            Show Message
            <form style="display: inline;" action="{{route('subscription.destroy', $Subscription->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </form>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/{{Auth()->user()->user_type}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li><a href="{{route('subscription.index')}}">Subscription</a></li>
            <li class="active"> Show Message </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">

                        <h3 class="box-title"> </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <blockquote>
                            <h3 class="box-title">@lang('website.service_name')</h3>
                            <p>{{$Subscription->service_name}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.company_name')</h3>
                            <p>{{$Subscription->company_name}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.industry')</h3>
                            <p>{{$Subscription->industry}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.user_name')</h3>
                            <p>{{$Subscription->user_name}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.phone_number')</h3>
                            <p>{{$Subscription->phone_number}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.email')</h3>
                            <p>{{$Subscription->email}}</p>
                            <hr>
                            <h3 class="box-title">@lang('website.additional_info')</h3>
                            <p>{{$Subscription->additional_info}}</p>
                            <hr>
                        </blockquote>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>



        </div>

        <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection