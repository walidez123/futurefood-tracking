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
            <form style="display: inline;" action="{{route('contacts.destroy', $contact->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </form>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/{{Auth()->user()->user_type}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li><a href="{{route('contacts.index')}}">Contact</a></li>
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
                            <h3 class="box-title">Name</h3>
                            <p>{{$contact->name}}</p>
                            <hr>
                            <h3 class="box-title">email</h3>
                            <p>{{$contact->email}}</p>
                            <hr>
                            <h3 class="box-title">Created At</h3>
                            <p>{{$contact->dateFormatted()}}</p>
                            <hr>
                            <h3 class="box-title">subject</h3>
                            <p>{{$contact->subject}}</p>
                            <hr>
                            <h3 class="box-title">message</h3>
                            <p>{{$contact->message}}</p>
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