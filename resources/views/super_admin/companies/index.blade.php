@extends('layouts.master')
@section('pageTitle', 'الشركات')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'شركة', 'iconClass' => 'fa-users', 'addUrl' => route('companies.create'), 'multiLang' => 'false'])

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

                  <th>التفعيل</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($companies as $user)
                <tr>
                  <td>{{$count}}</td>
                  <td><img class="img-circle" src="{{asset('storage/'.$user->avatar)}}" height="75" width="75"></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                    <td>
                  @foreach($user->works as $work)
                    @if($work->work==1)
                    متجر 
                    @elseif($work->work==2)
                    مطعم
                    @elseif($work->work==3)
                    مستودع
                    @elseif($work->work==4)
                    تعبئة و تغليف

                    @endif
                    /
                    <!--  -->
                  @endforeach
                  </td>
                  <td>
                    @if($user->company_active==0)
                    غير مفعل
                    @else
                    مفعل
                    @endif
                  </td>
                  <td>
                    @if (in_array('show_user', $permissionsTitle))
                    <a href="{{route('companies.show', $user->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">عرض</span> </a>
                    @endif
                    @if (in_array('edit_user', $permissionsTitle))
                        
                    <a href="{{route('companies.edit', $user->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>
                    @endif
                    @if (in_array('show_user', $permissionsTitle))
                    <a href="{{route('companies.transactions', $user->id)}}" title="View" class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">الحسابات</span> </a>
                    @endif
                    @if (in_array('delete_user', $permissionsTitle))
                    @if($user->company_active==0)
                    <form class="pull-right" style="display: inline;" action="{{route('companies.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('هل تريد تفعيل الشركة ?');">
                          <i class="fa fa-true" aria-hidden="true"></i> تفعيل
                        </button>
                      </form>  
                    @else
                    <form class="pull-right" style="display: inline;" action="{{route('companies.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد لغاء تفعيل الشركة ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> إلغاء التفعيل
                        </button>
                      </form>  
                    @endif
                   
                    @endif

                    <a href="{{route('company.orders', $user->id)}}" title="Edit" class="btn btn-sm btn-info" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">طلبات الحساب</span></a>
                    <a href="{{route('company.setting', $user->id)}}" title="Edit" class="btn btn-sm btn-info" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm"> إعدادات الشركات</span></a>
                    <a href="{{route('company_providers.index', ['id'=>$user->id])}}" title="Edit" class="btn btn-sm btn-info" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm"> إعدادات شركة الإنتجريشن </span></a>
                    <a href="{{route('Service_provider.activate', $user->id)}}" title="Edit" class="btn btn-sm btn-info" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm"> الشركات المشغلة</span></a>
                    
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
            {{ $companies->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection