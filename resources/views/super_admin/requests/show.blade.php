@extends('layouts.master')
@section('pageTitle', 'request Join')
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
            <form style="display: inline;" action="{{route('request-joins.destroy', $requestJoin->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </form>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/{{Auth()->user()->user_type}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li><a href="{{route('request-joins.index')}}">request Join</a></li>
            <li class="active"> Show request Join </li>
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
                            <h3 class="box-title">Name</h3>
                            <p>{{$requestJoin->name}}</p>
                            <hr>
                            <h3 class="box-title">email</h3>
                            <p>{{$requestJoin->email}}</p>
                            <hr>
                            <h3 class="box-title">Phone</h3>
                            <p>{{$requestJoin->phone}}</p>
                            <hr>
                            <h3 class="box-title">Website</h3>
                            <p>{{$requestJoin->website}}</p>
                            <hr>
                            <h3 class="box-title">Store</h3>
                            <p>{{$requestJoin->store}}</p>
                            <hr>
                            <h3 class="box-title">Address</h3>
                            <p>{{$requestJoin->address}}</p>
                            <hr>
                            
                            <h3 class="box-title">services</h3>
                            <p>
                                @foreach($Request_join_service as $Request_join_servic)
                                {{$Request_join_servic->services->title_en}} |


                                @endforeach
                            </p>
                            <hr>
                            <h3 class="box-title">Created At</h3>
                            <p>{{$requestJoin->dateFormatted()}}</p>
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