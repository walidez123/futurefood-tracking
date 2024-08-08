@extends('layouts.master')
@section('pageTitle', 'طلبات أنضمام المناديب')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <h1>طلبات أنضمام المناديب</h1>
  

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
                  <th>الصورة</th>
                  <th>الأسم</th>
                  <th>البريد الإلكترونى</th>
                  <th>رقم الجوال</th>
                  <th> طبيعة العمل</th>
                  <th>المشاهدة</th>

                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($Request_joins as $user)
                <tr>
                  <td>{{$count}}</td>
                
                  <td><img class="img-circle" src="{{asset('storage/'.$user->avatar)}}" height="75" width="75"></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                    <td>
                    @if($user->work_type == 1)
                                    دوام كلى

                                    @elseif($user->work_type == 2)
                                     دوام جزئى

                                    @else
                                      بالقطعة
                                    @endif
                  </td>
                  <td>
                    @if($user->is_read==0)
                    لم يتم المشاهدة
                    @else
                    تم المشاهدة الطلب 
                    @endif
                  </td>
               
                  <td>
                    @if (in_array('show_user', $permissionsTitle))
                    <a href="{{route('delegate_request_join.show', $user->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">عرض</span> </a>
                    @endif
                   
                    @if (in_array('delete_user', $permissionsTitle))
               
                    <form class="pull-right" style="display: inline;" action="{{route('delegate_request_join.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد مسح هذا الطلب ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i>  مسح
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
                  <th>الصورة</th>
                  <th>الأسم</th>
                  <th>البريد الإلكترونى</th>
                  <th>رقم الجوال</th>
                  <th> طبيعة العمل</th>

                  <th>التفعيل</th>
                  <th>العمليات</th>
                </tr>
              </tfoot>
            </table>
            {{ $Request_joins->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection