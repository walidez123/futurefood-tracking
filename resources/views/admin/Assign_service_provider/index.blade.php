@extends('layouts.master')
@section('pageTitle',__('admin_message.Rules for Appointing service provider') )
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@if (in_array('add_Orders_rules', $permissionsTitle))


@include('layouts._header-index', ['title' =>  __('admin_message.Rules for Appointing service provider')  , 'iconClass' => 'fa-users', 'addUrl' => route('Rule_service_provider.create'), 'multiLang' => 'false'])

@endif




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
                  <th>{{ __('admin_message.Designation name') }}</th>
                  <th>{{ __('admin_message.details') }}</th>
                  <th>{{ __('admin_message.Service provider') }}</th>
                  <th>{{ __('admin_message.Maximum order limit') }}</th>

                  <th>{{ __('admin_message.status') }}</th>

                  <th>{{ __('admin_message.Action') }}</th>
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
                  @if (in_array('edit_Orders_rules', $permissionsTitle))
                     <a href="{{route('Rule_service_provider.edit', $rule->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span></a>
                  @endif 

                  @if (in_array('delete_Orders_rules', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('Rule_service_provider.destroy', $rule->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('admin_message.Delete') }}
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
                <th>{{ __('admin_message.Designation name') }}</th>
                  <th>{{ __('admin_message.details') }}</th>
                  <th>{{ __('admin_message.Service provider') }}</th>
                  <th>{{ __('admin_message.Maximum order limit') }}</th>

                  <th>{{ __('admin_message.status') }}</th>

                  <th>{{ __('admin_message.Action') }}</th>
               
                </tr>
              </tfoot>
            </table>

            <nav>
                        <ul class="pager">
                        {{ $rules->appends($_GET)->links() }}


                        </ul>

            </nav> 


          </div><!-- /.box-body -->

        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
