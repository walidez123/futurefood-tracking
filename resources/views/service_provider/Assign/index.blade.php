@extends('layouts.master')
@section('pageTitle', '')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

@include('layouts._header-index', ['title' => __("admin_message.Rules for Appointing Delegates") , 'iconClass' => 'fa-users', 'addUrl' => route('order_rule_provider.create'), 'multiLang' => 'false'])






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
                  <th>العنوان</th>
                  <th>التفاصيل</th>
                  <th>المندوب</th>
                  <th>الحد الأعلى اليومي</th>

                  <th>الحالة</th>

                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($rules as $rule)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$rule->title}}</td>
                  <td>{{$rule->details}}</td>
                  <td>
                  {{ is_null($rule->delegate) ? '' : $rule->delegate->name }}
                  </td>
                  <td>{{$rule->max}}</td>
                  <td>
                    @if($rule->status==1)
                    نشط
                    @else
                    غير نشط
                    @endif
                  </td>

                  <td>
                    {{-- @if (in_array('edit_city', $permissionsTitle)) --}}
                     <a href="{{route('order_rule_provider.edit', $rule->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>
                    {{-- @endif --}}

                      {{-- @if (in_array('delete_city', $permissionsTitle)) --}}
                      <form class="pull-right" style="display: inline;" action="{{route('order_rule_provider.destroy', $rule->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> مسح
                          </button>
                        </form>
                      {{-- @endif --}}

                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <th>#</th>
                  <th>العنوان</th>
                  <th>التفاصيل</th>
                  <th>المندوب</th>
                  <th>الحالة</th>

                  <th>العمليات</th>
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
