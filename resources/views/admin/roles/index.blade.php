@extends('layouts.master')
@section('pageTitle', 'Roles')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if (in_array('add_role', $permissionsTitle))

  @include('layouts._header-index', ['title' => 'role', 'iconClass' => 'fa-lock', 'addUrl' =>
  route('roles.create'), 'multiLang' => 'false'])

@endif

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
                  <th>Title</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if ($roles->currentPage() == 1) {
                        $count = 1;
                    } else {
                        $count = ($roles->currentPage() - 1) * 15 + 1;
                    }
                ?>
                @foreach ($roles as $role)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$role->title}}</td>
                  <td>
                    @if (in_array('edit_role', $permissionsTitle))
                    <a href="{{route('roles.edit', $role->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                      @endif
                    @if (in_array('delete_role', $permissionsTitle))
                    <form class="pull-right" style="display: inline;" action="{{route('roles.destroy', $role->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                          onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> Delete
                        </button>
                      </form>  
                    @endif 
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
            {{ $roles->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection