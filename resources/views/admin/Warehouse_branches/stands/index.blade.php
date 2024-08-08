@extends('layouts.master')
@section('pageTitle',__('app.stands'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <!-- @include('layouts._header-index', ['title' => 'الستاند', 'iconClass' => 'fa-map-marker', 'addUrl' => route('warehouse_branches.create'), 'multiLang' => 'false']) -->
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  {{__('app.add')}} {{__('app.stands')}}   
 </button>

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        <form action="{{route('warehouse_stand.store')}}" method="post" class="col-xs-12">
          @csrf
          <input type="hidden" name="type" value="{{$type}}">
          <input type="hidden" name="warehouse_id" value="{{$warehouse_stand}}">

                <div class="col-lg-12">
                <label>{{__('app.stand number')}}</label>
                <input type="number" name="number" class="form-control" value="1" id="">
                </div>   
    </div>
      <div class="modal-footer">
         
        <div class="col-lg-6">
               <input type="submit" class="btn btn-block btn-danger col-lg-6"  value="{{__('app.save')}}"/>
          </div>
        <div class="col-lg-6">
               <button type="button" class="btn btn-block btn-secondary " data-dismiss="modal">{{__('app.close')}}</button>
          </div>
       
      </div>
      </form>
    </div>
  </div>
</div>
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
                  <th>@lang('app.title')</th>
                  <th>@lang('app.warehouse')</th>
                  <!-- <th>Longitude</th>
                 <th>Latitude</th>
                  <th>@lang('app.area')</th> -->
                  <th>@lang('app.control')</th>
                </tr>
              </thead>
              <tbody>
              <?php 
        if($stands->currentPage()==1){
            $count = 1; 

        }else{
            $count=(($stands->currentPage()-1)*25)+1;
        }
        ?>
                        @foreach ($stands as $branch)
                <tr>
                <td>{{$count}}</td>
                  <td>{{$branch->title}}</td>

                  <td>{{$branch->warehouse->trans('title')}}</td>
<!--               
                 <th>{{$branch->longitude}}</th>
                 <th>{{$branch->latitude}}</th>

                  <td>{{$branch->area}}</td> -->
                  <td>
                    <!-- <a aria-disabled="true"  href="{{route('warehouse_stand.edit', $branch->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a> -->
                     
                        <a href="{{route('warehouse_floor.index', ['id'=>$branch->id])}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">@lang('app.floors')</span></a>

                    <form style="display: inline;" action="{{route('warehouse_stand.destroy', $branch->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
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
                  <th>@lang('app.title')</th>
                  <th>@lang('app.warehouse')</th>
                  <!-- <th>Longitude</th>
                 <th>Latitude</th>
                  <th>@lang('app.area')</th> -->
                  <th>@lang('app.control')</th>
                </tr>
              </tfoot>
            </table>
            <nav>
                        <ul class="pager">
                            {{ $stands->appends($_GET)->links() }}
                        </ul>

                    </nav>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
