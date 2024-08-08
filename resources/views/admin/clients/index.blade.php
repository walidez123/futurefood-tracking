@extends('layouts.master')

@if($work==1)
@section('pageTitle',__('admin_message.Clients'))

@elseif($work==2)
@section('pageTitle',__('admin_message.restaurants'))
@elseif($work==3)
@section('pageTitle',__('admin_message.Warehouse Clients'))
@elseif($work==4)
@section('pageTitle',__('fulfillment.fulfillment_clients') )
@endif
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if($work==1)
  @if (in_array('add_client', $permissionsTitle))


  @include('layouts._header-index', ['title' =>__('admin_message.Clients'), 'iconClass' => 'fa-shop', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])
  @endif
  @elseif($work==2)
  @if (in_array('add_resturant', $permissionsTitle))

    @include('layouts._header-index', ['title' =>__('admin_message.restaurants'), 'iconClass' => 'fa-utensils', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])
@endif
@elseif($work==3)
@if (in_array('add_client_warehouse', $permissionsTitle))

@include('layouts._header-index', ['title' =>__('admin_message.Warehouse Clients'), 'iconClass' => 'fa-warehouse', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])
@endif

@elseif($work==4)
@if (in_array('add_client_warehouse', $permissionsTitle))

@include('layouts._header-index', ['title' =>__('fulfillment.fulfillment_clients'), 'iconClass' => 'fa-warehouse', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])

@endif
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
            <div class="nav-tabs-custom">
              @if(session('success'))
                  <div id="success-alert" class="alert alert-success">
                      {{ session('success') }}
                  </div>
              @endif
    
              @if(session('error'))
                  <div id="error-alert" class="alert alert-danger">
                      {{ session('error') }}
                  </div>
              @endif
          <table id="example1" class="table   table-striped   data_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{__('admin_message.image')}}</th>
                  <th>{{__('admin_message.Name')}}</th>
                  @if($work==1 )

                  <th>{{__('admin_message.Store Name')}}</th>
                  @elseif($work==2)
                  <th>{{__('admin_message.Resturant Name')}}</th>
                  @elseif($work==3)
                  <th>{{__('admin_message.Warehouse Name')}}</th>
                  @elseif($work==4)
                  <th>{{__('fulfillment.fulfillment_client_name')}}</th>
                  @endif
                  <th>{{__('admin_message.Email')}}</th>
                  <th>{{__('admin_message.Phone')}}</th>
                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                if($clients->currentPage()==1){
                    $count = 1; 

                }else{
                    $count=(($clients->currentPage()-1)*25)+1;
                }
              ?>               
                @foreach ($clients as $client)
                <tr>
                  <td>{{$count}}</td>
                  @if($client->provider!=NULL)

                  <td><img class="img-circle" src="{{$client->avatar}}" height="75" width="75"></td>
                  @elseif($client->avatar==NULL||$client->avatar=="avatar/avatar.png")
                  <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>

                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$client->avatar)}}" height="75" width="75"></td>


                  @endif
                  <td>{{$client->name}}</td>
                  <td>{{$client->store_name}}</td>
                  <td>{{$client->email}}</td>
                  <td>{{ $client->phone }} @if($client->phone) <a href="tel:{{$client->phone}}" style="padding:5px"><i class="fa fa-phone fa-1x"></i></a> <a href="https://api.whatsapp.com/send?phone={{$client->phone}}"  style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x" style="color:green"></i></a></td>
                  @endif<td>
                  @if($work==1)

                    @if (in_array('show_client', $permissionsTitle))
                   

                    <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.View')}}</span> </a>
                    @endif
                     @if (in_array('show_address', $permissionsTitle))
                    <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.addresses')}}</span> </a>
                    @endif

               
                    
                      @if (in_array('edit_client', $permissionsTitle))
                       <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>   
                      @endif
                    
                    @if (in_array('delete_client', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                        </button>
                      </form>   
                    @endif
                    @if (in_array('show_client', $permissionsTitle))
                      <a href="{{ route('clients.transactions', $client->id) }}" title="View" class="btn btn-sm btn-success" style="margin: 2px;">
                        <i class="fa-solid fa-dollar"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.Financial') }}</span>
                      </a>                    
                    @endif
                    @elseif($work==4)
                      @if (in_array('show_client_fulfillment', $permissionsTitle))
                        <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.View')}}</span> </a>
                      @endif
                      @if (in_array('show_address', $permissionsTitle))
                        <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.addresses')}}</span> </a>
                      @endif
                      @if (in_array('edit_client_fulfillment', $permissionsTitle))
                        <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                          class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>   
                      @endif
                      @if (in_array('delete_client_fulfillment', $permissionsTitle))
                        <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                          </button>
                        </form>   
                      @endif
                      @if (in_array('show_balance_fulfillment', $permissionsTitle))
                        <a href="{{ route('clients.transactions', $client->id) }}" title="View" class="btn btn-sm btn-success" style="margin: 2px;">
                          <i class="fa-solid fa-dollar"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.Financial') }}</span>
                        </a>                    
                      @endif
                    {{-- @endif --}}

                    @elseif($work==2)
                    @if (in_array('show_resturant', $permissionsTitle))
                      <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.View')}}</span> </a>
                    @endif
                     @if (in_array('show_address', $permissionsTitle))
                      <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.addresses')}}</span> </a>
                    @endif
                      @if (in_array('edit_resturant', $permissionsTitle))
                       <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>   
                      @endif
                    @if (in_array('delete_resturant', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                        </button>
                      </form>   
                    @endif
                    @if (in_array('show_resturant', $permissionsTitle))
                      <a href="{{ route('clients.transactions', $client->id) }}" title="View" class="btn btn-sm btn-success" style="margin: 2px;">
                        <i class="fa-solid fa-dollar"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.Financial') }}</span>
                      </a>                    
                    @endif
                    @else
                    @if ($client->work==3)
                    @if (in_array('show_client_warehouse', $permissionsTitle))
                      <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.View')}}</span> </a>
                    @endif
                     @if (in_array('show_address', $permissionsTitle))
                    <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.addresses')}}</span> </a>
                    @endif
                      @if (in_array('edit_client_warehouse', $permissionsTitle))
                       <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Edit')}}</span></a>   
                      @endif
                    
                    @if (in_array('delete_client_warehouse', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> {{__('admin_message.Delete')}}
                        </button>
                      </form>   
                    @endif
                    
                    @if (in_array('show_client_packages', $permissionsTitle))

                    <a href="{{route('clinet_packages.index',['id'=> $client->id])}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">{{__('admin_message.Packages')}}</span> </a>
                    @endif
                    @endif
                  @endif
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>{{__('admin_message.image')}}</th>
                  <th>{{__('admin_message.Name')}}</th>
                  @if($work==1 )

                  <th>{{__('admin_message.Store Name')}}</th>
                  @elseif($work==2)
                  <th>{{__('admin_message.Resturant Name')}}</th>
                  @elseif($work==3)
                  <th>{{__('admin_message.Warehouse Name')}}</th>
                  @elseif($work==4)
                  <th>{{__('fulfillment.fulfillment_client_name')}}</th>
                  @endif
                  <th>{{__('admin_message.Email')}}</th>
                  <th>{{__('admin_message.Phone')}}</th>
                  <th>{{__('admin_message.Action')}}</th>
                </tr>
              </tfoot>
            </table>
            <nav>
                        <ul class="pager">
                          {{ $clients->appends($_GET)->links() }}
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