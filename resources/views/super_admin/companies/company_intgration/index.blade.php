@extends('layouts.master')
@section('pageTitle', 'الشركات')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'شركة', 'iconClass' => 'fa-users', 'addUrl' => route('company_providers.create',['id'=>$user_id]), 'multiLang' => 'false'])

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
                  <th>الشركة</th>
                  <th>التفعيل</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($Company_providers as $Company_provider)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$Company_provider->provider_name}}</td>
                 
                    <td>
                    @if($Company_provider->active==1)
                    مفعل 
                    @else
                    غير مفعل
                  

                    @endif
                
                  </td>
               
                  <td>
                   
                        
                    <a href="{{route('company_providers.edit', $Company_provider->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>
                   
                    <form class="pull-right" style="display: inline;" action="{{route('company_providers.destroy', $Company_provider->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد مسح الشركة ?');">
                          <i class="fa fa-true" aria-hidden="true"></i> مسح
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
                <th>الشركة</th>
                  <th>التفعيل</th>
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