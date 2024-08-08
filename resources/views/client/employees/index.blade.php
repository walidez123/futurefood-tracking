@extends('layouts.master')
@section('pageTitle',  __('user.employees'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    {{-- @if (in_array('add_employee', $permissionsTitle)) --}}

  @include('layouts._header-index', ['title' => __('user.employees'), 'iconClass' => 'fa-users', 'addUrl' => route('employees.create'), 'multiLang' => 'false'])
{{-- @endif --}}
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
                 
                  <th>{{__('admin_message.image')}}</th>
                  <th>{{__('admin_message.Name')}}</th>
                  <th>{{__('admin_message.Email')}}</th>
                  <th>{{__('admin_message.Phone')}}</th>
                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($employees->currentPage()==1){
                      $count = 1; 

                  }else{
                      $count=(($employees->currentPage()-1)*25)+1;
                  }
                ?>
                @foreach ($employees as $user)
                <tr>
                  <td>{{$count}}</td>
                  @if($user->avatar=="avatar/avatar.png" || $user->avatar==NULL)
                    <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>
                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$user->avatar)}}" height="75" width="75"></td>
                  @endif                  
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>@if($user->phone){{ $user->phone }} 
                        <a href="tel:{{$user->phone}}" style="padding:5px"><i class="fa fa-phone fa-1x"></i></a> <a href="https://api.whatsapp.com/send?phone={{$user->phone}}"  style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x" style="color:green"></i></a></th>
                      @endif
                  </td>
                  <td>
                    <a href="{{route('employees.show', $user->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.View')}}</span> </a>
                    
                    <a href="{{route('employees.edit', $user->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>
                  
                    <form class="pull-right" style="display: inline;" action="{{route('employees.destroy', $user->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                      </button>
                    </form>  
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>{{__('admin_message.image')}}</th>
                  <th>{{__('admin_message.Name')}}</th>
                  <th>{{__('admin_message.Email')}}</th>
                  <th>{{__('admin_message.Phone')}}</th>
                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </tfoot>
            </table>
            {{ $employees->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection