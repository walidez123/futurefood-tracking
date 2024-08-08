@extends('layouts.master')
@section('pageTitle', 'Delegates')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <!-- @include('layouts._header-index', ['title' => 'delegate', 'iconClass' => 'fa-users', 'addUrl' => route('supervisor-delegates.create',['type'=>$type]), 'multiLang' => 'false']) -->

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
                  <th>{{__("admin_message.Action")}}</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($delegates as $delegate)
                <tr>
                  <td>{{$count}}</td>
                  <td><img class="img-circle" src="{{asset('storage/'.$delegate->avatar)}}" height="75" width="75"></td>
                  <td>{{$delegate->name}}</td>
                  <td>{{$delegate->code}}</td>
                  <td>{{$delegate->email}}</td>
                  <td>{{$delegate->phone}}</td>
                  <td>{{$delegate->city->title}}</td>
                  <td>
           
                    <a href="{{route('supervisor-delegates.show', $delegate->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">View</span> </a>
                  <a href="{{route('supervisor-delegates.orders', $delegate->id)}}" title="View" class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">Orders <strong>{{$delegate->ordersDelegate()->count()}}</strong></span> </a>
                        
                        <!-- <a href="{{route('supervisor-delegates.edit', $delegate->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                            class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a> -->
                        <form class="pull-right" style="display: inline;" action="{{route('delegates.destroy', $delegate->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                              <i class="fa fa-trash" aria-hidden="true"></i> Delete
                            </button>
                          </form>  



                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              {{-- <tfoot>
                <tr>
                  <th>#</th>
                  <th>الصورة</th>
                  <th>الاسم</th>
                  <th>البريد الالكتروني</th>
                  <th>رقم الجوال</th>
                  <th>المدينة</th>
                  <th>الإجراء</th>
                </tr>
              </tfoot> --}}
            </table>
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
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },

                retrieve: true,
                fixedColumns:   true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength : 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection