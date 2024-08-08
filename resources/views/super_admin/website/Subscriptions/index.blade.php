@extends('layouts.master')
@section('pageTitle', __('website.subscribe'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' =>  __('website.subscribe'), 'iconClass' => 'fa-subscript', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped data_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>@lang('website.service_name')</th>
                  <th>@lang('website.company_name')</th>
                  <th>@lang('website.industry')</th>

                  <th>@lang('website.user_name')</th>
                  <th>@lang('website.phone_number')</th>
                  <th>@lang('website.email')</th>
                  <th>@lang('website.additional_info')</th>
                  <th>@lang('admin_message.Action')</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($Subscriptions as $Subscription)
                <tr>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$count}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->service_name}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->company_name}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->industry}}</td>

                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->user_name}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->phone_number}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->email}}</td>
                  <td style="{{($Subscription->is_readed == 0)? 'font-weight: bold' : ''}}">{{$Subscription->additional_info}}</td>

                  <td>
                    <a href="{{route('subscription.show', $Subscription->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">@lang('admin_message.View')</span> </a>
                    <form class="pull-right" style="display: inline;" action="{{route('subscription.destroy', $Subscription->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('admin_message.Delete')
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
                <th>@lang('website.service_name')</th>
                  <th>@lang('website.company_name')</th>
                  <th>@lang('website.industry')</th>

                  <th>@lang('website.user_name')</th>
                  <th>@lang('website.phone_number')</th>
                  <th>@lang('website.email')</th>
                  <th>@lang('website.additional_info')</th>
                  <th>@lang('admin_message.Action')</th>
                </tr>
              </tfoot>
            </table>
            
            <nav>
                        <ul class="pager">
                          {{ $Subscriptions->appends($_GET)->links() }}
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
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },
             scrollX: true,
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