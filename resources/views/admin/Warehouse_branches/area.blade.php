@extends('layouts.master')
@section('pageTitle',__('app.area'))
@section('nav')


@section('css')
<style>
    .area:disabled {
        color: red; /* تغيير لون الخط */
        box-shadow: 0 0 0 1px red; /* إضافة ظل بلون حول المربع */
    }
</style>@endsection

@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <!-- @include('layouts._header-index', ['title' => 'المستودعات', 'iconClass' => 'fa-map-marker', 'addUrl' => route('warehouse_branches.create'), 'multiLang' => 'false']) -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            @if($branch->work==1 || $branch->work==3)
            <h2>@lang('app.Warehouse area')</h2>
            @foreach($stands as $stand)
            @if($stand->work==1)
            <h3>@lang('app.Stands area') : {{$stand->title}} </h3>
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                
                  <th>@lang('app.Floors/Packages')</th>
                
                  @for($i=1;$i<=$package_num;$i++)
                  <th>{{$i}}</th>
                  @endfor
                 
                 
                </tr>
              </thead>
              <tbody>
              @foreach($floors as $floor)
              @if($floor->stand_id==$stand->id)
                  <tr>
                  <td>{{$floor->title}}</td>

                  @foreach($packages as $package)

                  @if($package->floor_id==$floor->id)
                  <td>
                    @if($package->is_busy==1)
                    <!-- <input checked disabled value="{{$package->id}}" type="checkbox" class="area" class="" name="Occupied_area"> -->
                    <i style="color: red;" class="fa fa-ban" aria-hidden="true"></i>



                    @else
                    <input   value="{{$package->id}}"  type="checkbox"  class=" area" name="Occupied_area" id="">


                    @endif

                </td>  
                @endif               
                @endforeach

                  </tr>
                  @endif
              @endforeach
                

              </tbody>
              <tfoot>
               
              </tfoot>
            </table>
            @endif
              @endforeach
              @endif  
                     <!--  -->
                     @if($branch->work==2 || $branch->work==3)
            <h2>@lang('app.Fulfillment area')</h2>
            @foreach($stands as $stand)
            @if($stand->work==2)
            <h3>@lang('app.Stands area'): {{$stand->title}} </h3>
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                
                  <th>@lang('app.Floors/Shelves')</th>
                
                  @for($i=1;$i<=$package_num2;$i++)
                  <th>{{$i}}</th>
                  @endfor
                 
                 
                </tr>
              </thead>
              <tbody>
              @foreach($floors as $floor)
              @if($floor->stand_id==$stand->id)
                  <tr>
                  <td>{{$floor->title}}</td>

                  @foreach($packages as $package)

                  @if($package->floor_id==$floor->id)
                  <td>
                  @if($package->is_busy==1)
                    <!-- <input checked disabled value="{{$package->id}}" type="checkbox" class="area" name="Occupied_area"> -->
                    <i style="color: red;" class="fa fa-ban" aria-hidden="true"></i>



                    @else
                    <input   value="{{$package->id}}"  type="checkbox"  class="area" name="Occupied_area" id="">


                    @endif
                </td>  
                @endif               
                @endforeach

                  </tr>
                  @endif
              @endforeach
                

              </tbody>
              <tfoot>
               
              </tfoot>
            </table>
            @endif
              @endforeach
              @endif 
           </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
    //  $('.toggle').bootstrapToggle();
    //   $(document).on('change','.publish',function(){
    //     let id = $(this).attr('data-id');
    //     $.ajax({
    //         url: '{{url("/admin/delegate_appear")}}',
    //         type: 'post',
    //         data: {id: id, _token: "{{csrf_token()}}"},
    //         success: function (data) {
    //             //$('.toggle').bootstrapToggle();
    //         },
    //         error: function (data) {
    //             console.log('Error:', data);
    //         }
    //     });
    // });

      $(document).on('change','.area',function(){
        let val=$(this).attr('value');
        $.ajax({
            url: '{{url("/admin/occupied_areas")}}',
            type: 'post',
            data: {val:val, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
      
  </script>


@endsection