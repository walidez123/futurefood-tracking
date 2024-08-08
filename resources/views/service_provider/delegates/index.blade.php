@extends('layouts.master')
@section('pageTitle', __("admin_message.Delegates"))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' =>__("admin_message.Delegates"), 'iconClass' => 'fa-users', 'addUrl' => route('s_p_delegates.create',['type'=>$type]), 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
           
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{__("admin_message.image")}}</th>
                  <th>{{__("admin_message.Name")}}</th>
                  <th>{{__("admin_message.Functional code")}}</th>
                  <th>{{__("admin_message.Email")}}</th>
                  <th>{{__("admin_message.Phone")}}</th>
                  <th>{{__("admin_message.City")}}</th>
                  <th>{{__("admin_message.Activation")}}</th>
                  <th>{{__("admin_message.Action")}}</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($delegates as $delegate)
                <tr>
                  <td>{{$count}}</td>
                  @if($delegate->avatar=="avatar/avatar.png" || $delegate->avatar==NULL)
                  <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>

                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$delegate->avatar)}}" height="75" width="75"></td>

                  @endif
                  <td>{{$delegate->name}}</td>
                  <td>{{$delegate->code}}</td>
                  <td>{{$delegate->email}}</td>
                  <td>{{$delegate->phone}} <span><a href="https://wa.me/966{{$delegate->phone}}?text=مرحبا بك {{$delegate->name}} فى تطبيق فيوتشر 
رابط التطبيق : https://future-ex.com/admin  
رقم تسجيل الدخول : {{$delegate->phone}}
الباسورد : 12345678"><i class="fa-brands fa-whatsapp"></i></a></span></td>
                  <td>
                  {{ is_null($delegate->city) ? '' : $delegate->city->trans('title') }}
                  </td>
                  <td>
                    @if($delegate->is_active==1)
                      {{__('admin_message.active')}}

                    @else
                    {{__('admin_message.inactive')}}


                    @endif
                    </td>

                  <td>
                    @if($type==1)
                    <a href="{{route('s_p_delegates.show', $delegate->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.View")}}</span> </a>
                  <a href="{{route('s_p_delegates.orders', $delegate->id)}}" title="View" class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.orders")}} <strong>{{$delegate->ordersDelegate()->count()}}</strong></span> </a>
                        
                    <a href="{{route('s_p_delegates.edit', $delegate->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.Edit")}}</span></a>
                    <!-- <form class="pull-right" style="display: inline;" action="{{route('s_p_delegates.destroy', $delegate->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> {{__("admin_message.Delete")}}
                        </button>
                      </form>   -->
                    @else
                    <a href="{{route('s_p_delegates.show', $delegate->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.View")}}</span> </a>
                  <a href="{{route('s_p_delegates.orders', $delegate->id)}}" title="View" class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.orders")}} <strong>{{$delegate->ordersDelegate()->count()}}</strong></span> </a>
                  
                        <a href="{{route('s_p_delegates.edit', $delegate->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                            class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__("admin_message.Edit")}}</span></a>
                       
                        <!-- <form class="pull-right" style="display: inline;" action="{{route('s_p_delegates.destroy', $delegate->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                              <i class="fa fa-trash" aria-hidden="true"></i> {{__("admin_message.Delete")}}
                            </button>
                          </form>   -->
                        



                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>{{__("admin_message.image")}}</th>
                  <th>{{__("admin_message.Name")}}</th>
                  <th>{{__("admin_message.Email")}}</th>
                  <th>{{__("admin_message.Phone")}}</th>
                  <th>{{__("admin_message.City")}}</th>
                  <th>{{__("admin_message.Activation")}}</th>

                  <th>{{__("admin_message.Action")}}</th>
                </tr>
              </tfoot>
            </table>
            <nav>
                        <ul class="pager">
                          {{ $delegates->appends($_GET)->links() }}
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable( {
                retrieve: true,
                fixedColumns:   true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength: 25,
                dom: 'lBfrtip',
                scrollX: true,
                buttons: [


                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection