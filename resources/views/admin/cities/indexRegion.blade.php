@extends('layouts.master')
@section('pageTitle', __('admin_message.Regions'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
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
                  <th>{{ __("admin_message.Regions") }}</th>
                  <th>{{ __("admin_message.City") }}</th>
                  <th>{{ __("admin_message.longitude") }}</th>
                  <th>{{ __("admin_message.latitude") }}</th>
                  <th>{{ __("admin_message.Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($regions as $region)
                <tr>
                  <td>{{$count}}</td>

                  <td>{{$region->trans('title')}}</td>
                  <td>
                  {{ is_null($region->city) ? '' : $region->city->trans('title') }}
                  </td>
                  <td>{{$region->longitude}}</td>
                  <td>{{$region->latitude}}</td>
                  <td>
                  @if($region->company_id==Auth()->user()->company_id )
                    @if (in_array('edit_neighborhood', $permissionsTitle))
                     <a href="{{route('RegionCompany.edit', $region->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{ __("admin_message.Edit") }}</span></a>   
                    @endif                   
                      @if (in_array('delete_neighborhood', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('RegionCompany.destroy', $region->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __("admin_message.Delete") }}
                          </button>
                        </form>  
                      @endif
                      @endif                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                <th>#</th>
                <th>{{ __("admin_message.Regions") }}</th>
                  <th>{{ __("admin_message.City") }}</th>
                  <th>{{ __("admin_message.longitude") }}</th>
                  <th>{{ __("admin_message.latitude") }}</th>
                  <th>{{ __("admin_message.Action") }}</th>
                </tr>
              </tfoot>
            </table>
            <!--  -->
            <nav>
              <ul class="pager">
                {{ $regions->appends($_GET)->links() }}
              </ul>
            </nav> 
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
