@extends('layouts.master')
@section('pageTitle', 'الفروع')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if (in_array('add_branch', $permissionsTitle))

  @include('layouts._header-index', ['title' =>'الفروع', 'iconClass' => 'fa-map-marker', 'addUrl' => route('Company_branches.create'), 'multiLang' => 'false'])
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
                  <th>@lang('app.address')</th>

                  <th>@lang('app.city')</th>
                 <th>الحى</th>
                  <th>Longitude</th>
                 <th>Latitude</th>


                  <th>@lang('app.phone')</th>
                  <th>@lang('app.control')</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($branches->currentPage()==1){
                      $count = 1; 

                  }else{
                      $count=(($branches->currentPage()-1)*25)+1;
                  }
                ?>
                @foreach ($branches as $branch)
                <tr>
                  <td>{{$branch->title}}</td>

                  <td>{{$count}}</td>
                  <td>{{$branch->city->title}}</td>
                  
                  <td>
                      @if($branch->region != NULL)
                      {{$branch->region->title}}
                      @endif
                </td>
                 <th>{{$branch->longitude}}</th>
                 <th>{{$branch->latitude}}</th>

                  <td>{{$branch->phone}}</td>
                  <td>
                  @if (in_array('edit_branch', $permissionsTitle))

                    <a href="{{route('Company_branches.edit',$branch->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a>
                  @endif
                  @if (in_array('delete_branch', $permissionsTitle))


                    <form style="display: inline;" action="{{route('Company_branches.destroy', $branch->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
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
                    <th>الفرع</th>

                    <th>@lang('app.city')</th>
                    <th>الحى</th>
                     <th>Longitude</th>
                 <th>Latitude</th>

                    
                    <th>@lang('app.phone')</th>
                    <th>@lang('app.control')</th>
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
