@extends('layouts.master')
@section('pageTitle', 'Tracking')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'Tracking', 'iconClass' => 'fa-map-marker', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>email</th>
                  <th>phone</th>
                  <th>City</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($delegates as $delegate)
                <tr>
                  <td>{{$count}}</td>
                  <td><img class="img-circle" src="{{asset('storage/'.$delegate->avatar)}}" height="75" width="75"></td>
                  <td>{{$delegate->name}}</td>
                  <td>{{$delegate->email}}</td>
                  <td>{{$delegate->phone}}</td>
                  <td>{{$delegate->city->title}}</td>
                  <td>
                    
                    @if (in_array('show_follow', $permissionsTitle))
                        
                    <a href="/tracking-map/?id={{$delegate->id}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-map-marker"></i> <span class="hidden-xs hidden-sm">Tracking</span></a>
                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection