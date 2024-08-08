@extends('layouts.master')
@section('pageTitle',__('admin_message.statuses'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios, .toggle-on.ios, .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-index', ['title' =>__('admin_message.statuses'), 'iconClass' => 'fa-bookmark', 'addUrl' => route('defult_status.create'), 'multiLang' => 'false'])

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
                  <th>{{__('admin_message.statuses')}}</th>
                  <!-- <th>{{__('admin_message.priority')}}</th> -->


                  <!-- <th>{{__('admin_message.Notes')}}</th> -->
                  <th>{{__('admin_message.appear')}} {{__('admin_message.Delegate')}}</th>
                  <th>{{__('admin_message.appear')}} {{__('admin_message.Client')}}</th>

                  <th>{{__('admin_message.appear')}} {{__('admin_message.restaurant')}}</th>
                

                  <th>{{__('admin_message.appear')}} {{__('admin_message.shop')}}</th>


                  <th>{{__('admin_message.appear')}} {{__('admin_message.storehouse')}} </th>


                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($statuses as $status)
                <tr>
                  <td >{{$count}}</td>
                  <td >{{$status->trans('title')}}</td>
                  <!-- <td >{{$status->sort}}</td> -->

                  <!-- <td >{{$status->description}}</td> -->
                  <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle publish" 
                    {{$status->delegate_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>
                    <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle client_appear publish" 
                    {{$status->client_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>

                     <td>
                         
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle restaurant_appear" 
                    {{$status->restaurant_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td> 

                    <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle shop_appear" 
                    {{$status->shop_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>

                    <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle storehouse_appear" 
                    {{$status->storehouse_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>
                  <td> 
                        
                    <a href="{{route('defult_status.edit', $status->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>
                    

                     <form class="pull-right" style="display: inline;" action="{{route('defult_status.destroy', $status->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                        </button>
                      </form>  
                 
                    
                  </td>
                </tr>
                @endforeach
                <?php $count++ ?>

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>{{__('admin_message.statuses')}}</th>
                    <!-- <th>{{__('admin_message.priority')}}</th> -->

                  <!-- <th>{{__('admin_message.Notes')}}</th> -->
                  <th>{{__('admin_message.appear')}} {{__('admin_message.Delegate')}}</th>
                  <th>{{__('admin_message.appear')}} {{__('admin_message.Client')}}</th>

                  <th>{{__('admin_message.appear')}} {{__('admin_message.restaurant')}}</th>


                  <th>{{__('admin_message.appear')}} {{__('admin_message.shop')}}</th>


                  <th>{{__('admin_message.appear')}} {{__('admin_message.storehouse')}} </th>


                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </tfoot>
            </table>

            <nav>
                        <ul class="pager">
                        {{ $statuses->appends($_GET)->links() }}


                        </ul>

            </nav> 
            

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
     $('.toggle').bootstrapToggle();
      $(document).on('change','.publish',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/delegate_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

      $(document).on('change','.client_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/client_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     $(document).on('change','.restaurant_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/restaurant_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }); $(document).on('change','.shop_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/shop_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $(document).on('change','.storehouse_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/storehouse_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
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